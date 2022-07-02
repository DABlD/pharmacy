let errorColor = "#f76c6b";
let successColor = "#28a745";

function ss(title = "", text = ""){
	Swal.fire({
		icon: "success",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButtom: false
	});
};

function se(title = "", text = ""){
	Swal.fire({
		icon: "danger",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButtom: false
	});
};

function sc(title = "", text = ""){
	Swal.fire({
		icon: "danger",
		title: title,
		text: text,
	});
};

function input(name, placeholder, value, c1, c2, type = "text", autocomplete=""){
    return `
        <div class="row iRow">
            <div class="col-md-${c1} iLabel">
                ${placeholder}
            </div>
            <div class="col-md-${c2} iInput">
                <input type="${type}" name="${name}" placeholder="Enter ${placeholder}" class="form-control" value="${value ?? ""}" ${autocomplete}>
            </div>
        </div>
    `;
};