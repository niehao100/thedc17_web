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