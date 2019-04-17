<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reporting_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	function get_feedback_search($keyword=NULL)
	{
		if ($keyword == "All") $keyword = "";
		
		$sql = "SELECT f.*, u.PROPERTYNO, d.Department FROM Feedback f 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID 
			    WHERE f.CondoSeq = '".$_SESSION['condoseq']."' AND ComplaintIDParent IS NULL AND 
				(f.Status LIKE '%".$keyword."%' OR f.IncidentType LIKE '%".$keyword."%')";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				if(isset($result[$i]->CompletedDate) || $result[$i]->CompletedDate != ''){
					$completedDate = date("d/m/Y", strtotime($result[$i]->CompletedDate));
					
					$dateCompleted = new DateTime(date("Y-m-d", strtotime($result[$i]->CompletedDate)));
					$dateCreated = new DateTime(date("Y-m-d", strtotime($result[$i]->CreatedDate)));
					$diff = $dateCompleted->diff($dateCreated)->days;
				}
				else{
					$completedDate = '';
					$diff = '';
				}

				$array[$i] = array('feedbackID'=>$result[$i]->FeedbackID,
								   'createdDate'=>date("d/m/Y", strtotime($result[$i]->CreatedDate)),
								   'unitNo'=>$result[$i]->PROPERTYNO,
								   'priority'=>$result[$i]->Priority,
								   'status'=>$result[$i]->Status,
								   'category'=>$result[$i]->Department,
								   'subject'=>$result[$i]->Subject,
								   'closedDate'=>$completedDate,
								   'description'=>$result[$i]->Description,
								   'remark'=>$result[$i]->ManagementRemarks,
								   'daysTaken'=>$diff);
			}
			return $array;
		}
		else{
			return;
		}
	}
	
	function get_feedback_search_print($keyword=NULL)
	{
		if ($keyword == "All") $keyword = "";
		
		$sql = "SELECT f.*, u.PROPERTYNO, d.Department FROM Feedback f 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID 
			    WHERE f.CondoSeq = '".$_SESSION['condoseq']."' AND ComplaintIDParent IS NULL AND 
				(f.Status LIKE '%".$keyword."%' OR IncidentType LIKE '%".$keyword."%')";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				if(isset($result[$i]->CompletedDate) || $result[$i]->CompletedDate != ''){
					$completedDate = date("d/m/Y", strtotime($result[$i]->CompletedDate));
					
					$dateCompleted = new DateTime(date("Y-m-d", strtotime($result[$i]->CompletedDate)));
					$dateCreated = new DateTime(date("Y-m-d", strtotime($result[$i]->CreatedDate)));
					$diff = $dateCompleted->diff($dateCreated)->days;
				}
				else{
					$completedDate = '';
					$diff = '';
				}
				
				$array[$i] = array('feedbackID'=>$result[$i]->FeedbackID,
								   'createdDate'=>date("d/m/Y", strtotime($result[$i]->CreatedDate)),
								   'unitNo'=>$result[$i]->PROPERTYNO,
								   'priority'=>$result[$i]->Priority,
								   'status'=>$result[$i]->Status,
								   'category'=>$result[$i]->Department,
								   'subject'=>$result[$i]->Subject,
								   'closedDate'=>$completedDate,
								   'description'=>$result[$i]->ManagementRemarks,
								   'remark'=>'',
								   'daysTaken'=>$diff);
				
			}
			return $array;
		}
		else{
			return;
		}
	}
	
	public function get_status_count()
	{
		$sql = "SELECT DISTINCT Status FROM Feedback WHERE Status != ''";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$sql = "SELECT DISTINCT Status, count(*) AS cntTotal
						FROM Feedback
						WHERE CondoSeq = '".$_SESSION['condoseq']."' AND Status != '' AND ComplaintIDParent IS NULL 
						GROUP BY Status";
				$query = $this->jompay->query($sql);
				return $query->result();
			}
		}
		else{
			return;
		}
	}
	
	public function get_categories_count()
	{
		$this->cportal->from('Department');
        $query = $this->cportal->get();
        $result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$sql = "SELECT DISTINCT d.Department, count(*) AS cntTotal
						FROM [AllPmrsLive].[dbo].[Feedback] f
						JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
						WHERE CondoSeq = '".$_SESSION['condoseq']."' AND ComplaintIDParent IS NULL 
						GROUP BY d.Department";
				$query = $this->db->query($sql);
				return $query->result();
			}
		}
		else{
			return;
		}
	}
	
	public function get_feedback_count($keyword=NULL)
    {
        if ($keyword == "All") $keyword = "";
		
		$sql = "SELECT * FROM Feedback f 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID 
			    WHERE f.CondoSeq = '".$_SESSION['condoseq']."' AND ComplaintIDParent IS NULL AND 
				(f.Status LIKE '%".$keyword."%' OR f.IncidentType LIKE '%".$keyword."%')";
		$query = $this->jompay->query($sql);
        return $query->num_rows();
    }
	
	public function get_Status()
	{
		$sql = "SELECT DISTINCT Status FROM Feedback WHERE Status != ''";
		$query = $this->jompay->query($sql);
		return $query->result();
	}
	
	public function get_Category()
	{
		$this->cportal->from('Department');
        $query = $this->cportal->get();
        return $query->result();
	}
}
?>