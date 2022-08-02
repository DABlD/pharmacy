<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Exports\Report;
use Maatwebsite\Excel\Facades\Excel;
use DOMDocument;

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
        $title = "Bin Report - " . now()->toDateString() . '.xlsx';
        return Excel::download(new Report($headers, $title, $array), $title);
    }
}