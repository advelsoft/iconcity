<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bitdefender extends CI_Controller {
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
		$this->load->model('order_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('ProductName', 'Title', 'trim|required');
        $this->form_validation->set_rules('ProductImage', 'ProductImage', 'trim');
        $this->form_validation->set_rules('ProductDesc', 'ProductDesc', 'trim');
        $this->form_validation->set_rules('NormalPrice', 'NormalPrice', 'trim');
        $this->form_validation->set_rules('PromoDate', 'PromoDate', 'trim');
        $this->form_validation->set_rules('PromoPrice', 'PromoPrice', 'trim');
        
        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/BitDefender/Create', $data);
        }
        else
        {
			//validation succeed
			//rearrange date
			if($this->input->post('PromoDate') != ''){
				$temp = explode('/', $this->input->post('PromoDate'));
				$promoDate = $temp[2].'-'.$temp[1].'-'.$temp[0];
			}
			else{
				$promoDate = null;
			}
			
            $data = array(
				'SellerName' => 'BitDefender',
                'ProductName' => $this->input->post('ProductName'),
                'ProductImage' => $this->input->post('ProductImage'),
                'ProductDesc' => $this->input->post('Description'),
                'NormalPrice' => $this->input->post('NormalPrice'),
                'PromoDate' => $promoDate,
                'PromoPrice' => $this->input->post('PromoPrice'),
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );
			
			//echo "<pre>";
			//print_r($data);
			
            //insert record
            $this->db->insert('AntiVirusProduct', $data);

            //display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/Promotion/BitDefender');
        }
    }
	
	public function Detail($UID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['qty'] = $this->promotion_model->get_Qty();
		$data['bitdefRecord'] = $this->promotion_model->get_bitdefender_record($UID);
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/BitDefender/Detail',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/BitDefender/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/BitDefender/Detail',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Update($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['promoCat'] = $this->promotion_model->get_PromoCat();
		$data['display'] = $this->promotion_model->get_Display();
        $data['bitdefRecord'] = $this->promotion_model->get_bitdefender_record($UID);    

        //set validation rules
		$this->form_validation->set_rules('ProductName', 'Title', 'trim|required');
        $this->form_validation->set_rules('ProductImage', 'ProductImage', 'trim');
        $this->form_validation->set_rules('ProductDesc', 'ProductDesc', 'trim');
        $this->form_validation->set_rules('NormalPrice', 'NormalPrice', 'trim');
        $this->form_validation->set_rules('PromoDate', 'PromoDate', 'trim');
        $this->form_validation->set_rules('PromoPrice', 'PromoPrice', 'trim');
        
        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/BitDefender/Update', $data);
        }
        else
        {
			//rearrange date
			if($this->input->post('PromoDate') != ''){
				$temp = explode('/', $this->input->post('PromoDate'));
				$promoDate = $temp[2].'-'.$temp[1].'-'.$temp[0];
			}
			else{
				$promoDate = null;
			}
			
			$data = array(
                'SellerName' => 'BitDefender',
                'ProductName' => $this->input->post('ProductName'),
                'ProductImage' => $this->input->post('ProductImage'),
                'ProductDesc' => $this->input->post('Description'),
                'NormalPrice' => $this->input->post('NormalPrice'),
                'PromoDate' => $promoDate,
                'PromoPrice' => $this->input->post('PromoPrice'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//update record
			$this->db->where('UID', $UID);
			$this->db->update('AntiVirusProduct', $data);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/BitDefender/Update/'.$UID);
        }
	}

	public function Delete($UID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bitdefRecord'] = $this->promotion_model->get_bitdefender_record($UID);  
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/BitDefender/Delete',$data);
		$this->load->view('Admin/footer');
	}
	
    function delete_record($UID)
    {
        //delete record
        $this->db->where('UID', $UID);
        $this->db->delete('AntiVirusProduct');
        redirect('index.php/Common/Promotion/BitDefender');
    }
    
	public function OrderSumm()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		$insert = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'image' => $this->input->post('image'),
			'price' => $this->input->post('price'),
			'qty' => 1
		);		

		$this->cart->insert($insert);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Promotion/BitDefender/OrderSumm', $data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Promotion/BitDefender/OrderSumm', $data);
		}
	}
	
	public function OrderUpdate()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		foreach($_POST['cart'] as $id => $cart)
		{			
			$price = $cart['price'];
			$amount = $price * $cart['qty'];
			
			$this->order_model->update_cart($cart['rowid'], $cart['qty'], $price, $amount);
		}

		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Promotion/BitDefender/OrderSumm', $data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Promotion/BitDefender/OrderSumm', $data);
		}
	}

	function OrderRemove($rowid) 
	{
		if ($rowid=="All"){
			$this->cart->destroy();
			redirect('index.php/Common/Promotion/BitDefender');
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);

			$this->cart->update($data);
			redirect('index.php/Common/BitDefender/OrderSumm');
		}
	}
	
	public function CheckOut()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/BitDefender/PlaceOrder',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/BitDefender/PlaceOrder',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/BitDefender/PlaceOrder',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function PlaceOrder()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$company = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('Phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			//load the view
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Promotion/BitDefender/PlaceOrder',$data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Promotion/BitDefender/PlaceOrder',$data);
			}
        }
        else
        {
			//get user detail
			if($_SESSION['role'] == 'Mgmt'){
				$this->db->where('UserID', $_SESSION['userid']);
				$this->db->from('Users');
				$query = $this->db->get();
				$user = $query->result();

				$propNo = $user[0]->LoginID;
				$name = $user[0]->Name;
			}
			else{
				$this->cportal->where('UserID', $_SESSION['userid']);
				$this->cportal->from('Users');
				$query = $this->cportal->get();
				$user = $query->result();

				$propNo = $user[0]->PROPERTYNO;
				$name = $user[0]->OWNERNAME;
			}

			//send email
			//condo
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();	
			$condo = $query->result();

			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', $_SESSION['condoseq']);
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
			
			$sql = "SELECT MAX(CAST(OrderID as INT)) AS MaxOrderID FROM AntiVirusOrderID";
			$query = $this->db->query($sql);
			$result = $query->result();
			$maxorderid = $result[0]->MaxOrderID;
			$maxorderid = str_pad($maxorderid+1, 5, '0', STR_PAD_LEFT);

			$header = '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head>'.
					   '<body dir="auto"><div style="width: 680px;"><img src="'.base_url().'application/uploads/promotion/bitdefender.png" alt="Bitdefender" style="margin-bottom: 20px; border: none;">'.
					   '<p style="margin-top: 0px; margin-bottom: 20px;">Thank you for your interest in BitDefender products. Your order has been received and will be processed once payment has been confirmed.</p>'.
					   '<h1 style="color: #000;text-align: right;font-size: 24px;font-weight:normal;padding-bottom: 5px;margin-top: 0px;margin-bottom: 15px;border-bottom: 1px solid #CDDDDD;">ONLINE ORDER</h1>'.
					   '<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;"><thead><tr>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">Order Details</td>'.
					   '</tr></thead><tbody><tr>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b>Order ID:</b> '.$maxorderid.'<br>'.
					   '<b>Date Added:</b> '.date('d/m/Y').'<br><b>Payment Method:</b> Bank Transfer<br></td>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.
					   '<b>Email:</b> <a href="mailto:'.$this->input->post('Email').'">'.$this->input->post('Email').'</a><br><b>Telephone:</b> '.$this->input->post('Phone').'<br></td></tr></tbody></table>'.
					   '<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;"><thead><tr>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Instructions</td>'.
					   '</tr></thead><tbody><tr>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><br><br>'.
					   'Please bank-in cheque, cash or Internet Banking to the following account:<br><br>'.
					   'Bank : Public Bank.  | A/C: 3184460105 | Payee: Advelsoft Technologies (M) Sdn. Bhd.<br>'.
					   'Bank : MayBank. | A/C: 5620-8561-0585 | Payee: Advelsoft Technologies (M) Sdn. Bhd.<br><br>'.
					   '-------------------------------------------------------------------------------------------------------------------------<br><br>'.
					   'Please send us the payment details of:<br><br>'.
					   '1. Bank Name 2. Banking Date/Time<br><br>'.
					   '3. Banking Reference No 4. Total amount you have paid<br><br>'.
					   '5. Your Order No 6. End User / Company Name<br><br>'.
					   '<br><br>You may send the above info to: <a href="mailto:products@advelsoft.com.my">products@advelsoft.com.my</a> or WhatApps to Mobile no:+60182090117. Your purchases will not be delivered until the above information are received.'.
					   '</td></tr></tbody></table>'.
					   '<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;"><thead><tr>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Product</td>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Quantity</td>'.
					   '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Price</td>'.
					   '</tr></thead><tbody>';

			$header2 = '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head>'.
					   '<body dir="auto">'.
					   '<h1 style="color: #000;text-align: right;font-size: 24px;font-weight:normal;padding-bottom: 5px;margin-top: 0px;margin-bottom: 15px;border-bottom: 1px solid #CDDDDD;">ONLINE ORDER</h1>'.
					   '<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;"><thead><tr>'.
					   '<td style="font-size: 16px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">New Order</td>'.
					   '</tr></thead><tbody><tr>'.
					   '<td style="font-size: 16px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.
					   'New order has been placed from '.$propNo.' of '.$company[0]->CompanyName.
					   '</td></tr></tbody></table>'.
					   '<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;"><thead><tr>'.
					   '<td style="font-size: 16px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Product</td>'.
					   '<td style="font-size: 16px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Quantity</td>'.
					   '<td style="font-size: 16px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Price</td>'.
					   '</tr></thead><tbody>';
					   
			if ($cart = $this->cart->contents()):
				$grand_total = 0;
				$products = '';
				foreach ($cart as $item):
					$grand_total = $grand_total + $item['subtotal'];
					$products .= '<tr><td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$item['name'].'</td>'.
								 '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$item['qty'].'</td>'.
								 '<td style="font-size: 14px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">RM '.$item['subtotal'].'</td>';
				endforeach;
			endif;

			$footer = '</tr></tbody>'.
					  '<tfoot><tr><td style="font-size: 14px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="2"><b>Total Amount:</b></td>'.
					  '<td style="font-size: 14px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">RM '.$grand_total.'</td>'.
					  '</tr></tfoot></table></div></body></html>';

			$message = $header.$products.$footer;
			$message2 = $header2.$products.$footer;

			//Purchaser
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('products@advelsoft.com.my', $company[0]->CompanyName);
			$this->email->to(trim($this->input->post('Email')));
			$this->email->subject('Order Confirmation');
			$this->email->message($message);
			
			if($this->email->send())
			{	
				$this->sendEmail($config, $message2, $company[0]->CompanyName);
		
				$order = array(
					'Brand' => 'BitDefender',
					'PropertyNo' => $propNo,
					'OwnerName' => $name,
					'Email' => $this->input->post('Email'),
					'Phone' => $this->input->post('Phone'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s')
				);

				$orderid = str_pad($this->order_model->insert_order($order), 5, '0', STR_PAD_LEFT);
				
				if ($cart = $this->cart->contents()):
					foreach ($cart as $item):
						$data = array(
							'OrderID' => $orderid,
							'Brand' => 'BitDefender',
							'Product' => $item['name'],
							'Price' => $item['price'],
							'Quantity' => $item['qty'],
							'CreatedBy' => $_SESSION['userid'],
							'CreatedDate' => date('Y-m-d H:i:s'),
						);		

						//insert record
						$this->db->insert('AntiVirusOrderDetails', $data);
					endforeach;
				endif;
				$this->cart->destroy();
				
				//display success message
				redirect('index.php/Common/BitDefender/Confirmation/'.$orderid);
			}
			else
			{
				//show_error($this->email->print_debugger());
				//display message
				redirect('index.php/Common/BitDefender/CheckOut');
			}
        }
	}
	
	public function sendEmail($config, $message2, $companyName)
	{
		//Vendor
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('products@advelsoft.com.my', $companyName);
		$this->email->to('products@advelsoft.com.my');
		$this->email->subject('New Order - BitDefender');
		$this->email->message($message2);
		$this->email->send();
	}
	
	public function Confirmation($orderid)
	{
		//call the model
		$data['orderid'] = $orderid;
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/BitDefender/Confirmation',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Promotion/BitDefender/Confirmation',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Promotion/BitDefender/Confirmation',$data);
			$this->load->view('User/footer');
		}
	}
}?>