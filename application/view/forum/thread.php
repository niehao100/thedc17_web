
<?php if (isset($_SESSION['forum_type'])){?>
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
                  echo '比赛讨论';
                  break;
  }
  ?></a></li>
  <li class="active"><?php echo $sub['forum_title'];?></li>
</ol>
<?php }?>

<div class="panel panel-success">
   <div class="panel-heading">
      <span class="panel-title">主题：<?php echo handlestr2($sub['forum_title']);?></span>
      <span class="panel-title pull-right"><?php echo "<i>".$sub['forum_owner']."</i>发表于".date('m-d H:i',strtotime($sub['forum_estab']."+8 hour"))?></span>
   </div>
   <div class="panel-body"><h4>
<?php echo handlestr($sub['forum_content']);?>
</h4>
   </div>
</div>
   <?php if(isset($res) && $res!=null){?>
   <?php for($i=0;$i<count($res);++$i){?>
   <span class="label label-primary"><?php echo getname($i+1);?></span>
   <div name="<?php echo $res[$i]['thread_id'];?>" class="panel panel-default">

   <div class="panel-body"><h4>
<?php echo handlestr($res[$i]['thread_content']);?>
</h4>
   </div>
   <div class="panel-footer pull-right">
   <?php echo "<i>".$res[$i]['thread_owner']."</i>发表于".date('m-d H:i',strtotime($res[$i]['thread_estab']."+8 hour"))?>
   </div>

   </div>
   <?php }?>
   
   <?php }?>
   <br>
<?php 
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['login']) && $_SESSION['login']==true){
?>

<fieldset > 
<legend>回复</legend>
<form class="form-horizontal" id="threadupload" role="form" action="<?php echo URL;?>forum/uploadthread" method="post">
   <input type="hidden" id="forumid" name="forumid" value="<?php echo $id;?>"> 
   <div class="form-group">
      <label  for="inputtext" class="col-sm-2 control-label">内容</label>
    <div class="col-sm-10">
      <textarea id="inputtext" class="form-control" rows="5" name="inputtext" placeholder="支持Markdown语法"></textarea></div>
<a class="pull-right" target="_blank" href="http://markdown.pioul.fr/">在线编辑</a>
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
<legend>回复</legend>
   <div class="alert alert-danger">您需要<a data-toggle="modal" href="#loginmodal">登录</a>才能回复。</div>
   </fieldset>
   <?php }?></div>