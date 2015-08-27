<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>第17届电设比赛</title>
    <meta charset="utf-8">
    <meta name="description" content="thedc17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="http://cdn.bootcss.com/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
     <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
     
    <script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-validator/0.5.3/js/language/zh_CN.min.js"></script>
    <script src="<?php echo URL; ?>js/application.js"></script>
    

    
</head>
<body>
<?php
if (!isset($_SESSION)) {
    session_start();
}
function handlestr($str)
{
    $str=str_replace(" ", "&nbsp;", $str);
    
    $str=str_replace("<", "&lt;", $str);
    $str=str_replace(">", "&gt;", $str);
    $str=str_replace("\n", "<br>", $str);
    return $str;
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" 
         data-target="#example-navbar-collapse">
         <span class="sr-only">切换导航</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
   
      <a class="navbar-brand" href="<?php echo URL; ?>"><strong>第17届电设比赛</strong></a>
   </div>
<div class="collapse navbar-collapse" id="example-navbar-collapse">
      
<?php if (!isset($_SESSION['login']) || $_SESSION['login']!=true){?>
    <ul class="nav navbar-nav navbar-right">
         <li><a data-toggle="modal" href="#registermodal">注册</a></li>
         <li><a data-toggle="modal" href="#loginmodal">登录</a></li>
      </ul>
<?php }else {?>
 <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
           
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              欢迎， <?php echo $_SESSION['username'];?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a data-toggle="modal" href="#changemodal">修改密码</a></li>
               <li><a href="<?php echo URL."user/logout"; ?>">退出</a></li>
            </ul>
         </li>
         </ul>
       <div class="navbar-right">
   </div>
<?php }?>

    </div>
    </div>
</nav>   

<div class="modal fade" id="registermodal" data-backdrop="false" tabindex="-1" role="dialog" >
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title">
               注册用户
            </h4>
         </div>
         <div class="modal-body">
         
<!-- 注册表单  -->
 <form class="form-horizontal" id="registerform" role="form" action="<?php echo URL; ?>user/register" method="post">
   <div class="form-group">
      <label for="nickname" class="col-sm-2 control-label">昵称</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text" class="form-control" id="nickname" name="nickname"
            placeholder="长度3~10">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="password" class="col-sm-2 control-label">密码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="password" class="form-control" id="password" name="password"
            placeholder="至少6位">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="repassword" class="col-sm-2 control-label">确认密码</label>
      <div class="col-sm-10">
         <div class="input-group">
         <input type="password" class="form-control" id="repassword" name="repassword"
            placeholder="至少6位">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="realname" class="col-sm-2 control-label">真实姓名</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text" class="form-control" id="realname" name="realname">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="class" class="col-sm-2 control-label">班级</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text" class="form-control" id="class" name="class">
			<span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="cellphone" class="col-sm-2 control-label">手机</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text" class="form-control" id="cellphone" name="cellphone">
			<span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="mailaddress" class="col-sm-2 control-label">邮箱</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="email"
              class="form-control" id="mailaddress" name="mailaddress">
			<span class="input-group-addon"><span class="glyphicon glyphicon-send"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="vc" class="col-sm-2 control-label">验证码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text"
              class="form-control" id="vc" name="vc">
			<span class="input-group-addon"><img  title="点击刷新" src="<?php echo URL; ?>captcha" align="absbottom" onclick="this.src='<?php echo URL; ?>captcha/index/'+Math.random();"></img></span>
		     <div style='width: 20px'></div>
		</div>
      </div>
   </div>
   <div class="modal-footer ">
      
         <button type="submit" id="registersubmit" name="registersubmit" class="btn btn-primary">注册</button>

   </div>
</form>
         </div>
         
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->




<div class="modal fade" id="loginmodal" data-backdrop="false" tabindex="-1" role="dialog" >
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title">
               登录
            </h4>
         </div>
         <div class="modal-body">
         
<!-- 注册表单  -->
 <form class="form-horizontal" id="loginform" role="form" action="<?php echo URL; ?>user/login" method="post">

  <div id="loginAlert" class="alert alert-warning fade in hidden ">

   <strong>用户不存在或密码错误！</strong>

</div>
   <div class="form-group">
      <label for="loginnickname" class="col-sm-2 control-label">昵称/邮箱</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text" class="form-control" id="loginnickname" name="loginnickname">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="loginpassword" class="col-sm-2 control-label">密码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="password" class="form-control" id="loginpassword" name="loginpassword">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
<div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <div class="checkbox">
            <label>
               <input id="rememberme" name="rememberme" type="checkbox"> 请记住我
            </label>
         </div>
      </div>
   </div>
   <div class="modal-footer ">
      
         <button id="login" name="login" type="button" class="btn btn-primary">登录</button>

   </div>
</form>
         </div>
         
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->


<div class="modal fade" id="changemodal" data-backdrop="false" tabindex="-1" role="dialog" >
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title">
               修改密码
            </h4>
         </div>
         <div class="modal-body">
         
<!-- 注册表单  -->
 <form class="form-horizontal" id="changeform" role="form" action="<?php echo URL; ?>user/changepass" method="post">
   <div class="form-group">
      <label for="oldpass" class="col-sm-2 control-label">旧密码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="password" class="form-control" id="oldpass" name="oldpass">
			<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="newpass" class="col-sm-2 control-label">新密码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="password" class="form-control" id="newpass" name="newpass">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>
   <div class="form-group">
      <label for="renewpass" class="col-sm-2 control-label">重复新密码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="password" class="form-control" id="renewpass" name="renewpass">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		</div>
      </div>
   </div>

   <div class="modal-footer ">
      
         <button id="changesubmit" name="changesubmit" type="submit" class="btn btn-primary">提交</button>

   </div>
</form>
         </div>
         
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->

<div class="container">
   <div class="row" >
      <div id="leftinfo" class="col-xs-12 col-sm-3 col-lg-3 col-md-3" >
         
         
         <div class="list-group">
   <span class="list-group-item active">
      <h4 class="list-group-item-heading">
        通知
      </h4>
   </span>
   
   <?php if (isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
   <a href="<?php echo URL;?>file/index" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;上传资料
      </p>
   </a>
   <?php }?>
   <?php if (isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
   <a href="<?php echo URL;?>message/upload" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;发布消息
      </p>
   </a>
   <?php }?>
   <a href="<?php echo URL;?>file/listall" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;资料列表
      </p>
   </a>
   <a href="<?php echo URL;?>message/listall" class="list-group-item">

      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;重要消息
      </p>
   </a>
</div>
<div class="list-group">
   <span class="list-group-item active">
      <h4 class="list-group-item-heading">
        论坛
      </h4>
   </span>
   
   <a href="<?php echo URL;?>forum/listall/0" class="list-group-item">
      <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;吐槽灌水</p>
      
   </a>
   <a href="<?php echo URL;?>forum/listall/1" class="list-group-item">
      <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;平台报错</p>
      
   </a>
   <a href="<?php echo URL;?>forum/listall/2" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;战事汇报
      </p>
     
   </a>
</div>

      </div>
 <!--          style="background-color: #dedef8;box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;" -->
    <div class="col-xs-12 hidden-xs col-sm-8 col-lg-8 col-xs-8" >
        
      
   