<?php
class Forum extends Controller
{
    public function listall($type)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($type!='0' && $type!='1' && $type!='2' )
        {
            header("location:".URL);
            return;
        }
        $_SESSION['forum_type']=$type;
        $res=$this->forummodel->listall($type);
        if(isset($res) && $res!=null)
        {
            for($i=0;$i<count($res);++$i){
                $numtotal[$i]=$this->forummodel->gettotalnum($res[$i]['forum_id']);
                $lastest[$i]=$this->forummodel->getlatesttime($res[$i]['forum_id']);
            }
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/forum/listall.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/forum/listall.php';
        require APP . 'view/_templates/footer.php';
    }
   public function thread($id)
   {
       if (!isset($_SESSION)) {
           session_start();
       }
       $res=$this->forummodel->listallthread($id);
       $sub=$this->forummodel->getsubject($id);
       require APP . 'view/_templates/header.php';
       require APP . 'view/forum/thread.php';
       require APP . 'view/_templates/middle.php';
       require APP . 'view/forum/thread.php';
       require APP . 'view/_templates/footer.php';
   }
   public function uploadthread()
   {
       if (!isset($_SESSION)) {
           session_start();
       }
       if (strtolower($_POST['vc'])!=$_SESSION['authnum_session'])
       {
           header("location:".URL);
           return;
       }
       $res=$this->forummodel->uploadthread();
       header("location:".URL."forum/thread/".$_POST['forumid']."#".$res);
   }
    public function uploadsubject()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (strtolower($_POST['vc'])!=$_SESSION['authnum_session'])
        {
            header("location:".URL);
            return;
        }
        $res=$this->forummodel->uploadsubject($_SESSION['forum_type']);
        header("location:".URL."forum/listall/".$_SESSION['forum_type']);
    }
}
?>