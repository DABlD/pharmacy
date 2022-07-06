<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Rhu};
use DB;

class DatatableController extends Controller
{
    public function rhu(Request $req){
        $array = Rhu::select($req->select);

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

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $table){
                $array->load($table);
            }
        }

        foreach($array as $item){
            $item->actions = $item->actions;
        }
        echo json_encode($array->toArray());
    }
}