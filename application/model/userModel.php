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
    public function decrypt($str, $key) {
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $str)) {
            $str = substr($str, 0, strlen($str) - $pad);
        }
        return unserialize($str);
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
            return true;
        }else{
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

}
?>