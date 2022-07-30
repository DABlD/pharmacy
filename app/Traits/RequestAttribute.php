<?php

namespace App\Traits;

trait RequestAttribute{
	public function getActionsAttribute(){
		$id = $this->id;
		$ref = $this->reference;

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
	    	$string .= "<a class='btn btn-info' data-toggle='tooltip' title='Input Info' onClick='inputInfo($ref)'>" .
		        "<i class='fas fa-pencil'></i>" .
		    "</a>&nbsp;";
		}
		elseif($this->status == "For Delivery"){
	    	$string .= "<a class='btn btn-success' data-toggle='tooltip' title='Receive' onClick='receive($id)'>" .
		        "<i class='fa-light fa-inbox-in'></i>" .
		    "</a>&nbsp;";
		}

	    return $string;
	}
}