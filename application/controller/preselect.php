<?php

class Preselect extends Controller
{
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