         
</div>
</div>
</div>    
    <hr/>
    <div class="footdiv"><a href="<?php echo URL;?>forum/listall/1">平台报错</a>&nbsp;
    <a href="mailto:xxxxx@thedc.org" class="email" title="联系邮箱">xxxxx@thedc.org</a>&nbsp;
<?php 
//统计访问量
if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['totalguest']))
{
    $_SESSION['totalguest'] = true;
    $filename="counter.dat";
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
    $filename="counter.dat";
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
    <br>designed by 电设网站组</div>
</body>
</html>
