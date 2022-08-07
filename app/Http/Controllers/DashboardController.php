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

        return $this->_view('dashboard', [
            'title'         => 'Dashboard'
        ]);
    }

    private function _view($view, $data = array()){
        return view($view, $data);
    }
}
