         
</div>
</div>
</div>    
    <hr/>
    <div class="footdiv"><a href="<?php echo URL;?>forum/listall/1">平台报错</a>&nbsp;
    <a href="mailto:thedc@eesast.com" class="email" title="联系邮箱">thedc@eesast.com</a>&nbsp;
<?php 
//统计访问量
if (!isset($_SESSION)) {
    session_start();
}
$filename=ROOT . 'public' . DIRECTORY_SEPARATOR."counter.dat";
if(!isset($_SESSION['totalguest']))
{
    $_SESSION['totalguest'] = true;
    
    
    //require APP . 'view/_templates/header.php';
    if (file_exists($filename))
    {
        $counter = json_decode(file_get_contents($filename),true);
        $counter['total']++;
        $date=date("Ymd");
        if (!isset($counter[$date]))
        {
            $counter[$date]=1;
        }else{
            $counter[$date]++;
        }
        $today=$counter[$date];
        $total=$counter['total'];
        $fp = fopen($filename,"w");
        fwrite($fp, json_encode($counter));
        fclose($fp);
        echo "总访问量：".$total."&nbsp;今日访问量：".$today;
    }else{
        $date=date("Ymd");
        $counter[$date]=1;
        $counter['total']=1;
        $today=1;
        $total=1;
        $fp = fopen($filename,"w");
        fwrite($fp, json_encode($counter));
        fclose($fp);
        echo "总访问量：".$total."&nbsp;今日访问量：".$today;
    }
}else{

    if (file_exists($filename))
    {
        $counter = json_decode(file_get_contents($filename),true);
        $date=date("Ymd");
        if (!isset($counter[$date]))
            $counter[$date]=1;
        echo "总访问量：".$counter['total']."&nbsp;今日访问量：".$counter[$date];
    }
}

?>
    <br>designed by 电设网站组 <a href="http://www.zerouav.com/" target="_blank"><img  src="<?php echo URL."img/zerotech.jpg"?>" style="margin-bottom:4px; width:130px;"></a></div>

<script type="text/javascript" src="http://pv.sohu.com/cityjson?ie=utf-8" charset="utf-8"></script> 
<script>
var rootpath3="http://"+location.hostname+"";
$.post(rootpath3+'/user/ipstatistic',
		  {
		    ip:returnCitySN.cip,
		    city:returnCitySN.cname,
		  },
		  function(data,status){});

</script>

    </body>
</html>
