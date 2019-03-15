<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class itemlist_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_location_list()
	{
		$this->cportal->from('WOILocation');
		$this->cportal->order_by('LocName', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('locID'=>$result[$i]->LocID,
								   'locName'=>$result[$i]->LocName);
			}
			return $array;
		}
		else{
			return $result;
		}
	}

	public function get_location_record($GroupID)
	{
		$this->cportal->from('WOILocation');
		$this->cportal->where('GroupID', $GroupID);
        $query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Location()
	{
		$this->cportal->from('WOILocation');
		$this->cportal->order_by('LocName', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $location = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->LocID => $result[$i]->LocName);
			$location = $location+$array;
        }
        return $location;
	}
	
	public function get_location_sort()
	{
		$this->cportal->from('WOILocation');
		$this->cportal->order_by('LocName', 'ASC');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_group_list()
	{
		$this->cportal->from('WOIGroup');
		$this->cportal->order_by('GroupName', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('groupID'=>$result[$i]->GroupID,
								   'groupName'=>$result[$i]->GroupName);
			}
			return $array;
		}
		else{
			return $result;
		}
	}

	public function get_group_record($GroupID)
	{
		$this->cportal->from('WOIGroup');
		$this->cportal->where('GroupID', $GroupID);
        $query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Group()
	{
		$this->cportal->from('WOIGroup');
		$this->cportal->order_by('GroupName', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $group = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->GroupID => $result[$i]->GroupName);
			$group = $group+$array;
        }
        return $group;
	}
	
	public function get_group_sort()
	{
		$this->cportal->from('WOIGroup');
		$this->cportal->order_by('GroupName', 'ASC');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_type_list()
	{
		$this->cportal->from('WOIType');
		$this->cportal->join('WOILocation', 'WOILocation.LocID = WOIType.LocID');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIType.GroupID');
		$this->cportal->order_by('GroupName', 'ASC');
        $query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('typeID'=>$result[$i]->TypeID,
								   'typeName'=>$result[$i]->TypeName,
								   'locID'=>$result[$i]->LocID,
								   'locName'=>$result[$i]->LocName,
								   'groupID'=>$result[$i]->GroupID,
								   'groupName'=>$result[$i]->GroupName);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	function get_search_location($loc, $grp)
	{
		$this->cportal->from('WOIType');
		$this->cportal->join('WOILocation', 'WOILocation.LocID = WOIType.LocID');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIType.GroupID');
		
		if($loc != '')
		{
			$this->cportal->where('WOIType.LocID', $loc);
		}
		
		if($grp != '')
		{
			$this->cportal->where('WOIType.GroupID', $grp);
		}
		
		$this->cportal->order_by('GroupName', 'ASC');
		return $this->cportal->get();
	}
	
	function get_search_group($grp, $loc)
	{
		$this->cportal->from('WOIType');
		$this->cportal->join('WOILocation', 'WOILocation.LocID = WOIType.LocID');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIType.GroupID');
		
		if($grp != '')
		{
			$this->cportal->where('WOIType.GroupID', $grp);
		}
		
		if($loc != '')
		{
			$this->cportal->where('WOIType.LocID', $loc);
		}
		
		$this->cportal->order_by('GroupName', 'ASC');
		return $this->cportal->get();
	}
	
	public function get_typeS_list($LocID, $GroupID)     
    { 
        $this->cportal->from('WOIType');
		$this->cportal->join('WOILocation', 'WOILocation.LocID = WOIType.LocID');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIType.GroupID');
		$this->cportal->where('WOIType.LocID', $LocID);
		$this->cportal->where('WOIType.GroupID', $GroupID);
        $query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('typeID'=>$result[$i]->TypeID,
								   'typeName'=>$result[$i]->TypeName,
								   'locID'=>$result[$i]->LocID,
								   'locName'=>$result[$i]->LocName,
								   'groupID'=>$result[$i]->GroupID,
								   'groupName'=>$result[$i]->GroupName);
			}
			return $array;
		}
		else{
			return $result;
		}
    }
	
	public function get_type_record($TypeID)
	{
		$this->cportal->from('WOIType');
		$this->cportal->join('WOILocation', 'WOILocation.LocID = WOIType.LocID');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIType.GroupID');
		$this->cportal->where('TypeID', $TypeID);
        $query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Type()
	{
		$this->cportal->from('WOIType');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $type = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->TypeID => $result[$i]->TypeName);
			$type = $type+$array;
        }
        return $type;
	}
	
	public function get_component_list()
	{
		$this->cportal->select('WOIComponent.*, WOIGroup.GroupName, WOIType. TypeName');
        $this->cportal->from('WOIComponent');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIComponent.GroupID');
		$this->cportal->join('WOIType', 'WOIType.TypeID = WOIComponent.TypeID');
        $query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_component_record($ComponentID)
	{
        $this->cportal->from('WOIComponent');
		$this->cportal->join('WOIGroup', 'WOIGroup.GroupID = WOIComponent.GroupID');
		$this->cportal->join('WOIType', 'WOIType.TypeID = WOIComponent.TypeID');
		$this->cportal->where('ComponentID', $ComponentID);
        $query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_category_list()
	{
		$this->cportal->from('WorkOrderCategory');
		$query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('catID'=>$result[$i]->CatID,
								   'catCode'=>$result[$i]->CatCode,
								   'description'=>$result[$i]->Description);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
}?>