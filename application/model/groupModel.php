<?php
class groupModel
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
    public function makerequest($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->isgroupleader() || $this->isgroupmember())
            return;
        $sql = "INSERT INTO `group_req`(`req_owner`, `req_groupid`, `req_content`, `req_status`) VALUES(:owner,:id,:content,:status)";
        $parameters = array(":owner" => $_SESSION['username'],":id" => $id
            ,":content" => "",":status" => 0
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }
    public function cancelrequest($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->isgroupleader() || $this->isgroupmember())
            return;
        
        $sql = "delete from `group_req` where req_owner=:owner and req_groupid=:id";
        $parameters = array(":owner" => $_SESSION['username'],":id" => $id);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        
    }
    public function approverequest($name)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!$this->isgroupleader())
            return false;
        $res=$this->getgroupinfo();
        if ($res[1]==maxmember-1)
        {
            return false;
        }
            
        $sql = "update `group_req` set req_status=1 where req_owner=:owner and req_groupid=:id";
        $parameters = array(":owner" => $name,":id" => $res[0]);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        
        $sql = "update `group_req` set req_status=2 where req_owner=:owner and req_groupid!=:id";
        $parameters = array(":owner" => $name,":id" => $res[0]);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        if ($this->getgroupinfo()[1]==maxmember-1)
        {
            $sql = "update `group_req` set req_status=2 where req_groupid=:id and req_status=0";
            $parameters = array(":id" => $res[0]);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
        
            $sql = "update `groups` set group_valid=0 where group_id=:id";
            $parameters = array(":id" => $res[0]);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
        }
        return true;
    }
    public function getrequest()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->isgroupleader())
        {
            $res=$this->getgroupinfo()[0];
        }elseif ($this->isgroupmember()){
            $sql = "select req_groupid from group_req where req_owner=:name and req_status=1";
            $parameters = array(":name" => $_SESSION['username']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res=$query->fetch(PDO::FETCH_NUM)[0];
        }else{
            return;
        }
        $sql = "select group_req.req_owner,user.user_realname,group_req.req_status from group_req left join user on group_req.req_owner=user.user_nickname where req_groupid=:id ";
        
        $parameters = array(":id" => $res);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_NUM);
    }
    public function getleader()
    {
        if (!$this->isgroupleader())
            return;
        $res=$this->getgroupinfo();
        $sql = "select group_req.req_owner,user.user_realname,group_req.req_status from group_req left join user on group_req.req_owner=user.user_nickname where req_groupid=:id ";
        $parameters = array(":id" => $res[0]);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_NUM);
    }
    public function creategroup()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "INSERT INTO `groups`(`group_name`, `group_chant`, `group_leader`, `group_valid`) VALUES(:name,:chant,:leader,:valid)";
        $parameters = array(':name' => $_POST['groupname'],':chant' => $_POST['groupchant'],
            ':leader' => $_SESSION['username'],':valid' => 1
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        
        $sql="select @@identity";
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $lastid=$query->fetch(PDO::FETCH_NUM)[0];
        
        $sql = "INSERT INTO `group_req`(`req_owner`, `req_groupid`, `req_content`,`req_status`) VALUES(:owner,:id,:content,:status)";
        $parameters = array(':owner' => $_SESSION['username'],':id' => $lastid,
            ':content'=>"",':status' => 3
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }
    public function isGroupExist($name)
    {
        $sql = "SELECT count(*) FROM groups where group_name=:name";
        $parameters = array(":name" => $name);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0]>0?true:false;
    }
    public function isgroupleader()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select count(*) from groups where group_leader=:name";
        $parameters = array(':name' => $_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0]>0?true:false;
    }
    public function isgroupmember()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select count(*) from group_req where req_owner=:name and req_status=1";
        $parameters = array(':name' => $_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch(PDO::FETCH_NUM)[0]>0?true:false;
    }
    public function getgroupinfo()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $sql = "select group_id from groups where group_leader=:name";
        $parameters = array(':name' => $_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res[0]= $query->fetch(PDO::FETCH_NUM)[0];
        
        $sql = "select count(*) from group_req where req_groupid=:id and req_status=1";
        $parameters = array(':id' => $res[0]);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        $res[1]= $query->fetch(PDO::FETCH_NUM)[0];
        
        return $res;
    }
    public function listmyreq(){
        $sql = "select req_groupid,req_status from group_req where req_owner=:name and req_status!=2";
        $parameters = array(':name' => $_SESSION['username']);
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll(PDO::FETCH_NUM);
    }
    public function listall()
    {
        $sql = "select * from groups order by group_name asc";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getgroupmember(){
        $sql = "select * from groups order by group_name asc";
        $query = $this->db->prepare($sql);
        $query->execute();
        $res=$query->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($res) || $res==null || count($res)==0)
        {
            return null;
        }
        for ($i=0;$i<count($res);++$i)
        {
            $sql = "select req_owner from group_req where req_groupid=:id and req_status=1";
            $parameters = array(':id' => $res[$i]['group_id']);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            $res2=$query->fetchAll(PDO::FETCH_NUM);
            if (!isset($res2) || $res2==null || count($res2)==0)
            {
                $m[$i]="暂无队员";
            }else{
                $m[$i]=$res2[0][0];
                for ($j=1;$j<count($res2);++$j)
                {
                    $m[$i]=$m[$i].','.$res2[$j][0];
                }
            }
        }
        return $m;
    }
    
}