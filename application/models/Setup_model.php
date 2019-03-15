<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setup_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->jompay = $this->load->database('jompay',TRUE);
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_condo_list()
	{
		$sql = "SELECT CONDOSEQ, CondoName FROM [AllPmrsLive].[dbo].[Condo] 
				ORDER BY CondoName ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_setup_list($CondoSeq)
	{
		$this->db->where('CONDOSEQ', $CondoSeq);
		$this->db->from('WebCtrl');
		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_userstatus_list($CondoSeq)     
    { 
		$this->db->where('CONDOSEQ', $CondoSeq);
        $this->db->from('UserStatus');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_usergroup_list($CondoSeq)     
    { 
		$this->db->where('CONDOSEQ', $CondoSeq);
        $this->db->from('UserGroup');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_jompay()
	{
        $this->cportal->from('Company');
        $query = $this->cportal->get();
        return $query->result();
	}
}?>