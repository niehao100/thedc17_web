<div class="modal fade" id="fileuploadSuccessModal" tabindex="-1" role="dialog" >
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
         <div style="font-size: 20px" class="modal-body">
            上传成功
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function () { 
	$('#fileuploadSuccessModal').modal('show');
 });
</script>