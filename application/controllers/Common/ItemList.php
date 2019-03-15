<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class itemlist extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		
		//load the model
		$this->load->model('itemlist_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function LocationList($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$locList = $this->itemlist_model->get_location_list();
        $data['locationList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($locList) > 0) {
            $paginatedFiles = array_slice($locList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['locationList'][] = array('locID'=>$file['locID'],
													'locName'=>$file['locName']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ItemList/LocationList";
        $config['total_rows'] = count($locList);
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
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ItemList/WOLocation',$data);
		$this->load->view('Mgmt/footer');
	}
	
	public function LocationCreate()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('LocationName', 'LocationName', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOLocation',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'LocName' => $this->input->post('LocationName'),
				'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('WOILocation', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/ItemList/LocationList');
		}
	}
	
	public function LocationUpdate($LocID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('LocationName', 'LocationName', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOLocation',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'LocName' => $this->input->post('LocationName'),
				'ModifiedBy' => $_SESSION['username'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('LocID', $LocID);
			$this->cportal->update('WOILocation', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/ItemList/LocationList');
		}
	}
	
	public function LocationDelete($LocID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//delete record
		$this->cportal->where('LocID', $LocID);
		$this->cportal->delete('WOILocation');
		
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("Deleted");</script>');
		redirect('index.php/Common/ItemList/LocationList');
	}
	
	public function GroupList($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$groupList = $this->itemlist_model->get_group_list();
        $data['groupList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($groupList) > 0) {
            $paginatedFiles = array_slice($groupList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['groupList'][] = array('groupID'=>$file['groupID'],
											     'groupName'=>$file['groupName']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ItemList/GroupList";
        $config['total_rows'] = count($groupList);
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
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ItemList/WOGroup',$data);
		$this->load->view('Mgmt/footer');
	}
	
	public function GroupCreate()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('GroupName', 'GroupName', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOGroup',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'GroupName' => $this->input->post('GroupName'),
				'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('WOIGroup', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/ItemList/GroupList');
		}
	}
	
	public function GroupUpdate($GroupID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['groupList'] = $this->itemlist_model->get_group_list();
		
		//set validation rules
        $this->form_validation->set_rules('GroupName', 'GroupName', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOGroup',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'GroupName' => $this->input->post('GroupName'),
				'ModifiedBy' => $_SESSION['username'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('GroupID', $GroupID);
			$this->cportal->update('WOIGroup', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/ItemList/GroupList');
		}
	}
	
	public function GroupDelete($GroupID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//delete record
		$this->cportal->where('GroupID', $GroupID);
		$this->cportal->delete('WOIGroup');
		
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("Deleted");</script>');
		redirect('index.php/Common/ItemList/GroupList');
	}
	
	public function TypeList($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['location'] = $this->itemlist_model->get_Location();
		$data['locSort'] = $this->itemlist_model->get_location_sort();
		$data['group'] = $this->itemlist_model->get_Group();
		$data['groupSort'] = $this->itemlist_model->get_group_sort();
		$typeList = $this->itemlist_model->get_type_list();
        $data['typeList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($typeList) > 0) {
            $paginatedFiles = array_slice($typeList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['typeList'][] = array('typeID'=>$file['typeID'],
												'typeName'=>$file['typeName'],
												'locID'=>$file['locID'],
												'locName'=>$file['locName'],
											    'groupID'=>$file['groupID'],
											    'groupName'=>$file['groupName']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ItemList/TypeList";
        $config['total_rows'] = count($typeList);
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
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Setup/ItemList/WOType',$data);
	}
	
	function SearchLocation()
	{
		$output = '';
		$loc = '';
		$grp = '';
		
		if($this->input->post('loc'))
		{
			$loc = $this->input->post('loc');
			$grp = $this->input->post('grp');
		}
		$data = $this->itemlist_model->get_search_location($loc, $grp);

		$output .= '<div class="table-responsive">
		<table class="table table-striped table-hover table-custom footable">
		<thead>
			<tr>
				<th>Item Type</th>
				<th>Item Location</th>
				<th>Item Group</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';
		
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '<tr>
				<td style="text-align:left">'.$row->TypeName.'</td>
				<td style="text-align:left">'.$row->LocName.'</td>
				<td style="text-align:left">'.$row->GroupName.'</td>
				<td>
					<a href="#" data-toggle="modal" data-target="#edit'.$row->TypeID.'"><div class="btn btn-sm btn-grey">Edit</div></a>
					<a href="#" data-toggle="modal" data-target="#delete'.$row->TypeID.'"><div class="btn btn-sm btn-grey">Delete</div></a>
				</td>
				</tr>';
			}
		}
		else
		{
			$output .= '<tr>
			<td colspan="5">No Data Found</td>
			</tr>';
		}
		$output .= '</tbody></table>';
		echo $output;
	}
	
	function SearchGroup()
	{
		$output = '';
		$grp = '';
		$loc = '';
		
		if($this->input->post('grp'))
		{
			$grp = $this->input->post('grp');
			$loc = $this->input->post('loc');
		}
		$data = $this->itemlist_model->get_search_group($grp, $loc);

		$output .= '<div class="table-responsive">
		<table class="table table-striped table-hover table-custom footable">
		<thead>
			<tr>
				<th>Item Type</th>
				<th>Item Location</th>
				<th>Item Group</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';
		
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '<tr>
				<td style="text-align:left">'.$row->TypeName.'</td>
				<td style="text-align:left">'.$row->LocName.'</td>
				<td style="text-align:left">'.$row->GroupName.'</td>
				<td>
					<a href="#" data-toggle="modal" data-target="#edit'.$row->TypeID.'"><div class="btn btn-sm btn-grey">Edit</div></a>
					<a href="#" data-toggle="modal" data-target="#delete'.$row->TypeID.'"><div class="btn btn-sm btn-grey">Delete</div></a>
				</td>
				</tr>';
			}
		}
		else
		{
			$output .= '<tr>
			<td colspan="5">No Data Found</td>
			</tr>';
		}
		$output .= '</tbody></table>';
		echo $output;
	}
	
	public function TypeSList($LocID, $GroupID, $page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['location'] = $this->itemlist_model->get_Location();
		$data['group'] = $this->itemlist_model->get_Group();
		$typeList = $this->itemlist_model->get_typeS_list($LocID, $GroupID);
        $data['typeList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($typeList) > 0) {
            $paginatedFiles = array_slice($typeList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['typeList'][] = array('typeID'=>$file['typeID'],
												'typeName'=>$file['typeName'],
												'locID'=>$file['locID'],
												'locName'=>$file['locName'],
											    'groupID'=>$file['groupID'],
											    'groupName'=>$file['groupName']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ItemList/TypeSList";
        $config['total_rows'] = count($typeList);
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
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ItemList/WOTypeS',$data);
		$this->load->view('Mgmt/footer');
	}
	
	public function TypeCreate()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('Type', 'Type', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOType',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'LocID' => $this->input->post('Location'),
				'GroupID' => $this->input->post('Group'),
				'TypeName' => $this->input->post('Type'),
				'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('WOIType', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/ItemList/TypeList');
		}
	}
	
	public function TypeUpdate($TypeID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$type = $this->itemlist_model->get_type_record($TypeID);
		
		//set validation rules
        $this->form_validation->set_rules('Type', 'Type', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOType',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'LocID' => $this->input->post('Location'),
				'GroupID' => $this->input->post('Group'),
				'TypeName' => $this->input->post('Type'),
				'ModifiedBy' => $_SESSION['username'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('TypeID', $TypeID);
			$this->cportal->update('WOIType', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/ItemList/TypeSList/'.$type[0]->LocID.'/'.$type[0]->GroupID);
		}
	}
	
	public function TypeDelete($TypeID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$type = $this->itemlist_model->get_type_record($TypeID);
		
		//delete record
		$this->cportal->where('TypeID', $TypeID);
		$this->cportal->delete('WOIType');
		
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("Deleted");</script>');
		redirect('index.php/Common/ItemList/TypeList/'.$type[0]->LocID.'/'.$type[0]->GroupID);
	}
	
	public function ComponentList()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['componentList'] = $this->itemlist_model->get_component_list();
		$data['group'] = $this->itemlist_model->get_Group();
		$data['type'] = $this->itemlist_model->get_Type();
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ItemList/WOComponent',$data);
		$this->load->view('Mgmt/footer');
	}
	
	public function ComponentCreate()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('Component', 'Component', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOComponent',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'GroupID' => $this->input->post('Group'),
				'TypeID' => $this->input->post('Type'),
				'ComponentName' => $this->input->post('Component'),
				'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('WOIComponent', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/ItemList/ComponentList');
		}
	}
	
	public function ComponentUpdate($ComponentID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$component = $this->itemlist_model->get_component_record($ComponentID);
		
		//set validation rules
        $this->form_validation->set_rules('Type', 'Type', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOType',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'GroupID' => $this->input->post('Group'),
				'TypeID' => $this->input->post('Type'),
				'ComponentName' => $this->input->post('Component'),
				'ModifiedBy' => $_SESSION['username'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('ComponentID', $ComponentID);
			$this->cportal->update('WOIComponent', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/ItemList/ComponentList');
		}
	}
	
	public function ComponentDelete($ComponentID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$component = $this->itemlist_model->get_component_record($ComponentID);
		
		//delete record
		$this->cportal->where('ComponentID', $ComponentID);
		$this->cportal->delete('WOIComponent');
		
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("Deleted");</script>');
		redirect('index.php/Common/ItemList/ComponentList');
	}
	
	public function CategoryList($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$catList = $this->itemlist_model->get_category_list();
        $data['categoryList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($catList) > 0) {
            $paginatedFiles = array_slice($catList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['categoryList'][] = array('catID'=>$file['catID'],
												    'catCode'=>$file['catCode'],
												    'description'=>$file['description']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ItemList/CategoryList";
        $config['total_rows'] = count($catList);
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
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ItemList/WOCategory',$data);
		$this->load->view('Mgmt/footer');
	}
	
	public function CategoryCreate()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('CategoryCode', 'CategoryCode', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOCategory',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'CatCode' => $this->input->post('CategoryCode'),
				'Description' => $this->input->post('Description'),
				'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('WorkOrderCategory', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/ItemList/CategoryList');
		}
	}
	
	public function CategoryUpdate($CatID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('CategoryCode', 'CategoryCode', 'trim|required');
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ItemList/WOCategory',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'CatCode' => $this->input->post('CategoryCode'),
				'Description' => $this->input->post('Description'),
				'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('CatID', $CatID);
			$this->cportal->update('WorkOrderCategory', $data);
			
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/ItemList/CategoryList');
		}
	}
	
	public function CategoryDelete($CatID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//delete record
		$this->cportal->where('CatID', $CatID);
		$this->cportal->delete('WorkOrderCategory');
		
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("Deleted");</script>');
		redirect('index.php/Common/ItemList/CategoryList');
	}
}
?>