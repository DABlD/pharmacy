<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as Req;
use App\Models\{Reorder, Data};

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

    public function inputInfo(Request $req){
        $data = Req::where('reference', $req->ref)->where('status', 'Approved')->get();

        return $this->_view('inputInfo', [
            'title' => 'Input Info',
            'data' => $data,
        ]);
    }

    public function receive(Request $req){
        return $this->_view('receive', [
            'title' => 'Receive'
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

        if(isset($req->status) && $req->status == "Approved"){
            $request = Req::find($req->id);

            $this->updateStock(1, $request->medicine_id, "-", $request->approved_qty);
            $this->updateStock($request->user_id, $request->medicine_id, "+", $request->approved_qty);
        }
        elseif(isset($req->status) && $req->status == "For Delivery"){
            $request = Req::find($req->id);

            $data = new Data();
            $data->user_id = $request->user_id;
            $data->medicine_id = $request->medicine_id;
            $data->transaction_types_id = 6;
            $data->reference = $request->reference;
            $data->particulars = $request->requested_by;
            $data->lot_number = $request->lot_number;
            $data->expiry_date = $request->expiry_date;
            $data->qty = $request->approved_qty;
            $data->unit_price = $request->unit_price;
            $data->amount = $request->amount;
            $data->transaction_date = $request->transaction_date;
            $data->save();
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
        Req::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
