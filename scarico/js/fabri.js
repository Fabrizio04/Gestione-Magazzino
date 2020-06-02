function disableMenu(){
	var x = document.querySelectorAll('a');
	
	for (i = 0; i < x.length; i++) {
		x[i].href = "javascript:void(0);";
	}
	
	document.getElementById("myInput").disabled = true;
}

function loading(){
	document.getElementById("myUL").style.display = "none";
	document.getElementById("load_gif").style.display = "";
}

function mostra(id){
	var a = document.getElementById(id).style;
	
	switch(id){
		case "car":
		a.display = a.display=='block'?'none':'block'
		document.getElementById("scar").style.display = 'none';
		location.href="#car";
		break;
		
		case "scar":
		a.display = a.display=='block'?'none':'block'
		document.getElementById("car").style.display = 'none';
		location.href="#scar";
		break;
	}
}