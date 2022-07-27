<?php

namespace App\Traits;

trait RequestAttribute{
	public function getActionsAttribute(){
		$id = $this->id;

		$string = "";

		if($this->status == "For Approval"){
			if(auth()->user()->role == "Admin"){
		    	$string .= "<a class='btn btn-success' data-toggle='tooltip' title='Approve' onClick='updateStatus($id, `Approve`, `Approved`)'>" .
			        "<i class='fas fa-check'></i>" .
			    "</a>&nbsp;";
			}

			$action = auth()->user()->role == "Admin" ? "Decline" : "Cancel";
			$status = auth()->user()->role == "Admin" ? "Declined" : "Cancelled";

	    	$string .= "<a class='btn btn-danger' data-toggle='tooltip' title='$action' onClick='updateStatus($id, `$action`, `$status`)'>" .
		        "<i class='fas fa-ban'></i>" .
		    "</a>&nbsp;";
		}
		elseif($this->status == "Approved"){
	    	$string .= "<a class='btn btn-info' data-toggle='tooltip' title='Input Info' onClick='inputInfo($id)'>" .
		        "<i class='fas fa-pencil'></i>" .
		    "</a>&nbsp;";
		}

	    return $string;
	}
}