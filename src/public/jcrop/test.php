<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Insert title here</title>
<script src="/js/jquery/jquery-1.6.2.min.js"></script>
<script src="/js/jquery/plugins/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="/js/jquery/plugins/jcrop/css/jquery.Jcrop.css" type="text/css" />
<script language="Javascript">
$(function() {
	$('#cropbox').Jcrop({
		aspectRatio: 0.86,
		onSelect: updateCoords
	});
});
function updateCoords(c) {
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
}
function checkCoords() {
	if (parseInt($('#w').val())) return true;
	alert('Please select a crop region then press submit.');
	return false;
}
</script>
</head>
<body>
<img src="/jcrop/demos/demo_files/flowers.jpg" id="cropbox" />
<form action="crop.php" method="post" onsubmit="return checkCoords();">
	<input type="hidden" id="x" name="x" />
	<input type="hidden" id="y" name="y" />
	<input type="hidden" id="w" name="w" />
	<input type="hidden" id="h" name="h" />
	<input type="submit" value="Crop Image" />
</form>
</body>
</html>