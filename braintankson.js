function fazBolha(st, num) {
	var x = document.getElementById("som");
	x.play();
	if (num % 4 == 0) {
		document.getElementById(st).className += " bounce1";
	} else if (num % 4 == 1) {
		document.getElementById(st).className += " bounce2";
	} else if (num % 4 == 2) {
		document.getElementById(st).className += " bounce3";
	} else {
		document.getElementById(st).className += " bounce4";
	}
}

function playost() {
	document.getElementById("audio").play();
}
