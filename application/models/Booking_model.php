<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class booking_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_blockUser_list()
	{
		$this->cportal->from('BookingBlockUsers');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_bookingType_list()
	{
		$sql = "SELECT BookingType.*, BookingTypeStatus.Status, C.Name AS C_Name, M.Name AS M_Name 
				FROM [".GLOBAL_DATABASE_NAME."].[dbo].[BookingType] 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[BookingTypeStatus] ON BookingType.BTStatusID = BookingTypeStatus.BTStatusID
				LEFT JOIN [AllPmrsLive].[dbo].[Users] C ON BookingType.CreatedBy = C.UserID 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] M ON BookingType.ModifiedBy = M.UserID";
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('description'=>$result[$i]->Description,
								   'groupCode'=>$result[$i]->GROUPCODE,
								   'status'=>$result[$i]->Status,
								   'maxBookHour'=>$result[$i]->MaxBookHour,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'modifiedBy'=>$result[$i]->M_Name,
								   'modifiedDate'=>$result[$i]->ModifiedDate,
								   'bookingTypeID'=>$result[$i]->BookingTypeID);
			}
			return $array;
		}
		else{
			return;
		}
	}
	
	public function get_bookingStatus_list()
	{
		$this->cportal->from('BookingTypeStatus');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_bookingGroup_list()
	{
		$this->cportal->from('BookingTypeGroup');
		$query = $this->cportal->get();
		return $query->result();
	}
	
    public function get_bookingType_record($BookingTypeID)
    {
		$this->cportal->select('BookingType.*, BookingTypeStatus.Status, BookingType.ImgToShown');
        $this->cportal->from('BookingType');
		$this->cportal->join('BookingTypeStatus', 'BookingType.BTStatusID = BookingTypeStatus.BTStatusID');
        $this->cportal->where('BookingTypeID', $BookingTypeID);
        $query = $this->cportal->get();
        return $query->result();
    }
	
	public function get_BTGroup()
	{
		$this->cportal->from('BookingTypeGroup');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $btGroup = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->GROUPID => $result[$i]->DESCRIPTION);
			$btGroup = $btGroup+$array;
		}
        return $btGroup;
	}
	
	public function get_BTStatus()
	{
		$this->cportal->from('BookingTypeStatus');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $btStatus = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->BTStatusID => $result[$i]->Status);
			$btStatus = $btStatus+$array;
		}
        return $btStatus;
	}
	
	public function get_MaxBookHour()
	{
		$maxBookHour = array('Select Value');

        for ($i = 1; $i < 24; $i++)
        {
            array_push($maxBookHour, $i);
        }
        return $maxBookHour;
	}
}?>