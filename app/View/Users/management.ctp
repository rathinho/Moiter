<style type="text/css">
	#am-u-list a {
		text-decoration: none;
		cursor: pointer;
	}

	#am-u-list a:hover {
		position: relative;
		top: 1px;
		left: 1px;
		color: #fff;
	}

	#am-u-list tr:hover {
		cursor: pointer;
	}

</style>

<div id="authority-management">
	<div id="elevate-error" class="alert alert-error" style="text-align: center; display: none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>权限不能提升.</strong> 
	</div>

	<div id="reduce-error" class="alert alert-error" style="text-align: center; display: none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>权限不能降低.</strong> 
	</div>

	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>用户名</th>
				<th>电子邮箱</th>
				<th>权限</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody id="am-u-list">
			
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(function() {
		//显示用户列表
		var userListObj = eval("("+'<?=json_encode($users)?>'+")");
		var authorityMap = ["Error", "系统管理员", "项目经理", "普通员工"];
		for (var i = 0; i < userListObj.length; i++) {
			// 不显示系统管理员
			if (userListObj[i].authority !== 1) {
				var nameTd = "<td>" + userListObj[i].name + "</td>",
					emailTd = "<td>" + userListObj[i].email + "</td>",
					authorityTd = "<td>" + authorityMap[userListObj[i].authority] + "</td>",
					operationTd = "<td><a class='elevate'><i class='icon-arrow-up'></i>提升权限</a>&nbsp&nbsp&nbsp&nbsp<a class='reduce'><i class='icon-arrow-down'></i>降低权限</a></td>";
				var tr = "<tr id='"+ userListObj[i]._id + "-" + userListObj[i].authority + "'>" + nameTd + emailTd + authorityTd + operationTd + "</tr>";
				$("#am-u-list").append(tr);
			}
		};


		$(".elevate").click(function() {
			var id = $(this).parent().parent().attr("id").split("-");

			if (parseInt(id[1]) > 2) {
				window.location.pathname = "<?=$this->webroot?>users/modifyAuthority/" + id[0] + "/" + (parseInt(id[1])-1);
			} else {
				$("#elevate-error").css({"display": "block"});
				setTimeout(function(){
					$("#elevate-error").css({"display": "none"});
				}, 3000);
			}
		});

		$(".reduce").click(function() {
			var id = $(this).parent().parent().attr("id").split("-");

			if(parseInt(id[1]) < 3) {
				window.location.pathname = "<?=$this->webroot?>users/modifyAuthority/" + id[0] + "/" + (parseInt(id[1])+1);
			} else {
				$("#reduce-error").css({"display": "block"});
				setTimeout(function(){
					$("#reduce-error").css({"display": "none"});
				}, 3000);
			}
		});


		// 修改面包屑导航
		$('.breadcrumb').empty();
		$('.breadcrumb').append('<li><a href=".">首页</a> <span class="divider">></span></li>');
		$('.breadcrumb').append('<li id="added-bc"><a href="<?=$this->webroot?>users/index">用户管理</a> <span class="divider">></span></li>');
		$('.breadcrumb').append('<li id="added-bc" class="active">权限管理 <span class="divider">></span></li>');
	});
	

	
</script>