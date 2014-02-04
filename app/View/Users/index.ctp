<div class="tab-content">
	<!-- 用户管理 -->
	<div class="tab-pane active" id="user-management">
		<!-- 项目缩略图 -->
		<ul class="thumbnails">
			<?php
				foreach($users as $user){
			?>
			<li class="span2" style="margin-left: 15px;">
				<div class="thumbnail" style="cursor: pointer;" onclick="location.href='<?=$this->webroot;?>users/view/<?=$user['_id']?>'">
					<img class="img-polaroid" src="<?php echo $this->webroot;?><?=$user['pic_url']?>" style="width:125px; height:100px;"></img>
					<h5 class="label" style="display: block; text-align: center;"><?php echo $user['name'];?></h5>
				</div>
			</li>
			
			<?php
				}
			?>			
		</ul>
	</div>
</div>

<script>
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href=".">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active">用户管理 <span class="divider">></span></li>');

	var userId = "<?=$currentUser['user_id']?>",
		userAuthority = <?=$currentUser['authority']?>;
	
	if(userAuthority === 1) {
		pathname = "<?=$this->webroot?>users/management/";
		$(".breadcrumb").append("<li id='authority-management-entrance'><a href='"+pathname+"'><i class='icon-user'></i>权限管理</a></li>");
	}
</script>