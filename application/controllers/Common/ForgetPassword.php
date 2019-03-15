<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgetPassword extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->helper('email');
		$this->load->library('form_validation');
		
		//load the model
		$this->load->model('forgetpassword_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function Index()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('Default/ForgetPassword',$data);
	}
	
	public function ForgetPassword()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        //$data['forgetPw'] = $this->forgetpassword_model->get_change_list();
		$company = $this->header_model->get_Company();

		//set validation rules
		$this->form_validation->set_rules('LoginID', 'LoginID', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Default/ForgetPassword',$data);
		}
		else
        {
			//validation succeed
			/*//get the posted values
			$username = $this->input->post("LoginID");
			
			//get propertyNo
			$this->cportal->from('Users');
			$this->cportal->where('LoginID', $username);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $user[0]->CONDOSEQ);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			$groupid = $user[0]->GROUPID;
			if($groupid == '2'){
				$custtype = "O";
			}
			else{
				$custtype = "T";
			}
			
			$getemail = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/GetRegEmail?condoseqno='.$user[0]->CONDOSEQ.'&propno='.$user[0]->PROPERTYNO.'&custtype='.$custtype.'&userid='.$user[0]->LOGINID;
			$xml = @simplexml_load_file($getemail);

			if ($xml === false) {
				//error
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Reset Password Error. Please contact administrator.");</script>');
				redirect(base_url());
			}
			else{
				$result = $xml->RegEmailInfo;
				if(count($result) > 0){
					$email = $result[0]->Email;
					
					$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/RegisterEmail?condoseqno='.$user[0]->CONDOSEQ.'&forgot='.$user[0]->LOGINID.'&Email='.$email;
					$xml = @simplexml_load_file($url);
					
					if ($xml === false) {
						//error
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Reset Password Error. Please contact administrator.");</script>');
						redirect(base_url());
					}
					else{
						$result = $xml->EmailDone;
						$reason = $result[0]->RESPONSEREASON;
						
						//display message
						$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$reason.'");</script>');
						redirect(base_url());
					}
				}
			}*/
			
			//generate random characters
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < 8; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}

			//get the posted values
			$username = $this->input->post("LoginID");
			$email = $this->input->post("Email");

			//check if username & email exist
			$this->db->from('Users');
			$this->db->where('LoginID', $username);
			$this->db->where('Email', $email);
			$query = $this->db->get();
			$userDB = $query->result();

			if(count($userDB) > 0){
				$userid = $this->forgetpassword_model->get_useridDB($username);
				$user = $this->forgetpassword_model->get_userDB($userid);

				$log = array(
					'LoginID' => $this->input->post('LoginID'),
					'OldPassword' => (string)$user->LoginPassword,
					'NewPassword' => $randomString,
					'CreatedDate' => date('Y-m-d H:i:s'),
				);

				//send email
				//config
				$this->db->from('WebCtrl');
				$this->db->where('CONDOSEQ', $user->CONDOSEQ);
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

				$message = 'Your temporary password is: '.$randomString;
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from($webctrl[0]->EMAILSENDER);
				$this->email->to($user->Email);
				$this->email->subject('Password Recovery '.$company[0]->CompanyName);
				$this->email->message($message);
				if($this->email->send())
				{	
					//insert record
					$this->db->insert('ForgetPasswordLog', $log);

					//update record
					$this->db->set('LOGINPASSWORD', $randomString);
					$this->db->where('LOGINID', $this->input->post('LoginID'));
					$this->db->update('Users');

					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("New password sent. Kindly check your email for the new password.");</script>');
					redirect(base_url());
				}
				else
				{
					//show_error($this->email->print_debugger());
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
					redirect('index.php/Common/ForgetPassword/Index');
				}
			}
			else{
				//check if username & email exist
				$this->cportal->from('Users');
				$this->cportal->where('LoginID', $username);
				$this->cportal->where('Email', $email);
				$query = $this->cportal->get();
				$userCportal = $query->result();

				if(count($userCportal) > 0){
					$userid = $this->forgetpassword_model->get_useridPortal($username);
					$user = $this->forgetpassword_model->get_userPortal($userid);

					$log = array(
						'LoginID' => $this->input->post('LoginID'),
						'OldPassword' => (string)$user->LOGINPASSWORD,
						'NewPassword' => $randomString,
						'CreatedDate' => date('Y-m-d H:i:s'),
					);

					//send email
					//config
					$this->db->from('WebCtrl');
					$this->db->where('CONDOSEQ', $user->CONDOSEQ);
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

					$message = 'Your temporary password is: '.$randomString;
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from($webctrl[0]->EMAILSENDER);
					$this->email->to($user->EMAIL);
					$this->email->subject('Password Recovery '.$company[0]->CompanyName);
					$this->email->message($message);
					if($this->email->send())
					{	
						//insert record
						$this->cportal->insert('ForgetPasswordLog', $log);

						//update record
						$this->cportal->set('LOGINPASSWORD', $randomString);
						$this->cportal->where('LOGINID', $this->input->post('LoginID'));
						$this->cportal->update('Users');

						//display message
						$this->session->set_flashdata('msg', '<script language=javascript>alert("New password sent. Kindly check your email for the new password.");</script>');
						redirect(base_url());
					}
					else
					{
						//show_error($this->email->print_debugger());
						//display message
						$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
						redirect('index.php/Common/ForgetPassword/Index');
					}
				}
				else{
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Incorrect Username/Email. Please contact administrator.");</script>');
					redirect(base_url());
				}
			}
		}
	}
}
?>