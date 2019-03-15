<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class workorder_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_openWO_list()
	{
		$this->cportal->select('WorkOrder.*');
		$this->cportal->from('WorkOrder');
		$this->cportal->where('Status', 'Open');
		$this->cportal->order_by('WorkOrderID', 'ASC');
		$query = $this->cportal->get();
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$sql = "SELECT MAX(ModifiedDate) AS LastUpdate FROM WorkOrder WHERE WorkOrderID = '".$result[$i]->WorkOrderID."'";
				$query2 = $this->cportal->query($sql);
				$result2 = $query2->result();
				
				if($result2[0]->LastUpdate != ''){
					$lastUpdate = $result2[0]->LastUpdate;
				}
				else{
					$lastUpdate = $result[$i]->CreatedDate;
				}
				
				$array[$i] = array('propertyNo'=>$result[$i]->PropertyNo,
								   'feedbackID'=>$result[$i]->FeedbackID,
								   'priority'=>$result[$i]->Priority,
								   'status'=>$result[$i]->Status,
								   'category'=>$result[$i]->Category,
								   'incidentType'=>$result[$i]->IncidentType,
								   'subject'=>$result[$i]->Subject,
								   'dateIncident'=>$result[$i]->DateIncident,
								   'workOrderID'=>$result[$i]->WorkOrderID,
								   'maxDate'=>$lastUpdate);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_inprogressWO_list()
	{
		$this->cportal->select('WorkOrder.*');
		$this->cportal->from('WorkOrder');
		$this->cportal->where('Status', 'InProgress');
		$this->cportal->order_by('WorkOrderID', 'ASC');
		$query = $this->cportal->get();
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$sql = "SELECT MAX(ModifiedDate) AS LastUpdate FROM WorkOrder WHERE WorkOrderID = '".$result[$i]->WorkOrderID."'";
				$query2 = $this->cportal->query($sql);
				$result2 = $query2->result();
				
				if($result2[0]->LastUpdate != ''){
					$lastUpdate = $result2[0]->LastUpdate;
				}
				else{
					$lastUpdate = $result[$i]->CreatedDate;
				}
				
				$array[$i] = array('propertyNo'=>$result[$i]->PropertyNo,
								   'priority'=>$result[$i]->Priority,
								   'status'=>$result[$i]->Status,
								   'category'=>$result[$i]->Category,
								   'incidentType'=>$result[$i]->IncidentType,
								   'subject'=>$result[$i]->Subject,
								   'dateIncident'=>$result[$i]->DateIncident,
								   'workOrderID'=>$result[$i]->WorkOrderID,
								   'maxDate'=>$lastUpdate);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_closedWO_list()
	{
		$this->cportal->select('WorkOrder.*');
		$this->cportal->from('WorkOrder');
		$this->cportal->where('Status', 'Closed');
		$this->cportal->order_by('WorkOrderID', 'ASC');
		$query = $this->cportal->get();
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$sql = "SELECT MAX(ModifiedDate) AS LastUpdate FROM WorkOrder WHERE WorkOrderID = '".$result[$i]->WorkOrderID."'";
				$query2 = $this->cportal->query($sql);
				$result2 = $query2->result();
				
				if($result2[0]->LastUpdate != ''){
					$lastUpdate = $result2[0]->LastUpdate;
				}
				else{
					$lastUpdate = $result[$i]->CreatedDate;
				}
				
				$array[$i] = array('propertyNo'=>$result[$i]->PropertyNo,
								   'priority'=>$result[$i]->Priority,
								   'status'=>$result[$i]->Status,
								   'category'=>$result[$i]->Category,
								   'incidentType'=>$result[$i]->IncidentType,
								   'subject'=>$result[$i]->Subject,
								   'dateIncident'=>$result[$i]->DateIncident,
								   'workOrderID'=>$result[$i]->WorkOrderID,
								   'maxDate'=>$lastUpdate);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_workOrder_record($UID)
    {
		/*$this->cportal->select('WorkOrder.*, WorkOrderCategory.Description AS CatDesc, WorkOrderCategory.CatID, WOILocation.LocName, WOIGroup.GroupName');
        $this->cportal->from('WorkOrder');
		$this->cportal->join('WorkOrderCategory', 'WorkOrder.Category = WorkOrderCategory.CatCode');
		$this->cportal->join('WOILocation', 'WorkOrder.LocID = WOILocation.LocID');
		$this->cportal->join('WOIGroup', 'WorkOrder.GroupID = WOIGroup.GroupID');
		$this->cportal->where('WorkOrderID', $UID);
		$query = $this->cportal->get();
        return $query->result();*/
		
		$this->cportal->select('WorkOrder.*');
        $this->cportal->from('WorkOrder');
		$this->cportal->where('WorkOrderID', $UID);
		$query = $this->cportal->get();
        return $query->result();
    }
	
	public function get_Priority()
	{
		$priority = array('0'=>'Select Value', 
						  'High'=>'High', 
						  'Medium'=>'Medium',
						  'Low'=>'Low');
        return $priority;
	}	
	
	public function get_AssignTo()
	{
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $assignTo = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Name => $result[$i]->Name);
			$assignTo = $assignTo+$array;
        }
        return $assignTo;
	}
	
	public function get_Category()
	{
		$this->cportal->from('WorkOrderCategory');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $dept = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->CatCode => $result[$i]->Description);
			$dept = $dept+$array;
        }
        return $dept;
	}
	
	public function get_WOILocation()
	{
		$this->cportal->from('WOILocation');
		$this->cportal->order_by('LocName', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $item = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->LocID => $result[$i]->LocName);
			$item = $item+$array;
        }
        return $item;
	}
	
	public function get_WorkOrderItem($UID)
    {
		$this->cportal->from('WorkOrderItem');
		$this->cportal->where('WorkOrderID', $UID);
		$query = $this->cportal->get();
        return $query->result();
    }
	
	public function get_WOItem($UID)
	{
		$this->cportal->from('WorkOrder');
		$this->cportal->where('WorkOrderID', $UID);
		$query = $this->cportal->get();
        $wo = $query->result();
		
		$this->cportal->from('WOIType');
		$this->cportal->where('LocID', $wo[0]->LocID);
		$this->cportal->where('GroupID', $wo[0]->GroupID);
		$query = $this->cportal->get();
        $result = $query->result();
		
        $item = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->TypeID => $result[$i]->TypeName);
			$item = $item+$array;
        }
        return $item;
	}
}