<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Request as Req, Data, Alert};
use Auth;

class DashboardController extends Controller
{
    function index(){
        if(auth()->user()->role == "Approver"){
            return redirect()->route('request.request')->send();
        }

        // GET REQUESTS
        $requests = Req::whereBetween("transaction_date", [now()->startOfMonth(), now()->endOfMonth()])->select("transaction_date")->get();
        $rtm = $requests->count();
        $rt = 0;

        foreach($requests as $request){
            if($request->transaction_date->startOfDay()->toDateString() == now()->startOfDay()->toDateString()){
                $rt++;
            }
        }

        // GET DATA
        $datas = Data::whereBetween("transaction_date", [now()->startOfMonth(), now()->endOfMonth()])
                        ->whereIn('transaction_types_id', [6,7])
                        ->select("transaction_date", "transaction_types_id")->get();
        $itm = 0;
        $it = 0;
        $rcvtm = 0;
        $rcvt = 0;

        foreach($datas as $data){
            if($transaction_types_id == 6){
                $itm++;
                if($data->transaction_date->startOfDay()->toDateString() == now()->startOfDay()->toDateString()){
                    $it++;
                }
            }
            else{
                $rcvtm++;
                if($data->transaction_date->startOfDay()->toDateString() == now()->startOfDay()->toDateString()){
                    $rcvt++;
                }
            }
        }

        // GET ALERTS
        $alerts = Alert::whereBetween("created_at", [now()->startOfMonth(), now()->endOfMonth()])->select("created_at")->get();
        $atm = $alerts->count();
        $at = 0;

        foreach($alerts as $alert){
            if($alert->created_at->startOfDay()->toDateString() == now()->startOfDay()->toDateString()){
                $at++;
            }
        }

        return $this->_view('dashboard', [
            'title'         => 'Dashboard',
            'rtm'           => $rtm,
            'rt'            => $rt,
            'itm'           => $itm,
            'it'            => $it,
            'rcvtm'         => $rcvtm,
            'rcvt'          => $rcvt,
            'atm'           => $atm,
            'at'            => $at
        ]);
    }

    private function _view($view, $data = array()){
        return view($view, $data);
    }
}
