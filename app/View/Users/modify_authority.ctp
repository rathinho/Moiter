<div class="create-info">
	<div class="alert alert-success" style="text-align: center">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>修改权限成功.</strong> 
	</div>
	<div class="create-return">
		<span>
			<a href="<?php echo $this->webroot?>users/management">返回权限管理</a>
			<span>(</span>
			<span class="counter">3</span>
			<span>秒后自动返回)</span>
		</span>
	</div>
</div>

<script type="text/javascript">
	$(".create-info").ready(function() {
		var counter = 2;
		var tid = setInterval(function(){
			if(counter >= 0) {
				$(".counter").html(counter);
				counter -= 1;
			} else {
				clearInterval(tid);
			}
		}, 1000);

		setTimeout(function(){
			window.location.pathname = "<?=$this->webroot?>users/management";
		}, 3000);
	}); 
</script>