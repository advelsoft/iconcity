<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class technician_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_tech_list()
	{
		$this->db->select('Users.*, C.Name AS C_Name, M.Name AS M_Name');
        $this->db->from('Users');
		$this->db->join('Users as C', 'Users.CreatedBy = C.UserID', 'left');
		$this->db->join('Users as M', 'Users.ModifiedBy = M.UserID', 'left');
		$this->db->where('Users.Role', 'Tech');
		$this->db->where('Users.CondoSeq', GLOBAL_CONDOSEQ);
		$query = $this->db->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('loginID'=>$result[$i]->LoginID,
								   'name'=>$result[$i]->Name,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'modifiedBy'=>$result[$i]->M_Name,
								   'modifiedDate'=>$result[$i]->ModifiedDate,
								   'userID'=>$result[$i]->UserID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_tech_record($UserID)
	{
		$this->db->from('Users');
		$this->db->where('UserID', $UserID);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_tech_email($name)
	{
		$this->cportal->select('Email');
		$this->cportal->from('DepartmentEmail');
		$this->cportal->where('Name', $name);
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Name()
	{
		$this->cportal->from('DepartmentEmail');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $dept = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->Name) => trim($result[$i]->Name));
			$dept = $dept+$array;
        }
        return $dept;
	}
	
}?>