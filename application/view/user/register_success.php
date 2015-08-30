<div class="modal fade" id="registerSuccessModal" tabindex="-1" role="dialog" >
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">

            <h4 class="modal-title" id="myModalLabel">
               注册成功
            </h4>
         </div>
         <div style="font-size: 20px" class="modal-body">
            现在您将以<?php echo $_POST['nickname'];?>登录。
            <small><span style="color: Red" id="time">3</span>秒钟以后跳转到 <a id="url" href="<?php echo URL; ?>">主页</a> </small>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function () { 
	$('#registerSuccessModal').modal('show');
    setTimeout(changeTime, 1000); 
 });

function changeTime() { 
var time = document.getElementById("time").innerHTML; 
time = parseInt(time); 
time--; 
if (time <= 0) { 
var url = document.getElementById("url").href; 
window.location = url; 
} else { 
document.getElementById("time").innerHTML= time; 
setTimeout(changeTime, 1000); 
} 
} 
</script>