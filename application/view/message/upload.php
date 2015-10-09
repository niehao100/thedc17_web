<script type="text/javascript">

</script>
<form class="form-horizontal" id="messageupload" role="form" action="<?php echo URL;?>message/uploadmess" method="post">
   <div class="form-group">
      <label for="messagedecription" class="col-sm-2 control-label">标题</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="messagedecription"  name="messagedecription"
            placeholder="请输入一句话描述">
      </div>
   </div>
   
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
