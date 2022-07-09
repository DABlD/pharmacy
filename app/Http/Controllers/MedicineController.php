<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Medicine, Reorder};
use DB;

class MedicineController extends Controller
{
    public function __construct(){
        $this->table = "medicines";
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'SKU'
        ]);
    }

    public function get(Request $req){
        $array = Medicine::select($req->select);

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

    public function getCategories(Request $req){
        $array = Category::select($req->select);

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
        $entry = new Medicine();
        $entry->user_id = $req->user_id ?? auth()->user()->id;
        $entry->category_id = $req->category_id;
        $entry->code = $req->code;
        $entry->brand = $req->brand;
        $entry->name= $req->name;
        $entry->packaging= $req->packaging;
        $entry->unit_price= $req->unit_price;
        $entry->cost_price= $req->cost_price;
        $entry->save();

        $reorder = new Reorder();
        $reorder->user_id = $entry->user_id;
        $reorder->medicine_id = $req->medicine_id;
        $reorder->point = $req->reorder_point;
        $reorder->save();
    }

    public function storeCategory(Request $req){
        $entry = new Category();
        $entry->name = $req->name;
        $entry->save();
    }

    public function update(Request $req){
        DB::table($this->table)->where('id', $req->id)->update($req->except(['id', '_token']));
    }

    public function delete(Request $req){
        Medicine::find($req->id)->delete();
    }

    public function deleteCategory(Request $req){
        Category::find($req->id)->delete();
    }

    private function _view($view, $data = array()){
        return view($this->table . "." . $view, $data);
    }
}