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
    /**
     * Get all songs from database
     */
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
            $sql = "update user set user_lastlogin='".time()."' where user_nickname=:nick";
            $parameters = array(':nick' => $nickname);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return true;
        }else{
            $_SESSION['login']=false;
            return false;
        }
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