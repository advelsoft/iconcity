<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class complaint_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_cat_list()
	{
		$this->cportal->from('ComplaintCategories');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('categories'=>$result[$i]->Categories,
								   'department'=>$result[$i]->Department,
								   'email'=>$result[$i]->Email,
								   'UID'=>$result[$i]->UID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_cat_record($UID)
	{
		$this->cportal->where('UID', $UID);
		$this->cportal->from('ComplaintCategories');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_subcat_list()
	{
		$this->cportal->from('ComplaintSubCategories');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('subCategories'=>$result[$i]->SubCategories,
								   'categories'=>$result[$i]->Categories,
								   'email'=>$result[$i]->Email,
								   'UID'=>$result[$i]->UID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_subcat_record($UID)
	{
		$this->cportal->where('UID', $UID);
		$this->cportal->from('ComplaintSubCategories');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_deptpos_record($department)
	{
		$this->cportal->where('Department', $department);
		$this->cportal->from('DepartmentPosition');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_elev_list()
	{
		$this->cportal->from('ComplaintElevation');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_cat_dept($dept)
	{
		$this->cportal->select('Email');
		$this->cportal->where('Department', $dept);
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_subcat_dept($cat)
	{
		$this->cportal->select('Email');
		$this->cportal->where('Categories', $cat);
		$this->cportal->from('ComplaintCategories');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Department()
	{
		$this->cportal->from('DepartmentEmail');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $dept = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->Department) => trim($result[$i]->Department));
			$dept = $dept+$array;
        }
        return $dept;
	}
	
	public function get_Categories()
	{
		$this->cportal->from('ComplaintCategories');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $cat = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->Categories) => trim($result[$i]->Categories));
			$cat = $cat+$array;
        }
        return $cat;
	}
}?>