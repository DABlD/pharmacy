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
        $data = new Data();
        $data->medicine_id = $req->medicine_id;
        $data->transaction_types_id = $req->transaction_types_id;
        $data->reference = $req->reference;
        $data->particulars = $req->particulars;
        $data->lot_number = $req->lot_number;
        $data->expiry_date = $req->expiry_date;
        $data->qty = $req->qty;
        $data->unit_price = $req->unit_price;
        $data->amount = $req->amount;
        $data->save();
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

    public function delete(Request $req){
        Data::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
