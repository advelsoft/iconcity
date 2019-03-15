<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class amenities_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_amenities_list()
	{
		$this->cportal->from('Amenities');
		$query = $this->cportal->get();
        return $query->result();
	}
}?>