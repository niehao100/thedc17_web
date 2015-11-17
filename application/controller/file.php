<?php
class File extends Controller
{
    public function index()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/file/index.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/file/index.php';
        require APP . 'view/_templates/footer.php';
    }
    public function upload (){
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if ($_SESSION['type']=='1')
        {
            $this->filemodel->savefile();
            require APP . 'view/_templates/header.php';
            require APP . 'view/file/upload_success.php';
            require APP . 'view/file/index.php';
            require APP . 'view/_templates/middle.php';
            require APP . 'view/file/upload_success.php';
            require APP . 'view/file/index.php';
            require APP . 'view/_templates/footer.php';
        }else{
            header("location:".URL);
        }
    }
    public function delete($file_name)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->filemodel->deletefile($file_name)==false)
        {
            header("location:".URL);
            return;
        }
        header("location:".URL."file/listall2");
    }
    public function listall2(){
        $this->filemodel->updatetime();
        $res=$this->filemodel->getfilelist();
        require APP . 'view/_templates/header.php';
        require APP . 'view/file/delete_success.php';
        require APP . 'view/file/listall.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/file/delete_success.php';
        require APP . 'view/file/listall.php';
        require APP . 'view/_templates/footer.php';
    }
    public function download($file_name){
        
        $file_sub_path=dirname(__FILE__)."/../../uploadfile/";
        $file_path=$file_sub_path.$file_name;
        //首先要判断给定的文件存在与否
        if(!file_exists($file_path)){
           header("location:".URL);
            return ;
        }
        //header("Content-type:text/html;charset=utf-8");
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".substr($file_name, stripos($file_name,"_")+1));
        $buffer=1024;
        $file_count=0;
        //向浏览器返回数据
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    }
     public function listall (){
         $this->filemodel->updatetime();
         $res=$this->filemodel->getfilelist();
         require APP . 'view/_templates/header.php';
         require APP . 'view/file/listall.php';
         require APP . 'view/_templates/middle.php';
         require APP . 'view/file/listall.php';
         require APP . 'view/_templates/footer.php';
     }
}
?>