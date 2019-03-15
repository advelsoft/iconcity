<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class openfeedback_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function get_feedbacks_list()
	{
		if($_SESSION['role'] == 'Mgmt')
		{ 
			$sql = "SELECT f.*, d.Department AS IncidentType, u.PropertyNo, u.OwnerName 
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
					JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE ComplaintIDParent IS NULL AND Status = 'Open' AND f.CondoSeq = '".GLOBAL_CONDOSEQ."' ORDER BY f.FeedbackID DESC";
			$query = $this->jompay->query($sql);
			$result = $query->result();
			
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$sql = "SELECT MAX(CreatedDate) AS LastUpdate FROM Feedback WHERE ComplaintIDParent = '".$result[$i]->FeedbackID."'";
					$query2 = $this->jompay->query($sql);
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
									   'incidentType'=>$result[$i]->IncidentType,
									   'subject'=>$result[$i]->Subject,
									   'createdDate'=>$result[$i]->CreatedDate,
									   'feedbackID'=>$result[$i]->FeedbackID,
									   'maxDate'=>$lastUpdate,
									   'ownerName'=>$result[$i]->OwnerName);
				}
				return $array;
			}
			else{
				return $result;
			}
		}
		else if($_SESSION['role'] == 'Tech')
		{
			$this->db->from('Users');
			$this->db->where('UserID', $_SESSION['userid']);
			$query = $this->db->get();
			$users = $query->result();

			$sql = "SELECT ComplaintIDParent FROM FeedbackResponse 
					WHERE ForwardTo = '".$users[0]->Name."' AND CondoSeq = ".GLOBAL_CONDOSEQ."
					UNION
					SELECT ComplaintIDParent FROM FeedbackResponse 
					WHERE ForwardTo = '".$users[0]->Name."' AND CondoSeq = ".GLOBAL_CONDOSEQ."
					GROUP BY FeedbackResponse.ComplaintIDParent
					HAVING COUNT(*) > 1";
			$query = $this->db->query($sql);
			$remark = $query->result();

			if(count($remark) > 0){
				for ($r = 0; $r < count($remark); $r++)
				{
					$this->db->from('Feedback');
					$this->db->where('FeedbackID', $remark[$r]->ComplaintIDParent);
					$this->db->where('Status !=', 'Closed');
					$query = $this->db->get();
					$result = $query->result();

					if(count($result) > 0){
						for ($i = 0; $i < count($result); $i++)
						{
							$array[$r] = array('propertyNo'=>$result[$i]->PropertyNo,
											   'priority'=>$result[$i]->Priority,
											   'status'=>$result[$i]->Status,
											   'incidentType'=>$result[$i]->IncidentType,
											   'subject'=>$result[$i]->Subject,
											   'createdDate'=>$result[$i]->CreatedDate,
											   'feedbackID'=>$result[$i]->FeedbackID);
						}
					}
					else{
						$array = array();
					}
				}
				return $array;
			}
			else{
				return;
			}
		}
		else //User
		{
			$sql = "SELECT f.*, d.Department AS IncidentType
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
					WHERE ComplaintIDParent IS NULL AND Status != 'Closed' AND f.CreatedBy = ".$_SESSION['userid']." AND CondoSeq = '".GLOBAL_CONDOSEQ."' ORDER BY f.FeedbackID DESC";
			$query1 = $this->jompay->query($sql);
			$result1 = $query1->result();
			
			if(count($result1) > 0){
				for ($i = 0; $i < count($result1); $i++)
				{
					$sql = "SELECT MAX(CreatedDate) AS LastUpdate FROM Feedback WHERE ComplaintIDParent = '".$result1[$i]->FeedbackID."'";
					$query2 = $this->jompay->query($sql);
					$result2 = $query2->result();

					if($result2[0]->LastUpdate != ''){
						$lastUpdate = $result2[0]->LastUpdate;
					}
					else{
						$lastUpdate = $result1[$i]->CreatedDate;
					}
					
					$array[$i] = array('feedbackID'=>$result1[$i]->FeedbackID,
									   'status'=>$result1[$i]->Status,
									   'incidentType'=>$result1[$i]->IncidentType,
									   'subject'=>$result1[$i]->Subject,
									   'createdDate'=>$result1[$i]->CreatedDate,
									   'maxDate'=>$lastUpdate);
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
        $sql = "SELECT f.FeedbackID, f.Priority, u.PropertyNo, d.Department AS IncidentType, f.Subject, f.Status, f.CreatedDate, u.OwnerName 
				FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
				WHERE FeedbackID = ".$UID;
		$query = $this->jompay->query($sql);
        return $query->result();
    }
	
	public function get_replyfeedbacks_record($UID)
    {
        if($_SESSION['role'] == 'Mgmt')
		{
			$sql = "SELECT f.FeedbackID, f.Description, u.PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, 
					NULL as ForwardTo, NULL as ForwardDate, NULL as Role 
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE FeedbackID = ".$UID." 
					UNION 
					SELECT f.FeedbackID, f.Description, u.PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, f.ForwardTo, f.ForwardDate, f.Role
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE ComplaintIDParent = ".$UID." AND (ForwardTo IS NULL OR ForwardTo = '') AND f.Role = '' 
					UNION 
					SELECT f.FeedbackID, f.Description, NULL as PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, 
					f.ForwardTo, f.ForwardDate, f.Role 
					FROM Feedback f 
					JOIN [AllPmrsLive].[dbo].[Users] u ON f.CreatedBy = u.UserID AND f.Role = 'Mgmt'  
					WHERE ComplaintIDParent = ".$UID." AND f.Role = 'Mgmt' 
					ORDER BY CreatedDate ASC";
		}
		else if($_SESSION['role'] == 'Tech')
		{
			$this->db->from('Users');
			$this->db->where('UserID', $_SESSION['userid']);
			$query = $this->db->get();
			$users = $query->result();

			$sql = "SELECT f.FeedbackID,f. Description, f.PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, NULL as Role 
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE FeedbackID = ".$UID." 
					UNION 
					SELECT FeedbackID, Description, PropertyNo, Attachment1, Attachment2, Attachment3, Attachment4, ResponseBy as CreatedBy, ResponseDate as CreatedDate, Role 
					FROM FeedbackResponse WHERE ComplaintIDParent = ".$UID." AND ResponseBy = '".$users[0]->Name."'
					ORDER BY CreatedDate ASC";
		}
		else //User
		{
			$sql = "SELECT f.FeedbackID, f.Description, u.PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, NULL as ForwardTo, NULL as ForwardDate, NULL as Role
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE FeedbackID = ".$UID."
					UNION 
					SELECT f.FeedbackID, f.Description, u.PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, u.LOGINID as CreatedBy, f.CreatedDate, f.ForwardTo, f.ForwardDate, f.Role
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					WHERE ComplaintIDParent = ".$UID." AND (ForwardTo IS NULL OR ForwardTo = '') AND f.Role = '' 
					UNION
					SELECT f.FeedbackID, f.Description, NULL as PropertyNo, f.Attachment1, f.Attachment2, f.Attachment3, f.Attachment4, 
					u.LOGINID as CreatedBy, f.CreatedDate, f.ForwardTo, f.ForwardDate, f.Role 
					FROM Feedback f 
					JOIN [AllPmrsLive].[dbo].[Users] u ON f.CreatedBy = u.UserID AND f.Role = 'Mgmt' 
					WHERE ComplaintIDParent = ".$UID." 
					ORDER BY CreatedDate ASC";
		}

		$query = $this->jompay->query($sql);
		$result = $query->result();

		for ($i = 0; $i < count($result); $i++)
		{								
			if(isset($result[$i]->ForwardTo) && $result[$i]->ForwardTo != ''){
				$tech = $result[$i]->ForwardTo;
			}
			else{
				$tech = '';
			}
			
			$role = $result[$i]->Role;
			if($role == 'Tech' && $_SESSION['role'] == 'Mgmt'){ //Just to display in Mgmt page
				$frwd = 'Reply From';
			}
			else if($role == 'Mgmt' && $_SESSION['role'] == 'Mgmt' && $tech != ''){ //Just to display in Mgmt page
				$frwd = 'Forward To';
			}
			else{
				$frwd = '';
			}
			
			if(isset($tech) && $tech != ''){
				$array[$i] = array('desc'=>$result[$i]->Description,
								   'frwd'=>$frwd,
								   'tech'=>$tech,
								   'attach1'=>$result[$i]->Attachment1,
								   'attach2'=>$result[$i]->Attachment2,
								   'attach3'=>$result[$i]->Attachment3,
								   'attach4'=>$result[$i]->Attachment4,
								   'createdBy'=>$result[$i]->CreatedBy,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
			else{
				$array[$i] = array('desc'=>$result[$i]->Description,
								   'frwd'=>$frwd,
								   'tech'=>$result[$i]->CreatedBy,
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
		$this->jompay->from('Feedback');
        $this->jompay->where('ComplaintIDParent', $UID);
		$this->jompay->or_where('FeedbackID', $UID); 
        $query = $this->jompay->get();
        return $query->result();
    }
	
	public function get_complainer_email()
	{
		$this->jompay->from('Feedback');
		$this->jompay->where('FeedbackID', $UID);
		$query = $this->jompay->get();	
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
	
	public function get_Users()
	{	
		$this->cportal->select('UserID, PropertyNo, GroupID');
		$this->cportal->from('Users');
		$this->cportal->where('LoginID !=','ADMIN');
		$this->cportal->order_by('PropertyNo', 'ASC');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $users = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
			if($result[$i]->GroupID == '3'){
				$array = array($result[$i]->UserID => trim($result[$i]->PropertyNo).'T');
				$users = $users+$array;
			}
			else{
				$array = array($result[$i]->UserID => trim($result[$i]->PropertyNo));
				$users = $users+$array;
			}
        }
        return $users;
	}
	
	public function get_Technician()
	{
		$this->cportal->from('DepartmentEmail');
		$query = $this->cportal->get();
        $result = $query->result();
		
        $technician = array('0' => 'Select Value', 'None' => 'None');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->Name) => trim($result[$i]->Name));
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
            $array = array($result[$i]->UID => $result[$i]->Department);
			$dept = $dept+$array;
        }
        return $dept;
	}
}