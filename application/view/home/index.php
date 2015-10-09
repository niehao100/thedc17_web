<div id="url_info">
<p id="info_close"><button type="button" class="close"  >&times;</button></p>
<p>扫描官方微信号</p>
<img  src="../img/barcode.bmp">
<p>QQ交流群203207704</p>
</div>

<div id="myCarouse2" class="carousel slide">
   
   <ol class="carousel-indicators" id="carlist">
   <li data-target="#myCarouse2" data-slide-to="0" class="active"></li>
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <li data-target="#myCarouse2" data-slide-to="<?php echo $i;?>" <?php if ($i==0){?>class="active"<?php }?>></li>
   <?php }else{break;}}?>
   </ol>   
   <div class="carousel-inner">
   <div class="item active">
         <video id="video1" width="100%" >
  <source src="<?php echo URL."img/".(string)(mt_rand()%2+1)?>.mp4" type="video/mp4" />
您的浏览器暂不支持播放视频，请更换浏览器。
</video>
      </div>
      
   
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <div class="item">
         <img src="<?php echo URL."img/slide".$i.".jpg?".mt_rand();?>" alt="A slide">
      </div>
   <?php }else{break;}}?>
   
   </div>
   
   <a class="left carousel-control" id="prev" href="#myCarouse2" data-slide="prev">
 <span class="glyphicon glyphicon-chevron-left"></span></a>
 <a class="right carousel-control" id="next" href="#myCarouse2" data-slide="next">
 <span class="glyphicon glyphicon-chevron-right"></span></a>
</div> 
<script type="text/javascript">
//$('#myCarouse2').hide();
$('#myCarouse2').carousel({
  interval: 4000
})

var myVideo=document.getElementById("video1");

myVideo.volume=0.1;

$("#video1").click(function() { 
	var myVideo=document.getElementById("video1");
	if (myVideo.paused) 
	{
		  myVideo.play(); 
	}
		else 
		{
		  myVideo.pause(); 
		}
});

$("#video1").bind("ended", function(event) { 

	var myVideo=document.getElementById("video1");
	myVideo.currentTime=0;
	myVideo.pause(); 
	});
$("#video1").bind("pause", function(event) { 
	var myVideo=document.getElementById("video1");
	$("#prev").show();
	  $("#next").show();
	  $("#carlist").show();
	  myVideo.controls="";
	$("#myCarouse2").carousel('cycle');
	});
$("#video1").bind("play", function(event) { 
	var myVideo=document.getElementById("video1");
	$("#myCarouse2").carousel('pause');
	  $("#prev").hide();
	  $("#next").hide();
	  $("#carlist").hide();
	  myVideo.controls="controls";
	});
</script>
<br>
<div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
            <a href="<?php echo URL."intro/rule"?>" title="比赛规则" ><img src="<?php echo URL."img/rule.jpg";?>"></a>
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/rule"?>" title="比赛规则">比赛规则<br></a>
              </h3>
              <p>
              本次电设比赛趣味性强，拥有10余种陷阱类、攻击类、防御类道具，极大的增加了比赛的观赏性和挑战性。
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
          <a href="<?php echo URL."intro/thedc"?>" title="自动化系科协" ><img src="<?php echo URL."img/asta.jpg";?>"></a>
            <hr/>
            <a href="<?php echo URL."intro/thedc"?>" title="电子系科协" ><img src="<?php echo URL."img/ee.jpg";?>"></a>
                
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/thedc"?>" title="科协介绍">科协介绍<br></a>
              </h3>
              <p>
         历届电设大赛由电子系科协和自动化系科协共同承办，由两系同学一起构思、设计直至成功举办。
              </p>
            </div>
          </div>
        </div>
        
        <div class="col-sm-4 col-md-4 col-lg-4 ">
          <div class="thumbnail">
            <a href="<?php echo URL."intro/hardware"?>" title="电设概况" ><img src="<?php echo URL."img/logo.png";?>" ></a>
            <div class="caption">
              <h3> 
                <a href="<?php echo URL."intro/hardware"?>" title="电设概况">电设概况<br></a>
              </h3>
              <p>
              电设自1999年开办以来，今年已经是第17个年头，在历届大赛的组织和竞赛过程中，很多领导和老师亲临现场提出了许多关键性的指导和精辟的点评意见，使参赛选手受益匪浅。
              </p>
            </div>
          </div>
        </div>
