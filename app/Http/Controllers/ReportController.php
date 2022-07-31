<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Data};

class ReportController extends Controller
{
    public function inventory(){
        return $this->_view('inventory', [
            'title' => 'Inventory Report',
            // 'data' => $data
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

        $array = [];
        $from = $req->from;
        $to = $req->to;
        $dates = [];

        while($from <= $to){
            $tempDate = now()->parse($from);
            array_push($dates, $tempDate->toDateTimeString());
            $from = $tempDate->addDay()->toDateString();
        }

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

    private function _view($view, $data = array()){
        return view("reports" . "." . $view, $data);
    }
}
