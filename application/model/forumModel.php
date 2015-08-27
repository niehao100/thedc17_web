<?php
class forumModel
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
    public function uploadsubject($type)
    {
        $sql="INSERT INTO `forum`(`forum_title`, `forum_content`, `forum_owner`, `forum_type`) VALUES(:title,:content,:owner,:type)";
        $parameters = array(':title'=>$_POST['forumdecription'],':type' => $type,':content' => $_POST['inputtext'],':owner'=>$_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }
    public function uploadthread()
    {
        $sql="INSERT INTO `thread`(`thread_forumid`, `thread_owner`, `thread_content`) VALUES(:id,:owner,:content)";
        $parameters = array(':id' => $_POST['forumid'],':content' => $_POST['inputtext'],':owner'=>$_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $sql="select @@identity";
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0];
    }
    public function gettotalnum($forum_id)
    {
        $sql="select count(*) from thread where thread_forumid=:id";
        $parameters = array(':id' => $forum_id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0];
    }
    public function getlatesttime($forum_id)
    {
        $sql="select thread_owner,thread_estab from thread where thread_forumid=:id order by thread_estab desc LIMIT 1";
        $parameters = array(':id' => $forum_id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM);
    }
    public function listallthread($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql="select * from thread where thread_forumid=:id order by thread_estab asc";
        $parameters = array(':id' => $id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getsubject($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
         $sql="select * from forum where forum_id=:id";
        $parameters = array(':id' => $id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function listall($type)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql="select * from forum where forum_type=:type order by forum_estab desc";
        $parameters = array(':type' => $type);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>