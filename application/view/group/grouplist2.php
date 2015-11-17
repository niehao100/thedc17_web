<div class="table-responsive">
<table class="table table-striped">
   <caption>共<?php if(isset($res) && $res!=null){echo count($res);}else{echo '0';}?>支队伍</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>名称</th>
         <th>组别</th>
         <th>队长</th>
		 <th>班级</th>
         <th>联系方式</th>
		 <th>邮箱</th>
         <th>队员</th>
         <th>口号</th>
      </tr>
   </thead>
   <tbody>
   <?php if(isset($res) && $res!=null){?>
   
   <?php for($i=0;$i<count($res);++$i){ ?>
   <tr>
         <td><?php echo 1+$i;?></td>
         <td><?php echo $res[$i]['group_name'];?></td>
         <td><?php echo getteamtype($res[$i]['group_type']);?></td>
         <td><?php echo $res[$i]['user_realname'];?></td>
		 <td><?php echo $res[$i]['user_class'];?></td>
         <td><?php echo $res[$i]['user_phone'];?></td>
		 <td><?php echo $res[$i]['user_email'];?></td>
         <td><?php echo $mem[$i];?></td>
         <td><?php echo $res[$i]['group_chant'];?></td>
</tr>
      <?php }}?>
   </tbody>
</table>
</div>