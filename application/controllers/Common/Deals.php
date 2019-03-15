<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class deals extends CI_Controller {
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
	
	public function Create($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['display'] = $this->promotion_model->get_Display();
		$data['promoCat'] = $this->promotion_model->get_PromoCat();
		
		//set validation rules
        $this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('Introduction', 'Introduction', 'trim');
        $this->form_validation->set_rules('PromoPrice', 'PromoPrice', 'trim');
        $this->form_validation->set_rules('PromoDateFrom', 'PromoDateFrom', 'trim');
        $this->form_validation->set_rules('PromoDateTo', 'PromoDateTo', 'trim');
        $this->form_validation->set_rules('PromoUrl', 'PromoUrl', 'trim');
        $this->form_validation->set_rules('PromoCode', 'PromoCode', 'trim');
        $this->form_validation->set_rules('Display', 'Display', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/Deals/Create', $data);
        }
        else
        {
			//validation succeed
			//rearrange date
			$temp1 = explode('/', $this->input->post('PromoDateFrom'));
			$dateFrom = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('PromoDateTo'));
			$dateTo = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];
			
			$this->db->from('PromoCategory');
			$this->db->where('Description', 'Deals');
			$query = $this->db->get();
			$result = $query->result();
			
            $data = array(
				'PromoCat' => $result[0]->PromoCatId,
                'Title' => $this->input->post('Title'),
                'Summary' => $this->input->post('Summary'),
                'Description' => $this->input->post('Description'),
                'Introduction' => $this->input->post('Introduction'),
                'PromoPrice' => $this->input->post('PromoPrice'),
                'PromoDateFrom' => $dateFrom,
                'PromoDateTo' => $dateTo,
                'PromoUrl' => $this->input->post('PromoUrl'),
                'PromoCode' => $this->input->post('PromoCode'),
                'Display' => $this->input->post('Display'),
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => $CondoSeq,
            );
			
			//echo "<pre>";
			//print_r($data);
			
            //insert record
            $this->db->insert('Promotion', $data);

            //display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/Promotion/Deals/'.$CondoSeq);
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
			$this->load->view('Admin/Setup/Deals/Detail',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/Deals/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/Deals/Detail',$data);
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

        //set validation rules
		$this->form_validation->set_rules('Title', 'Title', 'trim|required');
		$this->form_validation->set_rules('Introduction', 'Introduction', 'trim');
        $this->form_validation->set_rules('PromoPrice', 'PromoPrice', 'trim');
        $this->form_validation->set_rules('PromoDateFrom', 'PromoDateFrom', 'trim');
        $this->form_validation->set_rules('PromoDateTo', 'PromoDateTo', 'trim');
        $this->form_validation->set_rules('PromoUrl', 'PromoUrl', 'trim');
        $this->form_validation->set_rules('PromoCode', 'PromoCode', 'trim');
        $this->form_validation->set_rules('Display', 'Display', 'trim');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/Deals/Update', $data);
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
				'Introduction' => $this->input->post('Introduction'),
                'PromoPrice' => $this->input->post('PromoPrice'),
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
			redirect('index.php/Common/Deals/Update/'.$PromoID);
        }
	}

	public function Delete($PromoID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoRecord'] = $this->promotion_model->get_promo_record($PromoID);
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Deals/Delete',$data);
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
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Promotion/upload_file');
		$this->load->view('Admin/footer');
	}
}?>