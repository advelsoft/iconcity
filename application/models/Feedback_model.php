<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class feedback_model extends CI_Model{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_feedbacks_list()
	{
		$this->db->where('ComplaintIDParent', NULL);
		$this->db->from('Feedback');
		$query = $this->db->get();
        return $query->result();
	}
	
	function get_feedbacks_record($UID)
    {
        $this->db->where('FeedbackID', $UID);
        $this->db->from('Feedback');
        $query = $this->db->get();
        return $query->result();
    }
	
	function get_feedbackforwards_record($UID)
    {
        $sql = 'SELECT Description, NULL AS TechnicianName, CreatedBy, CreatedDate FROM Feedback
				UNION ALL
				SELECT Description, TechnicianName, CreatedBy, CreatedDate FROM FeedbackForward
				WHERE ComplaintIDParent = '.$UID.' ORDER BY CreatedDate ASC';
		$query = $this->db->query($sql);
		$result = $query->result();

		for ($i = 0; $i < count($result); $i++)
		{									
			$desc = explode(":", $result[$i]->Description);

			if($desc[0] == "Forward To"){
				$array[$i] = array('desc'=>$desc[1],
								   'frwd'=>$desc[0],
								   'tech'=>$result[$i]->TechnicianName,
								   'createdBy'=>$result[$i]->CreatedBy,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
			else{
				$array[$i] = array('desc'=>$desc[0],
								   'createdBy'=>$result[$i]->CreatedBy,
								   'createdDate'=>$result[$i]->CreatedDate);
			}
			
		}
		//echo "<pre>";
		//print_r($array);
		return $array;
    }
	
	function get_feedbacks_replied($UID)
    {
		$this->db->where('ComplaintIDParent', $UID);
		$this->db->or_where('FeedbackID', $UID); 
        $this->db->from('Feedback');
        $query = $this->db->get();
        return $query->result();
    }
	
	function get_Priority()
	{
		$priority = array('0'=>'Select Value', 
						  'High'=>'High', 
						  'Medium'=>'Medium',
						  'Low'=>'Low');
        return $priority;
	}	
	
	function get_Status()
	{
		$status = array('0'=>'Select Value', 
						'Open'=>'Open', 
						'In Progress'=>'In Progress', 
						'Closed'=>'Closed');
        return $status;
	}
	
	function get_Technician()
	{
		$this->db->where('Role', 'Technician');
		$this->db->from('Users');
        $query = $this->db->get();
        $result = $query->result();
		
        $technician = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Name => $result[$i]->Name);
			$technician = $technician+$array;
        }
        return $technician;
	}
	
	function get_AssignTo()
	{
		$this->db->where('Role', 'Technician');
		$this->db->from('Users');
        $query = $this->db->get();
        $result = $query->result();
		
        $assignTo = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->Name.', '.$result[$i]->Email => $result[$i]->Name.', '.$result[$i]->Email);
			$assignTo = $assignTo+$array;
        }
        return $assignTo;
	}
}