<div class="panel panel-info">
   <div class="panel-heading">
      <h3 class="panel-title">
         <?php echo handlestr2($res['mess_title']);?>
      </h3>
   </div>
   <div class="panel-body">
      <?php echo handlestr($res['mess_content']);?>
   </div>
   <div class="panel-footer pull-right"><?php echo "<i>".$res['mess_owner']."</i>发布于".date('Y-m-d H:i:s',strtotime($res['mess_uploadtime']));?></div>
</div>