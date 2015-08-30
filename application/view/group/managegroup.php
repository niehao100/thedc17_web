<?php if ($isleader){?>
<fieldset > 
<legend>管理队伍</legend>
<div class="table-responsive">
<table class="table table-striped">
   <thead>
      <tr>
         <th>#</th>
         <th>昵称</th>
         <th>真实姓名</th>
         <th>状态</th>
      </tr>
   </thead>
   <tbody>
   <?php 
   $curnum=1;
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='3'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td>队长</td>
    </tr>
      <?php }}?>
      
   <?php 
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='1'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td>队员</td>
    </tr>
      <?php }}?>
   <?php 
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='0'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td><a href="<?php echo URL."group/approverequest/".$req[$i][0];?>">批准加入</a></td>
    </tr>
      <?php }}?>
   <?php 
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='2'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td>申请取消</td>
    </tr>
      <?php }}?>
   </tbody>
</table>
</div>
</fieldset>
<?php }elseif ($ismember){?>
<fieldset > 
<legend>查看队伍</legend>
<div class="table-responsive">
<table class="table table-striped">
   <thead>
      <tr>
         <th>#</th>
         <th>昵称</th>
         <th>真实姓名</th>
         <th>身份</th>
      </tr>
   </thead>
   <tbody>
   <?php 
   $curnum=1;
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='3'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td>队长</td>
    </tr>
      <?php }}?>
      
   <?php 
   for($i=0;$i<count($req);++$i){ if ($req[$i][2]=='1'){?>
   <tr>
         <td><?php echo $curnum++;?></td>
         <td><?php echo $req[$i][0];?></td>
         <td><?php echo $req[$i][1];?></td>
         <td>队员</td>
    </tr>
      <?php }}?>
   </tbody>
</table>
</div>
</fieldset>
<?php }?>