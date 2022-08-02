<?php

namespace App\Traits;

trait RequestAttribute{
	public function getActionsAttribute(){
		$id = $this->id;
		$ref = $this->reference;

		$string = "";

		if($this->status == "For Approval"){
			if(in_array(auth()->user()->role, ["Admin", "Approver"])){
		    	$string .= "<a class='btn btn-success' data-toggle='tooltip' title='Approve' onClick='updateStatus($id, `Approve`, `Approved`)'>" .
			        "<i class='fas fa-check'></i>" .
			    "</a>&nbsp;";
			}

			$action = in_array(auth()->user()->role, ["Admin", "Approver"]) ? "Decline" : "Cancel";
			$status = in_array(auth()->user()->role, ["Admin", "Approver"]) ? "Declined" : "Cancelled";

	    	$string .= "<a class='btn btn-danger' data-toggle='tooltip' title='$action' onClick='updateStatus($id, `$action`, `$status`)'>" .
		        "<i class='fas fa-ban'></i>" .
		    "</a>&nbsp;";
		}
		elseif($this->status == "Approved" && auth()->user()->role == "Admins"){
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