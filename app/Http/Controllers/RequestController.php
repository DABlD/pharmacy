<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as Req;
use App\Models\Reorder;

use DB;

class RequestController extends Controller
{
    public function __construct(){
        $this->table = "requests";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Requesition Entry'
        ]);
    }

    public function create(){
        return $this->_view('create', [
            'title' => 'Add Request'
        ]);
    }

    public function get(Request $req){
        $array = Req::select($req->select);

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

            $data = new Req();

            $aId = auth()->user()->id;
            $name = auth()->user()->name;
            $data->stock = Reorder::where('user_id', 1)->where('medicine_id', $temp->medicine_id)->first()->stock;

            $data->user_id = $aId;
            $data->reference = $temp->reference;
            $data->requested_by = $temp->requested_by . " ($name)";
            $data->medicine_id = $temp->medicine_id;
            $data->request_qty = $temp->request_qty;
            $data->unit_price = $temp->unit_price;
            $data->amount = $temp->amount;
            $data->transaction_date = $temp->transaction_date;

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

    public function delete(Request $req){
        Req::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
