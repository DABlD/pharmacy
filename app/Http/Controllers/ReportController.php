<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Data};

class ReportController extends Controller
{
    public function inventory(){
        return $this->_view('inventory', [
            'title' => 'Inventory Report',
        ]);
    }

    public function sales(){
        return $this->_view('sales', [
            'title' => 'Sales Report',
        ]);
    }

    public function getInventory(Request $req){
        $temp = Data::where('transaction_types_id', $req->tType)
            ->where('bhc_id', 'like', "%" . $req->outlet . "%")
            ->whereNotNull('bhc_id')
            ->whereBetween('transaction_date', [$req->from, $req->to])
            ->get();

        $temp->load('reorder.medicine');
        $temp->load('transaction_type');
        $temp = $temp->groupBy('medicine_id');

        $from = $req->from;
        $to = $req->to;

        $dates = $this->getDates($from, $to);
        $array = [];

        foreach($temp as $medicine){
            $grandtotal = 0;
            $tempDates = [];
            foreach($dates as $date){
                $total = 0;
                foreach($medicine as $data){
                    if($data->transaction_date == $date){
                        if($data->transaction_type->operator == "+"){
                            $total += $data->{$req->view};
                            $grandtotal += $data->{$req->view};
                        }
                        else{
                            $total -= $data->{$req->view};
                            $grandtotal -= $data->{$req->view};
                        }
                    }
                }

                $tempDates[now()->parse($date)->format('M d')] = $total;
            }

            array_push($array, 
                array_merge(
                    array_merge(
                        ["item" => $medicine[0]->reorder->medicine->name], 
                        $tempDates
                    ),
                    ["total" => $grandtotal]
                )
            );
        }

        echo json_encode($array);
    }

    public function getSales(Request $req){
        $temp = Data::whereNotNull('bhc_id')
                    ->whereIn('transaction_types_id', [2,3])
                    ->whereBetween('transaction_date', [$req->from, $req->to])
                    ->get();

        $temp->load('bhc');
        $temp->load('transaction_type');
        $temp->load('reorder.medicine');
        $temp = $temp->groupBy($req->fby);

        $from = $req->from;
        $to = $req->to;

        $dates = $this->getDates($from, $to);
        $array = [];

        foreach($temp as $group){
            $grandTotal = 0;
            $tempDates = [];
            foreach($dates as $date){
                $total = 0;
                foreach($group as $data){
                    if($data->transaction_date == $date){
                        if($data->transaction_type->operator == "-"){
                            $total += $data->{$req->view};
                            $grandTotal += $data->{$req->view};
                        }
                        else{
                            $total -= $data->{$req->view};
                            $grandTotal -= $data->{$req->view};
                        }
                    }
                }

                $tempDates[now()->parse($date)->format('M d')] = $total;
            }

            $title = $req->fby == "bhc_id" ? $group[0]->bhc->name : $group[0]->reorder->medicine->name;
            array_push($array, 
                array_merge(
                    array_merge(
                        ["item" => $title], 
                        $tempDates
                    ),
                    ["total" => $grandTotal]
                )
            );
        }

        echo json_encode($array);
    }

    private function getDates($from, $to){
        $dates = [];

        while($from <= $to){
            $tempDate = now()->parse($from);
            array_push($dates, $tempDate->toDateTimeString());
            $from = $tempDate->addDay()->toDateString();
        }

        return $dates;
    }

    private function _view($view, $data = array()){
        return view("reports" . "." . $view, $data);
    }
}
