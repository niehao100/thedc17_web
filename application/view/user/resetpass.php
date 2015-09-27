<?php if (isset($_POST['resetusername'])){?>
    
    <div class="panel <?php echo $paneltype;?> col-sm-offset-3 col-sm-6">
   <div class="panel-body">
      <?php echo $panelinfo;?>
   </div>
</div>

<?php }else{ ?>
<form class="form-horizontal" id="resetform" role="form" action="<?php echo URL;?>user/exresetpass" method="post">
   
   <div class="form-group">
      <label for="resetusername" class="col-sm-2 col-sm-offset-2 control-label">账号</label>
      <div class="col-sm-4">
         <input type="text" class="form-control" id="resetusername"  name="resetusername">
      </div>
   </div>
   
   <div class="form-group">
      <label for="resetmail" class="col-sm-2 col-sm-offset-2 control-label">邮箱地址</label>
      <div class="col-sm-4">
         <input type="email" class="form-control" id="resetmail"  name="resetmail">
      </div>
   </div>
   
   <div class="form-group">
      <label for="vc" class="col-sm-2 col-sm-offset-2 control-label">验证码</label>
      <div class="col-sm-4">
      <div class="input-group">
         <input type="text"
              class="form-control" id="vc" name="vc">
			<span class="input-group-addon"><img  title="点击刷新" src="<?php echo URL; ?>captcha" align="absbottom" onclick="this.src='<?php echo URL; ?>captcha/index/'+Math.random();"></img></span>
		     <div style='width: 20px'></div>
		</div>
      </div>
   </div>
   

   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-6">
         <button type="submit" id="resetsubmit" class="btn btn-default pull-right">找回密码</button>
      </div>
   </div>
</form>
<?php }?>