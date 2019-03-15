<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_company_list()
	{
		$this->cportal->from('Company');
		$query = $this->cportal->get();
        return $query->result();
	}
}?>