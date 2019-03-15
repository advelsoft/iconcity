<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		//load the model
		$this->load->model('index_model');
		$this->load->model('forms_model');
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url());
        }
	}

	public function Index()
	{
		//call the model
		$data['promo'] = $this->index_model->get_promotion();
		$data['booking'] = $this->index_model->get_booking();
		$data['feedback'] = $this->index_model->get_feedback();
		$data['news'] = $this->index_model->get_news();
		$data['promoList'] = $this->index_model->get_promo_details();
		$data['bookingList'] = $this->index_model->get_booking_details();
		$data['feedbackList'] = $this->index_model->get_feedback_details();
		$data['newsList'] = $this->index_model->get_news_details();
		$data['oshistory'] = $this->index_model->get_oshistory_details();
		$data['whatsnew'] = $this->index_model->get_whatsnew_details();
		$data['company'] = $this->index_model->get_Company();  
		$data['formList'] = $this->forms_model->get_forms_list();
		$data['subformList'] = $this->forms_model->get_subform_list();
		$data['subsubformList'] = $this->forms_model->get_subsubform_list();
		$data['archiveList'] = $this->forms_model->get_archive_list();
		$data['subarchiveList'] = $this->forms_model->get_subarchive_list();
		$data['subsubarchiveList'] = $this->forms_model->get_subsubarchive_list();
		$data['infoList'] = $this->forms_model->get_info_list();
		$data['subinfoList'] = $this->forms_model->get_subinfo_list();
		$data['subsubinfoList'] = $this->forms_model->get_subsubinfo_list();
		
		//load the view
		$data_view = array(
			"tab1" => $this->load->view('User/IndexWhatsNew', $data, TRUE),
			"tab2" => $this->load->view('User/IndexOutstanding', $data, TRUE),
			"tab3" => $this->load->view('User/IndexBooking', $data, TRUE),
			"tab4" => $this->load->view('User/IndexFeedback', $data, TRUE),
			"tab5" => $this->load->view('User/IndexNews', $data, TRUE),
			"tab6" => $this->load->view('User/IndexPromotion', $data, TRUE)
		);
		
		$this->load->view('User/Index',$data_view);
	}
}