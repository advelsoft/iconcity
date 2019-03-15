<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		//load form helper and validation library
		$this->load->helper('form');
		$this->load->helper('email');
		$this->load->library('form_validation');
		
		//load the model
		$this->load->model('menu_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function Index()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		//$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Menu',$data);
		$this->load->view('Mgmt/footer');
	}
}
?>