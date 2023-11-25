let mode2;
let btn_text2;


document.getElementById("change").onclick = function(){
	mode2 = document.getElementById("make_pass");
	btn_text2 = document.getElementById("change");
	
	if(mode2.type == 'password'){
		mode2.type = 'text';
		btn_text2.textContent = '非表示';
	}
	
	else{
		mode2.type = 'password';
		btn_text2.textContent = '表示';
	}
	
}

