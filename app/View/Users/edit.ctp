<div class="edit-view">
	<?php if($update): ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>保存成功!</strong>
		</div>
	<?php endif; ?>
	
	<div class="row-fluid">
		<div class="edit-header page-header well">
			<h3>编辑用户资料</h3>
		</div>
	</div>
	<div class="span5">
		<form method="post" action="<?=$this->webroot;?>users/edit">
			<div class="form-body">						
				<fieldset>
					<div class="input-prepend">
						<span class="add-on">用户名称：</span>
						<input type="text" placeholder="Name..." name="name" id="name-input" value="<?php echo $back['name'];?>" disabled></input>
					</div>
					<div class="input-prepend">
						<span class="add-on">电话号码：</span>
						<input type="text" placeholder="Tel..." name="tel" id="tel-input" value="<?php echo $back['tel'];?>"></input>
					</div>
					<div class="input-prepend">
						<span class="add-on">邮箱地址：</span>
						<input type="text" placeholder="Email..." name="email" id="email-input" value="<?php echo $back['email'];?>"></input>
					</div>
					<div class="input-prepend">
						<span class="add-on">公司：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
						<input type="text" placeholder="Company..." name="company" id="company-input" value="<?php echo $back['company'];?>"></input>
					</div>
					<div class="input-prepend">
						<span class="add-on">职位：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
						<input type="text"placeholder="Position..." name="position" id="position-input" value="<?php echo $back['position'];?>"></input>
					</div>
				</fieldset>						
			</div>
			<div class="btn-group" >
				<button class="btn" type="submit">保存</button>
				<button class="btn" type="reset">重置</button>
				<button class="btn" type="button">取消</button>
			</div>
		</form>
	</div>
</div>

<script>
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href=".">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active">编辑用户<span class="divider">></span></li>');
</script>