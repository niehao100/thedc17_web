<div class="modal fade" id="changeSuccessModal" tabindex="-1" role="dialog" >
   <div class="modal-dialog">
   
      <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              通知
            </h4>
         </div>
         <div style="font-size: 20px" class="modal-body text-danger">
            旧密码错误，修改密码失败
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function () { 
	$('#changeSuccessModal').modal('show');
 });
</script>