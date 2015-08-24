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
        $sql="select * from file where file_valid='1'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deletefile($file_name)
    {
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
    public function savefile()
    {
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
                $parameters = array(':name' => $newname,':comment'=>$_GET['decription'],':size'=>$_FILES["inputfile"]["size"],
                    ':owner'=>$_SESSION['username'],':valid'=>1
                );
                $query = $this->db->prepare($sql);
                $query->execute($parameters);
            }
        }
    }

}
?>