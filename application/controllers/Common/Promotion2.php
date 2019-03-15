<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion extends CI_Controller {
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
		$this->load->model('menu_model');

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
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/Menu',$data);
		$this->load->view('Admin/Setup/Promotion/List',$data);
		$this->load->view('Admin/footer');
	}

	public function Index()
	{
		//call the model
		$data['condoSeq'] = GLOBAL_CONDOSEQ;
		$data['company'] = $this->header_model->get_Company();
		$data['promoList'] = $this->promotion_model->get_promo_list(GLOBAL_CONDOSEQ);
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/Menu',$data);
			$this->load->view('Admin/Setup/Promotion/Index',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/Menu',$data);
			$this->load->view('Mgmt/Promotion/Index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/Menu',$data);
			$this->load->view('User/Promotion/Index',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Create($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['display'] = $this->promotion_model->get_Display();
		$data['promoCat'] = $this->promotion_model->get_PromoCat();
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//set validation rules
        $this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('PromoDateFrom', 'PromoDateFrom', 'trim');
        $this->form_validation->set_rules('PromoDateTo', 'PromoDateTo', 'trim');
        $this->form_validation->set_rules('PromoUrl', 'PromoUrl', 'trim');
        $this->form_validation->set_rules('PromoCode', 'PromoCode', 'trim');
        $this->form_validation->set_rules('Display', 'Display', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/Menu',$data);
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/Promotion/Create', $data);
        }
        else
        {
			//validation succeed
			//rearrange date
			$temp1 = explode('/', $this->input->post('PromoDateFrom'));
			$dateFrom = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('PromoDateTo'));
			$dateTo = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];
			
            $data = array(
				'PromoCat' => $this->input->post('Category'),
                'Title' => $this->input->post('Title'),
                'Summary' => $this->input->post('Summary'),
                'Description' => $this->input->post('Description'),
                'PromoDateFrom' => $dateFrom,
                'PromoDateTo' => $dateTo,
                'PromoUrl' => $this->input->post('PromoUrl'),
                'PromoCode' => $this->input->post('PromoCode'),
                'Display' => $this->input->post('Display'),
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => $CondoSeq,
            );
			
            //insert record
            $this->db->insert('Promotion', $data);

            //display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/Promotion/Index/'.$CondoSeq);
        }
    }
	
	public function Detail($PromoID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoRecord'] = $this->promotion_model->get_promo_record($PromoID);
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/Menu',$data);
			$this->load->view('Admin/Setup/Promotion/Detail',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/Menu',$data);
			$this->load->view('Mgmt/Promotion/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/Menu',$data);
			$this->load->view('User/Promotion/Detail',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Update($PromoID)
	{
		//call the model
		$data['promoID'] = $PromoID;
		$data['company'] = $this->header_model->get_Company();
		$data['promoCat'] = $this->promotion_model->get_PromoCat();
		$data['display'] = $this->promotion_model->get_Display();
        $data['promoRecord'] = $this->promotion_model->get_promo_record($PromoID);
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();

        //set validation rules
		$this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('PromoDateFrom', 'PromoDateFrom', 'trim');
        $this->form_validation->set_rules('PromoDateTo', 'PromoDateTo', 'trim');
        $this->form_validation->set_rules('PromoUrl', 'PromoUrl', 'trim');
        $this->form_validation->set_rules('PromoCode', 'PromoCode', 'trim');
        $this->form_validation->set_rules('Display', 'Display', 'trim');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/Menu',$data);
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/Promotion/Update', $data);
        }
        else
        {
			$temp1 = explode('/', $this->input->post('PromoDateFrom'));
			$dateFrom = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('PromoDateTo'));
			$dateTo = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];

            $data = array(
                'Title' => $this->input->post('Title'),
                'Summary' => $this->input->post('Summary'),
                'Description' => $this->input->post('Description'),
                'PromoDateFrom' => $dateFrom,
                'PromoDateTo' => $dateTo,
				'PromoUrl' => $this->input->post('PromoUrl'),
                'PromoCode' => $this->input->post('PromoCode'),
				'Display' => $this->input->post('Display'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//update record
			$this->db->where('PromoID', $PromoID);
			$this->db->update('Promotion', $data);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/Promotion/Update/'.$PromoID);
        }
	}

	public function Delete($PromoID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoRecord'] = $this->promotion_model->get_promo_record($PromoID);
		$data['menuList'] = $this->menu_model->get_menu_list();
		$data['submenuList'] = $this->menu_model->get_submenu_list();
		$data['subsubmenuList'] = $this->menu_model->get_subsubmenu_list();
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/Menu',$data);
		$this->load->view('Admin/Setup/Promotion/Delete',$data);
		$this->load->view('Admin/footer');
	}
	
    function delete_record($PromoID)
    {
        //delete record
        $this->db->where('PromoID', $PromoID);
        $this->db->delete('Promotion');
        redirect('index.php/Common/Promotion/Lists');
    }
    
	public function upload_image()
	{
		//load the view
		$this->load->view('Admin/header');
		$this->load->view('Admin/Menu');
		$this->load->view('Admin/Setup/Promotion/upload_file');
		$this->load->view('Admin/footer');
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