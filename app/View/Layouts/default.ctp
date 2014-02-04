<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		//css
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('mystyle');
	?>

	
</head>
<body>
	<div class="container-fluid">
		<!-- Header -->
		<div class="header row-fluid" id="header">
			<div class="span2">
				<div class="logo thumbnails">
					<img src="<?php echo $this->webroot;?>img/logo.png" alt="logo" id="cpn-logo">
				</div>
			</div>
			
			<div class="span8 text-right header-bar">
				<a class="btn" id="search" data-animation="true" data-title="搜索" data-placement="bottom">
					<i class="icon-search"></i>
					搜索
				</a>
				<a class="btn" id="addProject" href="#AddProject" data-toggle="modal">
					<i class="icon-plus"></i>
					添加项目
				</a>
				<a class="btn">
					<i class="icon-comment"></i>
					消息
				</a>
				<a class="btn" href="<?=$this->webroot;?>users/logout">
					<i class="icon-road"></i>
					登出
				</a>
			</div>
			
			<div class="span2">
				<div class="avatar thumbnails">
					<span>
						<a id="user-avatar" class="thumbnail" href="<?=$this->webroot;?>uploads/upload" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="修改头像">
							<img src="<?php echo $this->webroot.$currentUser['pic_url'];?>" alt="wolf" id="user-avatar">
						</a>						
						<a id="user-name" href="<?=$this->webroot;?>users/edit" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="修改资料"><?=$currentUser['userName'];?></a>
					</span>					
				</div>
			</div>
			
			
			<!-- 添加项目 -->
			<div id="AddProject" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>添加项目</h3>
				</div>
				<form method="post" action="<?=$this->webroot;?>projects/create" onsubmit="return formCheck(this);">
					<div class="modal-body">						
						<fieldset>
							<div class="input-prepend">
								<span class="add-on">项目名称：</span>
								<input type="text" placeholder="Project name" name="name" id="project-name-input" required>
							</div>

							<div class="input-prepend">
								<span class="add-on">负责人员：</span>
								<input type="text" placeholder="Manager" name="leader" id="manager-input" autocomplete="off" data-provide="typeahead" data-items="4" required>
							</div>

							<div class="input-prepend">
								<span class="add-on">项目简介：</span>
								<textarea type="text" rows="3" placeholder="Description about this project" name="summary" id="description-input" required></textarea>
							</div>

							<div class="input-prepend input-append date" id="dp1">
								<span class="add-on">开始时间：</span>
								<input size="16" type="text" placeholder="Start time" name="startTime" id="startTime-input" autocomplete="off" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>

							<div class="input-prepend input-append date" id="dp2">
								<span class="add-on">结束时间：</span>
								<input size="16" type="text" placeholder="End time" name="endTime" id="endTime-input" autocomplete="off" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>
						</fieldset>					
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">关闭</p>
						<input class="btn" id="save-project" type="submit"></input>
					</div>
				</form>
			</div>
		</div>
		
		<!-- Main View -->
		<div class="row-fluid" id="main-view">
			<div class="span2" id="sidebar">					
				<!-- 栈式导航 -->
				<ul class="nav nav-tabs nav-stacked" id="myTab">
					<li id="project-list"><a class="meun-item" id="proj-m" href="<?php echo $this->webroot;?>projects">项目管理<i class="icon-chevron-right"></i></a></li>						
					<li><a class="meun-item" href="<?php echo $this->webroot;?>users">用户管理<i class="icon-chevron-right"></i></a></li>
					<li><a class="meun-item" href="<?php echo $this->webroot;?>efficiencies">效率查看<i class="icon-chevron-right"></i></a></li>
				</ul>	
			</div>
			
			<div class="span10" id="main-content">
				<!-- 面包屑导航 -->
				<ul class="breadcrumb" id="breadcrumb">
					<li><a href="<?=$this->webroot;?>">首页</a> <span class="divider">></span></li>	
				</ul>
				
				<?php
					echo $this->Html->script('jquery');
					echo $this->Html->script('bootstrap');
				?>
				
				
				<div id="content">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>

				<div id="footer">
					<p>©Loiter Company</p>
					<p>2013</p>
				</div>
			</div>
		</div>		
	</div>
	
	<?php 
		echo $this->element('sql_dump');
		echo $this->Html->script('bootstrap-datetimepicker'); 
		echo $this->Html->css('datetimepicker');
		echo $this->Html->css('bootstrap-switch');
		echo $this->Html->script('bootstrap-switch');
	?>
	
	<script type="text/javascript">
		var userList = eval("("+'<?=json_encode($users);?>'+")");


		// 检查输入的负责人是否存在
		function formCheck(form) {
			var inputs = form.getElementsByTagName("input");

			var inputName = inputs[1].value;
			for (var i = 0; i < userList.length; i++) {
				if (userList[i].name === inputName && userList[i].authority <= 2) {
					return true;
				} 
			};			

			inputs[1].focus();
			alert("所选用户不存在 或 所选用户权限不足");

			return false;
		}

		(function userListAutoComplete(userList) {
			

			var dataSource = Array();
			for (var i = 0; i < userList.length; i++) {
				if(userList[i].authority <= 2) {
					dataSource.push(userList[i].name);
				}
			}

			var source = $("#manager-input").attr("data-source", JSON.stringify(dataSource));
		})(userList);



		// 将php数组转化为js对象，并保存到全局环境中
		window.currentUserObj = eval("("+'<?php echo json_encode($currentUser);?>'+")");

		// 非boss不能创建项目
		if (window.currentUserObj.authority != 1) {
			$("#addProject").remove();
		}


		var mainHeight = parseInt($("#main-view").css('height')),
			winHeight = window.innerHeight - 56;
		var sidebarHeight = mainHeight > winHeight ? mainHeight : winHeight;

		$('#sidebar').css("height", sidebarHeight + "px");

		$('#dp1').datetimepicker({
			startDate: new Date(),
			todayBtn: true,
			format: 'hh:ii dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true,
			keyboardNavigation: true,
			showMeridian: true
		});

		$('#dp2').datetimepicker({
			startDate: new Date(),
			todayBtn: true,
			format: 'hh:ii dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true,
			keyboardNavigation: true,
			showMeridian: true
		});

		$('#search').popover({
			content: "<form class='form-search' id='search-form'><div class='input-append'><input type='text' class='input-medium search-query'><button type='submit' class='btn'><i class='icon-search'></i></button></div></form>",
			html: true
		});
		
		$("#user-avatar").tooltip();
		$("#user-name").tooltip();
	</script>
</body>
</html>
