<?php
	pr($companies);
?>

<div id="nav-active">
<?php
	$arr = array();
	$arr[] = "Test";
	$arr[] = "Test2";	
?>
</div>




















<script>
//	$("#proj-m").remove();
	$("#proj-m").addClass("test");
	$("#project-list").after("<li><a class='meun-item' href='#' data-toggle='tab'><?php echo $arr[0];?></a></li>");
	$("#project-list").after("<li><a class='meun-item' href='#' data-toggle='tab'><?php echo $arr[1];?></a></li>");
</script>