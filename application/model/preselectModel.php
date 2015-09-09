<?php
class preselectModel
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
    public function producetime()
    {
        $filename="time.dat";
        $fp = fopen($filename, 'w');
        $str=array();
        for ($i=0;$i<30;$i++)
        {
            $str[$i]="";
        }
        fwrite($fp, json_encode($str));
        fclose($fp);
    }
    public function gettime($n)
    {
        if ($n<30)
        {
            $t1=mktime(9,0,0,10,10,2015);
            $t=$t1+$n*pretime*60;
            return date("H:i",$t)." ~ ".date("H:i",$t+pretime*60);
        }
    }
    public function getalltime()
    {
        $filename="time.dat";
        if (!file_exists($filename))
        {
            $this->producetime();
        }
        $t=json_decode(file_get_contents($filename),true);
        return $t;
    }
    
    public function settime($groupname)
    {
        $t=$this->getalltime();
        if ($this->getmytime($groupname)==-1)
        {
            $sql="update groups set group_pretime=:time where group_name=:group";
            $parameters = array(':time' => $_POST['timeperiod'],':group' => $groupname);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            
            $t[$_POST['timeperiod']]=$groupname;
            $filename="time.dat";
            $filename2="pretime.dat";
            $fp = fopen($filename,"w");
            fwrite($fp, json_encode($t));
            fclose($fp);
            
            $fp = fopen($filename2,"w");
            while(list($key,$val)= each($t)) {
                if ($val=="")
                {
                    fwrite($fp, $this->gettime($key)."\t\t\n");
                }else{
                    $sql="select group_leader from groups where group_name=:group";
                    $parameters = array(':group' => $val);
                    $query = $this->db->prepare($sql);
                    $query->execute($parameters);
                
                    $sql="select user_realname from user where user_nickname=:name";
                    $parameters = array(':name' => $query->fetch(PDO::FETCH_NUM)[0]);
                    $query = $this->db->prepare($sql);
                    $query->execute($parameters);
                    fwrite($fp, $this->gettime($key)."\t".$val."\t".$query->fetch(PDO::FETCH_NUM)[0]."\n");
                }
            }
            fclose($fp);
        }
        
        
    }
    public function canceltime($groupname)
    {
        $t=$this->getalltime();
        if ($this->getmytime($groupname)!=-1)
        {
            $sql="update groups set group_pretime=-1 where group_name=:group";
            $parameters = array(':group' => $groupname);
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
            
            $t[$this->getmytime($groupname)]="";
            $filename="time.dat";
            $filename2="pretime.dat";
            $fp = fopen($filename,"w");
            fwrite($fp, json_encode($t));
            fclose($fp);
            
            $fp = fopen($filename2,"w");
            while(list($key,$val)= each($t)) {
                if ($val=="")
                {
                    fwrite($fp, $this->gettime($key)."\t\t\n");
                }else{
                    $sql="select group_leader from groups where group_name=:group";
                    $parameters = array(':group' => $val);
                    $query = $this->db->prepare($sql);
                    $query->execute($parameters);
            
                    $sql="select user_realname from user where user_nickname=:name";
                    $parameters = array(':name' => $query->fetch(PDO::FETCH_NUM)[0]);
                    $query = $this->db->prepare($sql);
                    $query->execute($parameters);
                    fwrite($fp, $this->gettime($key)."\t".$val."\t".$query->fetch(PDO::FETCH_NUM)[0]."\n");
                }
            }
            fclose($fp);
        }
        
    }
    public function getmytime($groupname)
    {
        $t=$this->getalltime();
        
        while(list($key,$val)= each($t)) {
            if ($val==$groupname)
                return $key;
        }
        return -1;
    }
}
?>