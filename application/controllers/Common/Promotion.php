<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
		
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
	
	public function Lists()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['condoList'] = $this->promotion_model->get_condo_list();
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Promotion/List',$data);
		$this->load->view('Admin/footer');
	}

	public function Index($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['promoCat'] = $this->promotion_model->get_promoCat_list();
		$data['promoList'] = $this->promotion_model->get_promo_list($CondoSeq);
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Promotion/Index',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/Index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/Index',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Detail($PromoID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoRecord'] = $this->promotion_model->get_promo_record($PromoID);
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Promotion/Detail',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/Detail',$data);
			$this->load->view('User/footer');
		}
	}

	public function DetailAircon()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Promotion/DetailAircon',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/DetailAircon',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/DetailAircon',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Deals($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['promoList'] = $this->promotion_model->get_promo_list($CondoSeq);
		$data['antiVirus'] = $this->promotion_model->get_antiVirus_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Deals/Index',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/Deals/Index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/Deals/Index',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function InternetProvider($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			//no view
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$data_view = array(
				"tab1" => $this->load->view('Mgmt/Promotion/InternetProvider/Maxis', $data, TRUE),
				"tab2" => $this->load->view('Mgmt/Promotion/InternetProvider/Unifi', $data, TRUE),
				"tab3" => $this->load->view('Mgmt/Promotion/InternetProvider/Time', $data, TRUE)
			);
			$this->load->view('Mgmt/Promotion/InternetProvider/Index',$data_view);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$data_view = array(
				"tab1" => $this->load->view('User/Promotion/InternetProvider/Maxis', $data, TRUE),
				"tab2" => $this->load->view('User/Promotion/InternetProvider/Unifi', $data, TRUE),
				"tab3" => $this->load->view('User/Promotion/InternetProvider/Time', $data, TRUE)
			);
			$this->load->view('User/Promotion/InternetProvider/Index',$data_view);
		}
	}
	
	public function Eset()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['esetList'] = $this->promotion_model->get_eset_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Eset/Index',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/Eset/Index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/Eset/Index',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function BitDefender()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bitdefList'] = $this->promotion_model->get_bitdefender_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/BitDefender/Index',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/BitDefender/Index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Promotion/BitDefender/Index',$data);
		}
	}
	
    //custom validation function for dropdown input
    function combo_check($str)
    {
        if ($str == '0')
        {
            $this->form_validation->set_message('combo_check', 'The %s field is required');
            return FALSE;
        }
        else
        {
            return TRUE;
		}
	}
}?>