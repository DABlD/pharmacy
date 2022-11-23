<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Theme, TransactionType};
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->table = "users";
    }

    public function get(Request $req){
        $array = User::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        $array = $array->get();

        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        echo json_encode($array);
    }

    public function store(Request $req){
        $user = new User();
        if($req->role == "Approver" && auth()->user()->role == "Admin"){
            $user->admin_id = auth()->user()->id;
        }
        $user->name = $req->name;
        $user->contact = $req->contact;
        $user->email = $req->email;
        $user->role = $req->role;
        if($req->address){
            $user->address = $req->address;
        }
        $user->username = $req->username;
        $user->password = $req->password;
        $user->save();
        if($req->role == "Admin"){
            $user->login_link = "?u=$user->id";
            $user->save();
        }

        if($user->role == "Admin"){
            $this->initAdmin($user);
        }
    }

    private function initAdmin($user){
        $array = [
            ["app_name", "SEDI"],
            ["logo_img", 'images/sedi_banner.png'],
            ["login_banner_img", "images/sedi_logo.png"],
            ["login_bg_img", null],
            ["sidebar_bg_color", "#343a40"],
            ["sidebar_font_color", "#c2c7d0"],
            ["table_header_color", "#b96666"],
            ["table_header_font_color", "#ffffff"],
            ["table_group_color", "#66b966"],
            ["table_group_font_color", "#ffffff"],
        ];

        foreach($array as $theme){
            $data = new Theme();
            $data->admin_id = $user->id;
            $data->name = $theme[0];
            $data->value = $theme[1];
            $data->save();
        }

        $array = [
            ["Physical Count", "+", 0, 0],
            ["Sales", "-", 0, 0],
            ["Sales Return", "+", 0, 0],
            ["Ending Inventory", null, 0, 0],
            ["Purchase Order", "+", 0, 0],
            ["Issued To", "-", 0, 0],
            ["Receive", "+", 0, 0],
            ["Adj. Entry Plus", "+", 0, 0],
            ["Adj. Entry Minus", "-", 0, 0]
        ];

        foreach($array as $type){
            $tType = new TransactionType();
            $tType->admin_id = auth()->user()->id;
            $tType->type = $type[0];
            $tType->operator = $type[1];
            $tType->inDashboard = $type[2];
            $tType->canDelete = $type[3];
            $tType->save();
        }
    }

    public function update(Request $req){
        DB::table($this->table)->where('id', $req->id)->update($req->except(['id', '_token']));
    }

    public function updatePassword(Request $req){
        $user = User::find($req->id);
        $user->password = $req->password;
        $user->save();
    }

    public function delete(Request $req){
        User::find($req->id)->delete();
    }

    public function restore(Request $req){
        User::withTrashed()->find($req->id)->restore();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}