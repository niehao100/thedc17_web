<?php

class Message extends Controller
{
    public function listall()
    {
        $res=$this->messagemodel->getmessagelist();
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/listall.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/message/listall.php';
        require APP . 'view/_templates/footer.php';
    }
    public function upload()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/upload.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/message/upload.php';
        require APP . 'view/_templates/footer.php';
    }
    public function listitem($mess_id)
    {
        $res=$this->messagemodel->listmessage($mess_id);
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/list.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/message/list.php';
        require APP . 'view/_templates/footer.php';
    }
    public function delete($mess_id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->messagemodel->deletemessage($mess_id)==false)
        {
            header("location:".URL);
            return;
        }
        header("location:".URL."message/listall2");
    }
    public function listall2(){
        $res=$this->messagemodel->getmessagelist();
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/delete_success.php';
        require APP . 'view/message/listall.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/message/delete_success.php';
        require APP . 'view/message/listall.php';
        require APP . 'view/_templates/footer.php';
    }
    public function uploadmess()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if ($_SESSION['type']=='1')
        {
            $this->messagemodel->savemessage();
            require APP . 'view/_templates/header.php';
            require APP . 'view/message/upload_success.php';
            require APP . 'view/message/upload.php';
            require APP . 'view/_templates/middle.php';
            require APP . 'view/message/upload_success.php';
            require APP . 'view/message/upload.php';
            require APP . 'view/_templates/footer.php';
        }else{
            header("location:".URL);
        }
    }
}
?>