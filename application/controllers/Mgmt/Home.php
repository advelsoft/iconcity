<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->jompay = $this->load->database('jompay',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');	
		
		//load the model
		$this->load->model('index_model'); 
		$this->load->model('forms_model');
		$this->load->model('user_model');
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url());
        }
	}

	public function index()
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
		$data['tasktodo'] = $this->index_model->get_tasktodo_details();
		$data['company'] = $this->index_model->get_Company();  
		$data['version'] = $this->index_model->get_Version(); 
		$data['formList'] = $this->forms_model->get_forms_list();
		$data['subformList'] = $this->forms_model->get_subform_list();
		$data['subsubformList'] = $this->forms_model->get_subsubform_list();
		$data['archiveList'] = $this->forms_model->get_archive_list();
		$data['subarchiveList'] = $this->forms_model->get_subarchive_list();
		$data['subsubarchiveList'] = $this->forms_model->get_subsubarchive_list();
		$data['infoList'] = $this->forms_model->get_info_list();
		$data['subinfoList'] = $this->forms_model->get_subinfo_list();
		$data['subsubinfoList'] = $this->forms_model->get_subsubinfo_list();
		//Get User Access Control
		$UAC = $this->user_model->get_user_access_control($_SESSION['condoseq'], 'Mgmt');

		if($UAC != NULL){
			$sessiondata = array(
							 'MgmtProfile'=>$UAC->MgmtProfile,
							 'MgmtFeedbackRequest'=>$UAC->MgmtFeedbackRequest,
							 'MgmtFacilityBooking'=>$UAC->MgmtFacilityBooking,
							 'MgmtNewsfeed'=>$UAC->MgmtNewsfeed,
							 'MgmtSponsor'=>$UAC->MgmtSponsor,
							 'MgmtSetupForm'=>$UAC->MgmtSetupForm,
							 'MgmtSetupCondoIntro'=>$UAC->MgmtSetupCondoIntro,
							 'MgmtSetupContact'=>$UAC->MgmtSetupContact);
		} else{
			$sessiondata = array(
							 'MgmtProfile'=>NULL,
							 'MgmtFeedbackRequest'=>NULL,
							 'MgmtFacilityBooking'=>NULL,
							 'MgmtNewsfeed'=>NULL,
							 'MgmtSponsor'=>NULL,
							 'MgmtSetupForm'=>NULL,
							 'MgmtSetupCondoIntro'=>NULL,
							 'MgmtSetupContact'=>NULL);
		}
		$this->session->set_userdata($sessiondata);
		
		//load the view
		$data_view = array(
			"tab1" => $this->load->view('Mgmt/IndexTaskToDo', $data, TRUE),
			"tab2" => $this->load->view('Mgmt/IndexBooking', $data, TRUE),
			"tab3" => $this->load->view('Mgmt/IndexFeedback', $data, TRUE),
			"tab4" => $this->load->view('Mgmt/IndexNews', $data, TRUE),
			"tab5" => $this->load->view('Mgmt/IndexPromotion', $data, TRUE)
		);
		
		$this->load->view('Mgmt/Index',$data_view);
	}
}