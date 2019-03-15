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

	public function Index()
	{
		// $condoseq = "12255";
		//call the model function to get the data
		$condolink = substr($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 0, -1);
		$condoseq = $this->login_model->get_Condoseq_from_url($condolink);
		$condocode = $this->login_model->get_Condocode_from_url($condolink);

		$sessiondata = array('condoseq'=>$condoseq, 'condocode'=>$condocode);
        $this->session->set_userdata($sessiondata);

		$data['amenities'] = $this->login_model->get_Amenities();
		$data['news'] = $this->login_model->get_News();
		$data['company'] = $this->login_model->get_Company();
		$data['condo'] = $this->login_model->get_Condo($condoseq);
		$data['UACLanding'] = $this->user_model->get_user_access_control_landing($condoseq);
		
		//set validations
		$this->form_validation->set_rules("username", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");

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
					//update Users record
					$this->jompay->where('LOGINID', $username);
					$this->jompay->where('LOGINPASSWORD', $password);
					$this->jompay->update('Users', $users);
					
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
			else{ //Cportal
				$checkCportal = $this->login_model->user_loginPortal($username, $password);//check if exist
				
				if($checkCportal > 0){
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
						$this->cportal->from('Users');
						$this->cportal->where('LoginID', $username);
						$query = $this->cportal->get();
						$user = $query->result();

						//config
						$this->db->from('WebCtrl');
						$this->db->where('CONDOSEQ', $condoseq);
						$query = $this->db->get();	
						$webctrl = $query->result();

						$config = Array(
							'protocol' => 'smtp',
							'smtp_host' => trim($webctrl[0]->EMAILSERVER),
							'smtp_port' => trim($webctrl[0]->SERVERPORT),
							'smtp_user' => trim($webctrl[0]->AUTHUSER),
							'smtp_pass' => trim($webctrl[0]->AUTHPASSWORD),
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE
						);

						$message = "Dear ".$user[0]->PROPERTYNO." - ".$user[0]->OWNERNAME.",".
								   "<br><br><br><br>Your login ID have been locked due to 5 times failed login attempts, ".
								   "to release your login ID kindly inform your management office staff.".
								   "<br><br><br><br>Advelsoft C-Portal Support Team";
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from($webctrl[0]->EMAILSENDER);
						$this->email->to(trim($user[0]->EMAIL));
						$this->email->subject('Suspended Login ID');
						$this->email->message($message);
						$this->email->send();
					
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Your login ID has been locked because tried to log in too many times. Please contact management office for an assistance.");</script>');
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