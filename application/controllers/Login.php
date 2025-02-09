<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');	
		$this->load->library('PHPRequests');
		
		//load the login model
		$this->load->model('login_model');
		$this->load->model('user_model');

		$this->jompay = $this->load->database('jompay',TRUE);
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function Index()
	{
		//set main session
		$condolink = substr($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 0, -1);
		$condo_data = $this->login_model->get_condo_data($condolink);

		$sessiondata = array(
						'condoseq'=>$condo_data->CONDOSEQ, 
						'condocode'=>$condo_data->CONDOCODE,
						'formalname'=>$condo_data->CondoName
					);
        $this->session->set_userdata($sessiondata);
		
        $condocode = $condo_data->CONDOCODE;
		$data['amenities'] = $this->login_model->get_Amenities();
		$data['news'] = $this->login_model->get_News();
		$data['company'] = $this->login_model->get_Company();
		$data['condo'] = $this->login_model->get_Condo($_SESSION['condoseq']);
		$data['UACLanding'] = $this->user_model->get_user_access_control_landing($_SESSION['condoseq']);
		$data['unitNo'] = $this->login_model->get_AllUnit();

		//set validations
		$this->form_validation->set_rules("username", "username", "required");
		$this->form_validation->set_rules("password", "password", "required");

		if ($this->form_validation->run() == FALSE)
		{
			//validation fails
			$this->load->view('Default/Default', $data);
		}
		else
		{
			//validation succeeds
			//get the posted values
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			//check if username & password exist
			if($username == "Admin" || $username == "admin" || $username == "ADMIN"){
				$checkDB = $this->login_model->user_loginDB($username, $password, '0');//check if exist
			}
			else{
				$checkDB = $this->login_model->user_loginDB($username, $password, $_SESSION['condoseq']);//check if exist
			}

			if ($checkDB > 0){ //CRM

				$userid = $this->login_model->get_useridDB($username, $password);//get userid
				$user = $this->login_model->get_userDB($userid);//get user details

				$sessiondata = array('userid'=>$userid,
									 'username'=>$user->LoginID,
									 'fullname'=>$user->Name,
									 'role'=>$user->Role,
									 'loginuser'=>TRUE);
                $this->session->set_userdata($sessiondata);
				//var_dump($sessiondata); die();
				$users = array(
					'LASTLOGINDATE' => date('Y-m-d H:i:s'),
				);

				$userlog = array(
						'UserID' => $userid,
						'LoginDate' => date('Y-m-d H:i:s'),
						'LoginIp' =>  $_SERVER['REMOTE_ADDR'],
						'HostName' => $_SERVER['REMOTE_HOST'],
						'LoginSource' => '1' //from web
				);
				
				if($_SESSION['role'] == 'Admin'){
					//update Users record
					$this->db->where('LOGINID', $username);
					$this->db->where('LOGINPASSWORD', $password);
					$this->db->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/Admin/Home/Index');
				}
				else if($_SESSION['role'] == 'Mgmt'){
					//update Users record
					$this->db->where('LOGINID', $username);
					$this->db->where('LOGINPASSWORD', $password);
					$this->db->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/Mgmt/Home/Index');			
				}
				else if($_SESSION['role'] == 'Tech'){
					//update Users record
					$this->db->where('LOGINID', $username);
					$this->db->where('LOGINPASSWORD', $password);
					$this->db->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/Tech/Home/Index');	
				}
				else{
					// login failed
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Wrong username or password!");</script>');
					redirect(base_url());
				}
			}
			else {

				$checkCportalStatusOld = $this->login_model->user_loginPortalOldPW($username, $password);//check with old password
				$checkCportalStatusNew = $this->login_model->user_loginPortalNewPW($username, $password);//check with old password

				if($checkCportalStatusOld > 0 || $checkCportalStatusNew == "S"){
					//Get User Access Control
					$UAC = $this->user_model->get_user_access_control($_SESSION['condoseq'], 'Resident');

					if($UAC != NULL){
						$sessiondata = array(
										 'ResidentProfile'=>$UAC->ResidentProfile,
										 'ResidentAccountSummary'=>$UAC->ResidentAccountSummary,
										 'ResidentFeedbackRequest'=>$UAC->ResidentFeedbackRequest,
										 'ResidentFacilityBooking'=>$UAC->ResidentFacilityBooking,
										 'ResidentSponsor'=>$UAC->ResidentSponsor,
										 'ResidentNewsfeed'=>$UAC->ResidentNewsfeed,
										 'ResidentJompay'=>$UAC->ResidentJompay,
										 'ResidentRevpay'=>$UAC->ResidentRevpay);
					} else{
						$sessiondata = array(
										 'ResidentProfile'=>NULL,
										 'ResidentAccountSummary'=>NULL,
										 'ResidentFeedbackRequest'=>NULL,
										 'ResidentFacilityBooking'=>NULL,
										 'ResidentSponsor'=>NULL,
										 'ResidentNewsfeed'=>NULL,
										 'ResidentJompay'=>NULL,
										 'ResidentRevpay'=>NULL);
					}
					
	                $this->session->set_userdata($sessiondata);

					$userid = $this->login_model->get_useridPortal($username, $password);//get userid
					$user = $this->login_model->get_userPortal($userid);//get user details

					$sessiondata = array('userid'=>$userid,
										 'username'=>$user->LOGINID,
										 'fullname'=>$user->OWNERNAME,
										 'propertyno'=>$user->PROPERTYNO,
										 'role'=>'User',
										 'condoseq'=>$user->CONDOSEQ,
										 'loginuser'=>TRUE,
									 	 'condocode' => $condocode);
					$this->session->set_userdata($sessiondata);
					
					$users = array(
						'LASTLOGINDATE' => date('Y-m-d H:i:s'),
					);
					
					$userlog = array(
							'UserID' => $userid,
							'PropertyNo' => $user->PROPERTYNO,
							'LoginDate' => date('Y-m-d H:i:s'),
							'LoginIp' =>  $_SERVER['REMOTE_ADDR'],
							'HostName' => $_SERVER['REMOTE_HOST'],
							'LoginSource' => '1' //from web
					);
					
					if($checkCportalStatusOld > 0){
						//update Users record
						$this->cportal->where('LOGINID', $username);
						$this->cportal->where('LOGINPASSWORD', $password);
						$this->cportal->update('Users', $users);
					} else {
						//update Users record
						$this->cportal->where('LOGINID', $username);
						$this->cportal->update('Users', $users);
					}
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					if($checkCportalStatusOld > 0){
						//echo  "test"; die();
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Please change your password.");</script>');
						redirect('index.php/Common/ProfileSet/Index');
					}
					else{
						if (isset($_SESSION['JUMP_URL'])){
							$url = $_SESSION['JUMP_URL'];
							$this->session->unset_userdata('JUMP_URL');
							redirect($url, 'refresh');
						} else {
							redirect('index.php/User/Home/Index');
						}
					}
				}
				else
				{
					//login failed
					$this->cportal->where('AttemptDate <', date('Y-m-d'));
					$this->cportal->delete('UserAttempt');
					
					$data = array(
						'LoginID'=>$username,
						'IPAddress'=>$_SERVER['REMOTE_ADDR'],
						'AttemptDate'=>date('Y-m-d H:i:s'),
					);
					$this->cportal->insert('UserAttempt', $data);
					
					$checkAttempt = $this->login_model->get_attempt_count($_SERVER['REMOTE_ADDR'], $username);
					
					if($checkAttempt >= 5){
						//locked loginid
						$this->cportal->set('USABLEID', '0');
						$this->cportal->where('LOGINID', $username);
						$this->cportal->update('Users');
						
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Your ID has been locked because tried to log in too many times. Please contact management office for an assistance.");</script>');
						redirect(base_url());
					}
					else{
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Login or Password is incorrect");</script>');
						redirect(base_url());
					}
				}
			}
		}
	}
	
	function Logout()
    {
		$this->session->sess_destroy();
		redirect(base_url());
    }
	
}?>