<div class="edit-view">
	<?php if($code != 0): ?>
		<div class="alert <?php if($code == 4): ?>echo "alert-success"<?php endif; ?>">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>
				<?php 
					if($code == 1){
						echo "图片类型错误";
					}
					else if($code == 2){
						echo "图片大小不能超过300KB，请重新上传";
					}
					else if($code == 3){
						echo "图片上传失败";
					}
					else if($code == 4){
						echo "图片上传成功";
					}
				?>
			</strong>
		</div>
	<?php endif; ?>
	
	<div class="row-fluid">
		<div class="edit-header">
			<h3>编辑用户头像</h3>
		</div>
	</div>
	<div class="span5">
		<form method="post" action="<?=$this->webroot;?>uploads/upload" enctype="multipart/form-data">
			<div class="form-body">						
				<fieldset>
						<span class="add-on">头像：</span>
						<input type="file" name="avatar" id="avatar-input"></input>
				</fieldset>						
			</div>
			<button class="btn" type="submit">上传</button>
			<p>支持图片类型为：.jpg .jpeg .png .bmp .gif</p>
		</form>
	</div>
</div>

<script>
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href=".">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active">编辑头像<span class="divider">></span></li>');
</script>