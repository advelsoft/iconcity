<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->jompay = $this->load->database('jompay',TRUE);
		$this->cportal = $this->load->database('cportal',TRUE);
		
	}

	public function get_news_list()
	{
		$sql = "SELECT Newsfeed.*, NewsType.Description, C.Name AS C_Name
				FROM Newsfeed
				JOIN NewsType ON Newsfeed.NewsfeedTypeId = NewsType.NewsTypeId
				LEFT JOIN Users C ON Newsfeed.CreatedBy = C.UserID
				WHERE Newsfeed.CondoSeq = '".$_SESSION['condoseq']."' AND Newsfeed.Publish = 1";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('title'=>$result[$i]->Title,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'newsID'=>$result[$i]->NewsfeedID,
								   'Publish'=>$result[$i]->Publish,
								   'description'=>$result[$i]->Description);
			}
			return $array;
		}
		else{
			return $result;
		}
	}

	public function get_news_list_mgmt()
	{
		$sql = "SELECT Newsfeed.*, NewsType.Description, C.Name AS C_Name
				FROM Newsfeed
				JOIN NewsType ON Newsfeed.NewsfeedTypeId = NewsType.NewsTypeId
				LEFT JOIN Users C ON Newsfeed.CreatedBy = C.UserID
				WHERE Newsfeed.CondoSeq = '".$_SESSION['condoseq']."' ORDER BY Newsfeed.NewsfeedID DESC";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('title'=>$result[$i]->Title,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'newsID'=>$result[$i]->NewsfeedID,
								   'Publish'=>$result[$i]->Publish,
								   'description'=>$result[$i]->Description);
			}
			return $array;
		}
		else{
			return $result;
		}
	}
	
    public function get_news_record($NewsID)
    {
		$sql = "SELECT Newsfeed.*, NewsType.Description as NewsType
				FROM Newsfeed
				JOIN NewsType ON Newsfeed.NewsfeedTypeId = NewsType.NewsTypeId
				WHERE NewsfeedID = ".$NewsID." AND Newsfeed.CondoSeq = '".$_SESSION['condoseq']."'";
		$query = $this->jompay->query($sql);
        return $query->result();
    }
	
	public function get_news_record2($NewsID)
	{
		
		//get propertyNo
		if($_SESSION['role'] == 'Mgmt'){
			$unitseq = 0;
		} else if($_SESSION['role'] == 'User'){
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
	        $user = $query->result();

	        $unitseq = trim($user[0]->UNITSEQ);
		}

		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
		$condo = $query->result();
	
		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => $unitseq, 'UserIdNo' => $_SESSION['userid'], 'NoticeId' => $NewsID);
			
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeItem';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);

		$data_return = array();
		foreach($body as $key => $value)
		{
			if($key == 'Req'){
				$CondoSeqNo = $value['CondoSeqNo'];
				$UserTokenNo = $value['UserTokenNo'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				foreach($value as $k){
					$data_return = array(
						'NoticeId' => $k['NoticeId'],
	                    'Title' => $k['Title'],
	                    'Description' => base64_decode($k['Description']),
	                    'CreatedAt' => $k['CreatedAt'],
	                    'EventDate' => $k['EventDate'],
	                    'DateFrom' => $k['DateFrom'],
	                    'DateTo' => $k['DateTo'],
	                    'TimeFrom' => $k['TimeFrom'],
	                    'TimeTo' => $k['TimeTo'],
	                    'Type' => $k['Type'],
	                    'Attachment1' => $k['Attachment1'],
	                    'Attachment2' => $k['Attachment2'],
	                    'Attachment3' => $k['Attachment3'],
	                    'Attachment4' => $k['Attachment4']
					);
				}
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			//redirect('index.php/Common/News/Index');
		}
		else{
			return $data_return;
		}
	}
	
	public function get_NewsType()
	{
		$this->jompay->from('NewsType');
        $query = $this->jompay->get();
        $result = $query->result();
		
        $newstype = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->NewsTypeId => $result[$i]->Description);
			$newstype = $newstype+$array;
		}
        return $newstype;
	}

	public function get_viewer_list($NewsID)
	{
		$sql = "SELECT NewsfeedLog.dateread, U.PROPERTYNO
				FROM [AllPmrsLive].[dbo].[NewsfeedLog]
				JOIN [".GLOBAL_DATABASE_NAME."].[dbo].[Users] U ON NewsfeedLog.UserId = U.USERID
				WHERE NewsfeedLog.condoSeqNo = '".$_SESSION['condoseq']."' AND NewsfeedLog.newsfeedid = '".$NewsID."'";
		$query = $this->jompay->query($sql);
		$result = $query->result();

		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('dateread'=>$result[$i]->dateread,
								   'PROPERTYNO'=>$result[$i]->PROPERTYNO);
			}
			return $array;
		}
		else{
			$this->session->set_flashdata('msg', '<script language=javascript>alert("There are no viewers for this news.");</script>');
			return $result;
		}
	}
}?>