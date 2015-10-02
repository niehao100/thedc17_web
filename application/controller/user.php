<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class User extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function encrypt($data, $key) {

        return $this->authcode($data,"ENCODE",$key);
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
    
    public function register()
    {
		if (!isset($_SESSION)) {
            session_start();
        }
        if (strtolower($_POST['vc'])!=$_SESSION['authnum_session'])
        {
            header("location:".URL);
            return;
        }
        if (isset($_POST['registersubmit']))
        {
            $state=$this->usermodel->registeruser($_POST['nickname'],$_POST['password'],
                $_POST['realname'],$_POST['class'],$_POST['cellphone'],$_POST['mailaddress']);
            if ($state==true)
            {
                if (!isset($_SESSION)) {
            session_start();
				}
                $_SESSION['login']='true';
                $_SESSION['username']=$_POST['nickname'];
                $_SESSION['type']=0;
                require APP . 'view/_templates/header.php';
                require APP . 'view/user/register_success.php';
                require APP . 'view/_templates/footer.php';
            }
        }else{
            
        }
        
    }

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function checkVC()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (strtolower($_GET['vc'])==$_SESSION['authnum_session'])
        {
            echo json_encode(array('valid' => true));
        }else{
            echo json_encode(array('valid' => false));
        }
    }
    
    public function checkUser()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->usermodel->isUserExist($_GET['nickname']))
        {
            echo json_encode(array('valid' => false));
        }else{
            echo json_encode(array('valid' => true));
        }
    }
    public function checkUser2()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->usermodel->isUserExist($_GET['resetusername']))
        {
            echo json_encode(array('valid' => true));
        }else{
            echo json_encode(array('valid' => false));
        }
    }
    public function logout()
    {
        if (!isset($_SESSION)) {
        session_start();
        }
       $_SESSION['login']=false;
       $_SESSION['type']=0;
       $_SESSION['notauto']=true;
       setcookie("autologin","",time()-10000,substr(URL_SUB_FOLDER,0,-1));
       header("location:".URL);
    }
    public function changepass()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_POST['newpass']!=$_POST['renewpass'])
        {
            $_SESSION['status']="change_fail";
            header("location:".URL);
        }
        if ($this->usermodel->changepass($_POST['oldpass'],$_POST['newpass']))
        {
            $_SESSION['status']="change_success";
            header("location:".URL);
        }else{
            $_SESSION['status']="change_fail";
            header("location:".URL);
        }
        
    }
    public function resetpass()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['login']))
        {
            if ($_SESSION['login']==true)
                header("location:".URL);
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/resetpass.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/user/resetpass.php';
        require APP . 'view/_templates/footer.php';
    }
    public function ipstatistic()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $filename2="ip.dat";
        if(!isset($_SESSION['totalip']))
        {
            $_SESSION['totalip'] = true;
            $fp2 = fopen($filename2,"a+");
            fwrite($fp2, date("[Y-m-d H:i:s] ").$_POST['ip']." ".$_POST['city']."\n");
            fclose($fp2);
        }
    }
    public function exresetpass()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['login']))
        {
            if ($_SESSION['login']==true)
                header("location:".URL);
        }
        if (strtolower($_POST['vc'])!=$_SESSION['authnum_session'])
        {
            header("location:".URL);
            return;
        }
        if (!$this->usermodel->isUserExist($_POST['resetusername']))
        {
            header("location:".URL);
            return;
        }
        if ($this->usermodel->resetpass($_POST['resetusername'],$_POST['resetmail']))
        {
            $paneltype="panel-success";
            $panelinfo="新密码已经发送到您的邮箱，请查收。";
        }else{
            $paneltype="panel-danger";
            $panelinfo="邮箱与用户注册时不符，请重试。";
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/resetpass.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/user/resetpass.php';
        require APP . 'view/_templates/footer.php';
    }
    public function login()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['wrongtime']))
        {
            if ($_SESSION['wrongtime']>=maxwrong)
            {
                if (time()-$_SESSION['trytime']<5*60)
                {
                    $_SESSION['trytime']=time();
                    $arr = array ('cookie'=>"",'status'=>"用户名不存在或密码错误",'wrongtime'=>$_SESSION['wrongtime']);
                    echo json_encode($arr);
                    return;
                }
            }
        }
        if (!isset($_POST['ajax']) && isset($_COOKIE['autologin'])&&$_COOKIE['autologin']!="")
        {
            
            if ($this->usermodel->checkautologin($_COOKIE['autologin']))
            {
                header("Location:".URL);
                exit;
            }
        } 
        
        $res= $this->usermodel->checkpass($_POST['nickname'],$_POST['password']);
        if ($res)
        {
            if ($_POST['rememberme']=='1')
            {
                $co=$this->encrypt($_POST['nickname'],"thedc17").md5($_POST['nickname']."+and".$_SESSION['pass']);
            }else{
                $co="";
            }
            $arr = array ('cookie'=>$co,'status'=>"success");
            $_SESSION['notauto']=false;
            $_SESSION['wrongtime']=0;
            echo json_encode($arr);
        }else{
            if (!isset($_SESSION['wrongtime']))
            {
                $_SESSION['wrongtime']=1;
            }else{
                if ($_SESSION['wrongtime']>=maxwrong)
                {
                    if (time()-$_SESSION['trytime']>=5*60)
                    {
                        $_SESSION['wrongtime']=1;
                    }
                }else{
                    $_SESSION['wrongtime']++;
                    if ($_SESSION['wrongtime']==maxwrong)
                        $_SESSION['trytime']=time();
                }
            }
            $arr = array ('cookie'=>"",'status'=>"用户名不存在或密码错误",'wrongtime'=>$_SESSION['wrongtime']);
            echo json_encode($arr);
        }
    }
}
