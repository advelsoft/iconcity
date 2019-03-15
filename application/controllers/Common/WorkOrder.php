<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class workOrder extends CI_Controller {
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
		$this->load->library('pagination');
		$this->load->library('Curl');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('workorder_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
			$this->session->set_userdata('previous_page', uri_string());
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}

	public function Open($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $workOrder = $this->workorder_model->get_openWO_list();
        $data['workOrder'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($workOrder) > 0) {
            $paginatedFiles = array_slice($workOrder, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['workOrder'][] = array('propertyNo'=>$file['propertyNo'],
												 'feedbackID'=>$file['feedbackID'],
												 'priority'=>$file['priority'],
												 'status'=>$file['status'],
												 'category'=>$file['category'],
												 'incidentType'=>$file['incidentType'],
												 'subject'=>$file['subject'],
												 'dateIncident'=>$file['dateIncident'],
												 'workOrderID'=>$file['workOrderID'],
												 'maxDate'=>$file['maxDate']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/WorkOrder/Open";
        $config['total_rows'] = count($workOrder);
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
			$this->load->view('Mgmt/WorkOrder/Open/Index',$data);
		}
	}
	
	public function OpenWO($WOID)
	{
		//call the model
		$data['WOID'] = $WOID;
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->workorder_model->get_Priority();
		$data['assignTo'] = $this->workorder_model->get_AssignTo();
		$data['category'] = $this->workorder_model->get_Category();
		$data['location'] = $this->workorder_model->get_WOILocation();
		$data['openWO'] = $this->workorder_model->get_workOrder_record($WOID);
		$feedRecord = $this->workorder_model->get_workOrder_record($WOID);
		
		//set validation rules
		$this->form_validation->set_rules('Priority', 'Priority', 'required');
        $this->form_validation->set_rules('AssignTo', 'AssignTo', 'required');
		$this->form_validation->set_rules('Category', 'Category', 'required');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/WorkOrder/Open/WorkOrder',$data);
			}
		}
		else
        {
			//validation succeed
            $data = array(
				'Category' => $this->input->post('Category'),
				'LocID' => $this->input->post('Location'),
				'GroupID' => $this->input->post('Group'),
				'Priority' => $this->input->post('Priority'),
				'Instruction' => $this->input->post('Instruction'),
				'Status' => 'InProgress',
				'StartDate' => $this->input->post('StartDate'),
				'EndDate' => $this->input->post('EndDate'),
				'DateIncident' => $this->input->post('DateIncident').' '.$this->input->post('TimeIncident'),
				'ModifiedBy' => $_SESSION['userid'],
				'ModifiedDate' => date('Y-m-d H:i:s'),
				'AssignBy' => $_SESSION['username'],
				'AssignTo' => $this->input->post('AssignTo'),
				'AssignToDate' => date('Y-m-d H:i:s'),
            );

			$this->cportal->where('WorkOrderID', $UID);
			$this->cportal->update('WorkOrder', $data);

			//display message
			redirect('index.php/Common/WorkOrder/PrintWorkOrder/'.$UID);
		}
	}
	
	public function InProgress($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $workOrder = $this->workorder_model->get_inprogressWO_list();
        $data['workOrder'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($workOrder) > 0) {
            $paginatedFiles = array_slice($workOrder, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['workOrder'][] = array('propertyNo'=>$file['propertyNo'],
												 'priority'=>$file['priority'],
												 'status'=>$file['status'],
												 'category'=>$file['category'],
												 'incidentType'=>$file['incidentType'],
												 'subject'=>$file['subject'],
												 'dateIncident'=>$file['dateIncident'],
												 'workOrderID'=>$file['workOrderID'],
												 'maxDate'=>$file['maxDate']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/WorkOrder/InProgress";
        $config['total_rows'] = count($workOrder);
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
			$this->load->view('Mgmt/WorkOrder/InProgress/Index',$data);
		}
	}
	
	public function InProgressWO($WOID)
	{
		//call the model
		$data['WOID'] = $WOID;
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->workorder_model->get_Priority();
		$data['assignTo'] = $this->workorder_model->get_AssignTo();
		$data['woItem'] = $this->workorder_model->get_WorkOrderItem($WOID);
		$data['item'] = $this->workorder_model->get_WOItem($WOID);
		$data['inProgressWO'] = $this->workorder_model->get_workOrder_record($WOID);
		$feedRecord = $this->workorder_model->get_workOrder_record($WOID);
		
		//set validation rules
		$this->form_validation->set_rules('Priority', 'Priority', 'required');
        $this->form_validation->set_rules('AssignTo', 'AssignTo', 'required');
        $this->form_validation->set_rules('AssignBy', 'AssignBy', 'required');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/WorkOrder/InProgress/WorkOrder',$data);
			}
		}
		else
        {
			$priority = $this->input->post('Priority');
			if($priority == '0'){
				$priority = $feedRecord[0]->Priority;
			}
			
			$date = $this->input->post('CompletedDate');
			if($date != ''){
				$completedDate = $this->input->post('CompletedDate').' '.$this->input->post('CompletedTime');
			}
			else{
				$completedDate = NULL;
			}
			
			//validation succeed
            $data = array(
				'Priority' => $priority,
				'ActionTaken' => $this->input->post('ActionTaken'),
				'Status' => 'InProgress',
				'ModifiedBy' => $_SESSION['userid'],
				'ModifiedDate' => date('Y-m-d H:i:s'),
				'AssignBy' => $this->input->post('AssignBy'),
				'AssignByDate' => date('Y-m-d H:i:s'),
				'AssignTo' => $this->input->post('AssignTo'),
				'AssignToDate' => date('Y-m-d H:i:s'),
				'CompletedBy' => $this->input->post('CompletedBy'),
				'CompletedDate' => $completedDate,
            );

			$this->cportal->where('WorkOrderID', $WOID);
			$this->cportal->update('WorkOrder', $data);
			
			$rowCnt = $this->input->post('rowCnt').'</br>';
			for($i = 0; $i < $rowCnt; $i++){
				if($this->input->post('UID'.$i) != ''){
					$data = array(
						'Item' => $this->input->post('item'.$i),
						'Quantity' => $this->input->post('qty'.$i),
						'UnitPrice' => $this->input->post('up'.$i),
						'Amount' => $this->input->post('amt'.$i),
						'TotalAmount' => $this->input->post('hdnttlPrice'),
						'Chargeable' => $this->input->post('chargeable'),
						'ModifiedBy' => $_SESSION['username'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);

					$this->cportal->where('UID', $this->input->post('UID'.$i));
					$this->cportal->update('WorkOrderItem', $data);
				}
				else{
					$data = array(
						'WorkOrderID' => $WOID,
						'Item' => $this->input->post('item'.$i),
						'Quantity' => $this->input->post('qty'.$i),
						'UnitPrice' => $this->input->post('up'.$i),
						'Amount' => $this->input->post('amt'.$i),
						'TotalAmount' => $this->input->post('hdnttlPrice'),
						'Chargeable' => $this->input->post('chargeable'),
						'CreatedBy' => $_SESSION['username'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);

					$this->cportal->insert('WorkOrderItem', $data);
				}
			}
		
			//display message
			redirect('index.php/Common/WorkOrder/PrintWorkOrder/'.$WOID);
		}
	}
	
	public function Closed($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $workOrder = $this->workorder_model->get_closedWO_list();
        $data['workOrder'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($workOrder) > 0) {
            $paginatedFiles = array_slice($workOrder, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['workOrder'][] = array('propertyNo'=>$file['propertyNo'],
												 'priority'=>$file['priority'],
												 'status'=>$file['status'],
												 'category'=>$file['category'],
												 'incidentType'=>$file['incidentType'],
												 'subject'=>$file['subject'],
												 'dateIncident'=>$file['dateIncident'],
												 'workOrderID'=>$file['workOrderID'],
												 'maxDate'=>$file['maxDate']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/WorkOrder/Closed";
        $config['total_rows'] = count($workOrder);
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
			$this->load->view('Mgmt/WorkOrder/Closed/Index',$data);
		}
	}
	
	public function ClosedWO($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['woItem'] = $this->workorder_model->get_WorkOrderItem($UID);
		$data['closedWO'] = $this->workorder_model->get_workOrder_record($UID);

		$this->form_validation->set_rules('CloseDate', 'CloseDate', 'callback_combo_check');
        $this->form_validation->set_rules('CloseTime', 'CloseTime', 'callback_combo_check');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/WorkOrder/Closed/WorkOrder',$data);
			}
		}
		else
        {
			//validation succeed
			$date = $this->input->post('CloseDate');
			if($date != ''){
				$closeDate = $this->input->post('CloseDate').' '.$this->input->post('CloseTime');
			}
			else{
				$closeDate = NULL;
			}

			//complaint details
			$this->cportal->from('WorkOrder');
			$this->cportal->where('WorkOrderID', $UID);
			$query = $this->cportal->get();
			$msg = $query->result();
			
            $data = array(
                'ClosedDate' => $closeDate,
				'ClosedBy' => $_SESSION['username'],
				'ManagementRemarks' => $this->input->post('Comment'),
				'Status' => 'Closed',
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
            $this->cportal->where('WorkOrderID', $UID);
            $this->cportal->update('WorkOrder', $data);

            //display message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("PropertyNo: '.$this->input->post('propNo').'\nSubject: '.$msg[0]->Subject.'\nComplaint has been closed.");</script>');
            redirect('index.php/Common/WorkOrder/ClosedWO/'.$UID);
        }
	}
	
	public function ItemGroup() 
	{
		$output = '';
		$loc = $this->input->post('loc');
		$data = $this->cportal->query("SELECT DISTINCT GroupName, WOIGroup.GroupID FROM WOIType 
									   LEFT JOIN WOIGroup ON WOIType.GroupID = WOIGroup.GroupID  
									   WHERE LocID = '".$loc."'");
		
		$output .= '<select name="Group" id="Group">
					<option value="0">Select Value</option>';

		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '<option value="'.$row->GroupID.'">'.$row->GroupName.'</option>';
			}
		}

		$output .= '</select>';
		echo $output;
    }
	
	public function PrintWorkOrder($UID)
	{
		$data['WOrderID'] = $UID;
		
		//load the view
		$this->load->view('../Reporting/WorkOrder', $data);
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