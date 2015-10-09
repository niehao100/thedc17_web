<div class="table-responsive">
<table class="table table-striped" style="overflow-y:scroll; height:100px;">
   <caption>共<?php if(isset($res) && $res!=null){echo 1+count($res);}else{echo '1';}?>支队伍</caption>
   <thead>
      <tr>
         <th>#</th>
         <th>名称</th>
         <th>组别</th>
         <th>队长</th>
         <th>队员</th>
         <th>口号</th>
         <?php if (!$ismember && !$isleader){echo "<th>操作</th>";}else{echo "<th>状态</th>";}?>
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
         <?php 
         if ($res[$i]['group_valid']=='0'){?>
             
             <td>人员已满</td>
             
        <?php  }
         elseif (!$ismember && !$isleader){
         
         $flag=true;
         if(isset($myreq) && $myreq!=null)
         {
             for ($j=0;$j<count($myreq);++$j)
             {
                 if ($myreq[$j][0]==$res[$i]['group_id'])
                 {
                     $flag=false;
                     if ($myreq[$j][1]=='2')
                     {
         ?>
         <td>申请失败</td>
         <?php }elseif ($myreq[$j][1]=='0'){?>
         <td class="active"><a href="<?php echo URL; ?>group/cancelrequest/<?php echo $res[$i]['group_id']; ?>">取消申请</a></td>
         <?php }break;}}
            if ($flag==true)
            {?>
            <td><a href="<?php echo URL; ?>group/makerequest/<?php echo $res[$i]['group_id']; ?>">申请加入</a></td>
         <?php 
            }
         }else{
                ?>
                <td><a href="<?php echo URL; ?>group/makerequest/<?php echo $res[$i]['group_id']; ?>">申请加入</a></td>
                <?php
            }
         ?>
</tr>
      <?php }else {
            echo "<td></td>";}
}}?>
   </tbody>
</table>
</div>

<?php if (!$ismember && !$isleader){if (isset($myreq) && $myreq!=null){?>
<fieldset > 
<legend>创建队伍</legend>
<div class="alert alert-danger">由于您已经申请参加其他队伍，因此无法创建新的队伍。</div>
</fieldset>
<?php }else{?>
<fieldset > 
<legend>创建队伍</legend>
<form class="form-horizontal" id="groupupload" role="form" action="<?php echo URL;?>group/creategroup" method="post">
  
   <div class="form-group">
      <label for="groupname" class="col-sm-2 control-label">队伍名称</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="groupname"  name="groupname"
            >
      </div>
   </div>
   
   <div class="form-group">
      <label  for="groupchant" class="col-sm-2 control-label">队伍口号</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="groupchant"  name="groupchant"
            ></div>
</div>

<div class="form-group">
      <label  for="grouptype" class="col-sm-2 control-label">队伍组别</label>
    <div class="col-sm-10">
      <label class="checkbox-inline">
      <input type="radio" name="grouptype" id="optionsRadios3" 
         value="1" checked> 单片机
   </label>
   <label class="checkbox-inline">
      <input type="radio" name="grouptype" id="optionsRadios4" 
         value="2"> DSP
   </label>
           <label class="checkbox-inline">
      <input type="radio" name="grouptype" id="optionsRadios4" 
         value="3"> FPGA
   </label>
    </div>
    </div>
   
   
<div class="form-group">
      <label for="vc" class="col-sm-2 control-label">验证码</label>
      <div class="col-sm-10">
      <div class="input-group">
         <input type="text"
              class="form-control" id="vc" name="vc">
			<span class="input-group-addon"><img  title="点击刷新" src="<?php echo URL; ?>captcha" align="absbottom" onclick="this.src='<?php echo URL; ?>captcha/index/'+Math.random();"></img></span>
		     <div style='width: 20px'></div>
		</div>
      </div>
   </div>
   
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" id="groupsubmit" class="btn btn-default">发布</button>
      </div>
   </div>
</form>

   </fieldset>

<?php }}?>