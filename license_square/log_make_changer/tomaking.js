let checker;
let next;

let checker2;
let next2;


function clicker(){
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

function clicker2(){
checker2 = document.getElementById("makecheck");
	next2 = document.getElementById("logcheck");
	if(checker2.checked == true){
		checker2.checked = false;
		next2.checked = true;
	}
	
	else{
		checker2.checked = true;
		next2.checked = false;
	}
}
