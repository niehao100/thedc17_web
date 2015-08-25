<div class="panel panel-info">
   <div class="panel-heading">
      <h3 class="panel-title">
         <?php echo $res['mess_title'];?>
      </h3>
   </div>
   <div class="panel-body">
      <?php echo "<pre>".$res['mess_content']."</pre>";?>
   </div>
   <div class="panel-footer pull-right"><?php echo "<i>".$res['mess_owner']."</i>发布于".date('Y-m-d H:i:s',strtotime($res['mess_uploadtime']));?></div>
</div>