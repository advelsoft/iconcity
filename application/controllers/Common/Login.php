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
		
		//load the login model
		$this->load->model('login_model');
		$this->load->model('user_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function Deploy()
    {
		$commands = array(
			'echo $PWD',
			'whoami',
			'git reset --hard HEAD',
			'git pull',
			'git status',
			'git submodule sync',
			'git submodule update',
			'git submodule status',
		);
		// Run the commands for output
		$output = '';
		foreach($commands AS $command){
			// Run it
			$tmp = shell_exec($command);
			// Output
			$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
			$output .= htmlentities(trim($tmp)) . "\n";
		}
		// Make it pretty for manual user access (and why not?)
		echo $output;
    }

	public function Login()
	{
		//call the model function to get the data
		$data['amenities'] = $this->login_model->get_Amenities();
		$data['news'] = $this->login_model->get_News();
		$data['company'] = $this->login_model->get_Company();
		
		//set validations
		$this->form_validation->set_rules("Username", "Username", "ltrim|required");
		$this->form_validation->set_rules("Password", "Password", "ltrim|required");

		if ($this->form_validation->run() == FALSE)
		{
			//validation fails
			$this->load->view('Default/Login', $data);
		}
		else
		{
			//validation succeeds
			//get the posted values
			$username = $this->input->post("Username");
			$password = $this->input->post("Password");
			$condoseq = GLOBAL_CONDOSEQ;

			//check if username & password exist
			if($username == "Admin" || $username == "admin" || $username == "ADMIN"){
				$checkDB = $this->login_model->user_loginDB($username, $password, '0');//check if exist
			}
			else{
				$checkDB = $this->login_model->user_loginDB($username, $password, $condoseq);//check if exist
			}

			if ($checkDB > 0){ //CRM
				$userid = $this->login_model->get_useridDB($username, $password);//get userid
				$user = $this->login_model->get_userDB($userid);//get user details

				$sessiondata = array('userid'=>$userid,
									 'username'=>$user->LoginID,
									 'fullname'=>$user->Name,
									 'role'=>$user->Role,
									 'condoseq'=>$user->CondoSeq,
									 'loginuser'=>TRUE);
                $this->session->set_userdata($sessiondata);
				
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
					$this->jompay->where('LOGINID', $username);
					$this->jompay->where('LOGINPASSWORD', $password);
					$this->jompay->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/Admin/Home/Index');
				}
				else if($_SESSION['role'] == 'Mgmt'){
					//Get User Access Control
					$UAC = $this->user_model->get_user_access_control($condoseq, 'Mgmt');

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
	                
					//update Users record
					$this->jompay->where('LOGINID', $username);
					$this->jompay->where('LOGINPASSWORD', $password);
					$this->jompay->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/Mgmt/Home/Index');			
				}
				// else if($_SESSION['role'] == 'Tech'){
				// 	//update Users record
				// 	$this->db->where('LOGINID', $username);
				// 	$this->db->where('LOGINPASSWORD', $password);
				// 	$this->db->update('Users', $users);
					
				// 	//insert UsersLog record
				// 	$this->cportal->insert('UsersLog', $userlog);
					
				// 	$previous_page = $this->session->userdata('previous_page');
				// 	if(isset($previous_page) && $previous_page != ''){
				// 		$temp = explode('/', $previous_page);
				// 		$feedbackid = $temp[3];
						
				// 		$this->db->from('FeedbackResponse');
				// 		$this->db->where('ComplaintIDParent', $feedbackid);
				// 		$this->db->where('ForwardTo IS NOT NULL', NULL);
				// 		$query = $this->db->get();
				// 		$result = $query->result();
						
				// 		$this->db->from('Feedback');
				// 		$this->db->where('FeedbackID', $feedbackid);
				// 		$query = $this->db->get();
				// 		$status = $query->result();
						
				// 		$tech = $result[0]->ForwardTo;

				// 		if(trim($tech) == $user->Name){
				// 			if($status[0]->Status != 'Closed'){//check status of complaint
				// 				redirect('index.php/'.$previous_page);
				// 			}
				// 			else{
				// 				redirect('index.php/Tech/Home/Index');	
				// 			}
				// 		}
				// 		else{
				// 			redirect(base_url().'index.php/Common/Login/Login');
				// 		}
				// 	}
				// 	else{
				// 		redirect('index.php/Tech/Home/Index');	
				// 	}
				// }
				else{
					// login failed
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Wrong username or password!");</script>');
					redirect(base_url());
				}
			}
			else{ //Cportal
				$checkCportal = $this->login_model->user_loginPortal($username, $password);//check if exist
				
				if($checkCportal > 0){
					//Get User Access Control
					$UAC = $this->user_model->get_user_access_control($condoseq, 'Resident');

					if($UAC != NULL){
						$sessiondata = array(
										 'ResidentProfile'=>$UAC->ResidentProfile,
										 'ResidentAccountSummary'=>$UAC->ResidentAccountSummary,
										 'ResidentFeedbackRequest'=>$UAC->ResidentFeedbackRequest,
										 'ResidentFacilityBooking'=>$UAC->ResidentFacilityBooking,
										 'ResidentSponsor'=>$UAC->ResidentSponsor,
										 'ResidentNewsfeed'=>$UAC->ResidentNewsfeed);
					} else{
						$sessiondata = array(
										 'ResidentProfile'=>NULL,
										 'ResidentAccountSummary'=>NULL,
										 'ResidentFeedbackRequest'=>NULL,
										 'ResidentFacilityBooking'=>NULL,
										 'ResidentSponsor'=>NULL,
										 'ResidentNewsfeed'=>NULL);
					}
					
	                $this->session->set_userdata($sessiondata);

					$checkFirstLog = $this->login_model->check_firstlogin($username);//check first time login
					$userid = $this->login_model->get_useridPortal($username, $password);//get userid
					$user = $this->login_model->get_userPortal($userid);//get user details

					$sessiondata = array('userid'=>$userid,
										 'username'=>$user->LOGINID,
										 'fullname'=>$user->OWNERNAME,
										 'propertyno'=>$user->PROPERTYNO,
										 'role'=>'User',
										 'condoseq'=>$user->CONDOSEQ,
										 'loginuser'=>TRUE);
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
					
					//update Users record
					$this->cportal->where('LOGINID', $username);
					$this->cportal->where('LOGINPASSWORD', $password);
					$this->cportal->update('Users', $users);
					
					//insert UsersLog record
					$this->cportal->insert('UsersLog', $userlog);
					
					redirect('index.php/User/Home/Index');
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