<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class AdminController extends Controller
{
    public function __construct(){
        $this->table = "users";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Admin'
        ]);
    }

    private function _view($view, $data = array()){
        return view("admins" . "." . $view, $data);
    }
}
