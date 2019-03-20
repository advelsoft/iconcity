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
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function Index()
	{
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
				//get server, port
				$this->jompay->from('Condo');
				$this->jompay->where('CONDOSEQ',$condoseq);
				$query = $this->jompay->get();
				$condo = $query->result();
				
				$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $condoseq, 'LoginId' => $username, 'LoginPassword' => $password);
				
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/apiAuthenUser';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);
				
				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
						$UserTokenNo = $value['SuperTokenNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					}
				}

				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect(base_url());
				}
				else{
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
					//redirect('index.php/User/Home/Index');
					
					if(($user->LOGINPASSWORD) != NULL){
						//echo  "test"; die();
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Please change your password.");</script>');
						redirect('index.php/Common/ProfileSet/Index');
					}
					else{
						redirect('index.php/User/Home/Index');
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