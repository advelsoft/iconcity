<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jmb_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->jompay = $this->load->database('jompay',TRUE);
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_jmb_list()
	{
		$sql = "SELECT j.*, C.Name AS C_Name, M.Name AS M_Name
				FROM Jmb j 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] C ON j.CreatedBy = C.UserID 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] M ON j.ModifiedBy = M.UserID";
		$query = $this->cportal->query($sql);
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('UID'=>$result[$i]->UID,
								   'userID'=>$result[$i]->UserID,
								   'propertyNo'=>$result[$i]->PropertyNo,
								   'ownerName'=>$result[$i]->OwnerName,
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
	
	public function get_user_record($UID)
    {
		$sql = "SELECT j.*, C.Name AS C_Name, M.Name AS M_Name
				FROM Jmb j 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] C ON j.CreatedBy = C.UserID 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] M ON j.ModifiedBy = M.UserID 
				WHERE UID = '".$UID."'";
		$query = $this->cportal->query($sql);
        return $query->result();
    }
	
	public function get_UsersList()
	{
		$this->cportal->select('UserID, PropertyNo, GroupID');
		$this->cportal->from('Users');
		$this->cportal->where('LoginID !=','ADMIN');
		$this->cportal->order_by('PropertyNo', 'ASC');
		$query = $this->cportal->get();
		$result = $query->result();
		
        $users = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->PropertyNo) => trim($result[$i]->PropertyNo));
			$users = $users+$array;
        }
        return $users;
	}
}?>