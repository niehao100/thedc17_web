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

<?php if (openpre==1){if ($mytime==-1){?>
<form class="form-horizontal" id="choosetime" role="form" action="<?php echo URL;?>group/settime" method="post">

   <div class="form-group">
      <label for="timeperiod" class="col-sm-2 control-label">选择预赛时间</label>
      <div class="col-sm-10">
         <select class="selectpicker" id='timeperiod' name='timeperiod'>
         <?php for ($i=0;$i<count($alltime);++$i) {if ($alltime[$i]==""){?>
            <option value="<?php echo $i;?>"><?php echo $this->preselectmodel->gettime($i);?></option>
        <?php }}?>
         </select>
      </div>
   </div>
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" id="timesubmit" class="btn btn-default">提交</button>
      </div>
   </div>

</form>

<?php }else{?>
<div class="panel panel-default">
   <div class="panel-body">
      您选择的时间是&nbsp;<strong><?php echo $this->preselectmodel->gettime($mytime);?></strong>&nbsp;&nbsp;&nbsp;
      <a href="<?php echo URL."group/canceltime"?>">取消预约</a>
   </div>
</div>
<?php }}?>