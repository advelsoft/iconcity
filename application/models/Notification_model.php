<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notification_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_users_list()
	{
		$this->cportal->from('Users');
		$query = $this->cportal->get();
        return $query->result();
	}
	
	public function get_Users()
	{
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID !=', 'Admin');
		$this->cportal->where('LOGINID !=', 'Mgmt');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $users = array();
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array(trim($result[$i]->PROPERTYNO) => trim($result[$i]->PROPERTYNO));
			$users = $users+$array;
		}
        return $users;
	}
}?>