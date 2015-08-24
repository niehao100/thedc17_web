<script type="text/javascript">

</script>
<form class="form-horizontal" role="form">
   <div class="form-group">
      <label for="filedecription" class="col-sm-2 control-label">描述</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="filedecription"  name="filedecription"
            placeholder="请输入一句话描述">
      </div>
   </div>
   </form>
<form class="form-horizontal" id="fileupload" onsubmit="document.forms['fileupload'].action='<?php echo URL;?>file/upload'+'?decription='+document.getElementById('filedecription').value;return true;" role="form" action="<?php echo URL;?>file/upload" method="post"
enctype="multipart/form-data">
   
   <div class="form-group">
      <label  for="inputfile" class="col-sm-2 control-label">文件</label>
      <div class="col-sm-10">
      <input type="file" id="inputfile" name="inputfile"></div>
   </div>
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" id="filesubmit" class="btn btn-default">上传</button>
      </div>
   </div>
</form>