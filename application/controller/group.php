<?php
class Group extends Controller
{
    public function index()
    {
        header("location:".URL."group/listall");
    }
    public function makerequest($id)
    {
        $this->groupmodel->makerequest($id);
        header("location:".URL."group/listall");
    }
    public function approverequest($id)
    {
        $this->groupmodel->approverequest($id);
        header("location:".URL."group/listall");
    }
    public function cancelrequest($id)
    {
        $this->groupmodel->cancelrequest($id);
        header("location:".URL."group/listall");
    }
    public function creategroup()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (strtolower($_POST['vc'])!=$_SESSION['authnum_session'])
        {
           header("location:".URL);
           return;
        }
        $this->groupmodel->creategroup();
        header("location:".URL."group/listall");
    }
    public function checkgroup()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->groupmodel->isGroupExist($_GET['groupname']))
        {
            echo json_encode(array('valid' => false));
        }else{
            echo json_encode(array('valid' => true));
        }
    }
    public function managegroup()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['login']) || $_SESSION['login']==false)
        {
            header("location:".URL."group/listall");
            return ;
        }
        $ismember=$this->groupmodel->isgroupmember();
        $isleader=$this->groupmodel->isgroupleader();
        if ($ismember || $isleader )
        {
            if (openpre==1)
            {
                $mytime=$this->preselectmodel->getmytime($this->groupmodel->getgroupname());
                $alltime=$this->preselectmodel->getalltime();
            }
            $res=$this->groupmodel->listall();
            $mem=$this->groupmodel->getgroupmember();
            $name=$this->groupmodel->getgroupname();
            $type=$this->groupmodel->getgrouptype();
            $groupid=$this->groupmodel->getgroupid();
            $myreq=$this->groupmodel->listmyreq();
            $req=$this->groupmodel->getrequest();
            require APP . 'view/_templates/header.php';
            require APP . 'view/group/managegroup.php';
            require APP . 'view/_templates/middle.php';
            require APP . 'view/group/managegroup.php';
            require APP . 'view/_templates/footer.php';
        }else{
            header("location:".URL."group/listall");
            return ;
        }
        
    }
    public function changegrouptype(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->groupmodel->changegrouptype();
        header("location:".URL."group/managegroup");
    }
    public function listall(){
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['login']) || $_SESSION['login']==false)
        {
            header("location:".URL);
            return;
            
        }
        $res=$this->groupmodel->listall();
        $mem=$this->groupmodel->getgroupmember();
        $ismember=$this->groupmodel->isgroupmember();
        $isleader=$this->groupmodel->isgroupleader();
        $myreq=$this->groupmodel->listmyreq();
        $req=$this->groupmodel->getrequest();

        require APP . 'view/_templates/header.php';
        require APP . 'view/group/grouplist.php';
        require APP . 'view/_templates/middle.php';
        require APP . 'view/group/grouplist.php';
        require APP . 'view/_templates/footer.php';

    }
    public function getinfo()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['login']) || $_SESSION['login']==false)
        {
            header("location:".URL);
            return;
        }
        if ($_SESSION['type']=='1')
        {
            $res=$this->groupmodel->listall2();
            $mem=$this->groupmodel->getgroupmember2();

            
            require APP . 'view/_templates/header.php';
            require APP . 'view/group/grouplist2.php';
            require APP . 'view/_templates/middle.php';
            require APP . 'view/group/grouplist2.php';
            require APP . 'view/_templates/footer.php';
        }else{
            header("location:".URL);
        }
        
    }
    public function settime()
    {
        if (openpre==1)
        {
            $groupname=$this->groupmodel->getgroupname();
            $this->preselectmodel->settime($groupname);
        }
        header("location:".URL."group/managegroup");
        return ;
    }
    
    public function canceltime()
    {
        if (openpre==1)
        {
            $groupname=$this->groupmodel->getgroupname();
            $this->preselectmodel->canceltime($groupname);
        }
        header("location:".URL."group/managegroup");
        return ;
    }
}
?>