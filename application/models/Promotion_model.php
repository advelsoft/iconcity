<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function get_condo_list()
	{
		$sql = "SELECT CONDOSEQ, CondoName FROM [AllPmrsLive].[dbo].[Condo] 
				ORDER BY CondoName ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_promo_list($CondoSeq)
	{
		$this->db->select('Promotion.*, PromoCategory.Description, C.Name AS C_Name, M.Name AS M_Name');
		$this->db->from('Promotion');
		$this->db->join('PromoCategory', 'Promotion.PromoCat = PromoCategory.PromoCatId');
		$this->db->join('Users as C', 'Promotion.CreatedBy = C.UserID', 'left');
		$this->db->join('Users as M', 'Promotion.ModifiedBy = M.UserID', 'left');
		$this->db->where('Promotion.CondoSeq', $CondoSeq);
		$this->db->order_by('Display', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
    public function get_promo_record($PromoID)
    {
		$this->db->select('Promotion.*, PromoCategory.Description AS Desc');
		$this->db->from('Promotion');
		$this->db->join('PromoCategory', 'Promotion.PromoCat = PromoCategory.PromoCatId');
		$this->db->where('PromoID', $PromoID);
		$query = $this->db->get();
        return $query->result();
    }
	
	public function get_eset_list()
	{
		$this->db->select('AntiVirusProduct.*, C.Name AS C_Name, M.Name AS M_Name');
		$this->db->from('AntiVirusProduct');
		$this->db->join('Users as C', 'AntiVirusProduct.CreatedBy = C.UserID', 'left');
		$this->db->join('Users as M', 'AntiVirusProduct.ModifiedBy = M.UserID', 'left');
		$this->db->where('SellerName', 'Eset');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_eset_record($UID)
    {
		$this->db->from('AntiVirusProduct');
		$this->db->where('UID', $UID);
		$query = $this->db->get();
        return $query->result();
    }
	
	public function get_bitdefender_list()
	{
		$this->db->select('AntiVirusProduct.*, C.Name AS C_Name, M.Name AS M_Name');
		$this->db->from('AntiVirusProduct');
		$this->db->join('Users as C', 'AntiVirusProduct.CreatedBy = C.UserID', 'left');
		$this->db->join('Users as M', 'AntiVirusProduct.ModifiedBy = M.UserID', 'left');
		$this->db->where('SellerName', 'BitDefender');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_bitdefender_record($UID)
    {
		$this->db->from('AntiVirusProduct');
		$this->db->where('UID', $UID);
		$query = $this->db->get();
        return $query->result();
    }
	
	public function get_promoCat_list()
	{
		$this->db->from('PromoCategory');
		$this->db->where('CondoSeq', '1');
		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_antiVirus_list()
	{
		$this->db->from('PromoCategory');
		$this->db->where('CondoSeq', '0');
		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_PromoCat()
	{
		$this->db->from('PromoCategory');
        $query = $this->db->get();
        $result = $query->result();
		
        $promocat = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->PromoCatId => $result[$i]->Description);
			$promocat = $promocat+$array;
		}
        return $promocat;
	}
	
	public function get_Display()
	{
		$display = array('0'=>'Select Value', 
						 '1'=>'Dashboard and Promotion List', 
						 '2'=>'Promotion List');
        return $display;
	}
	
	public function get_Qty()
	{
		$display = array('0'=>'Select Value', 
						 '1'=>'1', 
						 '2'=>'2', 
						 '3'=>'3', 
						 '4'=>'4', 
						 '5'=>'5', 
						 '6'=>'6', 
						 '7'=>'7',
						 '8'=>'8',
						 '9'=>'9',
						 '10'=>'10');
        return $display;
	}
}?>