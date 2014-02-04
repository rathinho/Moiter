<div class="user-view">
	<div class="row-fluid">
		<div class="span3" style="height: 130px; width: 140px">
			<div class="user-avatars thumbnails">
				<a class="thumbnail" href="#">
					<img style="height: 130px;" src="<?=$this->webroot;?><?=$user['pic_url']?>">
				</a>				
			</div>
		</div>

		<div class="span9">
			<p id="name"><span class="label label-info">姓名</span>&nbsp&nbsp&nbsp<?=$user['name'];?></p>
			<p id="company"><span class="label label-info">公司</span>&nbsp&nbsp&nbsp<?=$user['company'];?></p>
			<p id="position"><span class="label label-info">职位</span>&nbsp&nbsp&nbsp<?=$user['position'];?></p>
			<p id="tel"><span class="label label-info">电话</span>&nbsp&nbsp&nbsp<?=$user['tel'];?></p>
			<p id="email"><span class="label label-info">邮箱</span>&nbsp&nbsp&nbsp<?=$user['email'];?></p>
		</div>
	</div>
	

	<div id="task-selector">
		<div id="selector-trigger"></div>
		<ul>
			<li><a id="all" href="javascript:void(0);">全部任务</a></li>
			<li><a id="underway" href="javascript:void(0);">进行中</a></li>
			<li><a id="checking" href="javascript:void(0);">待审核</a></li>
			<li><a id="finish" href="javascript:void(0);">已完成</a></li>
		</ul>
	</div>

	<div class="row-fluid thumbnail" id="u-projects-form">
		<?php foreach($tasks as $project){ ?>

			<div class="u-single thumbnail" id="<?=$project['task_id']?>-<?=$project['status']?>-<?=$project['project_leader']?>">
				<p>
					<span><?=$project['name'];?></span>
					<span class="u-priority"><?=$project['priority'];?></span>
				</p>
				<p><span style="font-size: 11px; line-height: 11px;"><?=$project['content'];?></span></p>
				<div class="u-progress">
					<div class="progress progress-striped active">
						<div class="bar"></div>
					</div>				
				</div>
				<p><span>还剩</span>
					<span class="left-day"></span>
					<span>天</span></p>
				<div class="u-status">
					<div class="switch switch-small" id="switch-<?=$project['stage_id']?>-<?=$project['task_id']?>-<?=$project['status']?>">
					    <input type="checkbox" checked disabled/>
					</div>
				</div>

				<script type="text/javascript">
					(function setPriority() {
						var priority = "<?php echo $project['priority'];?>";
						var strColor;

						switch (priority) {
							case "HIGH":
								strColor = "#ff0000";
								break;
							case "NORMAL":
								strColor = "#000000";
								break;
							case "LOW":
								strColor = "#aaaaaa";
								break;
						}

						$("#<?=$project['task_id']?>-<?=$project['status']?>-<?=$project['project_leader']?> .u-priority").css('color', strColor);
					})();

					(function setProgress() {
						var datetime= "<?=$project['deadline']?>".split(" "),
							date = datetime[1].split("/"),
							time = datetime[0].split(":");
						var someDate = new Date(Date.UTC(parseInt(date[2]), parseInt(date[1])-1, parseInt(date[0]), parseInt(time[0])-8, parseInt(time[1])));
						var secDiff = someDate - Date.now();
						var dayDiff = secDiff / (1000 * 60 * 60 * 24);
						dayDiff = dayDiff > 0 ? dayDiff.toFixed(2) : 0;
						$("#<?=$project['task_id']?>-<?=$project['status']?> .left-day").html(dayDiff);
					})();
				</script>
			</div>
		<?php } ?>		
	</div>

	<form id="status-modify" method="post" action="<?=$this->webroot;?>tasks/modifyStatus">
		<input type="hidden" name="user_id" value="c6a5d43a723b0480999bd4a9637dcadb">
		<input type="hidden" name="stage_id" value="3170daecc33fe4fa41febcf9d02e51c3">
		<input type="hidden" name="task_id" value="c4a071b876440ab0761f4833f6c8c9b8">
		<input type="hidden" name="status" value="3">
	</form>
</div>

