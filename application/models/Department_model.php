<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class department_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_dept_list()
	{
		$this->cportal->from('Department');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('department'=>$result[$i]->Department,
								   'UID'=>$result[$i]->UID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_deptpos_list()
	{
		$this->cportal->from('DepartmentPosition');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('department'=>$result[$i]->Department,
								   'position'=>$result[$i]->Position,
								   'UID'=>$result[$i]->UID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_deptpos_record($department)
	{
		$this->cportal->where('Department', $department);
		$this->cportal->from('DepartmentPosition');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_deptemail_list()
	{
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('name'=>$result[$i]->Name,
								   'email'=>$result[$i]->Email,
								   'department'=>$result[$i]->Department,
								   'position'=>$result[$i]->Position,
								   'UID'=>$result[$i]->UID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_deptemail_record($UID)
	{
		$this->cportal->where('UID', $UID);
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_dept_position($dept)
	{
		$this->cportal->select('Position');
		$this->cportal->where('Department', $dept);
		$this->cportal->from('DepartmentPosition');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Department()
	{
		$this->cportal->from('Department');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $dept = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Department => $result[$i]->Department);
			$dept = $dept+$array;
        }
        return $dept;
	}
	
	public function get_Position($UID)
	{
		$this->cportal->where('UID', $UID);
        $this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $dept = $query->result();
		
		$this->cportal->where('Department', $dept[0]->Department);
        $this->cportal->from('DepartmentPosition');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $post = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->Position) => trim($result[$i]->Position));
			$post = $post+$array;
        }
        return $post;
	}
}?>