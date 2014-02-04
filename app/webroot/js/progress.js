function drawCircle(id, percentage) {
	var canvas = document.getElementById("progress-" + id);

	var ctx = canvas.getContext("2d");

	var grd = ctx.createLinearGradient(70, 8, 70, 132);
	grd.addColorStop(0, "#B0B0B0");
	grd.addColorStop(1, "#EEEEEE");
	var angle = percentage * 2;

	ctx.fillStyle = grd;
	ctx.strokeStyle = "#E1E1E1";
	ctx.beginPath();
	ctx.arc(52, 52, 50, 0, 2 * Math.PI);
	ctx.fill();
	ctx.stroke();

	ctx.beginPath();
	ctx.moveTo(52, 52);
	ctx.arc(52, 52, 43, -0.5 * Math.PI, 1.5 * Math.PI, true);
	ctx.fill();
	ctx.stroke();

	ctx.fillStyle = "#0088cc";
	ctx.beginPath();
	ctx.moveTo(52, 52);
	ctx.arc(52, 52, 42, -0.5 * Math.PI, (-0.5 - angle) * Math.PI, true);
	ctx.fill();
	ctx.stroke();


	ctx.fillStyle = "#eef3e2";
	ctx.beginPath();
	ctx.arc(52, 52, 36, 0, 2 * Math.PI);
	ctx.fill();
	ctx.stroke();

	ctx.fillStyle = "#555";
	ctx.font = "20px Arial";
	ctx.textAlign="center";

	if (isNaN(percentage)) {
		ctx.fillText("0.0%", 52, 58);
	} else {
		ctx.fillText((percentage * 100).toFixed(1) + "%", 52, 58);
	}
}