<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class outstanding extends CI_Controller {
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
		$this->load->library('pagination');
		
		//load the model
		$this->load->model('outstanding_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url());
        }
	}

	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $osList = $this->outstanding_model->get_os_list();
		$data['totalGross'] = $this->outstanding_model->get_totalGross();
		$data['totalOpen'] = $this->outstanding_model->get_totalOpen();
        $data['osList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osList) > 0) {
            $paginatedFiles = array_slice($osList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osList'][] = array('custType'=>$file['custType'],
										  'docNo'=>$file['docNo'],
										  'trxnDate'=>$file['trxnDate'],
										  'desc'=>$file['desc'],
										  'dueDate'=>$file['dueDate'],
										  'amt'=>$file['amt'],
										  'floatAmt'=>$file['floatAmt'],
										  'ref1'=>$file['ref1']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/Index";
        $config['total_rows'] = count($osList);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Outstanding/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('tmpDocNo', 'tmpDocNo', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Outstanding/Index');
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/Index');
			}
        }
        else
        {
			//validation succeed
			//get BatchNo
			$sql1 = "SELECT MAX(CAST(BatchRefNo as INT)) AS maxBatchNo FROM OsToPay";
			$query1 = $this->jompay->query($sql1);
			$result1 = $query1->result();
			$batchNo = $result1[0]->maxBatchNo;
			
			if ($batchNo < 999999) {
				$batchNo++;
			}
			else { //more than 999999, reset to 1
				$batchNo = 1;
			}
			$bthNo = str_pad($batchNo, 6, '0', STR_PAD_LEFT);
			
			//separate DocNo
			$temp = explode('|', $this->input->post('tmpDocNo'));
			for ($i = 0; $i < count($temp)-1; $i++){
				$docNo = $temp[$i];
				
				if($this->input->post('tmpCustType') == "O") {
					$CustType = "1";
				}
				else if($this->input->post('tmpCustType') == "T"){
					$CustType = "2";
				}
				
				//calculate RefNo
				$sql2 = "SELECT CondoSeq, UnitNoSeq FROM OsToPay WHERE PropertyNo = '".$_SESSION['propertyno']."' AND DocNo = '".$docNo."'";
				$query2 = $this->jompay->query($sql2);
				$result2 = $query2->result();

				if(count($result2) > 0){
					$dbCdSq = $result2[0]->CondoSeq;
					$dbUnSq = $result2[0]->UnitNoSeq;	      	
				}
				else {
					$dbCdSq = "";
					$dbUnSq = "";
				}
				
				$dbCdSqLen = strlen((string)$dbCdSq);
				if($dbCdSqLen < 5){
					//Add leading zero to make it 5 digits
					$CondoSeq = str_pad($dbCdSq, 5, '0', STR_PAD_LEFT);
				}
				else{
					$CondoSeq = $dbCdSq;
				}
				
				$dbUnSqLen = strlen((string)$dbUnSq);
				if($dbUnSqLen < 4){
					//Add leading zero to make it 4 digits
					$UnitSeq = str_pad($dbUnSq, 4, '0', STR_PAD_LEFT);
				}
				else{
					$UnitSeq = $dbUnSq;
				}
				
				//calculate condoseq(5 digits)
				$CndSq = str_split($CondoSeq);
				$tmpCondoSeq = ($CndSq[0]*1)+($CndSq[1]*2)+($CndSq[2]*3)+($CndSq[3]*4)+($CndSq[4]*5);
				
				//calculate unitseq(4 digits)
				$UntSq = str_split($UnitSeq);
				$tmpUnitSeq = ($UntSq[0]*6)+($UntSq[1]*7)+($UntSq[2]*8)+($UntSq[3]*9);
				
				//calculate custType(1 digit)
				$tmpCustType = $CustType*10;
				
				//calculate batchNo(6 digits)
				$BthNo = str_split($bthNo);
				$tmpBatchNo = ($BthNo[0]*11)+($BthNo[1]*12)+($BthNo[2]*13)+($BthNo[3]*14)+($BthNo[4]*15)+($BthNo[5]*16);
				
				//sum of CondoSeq + UnitSeq + CustType + BatchNo
				$tmpRef1 = ($tmpCondoSeq + $tmpUnitSeq + $tmpCustType + $tmpBatchNo)*9;
				
				//take the last digit of sum above
				$lastDigit = $tmpRef1 % (10);
				
				//generate ref1
				$ref1 = $CondoSeq.$UnitSeq.$CustType.$bthNo.$lastDigit;
	
				$data = array(
					'DOCNO' => $docNo,
					'REF1' => $ref1,
					'CUMMULATEDSELECTED' => $this->input->post('tmpTtlSelect'),
					'BATCHREFNO' => $batchNo,
				);
				//echo "<pre>";
				//print_r($data);
				
				//update record
				$this->jompay->where('DocNo', $docNo);
				$this->jompay->where('CondoSeq', $_SESSION['condoseq']);
				$this->jompay->update('OsToPay', $data);
			}
            //redirect to Ref1 page
            redirect('index.php/Common/Outstanding/JomPayRef/'.$ref1);
        }
    }
	
	public function ResetRef1()
	{
		$temp = explode('|', $this->input->post('tmpRef1'));
		for ($i = 0; $i < count($temp)-1; $i++){
			$ref1 = $temp[$i];
			
			$data = array(
				'REF1' => $ref1,
			);
			//echo "<pre>";
			//print_r($data);

			//update record
			$this->jompay->set('REF1', nULL);
			$this->jompay->where('REF1', $ref1);
			$this->jompay->where('CondoSeq', $_SESSION['condoseq']);
			$this->jompay->update('OsToPay');
		}
		//redirect to Outstanding page
        redirect('index.php/Common/Outstanding/Index');
	}
	
	public function Lists($page=1)
	{
		$data['company'] = $this->header_model->get_Company();
		$osList = $this->outstanding_model->get_os_list();
		$data['totalGross'] = $this->outstanding_model->get_totalGross();
		$data['totalOpen'] = $this->outstanding_model->get_totalOpen();
        $data['osList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osList) > 0) {
            $paginatedFiles = array_slice($osList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osList'][] = array('docNo'=>$file['docNo'],
										  'trxnDate'=>$file['trxnDate'],
										  'desc'=>$file['desc'],
										  'dueDate'=>$file['dueDate'],
										  'amt'=>$file['amt']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/Lists";
        $config['total_rows'] = count($osList);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Outstanding/List',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/List',$data);
		}
	}
	
	public function JomPayRef($ref1)
	{
		//call the model
		$data['Ref1'] = $ref1;
		$data['company'] = $this->header_model->get_Company();
		$data['jomPayRef'] = $this->outstanding_model->get_jompay_ref($ref1);
		$data['bankLog'] = $this->outstanding_model->get_BankLog();
		
		//load the view
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/footer');
		$this->load->view('User/Outstanding/JomPayRef', $data);
	}
	
	public function JomPayBank($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['jomBank'] = $this->outstanding_model->get_JomBank();
        $jomBank = $this->outstanding_model->get_jompay_bank();
        $data['jomBankList'] = array();
        $offset = ($page - 1) * 20;
        $paginatedFiles = array();

        if (count($jomBank) > 0) {
            $paginatedFiles = array_slice($jomBank, $offset, 20, true);
        }
		
		if ($paginatedFiles) {
			foreach ($paginatedFiles as $file) {
                $data['jomBankList'][] = array('bankName'=>$file['bankName'],
											   'bankCode'=>$file['bankCode'],
											   'bankURL'=>$file['bankURL'],
											   'bankImg'=>$file['bankImg']);
				}
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/JomPayBank";
        $config['total_rows'] = count($jomBank);
        $config['per_page'] = 20;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

		//set validation rules
        $this->form_validation->set_rules('JomPayBank', 'JomPayBank', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Outstanding/JomPayBank',$data);	
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/JomPayBank', $data);
			}
        }
        else
        {
			//validation succeed
			//get user loginid
			$this->cportal->where('UserID',$_SESSION['userid']);
			$this->cportal->from('Users');
			$query = $this->cportal->get();
			$user = $query->result();

			//get bank url
			$this->jompay->where('SHORTBANKNAME',$this->input->post('tmpBankName'));
			$this->jompay->from('JomBank');
			$query = $this->jompay->get();
			$bank = $query->result();		
			
			//check if exist or not
			$this->cportal->where('LoginID',$user[0]->LOGINID);
			$this->cportal->from('BankLog');
			$query = $this->cportal->get();
			$result = $query->result();
			
			if(count($result) == 0){
				 $data = array(
					'LoginID' => $user[0]->LOGINID,
					'BankName' => $this->input->post('tmpBankName'),
				);

				//insert record
				$this->cportal->insert('BankLog', $data);
			}
            else{
				//update record
				$this->cportal->set('BankName', $this->input->post('tmpBankName'));
				$this->cportal->where('LoginID', $user[0]->LOGINID);
				$this->cportal->update('BankLog');
			}
			
            //display message
            redirect($bank[0]->BANKURL);
        }
	}
	
	public function Statement()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['statement'] = $this->outstanding_model->get_stmt_detail();
        $data['userType'] = $this->outstanding_model->get_UserType();
		
		//set validation rules
        $this->form_validation->set_rules('CustType', 'CustType', 'required');
        $this->form_validation->set_rules('DateStmt', 'DateStmt', 'required');
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Outstanding/Statement',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Statement',$data);
		}
	}
	
	public function History($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $osHistory = $this->outstanding_model->get_os_history();
        $data['osHistory'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osHistory) > 0) {
            $paginatedFiles = array_slice($osHistory, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osHistory'][] = array('desc'=>$file['desc'],
											 'amt'=>$file['amt'],
											 'datepaid'=>$file['datepaid'],
											 'receiptno'=>$file['receiptno'],
											 'propertyno'=>$file['propertyno'],
											 'printreceipt'=>$file['printreceipt']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/History";
        $config['total_rows'] = count($osHistory);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Outstanding/History',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/History',$data);
		}
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