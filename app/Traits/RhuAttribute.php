<?php

namespace App\Traits;

trait RhuAttribute{
	public function getActionsAttribute(){
		$id = $this->id;
		$uid = $this->user_id;

		return 
		"<a class='btn btn-success' data-toggle='tooltip' title='View' onClick='view($id)'>" .
	        "<i class='fas fa-search'></i>" .
	    "</a>&nbsp;" . 
		"<a class='btn btn-info' data-toggle='tooltip' title='Assign Products' onClick='assign($uid)'>" .
	        "<i class='fa-solid fa-cart-arrow-down'></i>" .
	    "</a>&nbsp;" . 
		"<a class='btn btn-danger' data-toggle='tooltip' title='Delete' onClick='del($id)'>" .
	        "<i class='fas fa-trash'></i>" .
	    "</a>&nbsp;";
	}
}