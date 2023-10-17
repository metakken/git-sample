let mode;
let btn_text;


document.getElementById("switch").onclick = function(){
	mode = document.getElementById("log_pass");
	btn_text = document.getElementById("switch");
	
	if(mode.type == 'password'){
		mode.type = 'text';
		btn_text.textContent = '非表示';
	}
	
	else{
		mode.type = 'password';
		btn_text.textContent = '表示';
	}
	
}

