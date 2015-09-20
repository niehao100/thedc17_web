<div id="myCarouse2" class="carousel slide">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators">
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <li data-target="#myCarouse2" data-slide-to="<?php echo $i-1;?>" <?php if ($i==1){?>class="active"<?php }?>></li>
   <?php }else{break;}}?>
   </ol>   
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">
   <?php for ($i=1;;$i++){if (file_exists("img/slide".$i.".jpg")){?>
      <div class="item<?php if ($i==1){?> active<?php }?>">
         <img src="<?php echo URL."img/slide".$i.".jpg";?>" alt="A slide">
      </div>
   <?php }else{break;}}?>
   </div>
   <!-- 轮播（Carousel）导航 -->
   <a class="left carousel-control" href="#myCarouse2" data-slide="prev">
 <span class="glyphicon glyphicon-chevron-left"></span></a>
 <a class="right carousel-control" href="#myCarouse2" data-slide="next">
 <span class="glyphicon glyphicon-chevron-right"></span></a>
</div> 
<script type="text/javascript">
$('#myCarouse2').carousel({
  interval: 4000
})

</script>
