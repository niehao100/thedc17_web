<table class="table table-striped">
   <caption>共<?php if(isset($res) && $res!=null){echo count($res);}else{echo '0';}?>条消息</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>标题</th>
         <th>作者</th>
         <th>时间</th>
         <?php if (isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
         <th>操作</th>
         <?php }?>
      </tr>
   </thead>
   <?php if(isset($res) && $res!=null){?>
   <tbody>
   <?php for($i=0;$i<count($res);++$i){ if ($res[$i]['mess_valid']=='1'){?>
   <tr><a >
         <td><?php echo 1+$i;?></td>
         <td><a href="<?php echo URL."message/listitem/".$res[$i]['mess_id']?>"><?php echo $res[$i]['mess_title'];?></a></td>
         <td><?php echo $res[$i]['mess_owner'];?></td>
         <td><?php echo date('m-d H:i',strtotime($res[$i]['mess_uploadtime']."+8 hour"));?></td>
         <?php if (isset($_SESSION['username']) &&$_SESSION['username']==$res[$i]['mess_owner']){?>
            <td><a href="<?php echo URL."message/delete/".$res[$i]['mess_id'];?>">删除</a></td>
         <?php }elseif(isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
         <td></td>
         <?php }?>
</tr>
      <?php }}}?>
   </tbody>
</table>