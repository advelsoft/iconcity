<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notice_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_notice_list()
	{
		$sql = "SELECT Notices.*, C.Name AS C_Name
				FROM [".GLOBAL_DATABASE_NAME."].[dbo].[Notices] 
				LEFT JOIN [AllPmrsLive].[dbo].[Users] C ON Notices.CreatedBy = C.UserID 
				WHERE DateTo >= CONVERT(date, getdate())";
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('title'=>$result[$i]->Title,
								   'noticeDate'=>$result[$i]->NoticeDate,
								   'dateTo'=>$result[$i]->DateTo,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'noticeID'=>$result[$i]->NoticeID);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
    public function get_notice_record($NoticeID)
    {
		$this->cportal->from('Notices');
		$this->cportal->where('NoticeID', $NoticeID);
		$query = $this->cportal->get();
        return $query->result();
    }
}?>