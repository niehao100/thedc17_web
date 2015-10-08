<ol class="breadcrumb">
  <li>论坛</li>
  <li><a href="<?php echo URL;?>forum/listall/<?php echo $_SESSION['forum_type'];?>">
  <?php 
  switch ($_SESSION['forum_type'])
  {
      case '0':
          echo '吐槽灌水';
          break;
          case '1':
              echo '平台报错';
              break;
              case '2':
                  echo '战事汇报';
                  break;
  }
  ?></a></li>
  <div class="pull-right">共<?php if(isset($res) && $res!=null){echo count($res);}else{echo '0';}?>条主题</caption></div>
</ol>
<?php if(isset($res) && $res!=null){?>
<?php for($i=0;$i<count($res);++$i){?>
<div class="panel panel-success">
   <div class="panel-heading">
      <span class="panel-title"><a href="<?php echo URL."forum/thread/".$res[$i]['forum_id'];?>">主题：<?php echo $res[$i]['forum_title'];?></a></span>
      <span class="panel-title pull-right"><?php echo "<i>".$res[$i]['forum_owner']."</i>发表于".date('m-d H:i',strtotime($res[$i]['forum_estab']))?></span>
   </div>
   <div class="panel-body"><h4>
<?php echo handlestr($res[$i]['forum_content']);?>
</h4>
   </div>
   <?php if ($numtotal[$i]>0){?>
   <div class="panel-footer pull-right"><?php echo "共".$numtotal[$i]."条回复。".$lastest[$i][0]."最新回复于".date('m-d H:i',strtotime($lastest[$i][1]));?></div>
   <?php }else{?>
   <div class="panel-footer pull-right"><?php echo "暂无回复。"?></div>
   <?php }?>
</div>
<br/>
<?php }}?>
<?php 
if (!isset($_SESSION)) {
    session_start();
}
/*
if ($type==2 && ((isset($_SESSION['type']) && $_SESSION['type']=='0')||!isset($_SESSION['type'])))
{
?>
<!-- 非管理员无法发布赛事信息。 -->
    <?php 
}
elseif (isset($_SESSION['login']) && $_SESSION['login']==true){*/
if (isset($_SESSION['login']) && $_SESSION['login']==true){
?>

<fieldset > 
<legend>发表主题</legend>
<form class="form-horizontal" id="forumupload" role="form" action="<?php echo URL;?>forum/uploadsubject" method="post">
  
   <div class="form-group">
      <label for="forumdecription" class="col-sm-2 control-label">标题</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="forumdecription"  name="forumdecription"
            placeholder="请输入一句话描述">
      </div>
   </div>
   
   <div class="form-group">
      <label  for="inputtext" class="col-sm-2 control-label">内容</label>
    <div class="col-sm-10">
      <textarea id="inputtext" class="form-control" rows="5" name="inputtext" placeholder="支持Markdown语法"></textarea></div>
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
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" id="messagesubmit" class="btn btn-default">发布</button>
      </div>
   </div>
   
</form>

   </fieldset>
   <?php }else{?>
   <fieldset > 
<legend>发表主题</legend>
   <div class="alert alert-danger">您需要<a data-toggle="modal" href="#loginmodal">登录</a>才能发表话题。</div>
   </fieldset>
   <?php }?>