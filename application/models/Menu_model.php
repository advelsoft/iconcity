<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_menu_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.UID, a.Label, a.Link, a. ParentID, a.Level, a.Role, a.Icon, b.Count  FROM Menu a LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Menu GROUP BY ParentID) b 
					ON a.uid = b.ParentID 
					WHERE a.Level = 1 AND (Role != 'User' OR Role IS NULL)
					ORDER BY a.ParentID, UID ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('uid'=>$result[$i]->UID,
									   'label'=>$result[$i]->Label,
									   'link'=>$result[$i]->Link,
									   'icon'=>$result[$i]->Icon,
									   'cnt'=>$result[$i]->Count);
				}
			}

			//echo '<pre>';
			//print_r($array);
			return $array;
		}
		else{
		}
	}
	
	public function get_submenu_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.UID, a.Label, a.Link, a. ParentID, a.Level, a.Role, a.Icon, b.Count  FROM Menu a
					LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Menu GROUP BY ParentID) b 
					ON a.uid = b.ParentID 
					WHERE a.Level = 2 AND (Role != 'User' OR Role IS NULL)
					ORDER BY a.ParentID, UID ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('uid'=>$result[$i]->UID,
									   'parentID'=>$result[$i]->ParentID,
									   'label'=>$result[$i]->Label,
									   'link'=>$result[$i]->Link,
									   'icon'=>$result[$i]->Icon,
									   'cnt'=>$result[$i]->Count);
					
				}
			}
			//echo '<pre>';
			//print_r($array);
			return $array;
		}
	}
	
	public function get_subsubmenu_list()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT a.UID, a.Label, a.Link, a. ParentID, a.Level, a.Role, a.Icon, b.Count  FROM Menu a
					LEFT JOIN 
					(SELECT ParentID, COUNT(*) AS Count FROM Menu GROUP BY ParentID) b 
					ON a.uid = b.ParentID 
					WHERE a.Level = 3 AND (Role != 'User' OR Role IS NULL)
					ORDER BY a.ParentID, UID ASC";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			
			$array = array();
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('uid'=>$result[$i]->UID,
									   'parentID'=>$result[$i]->ParentID,
									   'label'=>$result[$i]->Label,
									   'link'=>$result[$i]->Link,
									   'icon'=>$result[$i]->Icon);
					
				}
			}
			//echo '<pre>';
			//print_r($array);
			return $array;
		}
	}
}?>