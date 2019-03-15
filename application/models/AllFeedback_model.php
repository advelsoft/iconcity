<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class allfeedback_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_feedbacks_list()
	{
		if($_SESSION['role'] == 'Mgmt')
		{
			$this->db->from('Feedback');
			$this->db->where('ComplaintIDParent', NULL);
			$this->db->where('CondoSeq', GLOBAL_CONDOSEQ);
			$query = $this->db->get();
			$result = $query->result();
			
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$array[$i] = array('propertyNo'=>$result[$i]->PropertyNo,
									   'priority'=>$result[$i]->Priority,
									   'status'=>$result[$i]->Status,
									   'incidentType'=>$result[$i]->IncidentType,
									   'subject'=>$result[$i]->Subject,
									   'createdDate'=>$result[$i]->CreatedDate,
									   'feedbackID'=>$result[$i]->FeedbackID);
				}
				return $array;
			}
			else{
				return $result;
			}
		}
		else //User
		{
			$this->db->from('Feedback');
			$this->db->where('ComplaintIDParent', NULL);
			$this->db->where('CreatedBy', $_SESSION['userid']);
			$this->db->where('CondoSeq', GLOBAL_CONDOSEQ);
			$query1 = $this->db->get();
			$result1 = $query1->result();
			
			if(count($result1) > 0){
				for ($i = 0; $i < count($result1); $i++)
				{
					$sql = "SELECT MAX(CreatedDate) AS LastUpdate FROM Feedback 
							WHERE FeedbackID = '".$result1[$i]->FeedbackID."' OR ComplaintIDParent = '".$result1[$i]->FeedbackID."'";
					$query2 = $this->db->query($sql);
					$result2 = $query2->result();

					$array[$i] = array('feedbackID'=>$result1[$i]->FeedbackID,
									   'status'=>$result1[$i]->Status,
									   'incidentType'=>$result1[$i]->IncidentType,
									   'subject'=>$result1[$i]->Subject,
									   'createdDate'=>$result1[$i]->CreatedDate,
									   'maxDate'=>$result2[0]->LastUpdate);
				}
				return $array;
			}
			else{
				return;
			}
		}
	}
	
	public function get_feedbacks_record($UID)
    {
        $this->db->from('Feedback');
		$this->db->where('FeedbackID', $UID);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_replyfeedbacks_record($UID)
    {
		if($_SESSION['role'] == 'Mgmt')
		{
			$sql = "SELECT * FROM Feedback 
					WHERE (FeedbackID = ".$UID." OR ComplaintIDParent = ".$UID.")
					ORDER BY CreatedDate ASC";
		}
		else //User
		{
			$sql = "SELECT * FROM Feedback 
					WHERE (FeedbackID = ".$UID." OR ComplaintIDParent = ".$UID.") AND ManagementRemarks IS NULL AND Description NOT LIKE '%Reply%'
					ORDER BY CreatedDate ASC";
		}
		
		$query = $this->db->query($sql);
		$result = $query->result();

		for ($i = 0; $i < count($result); $i++)
		{									
			$desc = explode(":", $result[$i]->Description);
			$tech = explode(",", $result[$i]->ManagementRemarks);

			if($desc[0] == "Forward To" || strpos($desc[0], 'Reply') !== false){
				$array[$i] = array('desc'=>$desc[1],
								   'frwd'=>$desc[0],
								   'tech'=>$tech[0],
								   'attach1'=>$result[$i]->Attachment1,
								   'attach2'=>$result[$i]->Attachment2,
								   'attach3'=>$result[$i]->Attachment3,
								   'attach4'=>$result[$i]->Attachment4,
								   'createdBy'=>$result[$i]->CreatedBy,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
			else{
				$array[$i] = array('desc'=>$desc[0],
								   'attach1'=>$result[$i]->Attachment1,
								   'attach2'=>$result[$i]->Attachment2,
								   'attach3'=>$result[$i]->Attachment3,
								   'attach4'=>$result[$i]->Attachment4,
								   'createdBy'=>$result[$i]->CreatedBy,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
		}
		return $array;
    }
	
	public function get_feedbacks_replied($UID)
    {
		$this->db->from('Feedback');
        $this->db->where('ComplaintIDParent', $UID);
		$this->db->or_where('FeedbackID', $UID); 
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_complainer_email()
	{
		$this->db->from('Feedback');
		$this->db->where('FeedbackID', $UID);
		$query = $this->db->get();	
		$result = $query->result();
		
		$this->cportal->select('EMAIL');
        $this->cportal->from('Users');
		$this->cportal->where('PropertyNo',$result[0]->PropertyNo);
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
	
	public function get_Technician()
	{
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $technician = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Name => $result[$i]->Name);
			$technician = $technician+$array;
        }
        return $technician;
	}
	
	public function get_AssignTo()
	{
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $assignTo = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Name.', '.$result[$i]->Email => $result[$i]->Name.', '.$result[$i]->Email);
			$assignTo = $assignTo+$array;
        }
        return $assignTo;
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
}