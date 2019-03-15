<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class registerApp extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('PHPRequests');
		$this->load->library('CIQRCode');
		
		//load the model
		$this->load->model('registerapp_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['img_url'] = "";
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/ProfileSet',$data);
			$this->load->view('Mgmt/footer');
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->load->view('Tech/header',$data);
			$this->load->view('Tech/nav');
			$this->load->view('Tech/ProfileSet',$data);
			$this->load->view('Tech/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/RegisterApp',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function RegisterApp()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$registerApp = $this->registerapp_model->get_register_service();

		if(isset($registerApp)){
			foreach ($registerApp as $file) {
				$email = $file['email'];
				$activateCode = $file['activateCode'];
			}
		}
		else{
			$email = "";
			$activateCode = "";
		}
		
		$data['activateCode'] = $activateCode;
		
		$jsonData = '{"Email":"'.$email.'","ActivateCode":"'.$activateCode.'"}';
		$data['img_url'] = "";
		$qr_image = rand().'.png';
		$params['data'] = $jsonData;
		$params['level'] = 'H';
		$params['size'] = 8;
		$params['savename'] = FCPATH."application/uploads/qrimage/".$qr_image;
		if($this->ciqrcode->generate($params))
		{
			$data['img_url'] = $qr_image;	
		}
		
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/qrcode',$data);
		$this->load->view('User/footer');
		
	}
}
?>