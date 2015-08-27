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
        $prep_code = serialize($data);
        $block = mcrypt_get_block_size('des', 'ecb');
        if (($pad = $block - (strlen($prep_code) % $block)) < $block) {
            $prep_code .= str_repeat(chr($pad), $pad);
        }
        $encrypt = mcrypt_encrypt(MCRYPT_DES, $key, $prep_code, MCRYPT_MODE_ECB);
        return base64_encode($encrypt);
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
    public function logout()
    {
        if (!isset($_SESSION)) {
        session_start();
        }
       $_SESSION['login']=false;
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
    public function login()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_COOKIE['autologin'])&&$_COOKIE['autologin']!="")
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
            echo json_encode($arr);
        }else{
            $arr = array ('cookie'=>"",'status'=>"用户名不存在或密码错误");
            echo json_encode($arr);
        }
    }
}
