<div class="table-responsive">
<table class="table table-striped">
   <caption>共<?php if(isset($res) && $res!=null){echo 1+count($res);}else{echo '1';}?>支队伍</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>名称</th>
         <th>组别</th>
         <th>队长</th>
         <th>队员</th>
         <th>口号</th>
      </tr>
   </thead>
   <tbody>
   <!-- 不要奇怪，这是管理员们的队伍。 -->
   <tr class="success">
         <td><?php echo "0";?></td>
         <td><?php echo "同志们辛苦了";?></td>
         <td><?php echo "";?></td>
         <td><?php echo "neil";?></td>
         <td><?php echo "xumy13,路过打酱油的,wengzhe,ILT";?></td>
         <td><?php echo "为人民服务！";?></td>
         <?php echo "<td></td>";?>
   </tr>
   <?php if(isset($res) && $res!=null){?>
   
   <?php for($i=0;$i<count($res);++$i){ ?>
   <tr>
         <td><?php echo 1+$i;?></td>
         <td><?php echo $res[$i]['group_name'];?></td>
         <td><?php echo getteamtype($res[$i]['group_type']);?></td>
         <td><?php echo $res[$i]['group_leader'];?></td>
         <td><?php echo $mem[$i];?></td>
         <td><?php echo $res[$i]['group_chant'];?></td>
</tr>
      <?php }}?>
   </tbody>
</table>
</div>
<div class="alert alert-danger">您需要<a data-toggle="modal" href="#loginmodal">登录</a>才能发起或加入队伍。</div>
