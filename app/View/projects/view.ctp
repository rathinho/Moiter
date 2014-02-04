<?php
	echo $this->Html->script('progress');
	echo $this->Html->css('datetimepicker');
	echo $this->Html->script('bootstrap-datetimepicker');
?>

<div class="project-view">
	<div class="row-fluid">
		<div class="span2" >		
			<div class="project-logo thumbnails" style="height:115px; width: 114px;" >
				<a class="thumbnail" href="#">
					<canvas class="project-progress" id="progress-<?=$project['_id']?>" width="114" height="103"></canvas>
				</a>				
			</div>
		</div>
		<div class="span9" style="font-family: '微软雅黑', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
			<h3><span class="label label-info">项目名称&nbsp&nbsp&nbsp</span>&nbsp<?=$project['name'];?></h2>
			<p><span class="label label-info">项目负责人</span>&nbsp&nbsp&nbsp<?=$project['leader'];?></p>
			<p><span class="label label-info">项目简介&nbsp&nbsp&nbsp</span>&nbsp&nbsp&nbsp<?=$project['summary'];?></p>
			
			
			<!-- 添加任务 -->
			<div id="AddTask" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>添加任务</h3>
				</div>
				<?php if(count($stages) == 0) {?>
					<div class="alert">
						<strong>请先创建阶段!</strong>
					</div>
				<?php } 
					  else {
				?>
				<form method="post" action="<?=$this->webroot;?>tasks/create">
					<div class="modal-body">
						<fieldset>
							<div class="input-prepend">
								<span class="add-on">任务名称：</span>
								<input type="text" placeholder="Task name" name="content" id="project-name-input" required>
							</div>
							<div class="input-prepend">
								<!-- <span class="add-on">负责人员：</span> -->
								<input type="hidden" name="leader" id="manager-input" value="<?=$currentUser['userName'];?>" required>

							</div>
							<div class="input-prepend">
								<span class="add-on">阶段：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
								<select name="stage_id">
									<?php for($i = 0 ; $i < count($stages) ; $i++) { ?>
										<option value="<?php echo $stages[$i]['_id'];?>"><?php echo $i+1;?></option>
									<?php } ?>									
								</select>
							</div>

							<div class="input-prepend">
								<span class="add-on">优先级别：</span>
								<select name="priority">
									<option>HIGH</option>
									<option>NORMAL</option>
									<option>LOW</option>
								</select>
							</div>

							<div class="input-prepend input-append date" id="dp5">
								<span class="add-on">结束时间：</span>
								<input  size="16" type="text" placeholder="Deadline" name="deadline" id="endTime-input" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>
						</fieldset>						
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">关闭</p>
						<input class="btn" id="save-task" type="submit"></input>
					</div>
				</form>
				<?php } ?>
			</div>	
			
			
			<!-- 添加阶段 -->
			<div id="AddStage" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>添加阶段</h3>
				</div>
				<form method="post" action="<?=$this->webroot;?>stages/create">
					<div class="modal-body">						
						<fieldset>
							<div class="input-prepend input-append date" id="dp3">
								<span class="add-on">开始时间：</span>
								<input size="16" type="text" placeholder="Start time" name="startTime" id="startTime-input" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>

							<div class="input-prepend input-append date" id="dp4">
								<span class="add-on">结束时间：</span>
								<input size="16" type="text" placeholder="End time" name="endTime" id="endTime-name-input" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>

							<div class="input-prepend">
								<span class="add-on">阶段简介：</span>
								<textarea type="text" rows="3" placeholder="Description" name="summary" id="summary-input" required></textarea>
							</div>
										
							<div class="input-prepend">
								<!-- <span class="add-on">负责人员：</span> -->
								<input type="hidden" value="<?=$project['leader'];?>" name="leader" id="manager-input">
							</div>				
							<input type="hidden" name="project_id" id="projectid-input" value="<?=$project['_id'];?>"></input>
						</fieldset>						
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">关闭</p>
						<input class="btn" id="save-stage" type="submit"></input>
					</div>
				</form>
			</div>	


			<!-- 修改项目信息 -->
			<div id="modifyProject" class="modal hide fade">
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
								<textarea type="text" rows="3" placeholder="Description" name="summary" id="description-input" required></textarea>
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

			<!-- 修改任务信息 -->
			<div id="modifyTask" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>修改任务信息</h3>
				</div>
				<form method="post" action="<?=$this->webroot;?>tasks/edit">
					<div class="modal-body">
						<fieldset>
							<div class="input-prepend">
								<span class="add-on">任务名称：</span>
								<input type="text" placeholder="Content" name="content" id="modify-content-input" required>
							</div>

							<div class="input-prepend">
								<span class="add-on">优先级别：</span>
								<select name="priority" id="modify-priority-input">
									<option>HIGH</option>
									<option>NORMAL</option>
									<option>LOW</option>
								</select>
							</div>

							<div class="input-prepend input-append date" id="dp6">
								<span class="add-on">结束时间：</span>
								<input  size="16" type="text" placeholder="Deadline" name="deadline" id="modify-endTime-input" readonly required>
								<span class="add-on"><i class="icon-remove"></i></span>
    							<span class="add-on"><i class="icon-th"></i></span>
							</div>

							<input type="hidden" name="leader" id="modify-leader-input">
							<input type="hidden" name="status" id="modify-task-status-input">
							<input type="hidden" name="user_id" id="modify-user-id-input">
							<input type="hidden" name="project_id" id="modify-project-id-input">
							<input type="hidden" name="stage_id" id="modify-stage-id-input">
							<input type="hidden" name="task_id" id="modify-task-id-input">
						</fieldset>						
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">关闭</p>
						<input class="btn" id="save-task" type="submit"></input>
					</div>
				</form>
			</div>


			<!-- 删除项目 -->
			<div id="deleteProject" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5>Warning</h5>
				</div>
				<form type="hidden" method="post" action="<?=$this->webroot;?>projects/delete/<?=$project['_id'];?>">
					<div class="modal-body">
						<p>确定删除任务吗？</p>					
						<fieldset>					
							<input type="hidden" name="project_id" id="projectid-input" value="<?=$project['_id'];?>"></input>
						</fieldset>						
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">取消</p>
						<input class="btn" id="save-stage" type="submit" value="确定">
					</div>
				</form>
			</div>
			
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<?php if(!$stages): ?>
				<div class="alert" style="width: 500px; margin: 50px auto 0 auto;">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>项目内容为空，请添加阶段和任务.</strong> 
				</div>
			<?php endif ?>

			<?php foreach($stages as $i => $stage){ ?>
			<div class="row-fluid p-stage" id="stage-<?=$stage['_id']?>">				
				<a href="javascript:void(0);">
					<h4 style="text-align: center; text-shadow: 2px 1px 2px;">第 <?=$i+1;?> 阶 段</h4>
				</a>
				<div class="stage-separator"></div>
				<div class="row-fluid">
					<?php foreach($stage['task'] as $task){ ?>
						<div class="p-single" id="p-single-<?=$task['task_id']?>-<?=$task['leader'];?>" data-animation="true" data-title="" data-placement="top">				
							<div class="p-status-bar"></div>
							<div class="p-manager">
								<div class="p-avatar thumbnail">
									<img src="<?=$this->webroot;?><?=$task['pic_url']?>">
								</div>
								<div class="p-name"><span><?=$task['user_name'];?></span></div>
							</div>
							<div class="p-detail">
								<div class="p-summary">
									<p><span><?=$task['content'];?></span></p>
								</div>
								<div class="p-start">
									<p><span><?=$stage['startTime'];?></span></p>
								</div>
								<div class="p-end">
									<p><span><?=$task['deadline'];?></span></p>
								</div>								
							</div>
							<div class="p-status">
								<span></span>
							</div>
							<script type="text/javascript">
								var statusId = <?= $task['status'] ?>;
								var priority = "<?= $task['priority'] ?>";
								var statusStr, statusColor, statusBg;
								switch (statusId) {
									case 1:
										statusStr = "进行中";
										statusBg = "status_underway.png";
										break;
									case 2:
										statusStr = "待审核";
										statusBg = "status_checking.png";
										break;
									case 3:
										statusStr = "已完成";
										statusBg = "status_finished.png";
										break;
									default:
										statusStr = "出错啦";
								}

								switch (priority) {
									case "HIGH":
										statusColor = "#ff0000";
										break;
									case "NORMAL":
										statusColor = "#000000";
										break;
									case "LOW":
										statusColor = "#CCCCCC";
										break;
								}


								$("#p-single-<?=$task['task_id']?>-<?=$task['leader'];?>").css({
									'border-color': "#aaaaaa"
								});
								$("#p-single-<?=$task['task_id']?>-<?=$task['leader'];?> .p-status-bar").css({
									'background-color': statusColor
								});
								$("#p-single-<?=$task['task_id']?>-<?=$task['leader'];?> .p-status").css({
									'background-image': 'url(<?=$this->webroot?>/img/'+statusBg+")"
								});
								$("#p-single-<?=$task['task_id']?>-<?=$task['leader'];?> .p-status > span").html(statusStr);			
							</script>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php }	?>
		</div>
	</div>
</div>

<script>
	// 检查输入的负责人是否存在
	var userList = eval("("+'<?=json_encode($users);?>'+")");	
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


	$('#dp3').datetimepicker({
		startDate: new Date(),
		todayBtn: true,
		format: 'hh:ii dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
		keyboardNavigation: true,
		showMeridian: true
	});

	$('#dp4').datetimepicker({
		startDate: new Date(),
		todayBtn: true,
		format: 'hh:ii dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
		keyboardNavigation: true,
		showMeridian: true
	});

	$('#dp5').datetimepicker({
		startDate: new Date(),
		todayBtn: true,
		format: 'hh:ii dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
		keyboardNavigation: true,
		showMeridian: true
	});

	$('#dp6').datetimepicker({
		startDate: new Date(),
		todayBtn: true,
		format: 'hh:ii dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
		keyboardNavigation: true,
		showMeridian: true
	});

	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href="<?php echo $this->webroot;?>">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li><a href="<?php echo $this->webroot;?>projects">项目管理</a><span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active"><?php echo $project['name'];?><span class="divider">></span></li>');
	
	
	(function authorityControl() {
		// 所有用户都能创建任务，登录用户为当前任务负责人或者管理员才可创建阶段
		var projectLeader = "<?php echo $project['leader'];?>";
		var currentUserObj = eval("("+'<?php echo json_encode($currentUser);?>'+")");
		var projectAdder;
		if (currentUserObj.authority === 2 && currentUserObj.userName === projectLeader) {
			projectAdder = '<li><div id="project-adder"><a href="#AddStage" data-toggle="modal"><i class="icon-plus"></i>添加阶段</a>&nbsp&nbsp&nbsp<a href="#AddTask" data-toggle="modal"><i class="icon-plus"></i>添加任务</a></div></li>';
		} else if (currentUserObj.authority === 1) {
			projectAdder = '<li><div id="project-adder"><a href="#AddStage" data-toggle="modal"><i class="icon-plus"></i>添加阶段</a>&nbsp&nbsp&nbsp<a href="#AddTask" data-toggle="modal"><i class="icon-plus"></i>添加任务</a>&nbsp&nbsp&nbsp<a href="#deleteProject" data-toggle="modal"><i class="icon-remove"></i>删除项目</a></div></li>';
		} else {
			projectAdder = '<li><div id="project-adder"><a href="#AddTask" data-toggle="modal"><i class="icon-plus"></i>添加任务</a></div></li>';
		}

		$('.breadcrumb').append(projectAdder);

		if (currentUserObj.authority === 1 || (currentUserObj.authority === 2 && currentUserObj.userName === projectLeader)) {

			$(".p-stage").each(function () {
				var project_id = "<?=$project['_id']?>",
					stage = $(this).attr("id").split("-");

				$(this).children().eq(0).popover({
					content: "<span><a id=delete-" + stage[1] +" href='javascript:void(0);' style='cursor: pointer;'><i class='icon-remove'></i>删除</a></span>",
					html: true,
					placement: "top"
				});

				$(this).children().eq(0).click(function() {			
					$(this).popover();	

					$("#delete-" + stage[1]).click(function() {
						var pathname = "<?=$this->webroot?>/stages/delete/" + project_id + "/" + stage[1];
						window.location.pathname = pathname;
					});		
				});
			});
		}



		var project_id = "<?=$project['_id']?>";

		$(".p-single").each(function() {
			var stage = $(this).parent().parent().attr("id").split('-'),
				task = $(this).attr("id").split('-');

			if (currentUserObj.userName === task[3] || (currentUserObj.authority === 2 && currentUserObj.userName === projectLeader) || currentUserObj.authority === 1) {
				$(this).popover({
					content: "<span><a id='modify-" + task[2] + "' href='#modifyTask' data-toggle='modal' style='cursor: pointer;'><i class='icon-pencil'></i>修改</a></span><span><a id='delete-" + task[2] + "' href='javascript:void(0);' style='cursor: pointer;'><i class='icon-remove'></i>删除</a></span>",
					html: true
				});

				$(this).click(function(){
					$("#delete-" + task[2]).click(function() {
						var pathname = "<?=$this->webroot?>tasks/delete/" + project_id + "/" + stage[1] + "/" + task[2];
						window.location.pathname = pathname;
					});

					$("#modify-" + task[2]).click(function() {
						var stageObj = eval("(" + '<?=json_encode($stages)?>' + ")");

						var taskObj;
						for (var i = 0; i < stageObj.length; i++) {
							for (var j = 0; j < stageObj[i].task.length; j++) {
								if (stageObj[i].task[j].task_id === task[2]) {
									taskObj = stageObj[i].task[j];
									break;
								}
							};
						};

						console.log(taskObj);

						switch(taskObj.priority) {
							case "HIGH":
								$("#modify-priority-input").children().eq(0)[0].selected = true;
								break;
							case "NORMAL":
								$("#modify-priority-input").children().eq(1)[0].selected = true;
								break;
							case "LOW":
								$("#modify-priority-input").children().eq(2)[0].selected = true;
								break;
						}

						$("#modify-leader-input").attr('value', taskObj.leader);
						$("#modify-content-input").attr('value', taskObj.content);
						$("#modify-priority-input").attr('value', taskObj.priority);
						$("#modify-endTime-input").attr('value', taskObj.deadline);
						$("#modify-task-status-input").attr('value', taskObj.status);
						$("#modify-task-id-input").attr('value', taskObj.task_id);
						$("#modify-user-id-input").attr('value', taskObj.user_id);
						$("#modify-project-id-input").attr('value', project_id);
						$("#modify-stage-id-input").attr('value', stage[1]);
					});
				});
			}
		});
	})();

	(function setProgress() {
		var stages = eval("(" + '<?=json_encode($stages);?>' + ")"),
			project_id = "<?=$project['_id'];?>";

		var totalTaskNum = 0,
			finishedNum = 0,
			checkingNum = 0;

		for (var i = 0; i < stages.length; i++) {
			totalTaskNum += stages[i].task.length;
			for (var j = 0; j < stages[i].task.length; j++) {
				if (stages[i].task[j].status === 3) {
					finishedNum += 1;
				} else if (stages[i].task[j].status === 2) {
					checkingNum += 1;
				}
			};
		};

		var progress = (finishedNum + checkingNum * 0.5) / totalTaskNum;
		drawCircle(project_id, progress);
	})();
</script>

