<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}
	
	public function get_upload_list()
	{
		$sql = "SELECT Upload.*, UploadType.Description, C.Name AS C_Name 
				FROM [".GLOBAL_DATABASE_NAME."].[dbo].[Upload] 
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[UploadType] ON Upload.UploadType = UploadType.UploadTypeId
				LEFT JOIN [AllPmrsLive].[dbo].[Users] C ON Upload.CreatedBy = C.UserID";
		$query = $this->db->query($sql);
		$result1 = $query->result();
		
		if(count($result1) > 0){
			for ($i = 0; $i < count($result1); $i++)
			{	
				$array[$i] = array('uploadID'=>$result1[$i]->UploadID,
								   'file'=>$result1[$i]->UploadFile,
								   'type'=>$result1[$i]->Description,
								   'createdBy'=>$result1[$i]->C_Name,
								   'createdDate'=>$result1[$i]->CreatedDate);
			}
			return $array;
		}
		else{
			return;
		}
	}
	
    public function get_upload_record($UploadID)
    {
		$this->cportal->select('Upload.*, UploadType.Description');
		$this->cportal->from('Upload');
		$this->cportal->join('UploadType', 'Upload.UploadType = UploadType.UploadTypeId');
		$this->cportal->where('UploadID', $UploadID);
		$query = $this->cportal->get();
        $result1 = $query->result();
		
		//get CreatedBy
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $result1[0]->CreatedBy);
		$query = $this->cportal->get();
		$result2 = $query->result();

		if(count($result2) > 0){
			$CreatedBy = $result2[0]->OWNERNAME;
		}
		else {
			$CreatedBy = "";
		}
		
		//get ModifiedBy
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $result1[0]->ModifiedBy);
		$query = $this->cportal->get();
		$result3 = $query->result();

		if(count($result3) > 0){
			$ModifiedBy = $result3[0]->OWNERNAME;
		}
		else {
			$ModifiedBy = "";
		}

		$array = array('uploadID'=>$result1[0]->UploadID,
					   'file'=>$result1[0]->UploadFile,
					   'type'=>$result1[0]->UploadType,
					   'desc'=>$result1[0]->Description,
					   'createdBy'=>$CreatedBy,
					   'createdDate'=>$result1[0]->CreatedDate,
					   'modifiedBy'=>$ModifiedBy,
					   'modifiedDate'=>$result1[0]->ModifiedDate);
		
		return $array;
    }
	
	public function get_uploadType_list()
	{
		$this->cportal->from('UploadType');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_UploadType()
	{
		$this->cportal->from('UploadType');
        $query = $this->cportal->get();
        $result = $query->result();
		
        $uploadtype = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->UploadTypeId => $result[$i]->Description);
			$uploadtype = $uploadtype+$array;
		}
        return $uploadtype;
	}
}?>