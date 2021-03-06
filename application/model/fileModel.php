<?php
class fileModel
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
    public function getfilelist()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql="select * from file where file_valid='1'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deletefile($file_name)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select file_owner from file where file_name=:name";
        $parameters = array(':name' => $file_name);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res=$query->fetch(PDO::FETCH_NUM);
        if ($res)
        {
            if ($res[0]==$_SESSION['username'])
            {
                $sql = "update file set file_valid=0 where file_name=:name";
                $parameters = array(':name' => $file_name);
                $query = $this->db->prepare($sql);
                $query->execute($parameters);
                return true;
            }
        }
        return false;
    }
    public function updatetime()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['login']) && $_SESSION['login']==true)
        {
            $sql = "update user set user_lastfile='".date('Y-m-d H:i:s',time())."' where user_nickname=:name";
            $parameters = array(':name' => $_SESSION['username']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            return true;
        }
    }
    public function savefile()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($_FILES["inputfile"]["error"] <=0)
        {
            $newname=time()."_".$_FILES["inputfile"]["name"];
            $newpath=dirname(__FILE__)."/../../uploadfile/";
            if (!file_exists($newpath.$newname))
            {
                move_uploaded_file($_FILES["inputfile"]["tmp_name"],
                $newpath.$newname);
                $sql = "INSERT INTO `file`(`file_name`, `file_comment`, `file_size`,  `file_owner`, `file_valid`) VALUES ".
                "(:name,:comment,:size,:owner,:valid)";
                if (isset($_GET['decription']))
                {
                    $parameters = array(':name' => $newname,':comment'=>htmlspecialchars($_GET['decription']),':size'=>$_FILES["inputfile"]["size"],
                    ':owner'=>$_SESSION['username'],':valid'=>1);
                }
                else{
                    $parameters = array(':name' => $newname,':comment'=>htmlspecialchars(""),':size'=>$_FILES["inputfile"]["size"],
                        ':owner'=>$_SESSION['username'],':valid'=>1);
                }
                $query = $this->db->prepare($sql);
                $query->execute($parameters);
            }
        }
    }

}
?>