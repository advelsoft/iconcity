<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class index_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function get_promotion()
	{
		if($_SESSION['role'] == 'Admin'){
			$sql = "SELECT * FROM Promotion
					WHERE PromoDateTo >= CONVERT(date, getdate()) AND Display = '1'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		else{
			$sql = "SELECT * FROM Promotion
					WHERE PromoDateTo >= CONVERT(date, getdate()) AND Display = '1' AND CondoSeq = '".$_SESSION['condoseq']."'";
			$query = $this->db->query($sql);
			return $query->result();
		}
	}
	
	public function get_booking()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Admin'){
			$sql = "SELECT * FROM FacilitiesBooking
					WHERE DateFrom >= CONVERT(date, getdate()) AND BStatusID = '1'";
			$query = $this->cportal->query($sql);
			return $query->result();
		}
		else{
			$sql = "SELECT * FROM FacilitiesBooking
					WHERE DateFrom >= CONVERT(date, getdate()) AND UserID = '".$_SESSION['userid']."'";
			$query = $this->cportal->query($sql);
			return $query->result();
		}
	}
	
	public function get_feedback()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Admin'){
			$this->jompay->from('Feedback');
			$this->jompay->where('ComplaintIDParent is', NULL);
			$this->jompay->where('Status !=', 'Closed');
			$this->jompay->where('CondoSeq', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			
			return $query->result();
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->db->from('Users');
			$this->db->where('UserID', $_SESSION['userid']);
			$query = $this->db->get();
			$users = $query->result();

			$this->db->from('FeedbackResponse');
			$this->db->where('ForwardTo', $users[0]->Name);
			$this->db->where('Status !=', 'Closed');
			$this->db->where('CondoSeq', $_SESSION['condoseq']);
			$query = $this->db->get();
			$feedback = $query->result();

			if(isset($feedback[0]->ComplaintIDParent) && $feedback[0]->ComplaintIDParent != ''){
				$this->db->from('Feedback');
				$this->db->where('FeedbackID', $feedback[0]->ComplaintIDParent);
				$this->db->where('Status !=', 'Closed');
				$this->db->where('CondoSeq', $_SESSION['condoseq']);
				$query = $this->db->get();
				return $query->result();
			}
		}
		else{
			$this->jompay->from('Feedback');
			$this->jompay->where('ComplaintIDParent is', NULL);
			$this->jompay->where('Status !=', 'Closed');
			$this->jompay->where('CondoSeq', $_SESSION['condoseq']);
			$this->jompay->where('CreatedBy', $_SESSION['userid']);
			$query = $this->jompay->get();
			return $query->result();
		}
	}
	
	public function get_Version()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Admin'){
			$sql1 = "SELECT * FROM VersionTracker ORDER BY VERSION DESC";
			$query1 = $this->jompay->query($sql1);
			$result = $query1->result();

			if(count($result) > 0){
				$sql = "SELECT VersionTrackerDetails.*, VT.VERSION FROM VersionTrackerDetails JOIN VersionTracker VT ON VT.VERSIONID = VersionTrackerDetails.VERSIONID WHERE VersionTrackerDetails.VERSIONID = '".$result[0]->VERSIONID."' AND ROLE = 'Mgmt'";
				$query = $this->jompay->query($sql);
		        return $query->result();
			} else {
				return $result;
			}
		} else {
			$sql1 = "SELECT * FROM VersionTracker ORDER BY VERSION DESC";
			$query1 = $this->jompay->query($sql1);
			$result = $query1->result();

			if(count($result) > 0){
				$sql = "SELECT VersionTrackerDetails.*, VT.VERSION FROM VersionTrackerDetails JOIN VersionTracker VT ON VT.VERSIONID = VersionTrackerDetails.VERSIONID WHERE VersionTrackerDetails.VERSIONID = '".$result[0]->VERSIONID."' AND ROLE = 'User'";
				$query = $this->jompay->query($sql);
		        return $query->result();
			} else {
				return $result;
			}
			
		}
	}

	public function get_news()
	{
		$sql = "SELECT * FROM Newsfeed JOIN NewsType ON Newsfeed.NewsfeedTypeID = NewsType.NewsTypeID
				WHERE CondoSeq = '".$_SESSION['condoseq']."' AND Publish = '1' AND PublishDateTo >= CONVERT(date, getdate())";
		$query = $this->jompay->query($sql);
        return $query->result();
	}
	
	public function get_promo_details()
	{
		if($_SESSION['role'] == 'Admin'){
			$sql = "SELECT p.*, t.Description
					FROM Promotion p JOIN PromoCategory t ON p.PromoCat = t.PromoCatId
					WHERE PromoDateTo >= CONVERT(date, getdate()) AND Display = '1' ORDER BY NEWID()";
			$query = $this->db->query($sql);
			return $query->result();
		}
		else{
			$sql = "SELECT p.*, t.Description
					FROM Promotion p JOIN PromoCategory t ON p.PromoCat = t.PromoCatId
					WHERE PromoDateTo >= CONVERT(date, getdate()) AND Display = '1' AND p.CondoSeq = '".$_SESSION['condoseq']."' ORDER BY NEWID()";
			$query = $this->db->query($sql);
			return $query->result();
		}
	}
	
	public function get_booking_details()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Admin'){
			$sql = "SELECT f.BookingID, u.PropertyNo, f.DateFrom, f.CreatedDate, b.Description, s.Status
					FROM BookingType b 
					JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
					JOIN BookingStatus s ON f.BStatusID = s.BStatusID 
					JOIN Users u ON f.UserID = u.UserID
					WHERE DateFrom >= CONVERT(date, getdate()) AND f.BStatusID = '1' 
					ORDER BY f.CreatedDate DESC";
			$query = $this->cportal->query($sql);
			return $query->result();
		}
		else{
			$sql = "SELECT f.BookingID, u.PropertyNo, f.DateFrom, f.CreatedDate, b.Description, s.Status
					FROM BookingType b 
					JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
					JOIN BookingStatus s ON f.BStatusID = s.BStatusID 
					JOIN Users u ON f.UserID = u.UserID
					WHERE DateFrom >= CONVERT(date, getdate()) AND f.UserID = '".$_SESSION['userid']."' 
					ORDER BY f.CreatedDate DESC";
			$query = $this->cportal->query($sql);
			return $query->result();
		}
	}
	
	public function get_feedback_details()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Admin'){
			$sql = "SELECT f.FeedbackID, f.Priority, u.PropertyNo, d.Department AS IncidentType, f.Subject, f.Status, f.CreatedDate
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
					WHERE ComplaintIDParent is NULL AND Status != 'Closed' AND f.CondoSeq = '".$_SESSION['condoseq']."'  
					ORDER BY CreatedDate DESC";
			$query = $this->jompay->query($sql);
			return $query->result();
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->db->from('Users');
			$this->db->where('UserID', $_SESSION['userid']);
			$query = $this->db->get();
			$users = $query->result();

			$this->db->from('FeedbackResponse');
			$this->db->where('ForwardTo', $users[0]->Name);
			$this->db->where('Status !=', 'Closed');
			$this->db->where('CondoSeq', $_SESSION['condoseq']);
			$query = $this->db->get();
			$feedback = $query->result();

			if(count($feedback) > 0){
				for ($r = 0; $r < count($feedback); $r++)
				{
					$this->db->from('Feedback');
					$this->db->where('FeedbackID', $feedback[$r]->ComplaintIDParent);
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
											   'feedbackID'=>$result[$i]->FeedbackID,
											   'cnt'=>$r);
						}
					}
					else{
						$array = array();
					}
				}
				//echo '<pre>';
				//print_r($array);
				return $array;
			}
			else{
				return;
			}
		}
		else{
			$sql = "SELECT f.FeedbackID, f.Priority, u.PropertyNo, d.Department AS IncidentType, f.Subject, f.Status, f.CreatedDate
					FROM Feedback f JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.CreatedBy = u.UserID
					JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON f.IncidentType = d.UID
					WHERE ComplaintIDParent is NULL AND Status != 'Closed' AND f.CondoSeq = '".$_SESSION['condoseq']."' AND f.CreatedBy = '".$_SESSION['userid']."' 
					ORDER BY CreatedDate DESC";
			$query = $this->jompay->query($sql);
			return $query->result();
		}
	}
	
	public function get_news_details()
	{
		$sql = "SELECT Newsfeed.*, NewsType.Description 
				FROM Newsfeed JOIN NewsType ON Newsfeed.NewsfeedTypeID = NewsType.NewsTypeID
				WHERE CondoSeq = '".$_SESSION['condoseq']."' AND Publish = '1' AND PublishDateTo >= CONVERT(date, getdate())
				ORDER BY CreatedDate DESC";
		$query = $this->jompay->query($sql);
        return $query->result();
	}
	
	public function get_oshistory_details()
	{
		$this->cportal->from('OsToPayHistory');
		$this->cportal->where('PropertyNo', $_SESSION['propertyno']);
		$query = $this->cportal->get();
		return $query->result();
	}

	public function get_whatsnew_details()
	{
		$sql = "SELECT f.BookingID, u.PropertyNo, FORMAT(f.DateFrom, 'yyyy-MM-dd HH:mm:ss') as DateFrom, FORMAT(f.CreatedDate, 'yyyy-MM-dd HH:mm:ss') as CreatedDate, b.Description, s.Status, 
				NULL as FeedbackID, NULL as IncidentType, NULL as FeedSubject, NULL as PropNo, NULL as Progress, NULL as Priority, 
				NULL as NewsID, NULL as NewsTitle, NULL as NewsSummary, NULL as NewsType
				FROM [".GLOBAL_DATABASE_NAME."].[dbo].[FacilitiesBooking] f
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[BookingType] b ON f.BookingTypeID = b.BookingTypeID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[BookingStatus] s ON f.BStatusID = s.BStatusID 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.UserID = u.UserID
				WHERE f.DateFrom >= CONVERT(date, getdate()) AND f.UserID = '".$_SESSION['userid']."'
				UNION
				SELECT NULL, NULL, NULL, FORMAT(fb.CreatedDate, 'yyyy-MM-dd HH:mm:ss') as CreatedDate, NULL, NULL, fb.FeedbackID, d.Department, 
				fb.Subject, u.PropertyNo, fb.Status, fb.Priority, NULL, NULL, NULL, NULL
				FROM [AllPmrsLive].[dbo].[Feedback] fb
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON fb.UserID = u.UserID 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON fb.IncidentType = d.UID 
				WHERE ComplaintIDParent IS NULL AND Status != 'Closed' AND fb.CondoSeq = '".$_SESSION['condoseq']."' AND PropertyNo = '".$_SESSION['propertyno']."'
				UNION
				SELECT NULL, NULL, NULL, FORMAT(n.CreatedDate, 'yyyy-MM-dd HH:mm:ss') as CreatedDate, NULL, NULL, NULL, NULL, 
				NULL, NULL, NULL, NULL, n.NewsfeedID, n.Title, n.Summary, t.Description  
				FROM [AllPmrsLive].[dbo].[Newsfeed] n
				JOIN [AllPmrsLive].[dbo].[NewsType] t ON n.NewsfeedTypeID = t.NewsTypeID
				WHERE n.CondoSeq = '".$_SESSION['condoseq']."' AND n.Publish = '1' AND n.PublishDateTo >= CONVERT(date, getdate())
				ORDER BY CreatedDate DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_tasktodo_details()
	{
		$sql = "SELECT f.BookingID, u.PropertyNo, FORMAT(f.DateFrom, 'yyyy-MM-dd HH:mm:ss') as DateFrom, FORMAT(f.CreatedDate, 'yyyy-MM-dd HH:mm:ss') as CreatedDate, b.Description, s.Status, 
				NULL as FeedbackID, NULL as IncidentType, NULL as FeedSubject, NULL as PropNo, NULL as Progress, NULL as Priority
				FROM [".GLOBAL_DATABASE_NAME."].[dbo].[FacilitiesBooking] f
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[BookingType] b ON f.BookingTypeID = b.BookingTypeID
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[BookingStatus] s ON f.BStatusID = s.BStatusID 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON f.UserID = u.UserID
				WHERE f.DateFrom >= CONVERT(date, getdate()) AND f.BStatusID = '1' 
				UNION
				SELECT NULL, NULL, NULL, FORMAT(fb.CreatedDate, 'yyyy-MM-dd HH:mm:ss') as CreatedDate, NULL, NULL, 
				fb.FeedbackID, d.Department, fb.Subject, u.PropertyNo, fb.Status, fb.Priority
				FROM [AllPmrsLive].[dbo].[Feedback] fb
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] u ON fb.UserID = u.UserID 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Department] d ON fb.IncidentType = d.UID 
				WHERE ComplaintIDParent IS NULL AND Status != 'Closed' AND fb.CondoSeq = '".$_SESSION['condoseq']."'
				ORDER BY CreatedDate DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_Company(){
		$this->cportal->from('Company');
		$query = $this->cportal->get();
		return $query->result();
	}
}?>