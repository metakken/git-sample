let checker2;
let next2;

document.getElementById("tologin").onclick = function(){
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
