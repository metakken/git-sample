let mode3;
let btn_text3;


document.getElementById("kirikae").onclick = function(){
	mode3 = document.getElementById("newpass");
	btn_text3 = document.getElementById("kirikae");
	
	if(mode3.type == 'password'){
		mode3.type = 'text';
		btn_text3.textContent = '非表示';
	}
	
	else{
		mode3.type = 'password';
		btn_text3.textContent = '表示';
	}
	
}

