<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forms_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function get_form_list()
	{
		$this->cportal->select('Form.*, FormType.Description');
		$this->cportal->from('Form');
		$this->cportal->join('FormType', 'Form.FormType = FormType.FormTypeId');
		$query = $this->cportal->get();
        $result1 = $query->result();
		
		if(count($result1) > 0){
			for ($i = 0; $i < count($result1); $i++)
			{	
				//get CreatedBy
				$this->cportal->from('Users');
				$this->cportal->where('USERID', $result1[$i]->CreatedBy);
				$query = $this->cportal->get();
				$result2 = $query->result();

				if(count($result2) > 0){
					$CreatedBy = $result2[0]->OWNERNAME;
				}
				else {
					$CreatedBy = "";
				}
				
				//get ModifiedBy
				$this->cportal->from('Users');
				$this->cportal->where('USERID', $result1[$i]->ModifiedBy);
				$query = $this->cportal->get();
				$result3 = $query->result();

				if(count($result3) > 0){
					$ModifiedBy = $result3[0]->OWNERNAME;
				}
				else {
					$ModifiedBy = "";
				}
		
				$array[$i] = array('formID'=>$result1[$i]->FormID,
								   'file'=>$result1[$i]->FormFile,
								   'name'=>$result1[$i]->FormName,
								   'desc'=>$result1[$i]->Description,
								   'type'=>$result1[$i]->FormType,
								   'createdBy'=>$CreatedBy,
								   'createdDate'=>$result1[$i]->CreatedDate,
								   'modifiedBy'=>$ModifiedBy,
								   'modifiedDate'=>$result1[$i]->ModifiedDate);
			}
			return $array;
		}
		else{
			return;
		}
	}
	
    public function get_form_record($FormID)
    {
		$this->cportal->select('Form.*, FormType.Description');
		$this->cportal->from('Form');
		$this->cportal->join('FormType', 'Form.FormType = FormType.FormTypeId');
		$this->cportal->where('FormID', $FormID);
		$query = $this->cportal->get();
        $result1 = $query->result();
		
		//get CreatedBy
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $result1[0]->CreatedBy);
		$query = $this->cportal->get();
		$result2 = $query->result();

		if(count($result2) > 0){
			$CreatedBy = $result2[0]->OWNERNAME;
		}
		else {
			$CreatedBy = "";
		}
		
		//get ModifiedBy
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $result1[0]->ModifiedBy);
		$query = $this->cportal->get();
		$result3 = $query->result();

		if(count($result3) > 0){
			$ModifiedBy = $result3[0]->OWNERNAME;
		}
		else {
			$ModifiedBy = "";
		}

		$array = array('formID'=>$result1[0]->FormID,
					   'file'=>$result1[0]->FormFile,
					   'name'=>$result1[0]->FormName,
					   'desc'=>$result1[0]->Description,
					   'type'=>$result1[0]->FormType,
					   'level'=>$result1[0]->Level,
					   'parentID'=>$result1[0]->ParentID,
					   'sequence'=>$result1[0]->Sequence,
					   'mgmt'=>$result1[0]->Mgmt,
					   'owner'=>$result1[0]->Owner,
					   'tenant'=>$result1[0]->Tenant,
					   'jmb'=>$result1[0]->JMB,
					   'createdBy'=>$CreatedBy,
					   'createdDate'=>$result1[0]->CreatedDate,
					   'modifiedBy'=>$ModifiedBy,
					   'modifiedDate'=>$result1[0]->ModifiedDate);
		
		return $array;
    }
	
	public function get_formType_list()
	{
		$this->cportal->from('FormType');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_forms_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 1 AND Mgmt = 1 AND FormType = 1 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Owner = 1 AND FormType = 1  
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Tenant = 1 AND FormType = 1 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subform_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID
					WHERE a.Level = 2 AND Mgmt = 1 AND FormType = 1 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Owner = 1 AND FormType = 1 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Tenant = 1 AND FormType = 1 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subsubform_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 3 AND Mgmt = 1 AND FormType = 1 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Owner = 1 AND FormType = 1 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Tenant = 1 AND FormType = 1 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_archive_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 1 AND Mgmt = 1 AND FormType = 2 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Owner = 1 AND FormType = 2 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Tenant = 1 AND FormType = 2 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subarchive_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID
					WHERE a.Level = 2 AND Mgmt = 1 AND FormType = 2 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Owner = 1 AND FormType = 2 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Tenant = 1 AND FormType = 2 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subsubarchive_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 3 AND Mgmt = 1 AND FormType = 2  
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Owner = 1 AND FormType = 2  
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$query = $this->cportal->query($sql);
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Tenant = 1 AND FormType = 2  
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_info_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 1 AND Mgmt = 1 AND FormType = 3 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Owner = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 1 AND Tenant = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subinfo_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID
					WHERE a.Level = 2 AND Mgmt = 1 AND FormType = 3 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Owner = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 2 AND Tenant = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_subsubinfo_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
					ON a.FormID = b.ParentID 
					WHERE a.Level = 3 AND Mgmt = 1 AND FormType = 3 
					ORDER BY a.ParentID, Sequence ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('formID'=>$result[$i]->FormID,
									   'name'=>$result[$i]->FormName,
									   'file'=>$result[$i]->FormFile,
									   'level'=>$result[$i]->Level,
									   'parentID'=>$result[$i]->ParentID,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			return $array;
		}
		else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//Owner
			if($user[0]->GROUPID == '2')
			{
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Owner = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
			//Tenant
			else {
				$sql = "SELECT a.FormID, a.FormName, a.FormFile, a.Level, a.ParentID, b.Count FROM Form a LEFT JOIN 
						(SELECT ParentID, COUNT(*) AS Count FROM Form GROUP BY ParentID) b 
						ON a.FormID = b.ParentID 
						WHERE a.Level = 3 AND Tenant = 1 AND FormType = 3 
						ORDER BY a.ParentID, Sequence ASC";
				$query = $this->cportal->query($sql);
				$result = $query->result();
				
				$array = array();
				if(count($result) > 0){
					for ($i = 0; $i < count($result); $i++)
					{
						$array[$i] = array('formID'=>$result[$i]->FormID,
										   'name'=>$result[$i]->FormName,
										   'file'=>$result[$i]->FormFile,
										   'level'=>$result[$i]->Level,
										   'parentID'=>$result[$i]->ParentID,
										   'cnt'=>$result[$i]->Count);
					}
				}
				return $array;
			}
		}
	}
	
	public function get_FormType()
	{
		$this->cportal->from('FormType');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $formtype = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->FormTypeId => $result[$i]->Description);
			$formtype = $formtype+$array;
		}
        return $formtype;
	}
	
	public function get_Level()
	{
		$level = array('0'=>'Select Value',
					   '1'=>'Level 1',
					   '2'=>'Level 2',
					   '3'=>'Level 3');
        return $level;
	}
	
	public function get_ParentID()
	{
		$this->cportal->from('Form');
		$this->cportal->where('FormFile', '#');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $parentID = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->FormID => $result[$i]->FormName);
			$parentID = $parentID + $array;
		}
        return $parentID;
	}
}?>