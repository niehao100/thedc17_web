<?php
class messageModel
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
        for ($i=0;$i<count($to);++$i)
        {
            $mail->AddAddress($to[$i][0]);
            $mail->Send();
            $mail->clearAddresses();
        }
        
    }
    function handlestr($str)
    {
        require_once APP . 'controller/Parsedown.php';
        $Parsedown = new Parsedown();
        return $Parsedown->text($str);
    }
    public function massemail()
    {
       
        
        header("Content-Type: application/octet-stream");
        header('Content-Disposition:attachment;filename="email.txt"');
        
        if ($_POST['emailobj']==1)
        {
            $sql = "SELECT user_email FROM groups cross join user where groups.group_leader=user.user_nickname";
            $query = $this->db->prepare($sql);
            $query->execute();
            $to=$query->fetchAll(PDO::FETCH_NUM);
            
            //$this->postmail($to,$_POST['emaildecription'],$this->handlestr($_POST['inputtext']));
        }
        elseif ($_POST['emailobj']==2)
        {
            $sql = "SELECT user_email FROM user";
            $query = $this->db->prepare($sql);
            $query->execute();
            $to=$query->fetchAll(PDO::FETCH_NUM);
            //$this->postmail($to,$_POST['emaildecription'],$this->handlestr($_POST['inputtext']));
        }
        elseif ($_POST['emailobj']==3)
        {
            $sql = "SELECT user_email FROM group_req cross join user where group_req.req_owner=user.user_nickname and ( group_req.req_status=1 or group_req.req_status=3)";
            $query = $this->db->prepare($sql);
            $query->execute();
            $to=$query->fetchAll(PDO::FETCH_NUM);
            //$this->postmail($to,$_POST['emaildecription'],$this->handlestr($_POST['inputtext']));
        }
        for ($i=0;$i<count($to);++$i)
        {
            echo $to[$i][0]."\n";
        }
        echo "****************************************************\n\n";
        echo "subject:\n".$_POST['emaildecription']."\n\n";
        echo "content:\n".$this->handlestr($_POST['inputtext']);
        exit;
    }
    public function updatetime()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['login']) && $_SESSION['login']==true)
        {
            $sql = "update user set user_lastmessage='".date('Y-m-d H:i:s',time())."' where user_nickname=:name";
            $parameters = array(':name' => $_SESSION['username']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return true;
        }
    }
    public function listmessage($mess_id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select * from message where mess_id=:id";
        $parameters = array(':id' => $mess_id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function deletemessage($mess_id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select mess_owner from message where mess_id=:id";
        $parameters = array(':id' => $mess_id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res=$query->fetch(PDO::FETCH_NUM);
        if ($res)
        {
            if ($res[0]==$_SESSION['username'])
            {
                $sql = "update message set mess_valid=0 where mess_id=:id";
                $parameters = array(':id' => $mess_id);
                $query = $this->db->prepare($sql);
                $query->execute($parameters);
                return true;
            }
        }
        return false;
    }
    
    public function getmessagelist()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql="select * from message where mess_valid='1'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function savemessage()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
         $sql = "INSERT INTO `message`( `mess_title`, `mess_content`, `mess_owner`,  `mess_valid`) VALUES  ".
                    "(:title,:content,:owner,:valid)";
         $parameters = array(':title' => htmlspecialchars($_POST['messagedecription']),':content'=>htmlspecialchars($_POST['inputtext']),
                    ':owner'=>$_SESSION['username'],':valid'=>1
         );
         $query = $this->db->prepare($sql);
         $query->execute($parameters);


    }
}
?>