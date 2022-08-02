<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\Report;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\{Data, Request as Req};

class ExportController extends Controller
{
    public function exportBinCard(Request $req){
        $data = Data::orderBy('transaction_date', 'desc')->get();

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
                    "Category" => $record->reorder->medicine->category->name,
                    "Item" => $name,
                    "Type" => $record->transaction_type->type,
                    "Receiving" => $receiving,
                    "Issuance" => $issuance,
                    "Running Balance" => $balance,
                    "Date" => $record->transaction_date->toDateString(),
                ]);
            }
        }

        $headers = array_keys($array[0]);
        $title = "Bin Report - " . now()->toDateString();
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
    }

    public function exportInventory(Request $req){
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
                    ["Item" => $medicine[0]->reorder->medicine->name], 
                    $tempDates
                ),
            );
        }

        $headers = array_keys($array[0]);
        $title = "Inventory Report - $from to $to";
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
    }

    public function exportSales(Request $req){
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
                        ["Item" => $title], 
                        $tempDates
                    ),
                    ["Total" => $grandTotal]
                )
            );
        }

        $headers = array_keys($array[0]);
        $title = "Sales Report - $from to $to";
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
    }

    public function exportPurchaseOrder(Request $req){
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
                        ["Item" => $group[0]->reorder->medicine->name], 
                        $tempDates
                    ),
                    ["Total" => $grandTotal]
                )
            );
        }

        $headers = array_keys($array[0]);
        $title = "Purchase Order Report - $from to $to";
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
    }

    public function exportDailySheet(Request $req){
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
                    ["Item" => $group[0]->reorder->medicine->name], 
                    array_reverse($tempDates)
                ),
            );
        }

        $headers = array_keys($array[0]);
        $title = "Daily Sheet Report - $from to $to";
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
    }

    public function exportRequests(Request $req){
        $array = Req::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        $array = $array->get();

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }
        $array = $array->groupBy("user_id");

        $headers = ["ID", "Ref No", "Requestor", "Category", "Item", "Stock", "Request Qty", "Approved Qty", "Request Date", "Received Qty", "Received Date", "Status"];

        $data = [];
        foreach($array as $rhus){
            array_push($data, ["group" => $rhus[0]->rhu->company_name, "cols" => 12]);

            foreach($rhus as $item){
                $temp = [];
                $temp["ID"] = $item->id;
                $temp["Ref No"] = $item->reference;
                $temp["Requestor"] = $item->requested_by;
                $temp["Category"] = $item->medicine->category->name;
                $temp["Item"] = $item->medicine->name;
                $temp["Stock"] = $item->stock;
                $temp["Request Qty"] = $item->request_qty;
                $temp["Approved Qty"] = $item->approved_qty ?? "N/A";
                $temp["Request Date"] = $item->transaction_date->toDateString();
                $temp["Received Qty"] = $item->received_qty ?? "N/A";
                $temp["Received Date"] = $item->received_date ? $item->received_date->toDateString() : "N/A";
                $temp["Status"] = $item->status;

                array_push($data, $temp);
            }
        }

        $array = $data;
        $date = now()->toDateString();
        $title = "Requests - $date";
        return Excel::download(new Report($headers, $title, $array), $title . ".xlsx");
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
}