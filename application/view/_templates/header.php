<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>第17届电设比赛</title>
    <meta charset="utf-8">
    <meta name="description" content="thedc17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    
    <link href="http://cdn.bootcss.com/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
     <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
     <link href="<?php echo URL; ?>css/bootstrap-select.min.css" rel="stylesheet">
     
    <script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-validator/0.5.3/js/language/zh_CN.min.js"></script>
    <script src="<?php echo URL; ?>js/application.js" charset="utf-8"></script>
    <script src="<?php echo URL; ?>js/bootstrap-select.min.js" charset="utf-8"></script>
    
</head>
<body> 
<script type="text/javascript" src="http://pv.sohu.com/cityjson?ie=utf-8" charset="utf-8"></script> 
<script>
var rootpath3="http://"+location.hostname+"";
$.post(rootpath3+'/user/ipstatistic',
		  {
		    ip:returnCitySN.cip,
		    city:returnCitySN.cname,
		  },
		  function(data,status){});

</script>
<?php
require_once APP . 'controller/Parsedown.php';
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['login']) && $_SESSION['login']==true)
{
    $index_bool=$this->groupmodel->isgroupmember()||$this->groupmodel->isgroupleader();
}else{
    $index_bool=false;
}
//if (isset($_SESSION['login']) && isset($_COOKIE['autologin']))
//   echo ("<script>alert('".$_SESSION['login'].$_COOKIE['autologin']."')</script>");

function handlestr($str)
{
    //$str=str_replace(" ", "&nbsp;", $str);
    
    $str=str_replace("<", "&lt;", $str);
    $str=str_replace(">", "&gt;", $str);
    //$str=str_replace("\n", "<br>", $str);
    $Parsedown = new Parsedown();
    return $Parsedown->text($str);
}

function handlestr2($str)
{
    $str=str_replace(" ", "&nbsp;", $str);

    $str=str_replace("<", "&lt;", $str);
    $str=str_replace(">", "&gt;", $str);
    $str=str_replace("\n", "<br>", $str);

    return $str;
}
function getteamtype($i)
{
    switch ($i)
    {
        case 1:
            return "单片机";
            break;
        case 2:
            return "DSP";
            break;
        case 3:
            return "FPGA";
            break;        
        default:
            return "";
            break;                
    }
}
function getname($i)
{
    if ($i==1)
    {
        return "沙发";
    }
    if ($i==2)
    {
        return "板凳";
    }
    if ($i==3)
    {
        return "地板";
    }
    return "#".(string)$i;
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
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                 介绍
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="<?php echo URL."intro/rule"?>">比赛规则</a></li>
               <li><a href="<?php echo URL."intro/thedc"?>">科协介绍</a></li>
              <li><a href="<?php echo URL."intro/hardware"?>">电设概况</a></li>
            </ul>
         </li>
         
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
            <a class="pull-right" href="<?php echo URL."user/resetpass"?>">找回密码</a>
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

<div class="hidden" id="myCarouse3">
   <div id="myCarousel" class="carousel slide">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators">
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $i-1;?>" <?php if ($i==1){?>class="active"<?php }?>></li>
   <?php }else{break;}}?>
   </ol>   
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <div class="item<?php if ($i==1){?> active<?php }?>">
         <img src="<?php echo URL."img/slide".$i.".jpg?".mt_rand();?>" alt="A slide">
      </div>
   <?php }else{break;}}?>
   </div>
   <!-- 轮播（Carousel）导航 -->
   <a class="left carousel-control" href="#myCarousel" data-slide="prev">
 <span class="glyphicon glyphicon-chevron-left"></span></a>
 <a class="right carousel-control" href="#myCarousel" data-slide="next">
 <span class="glyphicon glyphicon-chevron-right"></span></a>
</div> 
<script type="text/javascript">
$('#myCarousel').carousel({
  interval: 4000
})

