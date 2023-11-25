
function change_make_group{
	let checker;
	let next;
	
	checker = document.getElementById("logcheck");
	next = document.getElementById("makecheck");
	if(checker.checked == true){
		checker.checked = false;
		next.checked = true;
	}
	
	else{
		checker.checked = true;
		next.checked = false;
	}
	
	
}
