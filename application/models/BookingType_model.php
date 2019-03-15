<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bookingType_model extends CI_Model{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function get_bookingType_list()
	{
		$this->db->from('BookingType');
		$query = $this->db->get();
        return $query->result();
	}
	
    function get_bookingType_record($BookingTypeID)
    {
        $this->db->from('BookingType');
        $this->db->where('BookingTypeID', $BookingTypeID);
        $query = $this->db->get();
        return $query->result();
    }
	
	function get_BTStatus()
	{
		$btStatus = array('Select Value', 'Active', 'Renovation', 'Closed', 'View Only');
        return $btStatus;
	}
	
	function get_MaxBookHour()
	{
		$maxBookHour = array('Select Value');

        for ($i = 1; $i < 24; $i++)
        {
            array_push($maxBookHour, $i);
        }
        return $maxBookHour;
	}
}?>