</script>
<br>
<?php if (!isset($_SESSION['login']) || $_SESSION['login']!=true){?>
<div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
            <a href="<?php echo URL."intro/rule"?>" title="比赛规则" ><img src="<?php echo URL."img/rule.jpg";?>"></a>
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/rule"?>" title="比赛规则">比赛规则<br></a>
              </h3>
              <p>
              本次电设比赛趣味性强，拥有10余种陷阱类、攻击类、防御类道具，极大的增加了比赛的观赏性和挑战性。
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
          <a href="<?php echo URL."intro/thedc"?>" title="自动化系科协" ><img src="<?php echo URL."img/asta.jpg";?>"></a>
            
            <a href="<?php echo URL."intro/thedc"?>" title="电子系科协" ><img src="<?php echo URL."img/ee.jpg";?>"></a>
                
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/thedc"?>" title="科协介绍">科协介绍<br></a>
              </h3>
              <p>
         历届电设大赛由电子系科协和自动化系科协共同承办，由两系同学一起构思、设计直至成功举办。
              </p>
            </div>
          </div>
        </div>
        
        <div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
            <a href="<?php echo URL."intro/hardware"?>" title="电设概况" ><img src="<?php echo URL."img/logo.png";?>" ></a>
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/hardware"?>" title="电设概况">电设概况<br></a>
              </h3>
              <p>
              电设自1999年开办以来，今年已经是第17个年头，在历届大赛的组织和竞赛过程中，很多领导和老师亲临现场提出了许多关键性的指导和精辟的点评意见，使参赛选手受益匪浅。
              </p>
            </div>
          </div>
        </div>
<?php }?>
        
</div>
<?php if (!isset($_SESSION['login']) || $_SESSION['login']!=true){?>
        <div id="leftinfo" class="hidden">
<?php }else{?>
      <div id="leftinfo" class="hidden-xs col-sm-3 col-lg-3 col-md-3" >
<?php }?>
         
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
   <?php if (isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
<!--  
   <a href="<?php echo URL;?>message/massemail" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;群发邮件
      </p>
   </a>
-->
   <?php }?>
   <a href="<?php echo URL;?>file/listall" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;资料列表<?php if (($filenum=$this->usermodel->getfilenum())>0){?><span class="badge pull-right"><?php echo $filenum;?></span><?php }?>
      </p>
   </a>
   <a href="<?php echo URL;?>message/listall" class="list-group-item">

      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;重要消息<?php if (($messagenum=$this->usermodel->getmessagenum())>0){?><span class="badge pull-right"><?php echo $messagenum;?></span><?php }?>
      </p>
   </a>
   <a href="<?php echo URL;?>group/listall" class="list-group-item">

      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;查看队伍
      </p>
   </a>
   <?php if ($index_bool==true){?>
   <a href="<?php echo URL;?>group/managegroup" class="list-group-item">

      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;队伍管理
      </p>
   </a>
   <?php }?>
</div>
<div class="list-group">
   <span class="list-group-item active">
      <h4 class="list-group-item-heading">
        论坛
      </h4>
   </span>
   
   <a href="<?php echo URL;?>forum/listall/2" class="list-group-item">
      <p class="list-group-item-text">
         &nbsp;&nbsp;&nbsp;比赛讨论
      </p>
   </a>
   
   <a href="<?php echo URL;?>forum/listall/0" class="list-group-item">
      <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;吐槽灌水</p>
      
   </a>
   
   <a href="<?php echo URL;?>forum/listall/1" class="list-group-item">
      <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;平台报错</p>
   </a>
   
     
   
</div>
<div class="list-group">
   <span class="list-group-item active">
      <h4 class="list-group-item-heading">
        介绍
      </h4>
   </span>
   
   <a href="<?php echo URL;?>intro/rule" class="list-group-item">
      <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;比赛规则</p>  
   </a>
   <a href="<?php echo URL;?>intro/thedc" class="list-group-item">
        <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;科协介绍</p>
   </a>
   <a href="<?php echo URL;?>intro/hardware" class="list-group-item">
        <p class="list-group-item-text">&nbsp;&nbsp;&nbsp;电设概况</p>
   </a>
</div>

      </div>
 <!--          style="background-color: #dedef8;box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;" -->
  <script type="text/javascript">
  
  var rootpath2="";
	if (document.body.clientWidth<768 && window.location.pathname.replace(/\//g, "")==rootpath2){
		if (document.getElementById('leftinfo').className!="hidden")
		{
			document.getElementById('leftinfo').setAttribute('class',"col-xs-12 col-sm-3 col-lg-3 col-md-3");
		}
		document.getElementById('myCarouse3').setAttribute('class','visible-xs col-xs-12'); 
	}
  </script>
  <?php if (!isset($_SESSION['login']) || $_SESSION['login']!=true){?>
    <div class="hidden-xs col-sm-12 col-lg-12 " >
  <?php }else{?>
    <div class="hidden-xs col-sm-8 col-lg-8" >
    
    <?php }?>
        
      
   
