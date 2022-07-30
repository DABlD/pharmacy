<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use DB;

class DataController extends Controller
{
    public function __construct(){
        $this->table = "datas";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Data Entry'
        ]);
    }

    public function get(Request $req){
        $array = Data::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        echo json_encode($array);
    }

    public function store(Request $req){
        foreach($req->data as $temp){
            $temp = (object)$temp;

            $data = new Data();
            $data->medicine_id = $temp->medicine_id;
            $data->transaction_types_id = $temp->transaction_types_id;
            $data->reference = $temp->reference;
            $data->particulars = $temp->particulars;
            $data->lot_number = $temp->lot_number;
            $data->expiry_date = $temp->expiry_date;
            $data->qty = $temp->qty;
            $data->unit_price = $temp->unit_price;
            $data->amount = $temp->amount;
            $data->transaction_date = $temp->transaction_date;
            $data->user_id = auth()->user()->id;

            if(isset($temp->bhc_id)){
                $data->bhc_id = $temp->bhc_id;
            }
            $data->save();
        }
    }

    public function update(Request $req){
        $query = DB::table($this->table);

        if($req->where){
            $query = $query->where($req->where[0], $req->where[1])->update($req->except(['id', '_token', 'where']));
        }
        else{
            $query = $query->where('id', $req->id)->update($req->except(['id', '_token']));
        }
    }

    public function updateStock($uid, $mid, $operator, $num){
        $reorder = Reorder::where('user_id', $uid)->where('medicine_id', $mid);

        if($operator == "+"){
            $reorder->increment('stock', $num);
        }
        elseif($operator == "-"){
            $reorder->decrement('stock', $num);
        }
    }

    public function delete(Request $req){
        Data::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
