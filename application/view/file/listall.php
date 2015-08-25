<table class="table table-striped">
   <caption>共<?php if($res!=null){echo count($res);}else{echo '0';}?>个文件</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>名称</th>
         <th>大小</th>
         <th>时间</th>
         <?php if (isset($_SESSION['type']) && $_SESSION['type']=='1'){?>
         <th>操作</th>
         <?php }?>
      </tr>
   </thead>
   <?php if($res!=null){?>
   <tbody>
   <?php for($i=0;$i<count($res);++$i){ if ($res[$i]['file_valid']=='1'){?>
   <tr><a >
         <td><?php echo 1+$i;?></td>
         <td><a title="说明" data-container="body" data-toggle="popover" data-placement="top"  
      data-content="<?php echo $res[$i]['file_comment'];?>" data-trigger='hover' href="<?php echo URL."file/download/".$res[$i]['file_name']?>"><?php echo substr($res[$i]['file_name'], stripos($res[$i]['file_name'],"_")+1);?></a></td>
         <td><?php echo number_format($res[$i]['file_size']/1024/1024,1);echo "MB";?></td>
         <td><?php echo date('m-d H:i',strtotime($res[$i]['file_uploadtime']));?></td>
         <?php if (isset($_SESSION['username']) &&$_SESSION['username']==$res[$i]['file_owner']){?>
            <td><a href="<?php echo URL."file/delete/".$res[$i]['file_name'];?>">删除</a></td>
         <?php }?>
</tr>
      <?php }}}?>
   </tbody>
</table>