<script>
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href="<?php echo $this->webroot;?>">首页</a> <span class="divider">></span></li>');
	$('.breadcrumb').append('<li><a href="<?php echo $this->webroot;?>users">用户管理</a><span class="divider">></span></li>');
	$('.breadcrumb').append('<li id="added-bc" class="active"><?php echo $user['name'];?><span class="divider">></span></li>');

	$("#user-view").ready(function() {
		var uSingleList = document.getElementsByClassName("u-single");
		window.userTasksList = Array();
		for (var i = 0; i < uSingleList.length; i++) {
			window.userTasksList.push(uSingleList[i]);
		};
	});

	$("#all").click(function() {
		var form = document.getElementById("u-projects-form");
		form.innerHTML = "";

		for (var i = 0; i < userTasksList.length; i++) {
			form.appendChild(userTasksList[i]);
		};
	});

	$("#underway").click(function() {
		var form = document.getElementById("u-projects-form");
		form.innerHTML = "";

		for (var i = 0; i < userTasksList.length; i++) {
			var status = userTasksList[i].id.split("-");
			if (status[1] == "1") {
				form.appendChild(userTasksList[i]);
			}
		};
	});

	$("#checking").click(function() {
		var form = document.getElementById("u-projects-form");
		form.innerHTML = "";

		for (var i = 0; i < userTasksList.length; i++) {
			var status = userTasksList[i].id.split("-");
			if (status[1] == "2") {
				form.appendChild(userTasksList[i]);
			}
		};
	});

	$("#finish").click(function() {
		var form = document.getElementById("u-projects-form");
		form.innerHTML = "";

		for (var i = 0; i < userTasksList.length; i++) {
			var status = userTasksList[i].id.split("-");
			if (status[1] == "3") {
				form.appendChild(userTasksList[i]);
			}
		};
	});

	// 权限控制
	var username = "<?=$user['name'];?>";
	var currentUserObj = eval("(" + '<?=json_encode($currentUser);?>' + ")");
	if (currentUserObj.userName === username) {
		// 任何用户查看自己的资料时， 将状态开关设置为enabled
		$(".switch").each(function() {
			var id = $(this).attr("id").split("-");
			
			if (id[3] === "3") {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
				$(this).children()[0].checked = false;
			} else if (id[3] === "2" && currentUserObj.authority <= 2){
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
			} else if (id[3] === "2" && currentUserObj.authority === 3) {
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
				$(this).children()[0].checked = false;
			} else if (id[3] === "1") {
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
			}
		});
	} else if (currentUserObj.authority === 1) {
		// 系统管理员可以更改所有用户的任务状态
		$(".switch").each(function() {
			var id = $(this).attr("id").split("-");

			if (id[3] === "3") {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
				$(this).children()[0].checked = false;
			} else if (id[3] === "2"){
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
			} else if (id[3] === "1") {
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
			}
		});
	} else if (currentUserObj.authority === 2 && currentUserObj.userName !== username) {
		$(".switch").each(function() {
			var project_leader = $(this).parent().parent().attr("id").split("-");
			var id = $(this).attr("id").split("-");

			if (id[3] === "3") {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
				$(this).children()[0].checked = false;
			} else if (id[3] === "2" && currentUserObj.userName === project_leader[2]){
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
			} else if (id[3] === "2" && currentUserObj.userName !== project_leader[2]) {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
				$(this).children()[0].checked = false;
			} else if (id[3] === "1" && currentUserObj.userName === project_leader[2]) {
				$(this).children()[0].disabled = false;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
			} else if (id[3] === "1" && currentUserObj.userName !== project_leader[2]) {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");
			}

		});
	} else if (currentUserObj.authority === 3 && currentUserObj.userName !== username) {
		// 普通用户查看其他用户的资料时， 将状态开关设置为disabled
		$(".switch").each(function() {
			var id = $(this).attr("id").split("-");

			if (id[3] === "3") {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
				$(this).children()[0].checked = false;
			} else if (id[3] === "2"){
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "待审核");
				$(this).attr("data-off-label", "已完成");
				$(this).attr("data-on", "info");
				$(this).attr("data-off", "success");
			} else if (id[3] === "1") {
				$(this).children()[0].disabled = true;
				$(this).attr("data-on-label", "进行中");
				$(this).attr("data-off-label", "待审核");
				$(this).attr("data-on", "warning");
				$(this).attr("data-off", "info");			
			}
		});
	}

	// 监听状态开关改变事件，向服务器Post更新后的状态
	$(".switch").on('switch-change', function(e, data) {
		var id = $(this).attr('id').split("-");

		$("#status-modify > input[name=stage_id]").attr("value", id[1]);
		$("#status-modify > input[name=task_id]").attr("value", id[2]);
		$("#status-modify > input[name=user_id]").attr("value", "<?=$user['_id']?>");

		var status = $(this).children().children().eq(0)[0].checked;
		console.log(status);
		if (!status) {
			$("#status-modify > input[name=status]").attr("value", parseInt(id[3]) + 1);
		} else {
			$("#status-modify > input[name=status]").attr("value", parseInt(id[3]) - 1);
		}

		// 延迟提交，让开关动画完成
		setTimeout(function() {
			$("#status-modify").submit();
		}, 500);
	});
</script>