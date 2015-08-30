<div class="table-responsive">
<table class="table table-striped">
   <caption>共<?php if(isset($res) && $res!=null){echo count($res);}else{echo '0';}?>支队伍</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>名称</th>
         <th>队长</th>
         <th>队员</th>
         <th>口号</th>
      </tr>
   </thead>
   <?php if(isset($res) && $res!=null){?>
   <tbody>
   <?php for($i=0;$i<count($res);++$i){ ?>
   <tr>
         <td><?php echo 1+$i;?></td>
         <td><?php echo $res[$i]['group_name'];?></td>
         <td><?php echo $res[$i]['group_leader'];?></td>
         <td><?php echo $mem[$i];?></td>
         <td><?php echo $res[$i]['group_chant'];?></td>
</tr>
      <?php }}?>
   </tbody>
</table>
</div>
<div class="alert alert-danger">您需要<a data-toggle="modal" href="#loginmodal">登录</a>才能发起或加入队伍。</div>
