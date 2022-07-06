<?php

namespace App\Traits;

trait RhuAttribute{
	public function getActionsAttribute(){
		$id = $this->id;

		return 
		"<a class='btn btn-success' data-toggle='tooltip' title='View' onClick='view($id)'>" .
	        "<i class='fas fa-search'></i>" .
	    "</a>&nbsp;";
	}
}