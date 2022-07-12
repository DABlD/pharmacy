<?php

namespace App\Traits;

trait MedicineAttribute{
	public function getActionsAttribute(){
		$id = $this->id;

		$string = "<a class='btn btn-success' data-toggle='tooltip' title='View' onClick='view($id)'>" .
	        "<i class='fas fa-search'></i>" .
	    "</a>&nbsp;";

	    if(auth()->user()->role == "Admin"){
	    	$string .= "<a class='btn btn-danger' data-toggle='tooltip' title='Delete' onClick='del($id)'>" .
		        "<i class='fas fa-trash'></i>" .
		    "</a>&nbsp;";
	    }

	    return $string;
	}
}