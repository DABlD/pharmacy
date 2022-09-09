<div class="row">
	<div class="col-md-3 {{ auth()->user()->role == "RHU" ? "d-none" : ''; }}">

	    <div class="row iRow">
	        <div class="col-md-4 iLabel" style="margin: auto;">
	            Select RHU
	        </div>
	        <div class="col-md-8 iInput">
	        	<select id="rhu" class="form-control">
	        	</select>
	        </div>
	    </div>

	</div>

	<div class="col-md-3">

	    <div class="row iRow">
	        <div class="col-md-4 iLabel" style="margin: auto;">
	            Select BHC
	        </div>
	        <div class="col-md-8 iInput">
	        	<select id="bhc" class="form-control">
	        	</select>
	        </div>
	    </div>

	</div>
</div>

<br>

<div class="row">
	<div class="col-md-3" id="from"></div>
	<div class="col-md-3" id="to"></div>
</div>