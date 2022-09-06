<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use DB;
use Image;

class ThemeController extends Controller
{   
    public function __construct(){
        $this->table = "themes";
    }

    public function get(Request $req){
        $array = Theme::select($req->select);

        // IF HAS SORT PARAMETER $ORDER
        if($req->order){
            $array = $array->orderBy($req->order[0], $req->order[1]);
        }

        // IF HAS WHERE
        if($req->where){
            $array = $array->where($req->where[0], $req->where[1]);
        }

        // IF HAS WHERENOTNULL
        if($req->whereNotNull){
            $array = $array->whereNotNull($req->whereNotNull);
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

    public function update(Request $req){
        $aid = $req->admin_id;
        $themes = $req->except('logo_img', 'login_banner_img', 'login_bg_img', '_token', 'admin_id');
        foreach($themes as $key => $theme){
            $temp = Theme::where('name', $key)->where('admin_id', $aid)->first();
            $temp->value = $theme;
            $temp->save();
        }

        if($req->hasFile('logo_img')){
            $theme = Theme::where('name', 'logo_img')->where('admin_id', $aid)->first();

            $temp = $req->file('logo_img');
            $image = Image::make($temp);

            $name = 'logo_img - ' . time() . "." . $temp->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');
            $image->save($destinationPath . $name);

            $theme->value = 'uploads/' . $name;
            $theme->save();
        }
        if($req->hasFile('login_banner_img')){
            $theme = Theme::where('name', 'login_banner_img')->where('admin_id', $aid)->first();

            $temp = $req->file('login_banner_img');
            $image = Image::make($temp);

            $name = 'login_banner_img - ' . time() . "." . $temp->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');
            $image->save($destinationPath . $name);
            
            $theme->value = 'uploads/' . $name;
            $theme->save();
        }
        if($req->hasFile('login_bg_img')){
            $theme = Theme::where('name', 'login_bg_img')->where('admin_id', $aid)->first();

            $temp = $req->file('login_bg_img');
            $image = Image::make($temp);

            $name = 'login_bg_img - ' . time() . "." . $temp->getClientOriginalExtension();
            $destinationPath = public_path('uploads/');
            $image->save($destinationPath . $name);
            
            $theme->value = 'uploads/' . $name;
            $theme->save();
        }

        // $query = DB::table($this->table);

        // if($req->where){
        //     $query = $query->where($req->where[0], $req->where[1])->update($req->except(['id', '_token', 'where']));
        // }
        // else{
        //     $query = $query->where('id', $req->id)->update($req->except(['id', '_token']));
        // }
    }
}
