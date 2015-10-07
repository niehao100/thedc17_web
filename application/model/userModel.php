<?php

class userModel
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
            $query = $this->db->prepare("set names 'utf8'");
            $query->execute();
                     
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    
    public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 4;
         
        // 密匙
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
         
        // 密匙a会参与加解密
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):
            substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
        //解密时会通过这个密匙验证数据完整性
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
        sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                    return substr($result, 26);
                } else {
                    return '';
                }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
    public function decrypt($str, $key) {
        
        return $this->authcode($str,'DECODE',$key);
    }
    
    function postmail($to,$subject = "",$body = ""){
        //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
        //error_reporting(E_ALL);
        //error_reporting(E_STRICT);
        date_default_timezone_set("Asia/Shanghai");//设定时区东八区
        require_once(APP .'controller/class.phpmailer.php');
        require_once(APP ."controller/class.smtp.php");
        $mail = new PHPMailer(); //new一个PHPMailer对象出来
        //$body = preg_replace("[\]",'',$body); //对邮件内容进行必要的过滤
        $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP(); // 设定使用SMTP服务
        $mail->SMTPDebug = 0; // 启用SMTP调试功能
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth = true; // 启用 SMTP 验证功能
        $mail->SMTPSecure = "tls"; // 安全协议
        $mail->Host = "smtp.sina.com.cn"; // SMTP 服务器
        $mail->Port = 25; // SMTP服务器的端口号
        $mail->WordWrap=50;
        $mail->Username = "thedc17@sina.com"; // SMTP服务器用户名
        $mail->Password = "Hardware"; // SMTP服务器密码
        $mail->SetFrom('thedc17@sina.com', '电子设计大赛官方邮箱');
        $mail->AddReplyTo("thedc17@sina.com","电子设计大赛官方邮箱");
        $mail->Subject = $subject;
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address);
        $mail->Send();
    }
    
    function getRandomString($len, $chars=null)
    {
        if (is_null($chars)){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }  
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
           $str .= $chars[mt_rand(0, $lc)];  
        }
        return $str;
    }
    public function resetpass($name,$email)
    {
        error_reporting(0);
        $sql = "SELECT count(*) FROM user where user_nickname=:nickname and user_email=:email";
        $parameters = array(":nickname" => $name,":email"=>$email);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        if  ($query->fetch(PDO::FETCH_NUM)[0]==0)
        {
            return false;
        }
        $newpass=$this->getRandomString(8);
        $this->postmail($email,"电设账户密码更改","您的密码已经更改为<strong>".$newpass."</strong>".
            "<br>建议您尽快前往<a href='http://www.thedc.org'>电设官网</a>登录并<strong>更改密码</strong>。<br><br>电设网站组");
        //$this->postmail($email,"电设","ffff");
        $this->changepass2($name, $newpass);
        return true;
        
    }
    public function changepass($oldpass,$newpass)
    {
        $sql = "SELECT count(*) FROM user where user_nickname=:nickname and user_pass=password(:pass)";
        $parameters = array(":nickname" => $_SESSION['username'],":pass"=>$oldpass);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        if  ($query->fetch(PDO::FETCH_NUM)[0]==0)
        {
            return false;
        }
        $sql = "update user set user_pass=password(:newpass) where user_nickname=:nickname";
        $parameters = array(":nickname" => $_SESSION['username'],":newpass"=>$newpass);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return true;
    }
    public function changepass2($username,$newpass)
    {
        $sql = "update user set user_pass=password(:newpass) where user_nickname=:nickname";
        $parameters = array(":nickname" => $username,":newpass"=>$newpass);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return true;
    }
    public function isUserExist($nickname)
    {
        $sql = "SELECT count(*) FROM user where user_nickname=:nickname";
        $parameters = array(":nickname" => $nickname);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0]>0?true:false;
        
    }
    public function checkpass($nickname,$password)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "SELECT user_nickname,user_type,user_pass FROM user where ( user_nickname=:nick or user_email=:nick2 ) and user_pass=password(:pass)";
        $parameters = array(':nick' => $nickname, ':nick2' => $nickname,':pass' => $password);
        
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res=$query->fetch(PDO::FETCH_NUM);
        if ($res)
        {
            $_SESSION['login']=true;
            $_SESSION['username']=$res[0];
            $_SESSION['type']=$res[1];
            $_SESSION['pass']=$res[2];
            $sql = "update user set user_lastlogin='".date('Y-m-d H:i:s',time())."',user_lastip='".$_SERVER['REMOTE_ADDR']."' where user_nickname=:nick";
            $parameters = array(':nick' => $nickname);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return true;
        }else{
            $_SESSION['login']=false;
            $_SESSION['type']=0;
            $sql = "update user set user_lastfaillogin='".date('Y-m-d H:i:s',time())."' where user_nickname=:nick";
            $parameters = array(':nick' => $nickname);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return false;
        }
    }
    public function getfilenum()
    {
        if (isset($_SESSION['login']) && $_SESSION['login']==true)
        {
            $sql = "SELECT user_lastfile FROM user where user_nickname=:nick";
            $parameters = array(':nick' => $_SESSION['username']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res=$query->fetch(PDO::FETCH_NUM);
            
            $sql = "SELECT count(*) FROM file where file_uploadtime>=:time";
            $parameters = array(':time' => $res[0]);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res=$query->fetch(PDO::FETCH_NUM);
            return $res[0];
        }
        return 0;
    }
    public function getmessagenum()
    {
        if (isset($_SESSION['login']) && $_SESSION['login']==true)
        {
            $sql = "SELECT user_lastmessage FROM user where user_nickname=:nick";
            $parameters = array(':nick' => $_SESSION['username']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res=$query->fetch(PDO::FETCH_NUM);
    
            $sql = "SELECT count(*) FROM message where mess_uploadtime>=:time";
            $parameters = array(':time' => $res[0]);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res=$query->fetch(PDO::FETCH_NUM);
            return $res[0];
        }
        return 0;
    }
    public function checkautologin($al)
    {
        
        $user=substr($al, 0,-32);
        $user=$this->decrypt($user,"thedc17");
        
        $sql = "SELECT user_pass,user_type FROM user where user_nickname=:nick";
        $parameters = array(':nick' => $user);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res=$query->fetch(PDO::FETCH_NUM);
        if (!$res)
            return false;
        $pass=$res[0];
        
        $temp=md5($user."+and".$pass);
        if (substr($al, -32)==$temp)
        {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['login']=true;
            $_SESSION['username']=$user;
            $_SESSION['type']=$res[1];
            
            $sql = "update user set user_lastlogin='".date('Y-m-d H:i:s',time())."',user_lastip='".$_SERVER['REMOTE_ADDR']."' where user_nickname=:nick";
            $parameters = array(':nick' => $user);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            
            return true;
        }else{
            $sql = "update user set user_lastfaillogin='".date('Y-m-d H:i:s',time())."' where user_nickname=:nick";
            $parameters = array(':nick' => $user);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return false;
        }
    }
    public function registeruser($nickname,$pass,$realname,$class,$cellphone,$email)
    {
        $sql = "INSERT INTO `user`(`user_nickname`, `user_pass`, `user_type`, `user_realname`, `user_class`, `user_phone`, `user_email`) VALUES(:nickname,password(:pass),:type,:realname,:class,:cellphone,:email)";
        $query = $this->db->prepare($sql);
        $parameters = array(':nickname' => $nickname, ':pass' => $pass, ':type' => 0, 
            ':realname' => $realname,':class'=>$class,':cellphone'=>$cellphone,':email'=>$email);
        $query->execute($parameters);
        return true;
    }
    public function updateip()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['login']) && isset($_SESSION['ipaddress']))
        {
            if ($_SESSION['login']==true)
            {
                $sql = "update user set user_lastip='".$_SESSION['ipaddress']."' where user_nickname=:nick";
                $parameters = array(':nick' => $_SESSION['username']);
                $query = $this->db->prepare($sql);
                $query->execute($parameters);
            }
        }
    }
}
?>