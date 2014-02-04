<div class="edit-view">
	<?php if($code != 0): ?>
		<div class="alert <?php if($code == 4):?>alert-success<?php endif; ?>">
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
		<div class="edit-header page-header well">
			<h3>编辑用户头像</h3>
		</div>
	</div>

	<div class="row-fluid">
		<h5>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp当前头像:</h5>
		<div class="span2">
			<div style="cursor: pointer;">
				<img class="img-polaroid" src="<?php echo $this->webroot;?><?=$currentUser['pic_url']?>" style="width:125px; height:125px;"></img>
			</div>
		</div>
		<div class="span5">
			<form method="post" action="<?=$this->webroot;?>uploads/upload" enctype="multipart/form-data">
				<div class="form-body">						
					<fieldset>
							<span class="add-on">头像：</span>
							<input type="file" name="avatar" id="avatar-input" onchange="preivew(this, document.getElementById('preview'));"></input>
					</fieldset>						
				</div>
				<button class="btn" type="submit">上传</button>
				<p>支持图片类型为：.jpg .jpeg .png .bmp .gif</p>
			</form>
			<img id="preview" style="height: 100px; width: 100px; visibility:hidden;">
		</div>
	</div>
</div>

<script>
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href=".">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active">编辑头像<span class="divider">></span></li>');
</script>