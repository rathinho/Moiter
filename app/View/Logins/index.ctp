<style type="text/css">
	.login {
		width: 940px;
		min-width: 940px;
		margin-left: auto;
		margin-right: auto;
		visibility: hidden;
	}
	
	.tips {
		width: 620px;
		min-width: 620px;
		margin: 0 auto;
	}

	.login-form {
		width: 263px;
		min-width: 263px;
		margin: 0 auto;
	}

	.login-form #login-form {
		width: 263px;
		min-width: 263px;
		margin: 0;
	}

	.button-group {
		width: 170px;
		min-width: 170px;
		margin: 0 auto;
	}
</style>

<div class="container">
	<div class="login" id="login">
		<div class="header">
			<h3 class="text-center">欢迎使用Moiter项目管理系统</h3>
		</div>
		<div class="tips">
			<?if ($error):?>  
				<div class="alert alert-error" style="text-align: center;">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>登录失败，用户名或密码错误</strong> 
				</div>
			<? endif; ?>
		</div>
		<div class="login-form">		
			<form id="login-form" action='<?php echo $this->webroot;?>logins/index' method="post">  
				<div class="input-prepend">
					<label class="add-on" for="username">帐号:</label>
					<input type="text" name="userName"  required/>
				</div>  
				<div class="input-prepend">
					<label class="add-on" for="password">密码:</label>  
					<input type="password" name="password"  required/>
				</div>  
				<div class="button-group">  
					<button class="btn btn-primary" type="submit">登录</button>
					<button class="btn" type="reset">重置</button>
					<button class="btn" href="#Register" data-toggle="modal">注册</button>  
				</div>  
			</form> 
			

			<div id="Register" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>用户注册</h3>
				</div>
				
				<form name="register" method="post" action="<?=$this->webroot;?>logins/register">
					<div class="modal-body">		
						<fieldset>
							<div class="input-prepend input-append">
								<span class="add-on">用户名：&nbsp&nbsp&nbsp&nbsp</span>
								<input type="text" placeholder="Username" name="name" id="user-name-input" required>
								<span class="add-on" id="usernameValidation"><i class="icon-exclamation-sign"></i><span>此项为必填</span></span>
							</div>
							<p class="label label-important"><i class="icon-user"></i>用户名必须是5-20位以字母开头，包含数字和下划线的文本</p>
							<div class="input-prepend input-append">
								<span class="add-on">密码：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
								<input type="password" placeholder="Password" name="password" id="password-input" required>
								<span class="add-on" id="pwValidation"><i class="icon-exclamation-sign"></i><span>此项为必填</span></span>
							</div>
					
							<div class="input-prepend input-append">
								<span class="add-on">重复密码：</span>
								<input type="password" placeholder="Repeat your password"  id="repeated-password-input" required disabled>
								<span class="add-on" id="repeatedpwValidation"><i class="icon-exclamation-sign"></i><span>此项为必填</span></span>
							</div>
							<p class="label label-important"><i class="icon-lock"></i>密码必须是6-20位包含字母，数字和下划线的文本 </p>
							<div class="input-prepend input-append">
								<span class="add-on">邮箱：&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
								<input type="email" placeholder="Email" name="email" id="email-input" required>
								<span class="add-on" id="emailValidation"><i class="icon-exclamation-sign"></i><span>此项为必填</span></span>
							</div>
						
						</fieldset>			
					</div>
					<div class="modal-footer">
						<p class="btn" data-dismiss="modal" type="button">关闭</p>
						<input class="btn" id="save-user" type="submit"></input>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type='text/javascript'>
	var unOk = false,
		pwOk = false,
		rpwOk = false,
		emOk = false;

	(function registerValidate() {
		var userList = eval("("+'<?=json_encode($name_email)?>'+")");
		function hasUser(username) {
			for (var i = 0; i < userList.length; i++) {
				if (userList[i].name === username) {
					return true;
				}
			}
			return false;
		}
		
		var unTid, pwTid, rpwTid, emTid;

		// 当输入框获得焦点时进行验证
		$("#user-name-input").focus(function() {
			unTid = setInterval(function() {
				var usernamePattern = /^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){4,19}$/;  //5-20个以字母开头,可带数字和下划线
				var username = $("#user-name-input").val();
				var isMatch = usernamePattern.exec(username); 

				console.log(username);
				if (hasUser(username) && isMatch && username) {
					$("#usernameValidation").html("<i class='icon-remove-sign'></i><span>用户名已存在</span>");
					unOk = false;
					document.getElementById('user-name-input').setCustomValidity("用户名已存在");
				} else if (!hasUser(username) && isMatch && username){
					$("#usernameValidation").html("<i class='icon-ok-sign'></i><span>OK</span>");
					unOk = true;
					document.getElementById('user-name-input').setCustomValidity("");
				} else if (!isMatch && username) {
					$("#usernameValidation").html("<i class='icon-remove-sign'></i><span>用户名不符合要求</span>");
					unOk = false;
					document.getElementById('user-name-input').setCustomValidity("用户名不符合要求");
				}
			}, 1500);
		});		

		$("#password-input").focus(function() {
			pwTid = setInterval(function() {
				var pwPattern=/^(\w){6,20}$/;	//6-20位由字母、数字、下划线组成
				var pw = $("#password-input").val();			
				var isMatch = pwPattern.exec(pw);

				if (!isMatch && pw) {
					$("#pwValidation").html("<i class='icon-remove-sign'></i><span>密码不符合要求</span>");
					pwOk = false;
					$("#repeated-password-input")[0].disabled = true;
					document.getElementById('password-input').setCustomValidity("密码不符合要求");
				} else if (isMatch && pw){
					$("#pwValidation").html("<i class='icon-ok-sign'></i><span>OK</span>");
					pwOk = true;
					$("#repeated-password-input")[0].disabled = false;
					document.getElementById('password-input').setCustomValidity("");
				}
			}, 1500);
		});

		
		$("#repeated-password-input").focus(function() {
			rpwTid = setInterval(function() {
				var rePw = $("#repeated-password-input").val();
				var isEqual = (rePw === $("#password-input").val());

				if (rePw && isEqual && pwOk) {
					$("#repeatedpwValidation").html("<i class='icon-ok-sign'></i><span>OK</span>");
					rpwOk = true;
					document.getElementById('repeated-password-input').setCustomValidity("");
				} else if (rePw && !isEqual){
					$("#repeatedpwValidation").html("<i class='icon-remove-sign'></i><span>两次输入的密码不一致</span>");
					rpwOk = false;
					document.getElementById('repeated-password-input').setCustomValidity("两次输入的密码不一致");
				}
			}, 1500);
		});
		
		$("#email-input").focus(function() {
			emTid = setInterval(function() {
				var emailPattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
				var email = $("#email-input").val();
				var isMatch = emailPattern.exec(email);

				if (email && isMatch) {
					$("#emailValidation").html("<i class='icon-ok-sign'></i><span>OK</span>");
					emOk = true;				
					document.getElementById('email-input').setCustomValidity("");
				} else if (email && !isMatch){
					$("#emailValidation").html("<i class='icon-remove-sign'></i><span>邮箱地址错误</span>");
					emOk = false;
					document.getElementById('email-input').setCustomValidity("邮箱地址不符合要求");
				}
			}, 1500);
		});		

		// 当输入框失去焦点时取消验证
		$("#user-name-input").blur(function() {
			clearInterval(unTid);
		});

		$("#password-input").blur(function() {
			clearInterval(unTid);
		});

		$("#repeated-password-input").blur(function() {
			clearInterval(unTid);
		});

		$("#email-input").blur(function() {
			clearInterval(unTid);
		});				
	})();
	
	window.onload = function() {
		var marginTop = window.innerHeight - parseInt($('#login').css('height'));
		$('#login').css({
			'margin-top': marginTop / 3 + 'px'
		});		
		$("#login").css("visibility", "visible");
	};
</script>