<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promoLog extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//load the model
		$this->load->model('promotion_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Dashboard($title)
	{
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
		$result = $query->result();
		
		$data = array(
			'Product' => $title,
			'PropertyNo' => $result[0]->PROPERTYNO,
			'CreatedBy' => $_SESSION['userid'],
			'CreatedDate' => date('Y-m-d'),
			'CondoSeq' => GLOBAL_CONDOSEQ,
		);
		
		//insert record
		$this->db->insert('PromotionLog', $data);
		redirect('index.php/User/Home/Index');
    }
	
	public function Deals($title)
	{
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
		$result = $query->result();
		
		$data = array(
			'Product' => $title,
			'PropertyNo' => $result[0]->PROPERTYNO,
			'CreatedBy' => $_SESSION['userid'],
			'CreatedDate' => date('Y-m-d'),
			'CondoSeq' => GLOBAL_CONDOSEQ,
		);
		
		//insert record
		$this->db->insert('PromotionLog', $data);
		redirect('index.php/Common/Promotion/Deals/'.GLOBAL_CONDOSEQ);
    }
}?>