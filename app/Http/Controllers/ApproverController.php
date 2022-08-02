<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class ApproverController extends Controller
{
    public function __construct(){
        $this->table = "users";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Approver'
        ]);
    }

    private function _view($view, $data = array()){
        return view("approvers" . "." . $view, $data);
    }
}
