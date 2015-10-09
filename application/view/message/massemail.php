<form class="form-horizontal" id="massemail" role="form" action="<?php echo URL;?>message/email" method="post">
   <div class="form-group">
      <label for="emaildecription" class="col-sm-2 control-label">邮件主题</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="emaildecription"  name="emaildecription"
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
      <label  for="emailobj" class="col-sm-2 control-label">群发对象</label>
    <div class="col-sm-10">
      <label class="checkbox-inline">
      <input type="radio" name="emailobj" id="optionsRadios3" 
         value="1" checked> 队长
   </label>
      <label class="checkbox-inline">
      <input type="radio" name="emailobj" id="optionsRadios3" 
         value="3" checked> 所有参队人员
   </label>
   <label class="checkbox-inline">
      <input type="radio" name="emailobj" id="optionsRadios4" 
         value="2"> 所有注册人员
   </label>
    </div>
    </div>
    
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" id="messagesubmit" class="btn btn-default">群发</button>
      </div>
   </div>
</form>
