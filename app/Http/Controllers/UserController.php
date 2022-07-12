<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $user->name = $req->name;
        $user->contact = $req->contact;
        $user->email = $req->email;
        $user->role = $req->role;
        $user->save();
    }

    public function update(Request $req){
        DB::table($this->table)->where('id', $req->id)->update($req->except(['id', '_token']));
    }

    public function updatePassword(Request $req){
        $user = User::find(auth()->user()->id);
        $user->password = $req->password;
        $user->save();
    }

    public function delete(Request $req){
        User::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
