<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facilityBooking_model extends CI_Model 
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_bookingType_list()
	{
		$sql = "SELECT BookingTypeID, Description, ImgToShown
				,(
					SELECT COUNT(*) FROM FacilitiesBooking
					WHERE DateFrom >= CONVERT(date, getdate()) 
					AND BookingTypeID = BookingType.BookingTypeID
				) AS Booked
				FROM BookingType";
		$query = $this->cportal->query($sql);
		return $query->result();
	}
	
	public function get_bookingType_history()
	{
		$sql = "SELECT Description, DateFrom, TimeFrom, TimeTo, PropertyNo
				FROM BookingType AS b 
				JOIN FacilitiesBooking AS f ON b.BookingTypeID = f.BookingTypeID
				JOIN Users u ON f.UserID = u.UserID
				WHERE f.DateFrom < CONVERT(date, getdate()) 
				GROUP BY Description, DateFrom, TimeFrom, TimeTo, PropertyNo 
				ORDER BY DateFrom DESC";
		$query = $this->cportal->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('description'=>$result[$i]->Description,
								   'dateFrom'=>$result[$i]->DateFrom,
								   'timeFrom'=>$result[$i]->TimeFrom,
								   'timeTo'=>$result[$i]->TimeTo,
								   'propertyNo'=>$result[$i]->PropertyNo);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_facilityBooking_list($BookingTypeID)
	{
		$sql = "SELECT BookingID, Description, PROPERTYNO, DateFrom, TimeFrom, TimeTo, Status, f.CreatedDate
				FROM BookingType b 
				JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
				JOIN BookingStatus s ON f.BStatusID = s.BStatusID
				JOIN Users u ON f.UserID = u.UserID
				WHERE f.DateFrom >= CONVERT(date, getdate()) AND b.BookingTypeID = ".$BookingTypeID;
		$query = $this->cportal->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('bookingID'=>$result[$i]->BookingID,
								   'description'=>$result[$i]->Description,
								   'propertyNo'=>$result[$i]->PROPERTYNO,
								   'dateFrom'=>$result[$i]->DateFrom,
								   'timeFrom'=>$result[$i]->TimeFrom,
								   'timeTo'=>$result[$i]->TimeTo,
								   'status'=>$result[$i]->Status,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_facilityBooking_approve()
	{
		$sql = "SELECT *
				FROM BookingType b 
				JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
				JOIN BookingStatus s ON f.BStatusID = s.BStatusID
				JOIN Users u ON f.UserID = u.UserID
				WHERE f.DateFrom >= CONVERT(date, getdate()) AND f.BStatusID = '1'";
		$query = $this->cportal->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('bookingID'=>$result[$i]->BookingID,
								   'description'=>$result[$i]->Description,
								   'propertyNo'=>$result[$i]->PROPERTYNO,
								   'dateFrom'=>$result[$i]->DateFrom,
								   'timeFrom'=>$result[$i]->TimeFrom,
								   'timeTo'=>$result[$i]->TimeTo,
								   'status'=>$result[$i]->Status);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_facilityBooking_all()
	{
		if($_SESSION['role'] == 'Mgmt'){
			$sql = "SELECT *
					FROM BookingType b 
					JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
					JOIN BookingStatus s ON f.BStatusID = s.BStatusID
					JOIN Users u ON f.UserID = u.UserID
					WHERE f.DateFrom >= CONVERT(date, getdate())";
			$query = $this->cportal->query($sql);
			$result = $query->result();
		}
		else{
			$sql = "SELECT *
					FROM BookingType b 
					JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
					JOIN BookingStatus s ON f.BStatusID = s.BStatusID
					JOIN Users u ON f.UserID = u.UserID
					WHERE f.DateFrom >= CONVERT(date, getdate()) AND f.UserID = '".$_SESSION['userid']."'";
			$query = $this->cportal->query($sql);
			$result = $query->result();
		}
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('description'=>$result[$i]->Description,
								   'propertyNo'=>$result[$i]->PROPERTYNO,
								   'dateFrom'=>$result[$i]->DateFrom,
								   'timeFrom'=>$result[$i]->TimeFrom,
								   'timeTo'=>$result[$i]->TimeTo,
								   'status'=>$result[$i]->Status,
								   'bookingID'=>$result[$i]->BookingID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_facilityBooking_record($BookingID)
    {
        $sql = "SELECT f.BookingID, u.PropertyNo, f.DateFrom, b.Description, s.BStatusID, s.Status, f.UserID,
				FORMAT(f.TimeFrom, 'hh:mm') AS TimeFrom, 
				FORMAT(f.TimeTo, 'hh:mm') AS TimeTo
				FROM BookingType b 
				JOIN FacilitiesBooking f ON b.BookingTypeID = f.BookingTypeID
				JOIN BookingStatus s ON f.BStatusID = s.BStatusID
				JOIN Users u ON f.UserID = u.UserID
				WHERE f.BookingID = ".$BookingID;
		$query = $this->cportal->query($sql);
		$result = $query->result();

		$array = array('description'=>$result[0]->Description,
					   'propertyNo'=>$result[0]->PropertyNo,
					   'dateFrom'=>$result[0]->DateFrom,
					   'timeFrom'=>$result[0]->TimeFrom,
					   'timeTo'=>$result[0]->TimeTo,
					   'statusID'=>$result[0]->BStatusID,
					   'status'=>$result[0]->Status,
					   'bookingID'=>$result[0]->BookingID,
					   'userid'=>$result[0]->UserID);
		return $array;
    }
	
	public function get_BookingTypeDesc($BookingTypeID)     
    { 
		$this->cportal->from('BookingType');
        $this->cportal->where('BookingTypeID', $BookingTypeID);
        $query = $this->cportal->get();
        return $query->result();
    }
	
	public function get_ScheduleList($BookingTypeID)
	{
		$sql = "SELECT StartTime, EndTime, StartTime + ' - ' + EndTime AS TimeRange
				,(
					SELECT COUNT(*) FROM FacilitiesBooking 
					WHERE BookingTypeID = ".$BookingTypeID." 
					AND CONVERT(DATE, DateFrom, 103) = '".$_GET['Date']."'
					AND CONVERT(TIME, TimeFrom, 108) <= CONVERT(TIME, vBookingTimeRange.StartTimeSave, 108) 
					AND CONVERT(TIME, TimeTo, 108) >= CONVERT(TIME, vBookingTimeRange.EndTimeSave, 108) 
					AND FacilitiesBooking.BStatusID != '3'
				) AS Booked
				FROM vBookingTimeRange";
		$query = $this->cportal->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$start = date("H:i", strtotime($result[$i]->StartTime));
				$end = date("H:i", strtotime($result[$i]->EndTime));
				
				$sql2 = "SELECT PROPERTYNO, STATUS FROM FacilitiesBooking 
						JOIN Users ON FacilitiesBooking.UserID = Users.UserID
						JOIN BookingStatus ON FacilitiesBooking.BStatusID = BookingStatus.BStatusID
						WHERE BookingTypeID = '".$BookingTypeID."' AND CONVERT(DATE, DateFrom, 103) = '".$_GET['Date']."'
						AND convert(VARCHAR(5), TimeFrom, 108) <= '".$start."' AND convert(VARCHAR(5), TimeTo, 108) >= '".$end."' AND FacilitiesBooking.BStatusID != '3'";
				$query2 = $this->cportal->query($sql2);
				$result2 = $query2->result();

				if(count($result2) > 0){
					$array[$i] = array('timeRange'=>$result[$i]->TimeRange,
									   'propNo'=>trim($result2[0]->PROPERTYNO),
									   'status'=>trim($result2[0]->STATUS),
								       'booked'=>$result[$i]->Booked);
				}
				else{
					$array[$i] = array('timeRange'=>$result[$i]->TimeRange,
									   'booked'=>$result[$i]->Booked);
				}
			}
			//echo '<pre>';
			//print_r($array);
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_ScheduleUpdate($BookingID)
	{
		$this->cportal->from('FacilitiesBooking');
        $this->cportal->where('BookingID', $BookingID);
        $query = $this->cportal->get();
        $bookTypeID = $query->result();
		
		$sql = "SELECT StartTime, EndTime, StartTime + ' - ' + EndTime AS TimeRange
				,(
					SELECT COUNT(*) FROM FacilitiesBooking 
					WHERE BookingTypeID = ".$bookTypeID[0]->BookingTypeID." 
					AND CONVERT(DATE, DateFrom, 103) = '".$_GET['Date']."'
					AND CONVERT(TIME, TimeFrom, 108) <= CONVERT(TIME, vBookingTimeRange.StartTimeSave, 108) 
					AND CONVERT(TIME, TimeTo, 108) >= CONVERT(TIME, vBookingTimeRange.EndTimeSave, 108) 
					AND FacilitiesBooking.BStatusID != '3'
				) AS Booked
				FROM vBookingTimeRange";
		$query = $this->cportal->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$start = date("H:i", strtotime($result[$i]->StartTime));
				$end = date("H:i", strtotime($result[$i]->EndTime));
				
				$sql2 = "SELECT PROPERTYNO, STATUS FROM FacilitiesBooking 
						JOIN Users ON FacilitiesBooking.UserID = Users.UserID
						JOIN BookingStatus ON FacilitiesBooking.BStatusID = BookingStatus.BStatusID
						WHERE BookingTypeID = '".$bookTypeID[0]->BookingTypeID."' AND CONVERT(DATE, DateFrom, 103) = '".$_GET['Date']."'
						AND convert(VARCHAR(5), TimeFrom, 108) <= '".$start."' AND convert(VARCHAR(5), TimeTo, 108) >= '".$end."' AND FacilitiesBooking.BStatusID != '3'";
				$query2 = $this->cportal->query($sql2);
				$result2 = $query2->result();

				if(count($result2) > 0){
					$array[$i] = array('timeRange'=>$result[$i]->TimeRange,
									   'propNo'=>trim($result2[0]->PROPERTYNO),
									   'status'=>trim($result2[0]->STATUS),
								       'booked'=>$result[$i]->Booked);
				}
				else{
					$array[$i] = array('timeRange'=>$result[$i]->TimeRange,
									   'booked'=>$result[$i]->Booked);
				}
			}
			//echo '<pre>';
			//print_r($array);
			return $array;
		}
		else{
			return $result;
		}
	}
	
	public function get_BookingDesc($BookingID)     
    { 
		$this->cportal->from('FacilitiesBooking');
        $this->cportal->where('BookingID', $BookingID);
        $query = $this->cportal->get();
        $result = $query->result();
		
		$this->cportal->where('BookingTypeID', $result[0]->BookingTypeID);
        $this->cportal->from('BookingType');
        $query = $this->cportal->get();
        return $query->result(); 
    }
	
	public function get_PropertyNo()     
    { 
		$this->cportal->select('UserID, PropertyNo, GroupID');
        $this->cportal->from('Users');
		$this->cportal->where('PropertyNo !=','');
		$this->cportal->where('LoginID !=','ADMIN');
		$this->cportal->order_by('PropertyNo', 'ASC');
        $query = $this->cportal->get();
        $result = $query->result();

		$usersPropNo = array('0'  => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
			if($result[$i]->GroupID == '3'){
				$array = array($result[$i]->UserID => trim($result[$i]->PropertyNo).'T');
				$usersPropNo = $usersPropNo+$array;
			}
			else{
				$array = array($result[$i]->UserID => trim($result[$i]->PropertyNo));
				$usersPropNo = $usersPropNo+$array;
			}
        }
        return $usersPropNo;
    }
	
	public function get_TimeFrom()     
    { 
        $this->cportal->from('BookingHourCRM');
        $query = $this->cportal->get();
        $result = $query->result();

        $timeFrom = array('0'  => 'Select Value');

        for ($i = 0; $i < count($result)-1; $i++)
        {
            $timeCnvt = date("H:i", strtotime($result[$i]->Hour));
		
            $array = array($timeCnvt => $result[$i]->Hour);
			$timeFrom = $timeFrom+$array;
        }
        return $timeFrom;
    }
	
	public function get_TimeTo()     
    { 
        $this->cportal->from('BookingHourCRM');
        $query = $this->cportal->get();
        $result = $query->result();

        $timeTo = array('0'  => 'Select Value');

        for ($i = 1; $i < count($result); $i++)
        {
            $timeCnvt = date("H:i", strtotime($result[$i]->Hour));
			
            $array = array($timeCnvt => $result[$i]->Hour);
			$timeTo = $timeTo+$array;
        }
        return $timeTo;
    }
	
	public function get_Status()     
    { 
        $this->cportal->from('BookingStatus');
        $query = $this->cportal->get();
        $result = $query->result();

        $bookingStatus = array('Select Value');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($bookingStatus, $result[$i]->Status);
        }
        return $bookingStatus;
    }
	
	public function get_Blacklist()
	{
		if($_SESSION['role'] == 'User'){
			//get propertyNo
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq']);

			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/BlackListRead';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);

			foreach((array)$body as $key => $value)
			{
				if($key == 'Resp'){
					$Status = $value['Status'];
					$FailedReason = $value['FailedReason'];
					$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
				}
				else if($key == 'Result'){
					$Enabled = $value['Enabled'];
					$BlockMethod = $value['BlockMethod'];
					$OverdueAmount = $value['OverdueAmount'];
					$OverdueDays = $value['OverdueDays'];
					
					$array = array(
								'enabled'=>$Enabled,
								'blockMethod'=>$BlockMethod,
								'overdueAmount'=>$OverdueAmount,
								'overdueDays'=>$OverdueDays);
				}
			}

			if($Status == 'F'){
				$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
				redirect('index.php/Common/FacilityBooking/Index');
			}
			else{
				if(isset($array)){
					return $array;
				}
			}
		}
	}
	
	public function get_BookingTypeGroup($BookingTypeID)     
    { 
		$this->cportal->from('BookingType');
        $this->cportal->where('BookingTypeID', $BookingTypeID);
        $query = $this->cportal->get();
        $result = $query->result();
		
        $this->cportal->from('BookingTypeGroup');
        $this->cportal->where('GROUPID', $result[0]->GROUPID);
        $query = $this->cportal->get();
        return $query->result();
    }

    public function get_BookedFacility($UserID)     
    { 
    	$dt = new DateTime();
		$dt = $dt->format('Y-m-d H:i:s');

		$this->cportal->from('FacilitiesBooking');
        $this->cportal->where('UserID', $UserID);
        $this->cportal->where('TimeFrom >', $dt);
        $query = $this->cportal->get();
        $result = $query->result();
        return $query->result();
    }

    
}?>