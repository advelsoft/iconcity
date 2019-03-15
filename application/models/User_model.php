<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function get_user_list()
	{
		$this->jompay->select('Users.*, C.Name AS C_Name, M.Name AS M_Name');
        $this->jompay->from('Users');
		$this->jompay->join('Users as C', 'Users.CreatedBy = C.UserID', 'left');
		$this->jompay->join('Users as M', 'Users.ModifiedBy = M.UserID', 'left');
		$this->jompay->order_by('LoginID', 'ASC');
		$query = $this->jompay->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('userID'=>$result[$i]->UserID,
								   'loginID'=>$result[$i]->LoginID,
								   'name'=>$result[$i]->Name,
								   'email'=>$result[$i]->Email,
								   'role'=>$result[$i]->Role,
								   'condoName'=>$result[$i]->CondoName,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'modifiedBy'=>$result[$i]->M_Name,
								   'modifiedDate'=>$result[$i]->ModifiedDate);
			}
			return $array;
		}
		else{
			return;
		}
	}
	
	public function get_user_record($UserID)
    {
		$this->jompay->where('UserID',$UserID);
        $this->jompay->from('Users');
		$query = $this->jompay->get();
        return $query->result();
    }

    public function get_user_access_control($condoseq, $role)
    {
		$this->jompay->where('CONDOSEQ',$condoseq);
		$this->jompay->where('Role',$role);
        $this->jompay->from('UserAccessControl');
		$query = $this->jompay->get();
        return $query->row();
    }

    public function get_user_access_control_landing($condoseq)
    {
		$this->jompay->where('CONDOSEQ',$condoseq);
        $this->jompay->from('UserAccessControlLanding');
		$query = $this->jompay->get();
        return $query->row();
    }
	
	public function get_UserRole()
	{
		$userRole = array('0'=>'Select Value',
						  'Admin'=>'Admin',
						  'Mgmt'=>'Management');
        return $userRole;
	}
	
	public function get_Condo()
	{
		$sql = "SELECT CONDOSEQ, CondoName FROM [AllPmrsLive].[dbo].[Condo] 
				ORDER BY CondoName ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		
        $condo = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->CONDOSEQ => $result[$i]->CondoName);
			$condo = $condo+$array;
        }
        return $condo;
	}
}?>