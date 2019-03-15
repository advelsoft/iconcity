<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class registerapp_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function get_register_service()
	{
        //get propertyNo
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
        $user = $query->result();
		
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UserLoginId' => trim($user[0]->LOGINID), 'PropertyNo' => trim($user[0]->PROPERTYNO), 'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NewApps';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		//echo '<pre>';
		//print_r($body);
		foreach($body as $key => $value)
		{
			if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				$array[] = array('activateCode'=>$value['ActivateCode'],
								 'email'=>$value['Email']);
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Registration Error: "'.$FailedReason.'". Please contact administrator.");</script>');
			redirect('index.php/Common/RegisterApp/Index');
		}
		else{
			return $array;
		}
	}
}?>