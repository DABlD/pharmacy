<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Rhu, Bhc, Medicine, Category, TransactionType, Request as Req};
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

    public function bhc(Request $req){
        $array = Bhc::select($req->select);

        // IF HAS JOIN //CUSTOM
        if($req->join){
            $array = $array->join('rhus as r', 'r.id', '=', "bhcs.rhu_id");
        }

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
        $array = $this->addRhus($array);
        echo json_encode($array->toArray());
    }

    private function addRhus($array){
        $rhus = Rhu::all();

        foreach($rhus as $rhu){
            $temp = new Rhu();
            $temp->id = null;
            $temp->rhu = $rhu;
            $temp->name = null;
            $temp->code = null;
            $temp->region = null;
            $temp->municipality = null;
            $temp->actions = null;

            $array->push($temp);
        }

        return $array;
    }

    public function medicine(Request $req){
        $array = Medicine::select($req->select)
                    ->join("reorders as r", "r.medicine_id", '=', 'medicines.id');

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }
        
        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
            $array = $array->where('r.deleted_at', null);
        }

        $array = $array->get();
        // IF HAS GROUP
        if($req->group){
            $array = $array->groupBy($req->group);
        }

        // IF HAS LOAD
        if($array->count() && $req->load){
            foreach($req->load as $key => $table){
                $array->load($table);
            }
        }

        foreach($array as $key => $item){
            $item->actions = $item->actions;
        }

        $array = $this->addCategories($array)->values();
        echo json_encode($array->toArray());
    }

    public function medicine2(Request $req){
        $array = Medicine::select($req->select)
                    ->join("reorders as r", "r.medicine_id", '=', 'medicines.id');

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }
        
        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
            $array = $array->where('r.deleted_at', null);
        }

        if(auth()->user()->role != "Admin"){
            $array = $array->where('r.user_id', auth()->user()->id);
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

    private function addCategories($array){
        $categories = Category::all();

        foreach($categories as $category){

            $temp = new Medicine();
            $temp->id = null;
            $temp->category = $category;
            $temp->image = null;
            $temp->code = null;
            $temp->brand = null;
            $temp->name = null;
            $temp->packaging = null;
            $temp->unit_price = null;
            $temp->cost_price = null;
            $temp->reorder = (object)["point" => null, "stock" => null];
            $temp->actions = null;

            $array->push($temp);
        }

        return $array;
    }

    public function transactionType(Request $req){
        $array = TransactionType::select($req->select);

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

    public function approver(Request $req){
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

    public function requests(Request $req){
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

    public function receive(Request $req){
        $array = Req::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
            $array = $array->where($req->where[2], $req->where[3], $req->where[4]);
        }

        // IF HAS WHEREIN
        if($req->whereIn){
            $array = $array->whereIn($req->whereIn[0], $req->whereIn[1]);
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