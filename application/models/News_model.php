<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function get_news_list()
	{
		$sql = "SELECT Newsfeed.*, NewsType.Description, C.Name AS C_Name
				FROM Newsfeed
				JOIN NewsType ON Newsfeed.NewsfeedTypeId = NewsType.NewsTypeId
				LEFT JOIN Users C ON Newsfeed.CreatedBy = C.UserID
				WHERE Newsfeed.CondoSeq = '".GLOBAL_CONDOSEQ."' AND Publish = 1";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			for ($i = 0; $i < count($result); $i++)
			{
				$array[$i] = array('title'=>$result[$i]->Title,
								   'createdBy'=>$result[$i]->C_Name,
								   'createdDate'=>$result[$i]->CreatedDate,
								   'newsID'=>$result[$i]->NewsfeedID,
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
				WHERE NewsfeedID = ".$NewsID." AND Newsfeed.CondoSeq = '".GLOBAL_CONDOSEQ."'";
		$query = $this->jompay->query($sql);
        return $query->result();
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
}?>