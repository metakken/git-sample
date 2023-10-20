let checker;
let next;

document.getElementById("tomake").onclick = function(){
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
