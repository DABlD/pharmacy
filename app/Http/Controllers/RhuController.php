<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Rhu};
use DB;

class RhuController extends Controller
{
    public function __construct(){
        $this->table = "rhus";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Rural Health Unit'
        ]);
    }

    public function get(Request $req){
        $array = DB::table($this->table)->select($req->cols);

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
        $user->address = $req->address;
        $user->username = $req->username;
        $user->password = $req->password;
        $user->role = "RHU";
        $user->save();

        $rhu = new RHU();
        $rhu->user_id = $user->id;
        $rhu->company_name = $req->company_name;
        $rhu->contact_personnel = $req->contact_personnel;
        $rhu->company_code = ""; //LEAVE TO MUTATORS
        $rhu->save();
    }

    public function update(Request $req){
        DB::table($this->table)->where('id', $req->id)->update($req->except(['id', '_token']));
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}
