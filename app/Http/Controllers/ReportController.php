<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Data, Alert};

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

    public function purchaseOrder(){
        return $this->_view('purchaseOrder', [
            'title' => 'Purchase Order Report',
        ]);
    }

    public function binCard(){
        return $this->_view('binCard', [
            'title' => 'Bin Card Activity',
        ]);
    }

    public function alert(){
        return $this->_view('alert', [
            'title' => 'Alerts',
        ]);
    }

    public function dailySheet(){
        return $this->_view('dailySheet', [
            'title' => 'Daily Sheet',
        ]);
    }

    public function getInventory(Request $req){
        $temp = Data::where('transaction_types_id', $req->tType)
            ->where('bhc_id', 'like', $req->outlet)
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

    public function getPurchaseOrder(Request $req){
        $temp = Data::where('bhc_id', 'like', $req->bhc_id)
                    ->where('transaction_types_id', 5)
                    ->whereBetween('transaction_date', [$req->from, $req->to])
                    ->get();

        $temp->load('reorder.medicine');
        $temp = $temp->groupBy('medicine_id');

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
                        $total += $data->{$req->view};
                        $grandTotal += $data->{$req->view};
                    }
                }

                $tempDates[now()->parse($date)->format('M d')] = $total;
            }

            array_push($array, 
                array_merge(
                    array_merge(
                        ["item" => $group[0]->reorder->medicine->name], 
                        $tempDates
                    ),
                    ["total" => $grandTotal]
                )
            );
        }

        echo json_encode($array);
    }

    public function getDailySheet(Request $req){
        $temp = Data::where('bhc_id', 'like', $req->bhc_id)
                    ->whereBetween('transaction_date', [$req->from, $req->to])
                    ->get();

        $temp->load('transaction_type');
        $temp->load('reorder.medicine');
        $temp = $temp->groupBy('medicine_id');

        $from = $req->from;
        $to = $req->to;

        $dates = array_reverse($this->getDates($from, $to));
        $array = [];

        foreach($temp as $group){
            $total = $group[0]->reorder->stock;
            $tempDates = [];
            foreach($dates as $date){
                foreach($group as $data){
                    if($data->transaction_date == $date){
                        if($data->transaction_type->operator == "+"){
                            $total -= $data->{$req->view};
                        }
                        elseif($data->transaction_type->operator == "-"){
                            $total += $data->{$req->view};
                        }
                    }
                }
                $tempDates[now()->parse($date)->format('M d')] = $total;
            }

            array_push($array, 
                array_merge(
                    ["item" => $group[0]->reorder->medicine->name], 
                    $tempDates
                ),
            );
        }

        echo json_encode($array);
    }
    
    public function getBinCard(Request $req){
        $data = Data::where('user_id', 'like', $req->user_id)->orderBy('transaction_date', 'desc')->get();

        $data->load('transaction_type');
        $data->load('reorder.medicine.category');
        $data = $data->groupBy('medicine_id');

        $array = [];

        foreach($data as $group){
            $balance = $group[0]->reorder->stock;
            $name = $group[0]->reorder->medicine->name;

            foreach($group as $record){
                $receiving = 0;
                $issuance = 0;

                $temp = $balance;

                if($record->transaction_type->operator == "+"){
                    $balance -= $record->qty;
                    $receiving = $record->qty;
                }
                else{
                    $balance += $record->qty;
                    $issuance = $record->qty;
                }

                array_push($array, [
                    // "category" => $record->reorder->medicine->category->name,
                    "item" => $name . " (" . $record->reorder->medicine->category->name . ")",
                    "tx" => $record->transaction_type->type,
                    "rcv" => $receiving,
                    "issue" => $issuance,
                    "bal" => $balance,
                    "date" => $record->transaction_date->toDateString(),
                    'stock' => $record->reorder->stock
                ]);
            }
        }

        echo json_encode($array);
    }

    public function getAlert(){
        $data = Alert::orderBy('created_at', 'desc')->get();
        echo json_encode($data);
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
