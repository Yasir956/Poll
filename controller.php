<?php

class Dbh {

	private $servername;
	private $username;
	private $password;
	private $dbnme;

	protected function connect() {
		$this ->servername = "localhost";
		$this ->username = "root";
		$this ->password = "";
		$this ->dbname = "polls_db";

		$con = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
		return $con;
	}
}

class polls extends Dbh {
	public function getPolls() {
		$sql = "SELECT * FROM `poll_subject` WHERE `status` = '1'";
		$polls = $this-> connect()->query($sql);
		$numRows = $polls->num_rows;
		if ($numRows > 0) {
			while ($row = $polls->fetch_assoc()){
				$data[] =$row;
			}
			return $data;
		}
	}
	public function getOptions(){
		$sql  = "SELECT * FROM `polls_options` WHERE `sub_id` = '1'" ;            //.$this->getPolls()->$data['id'];
		$options = $this-> connect()->query($sql);
		$numRows = $options->num_rows;
		if ($numRows > 0) {
			while ($row = $options->fetch_assoc()){
				$data[] =$row;
			}
			return $data;

       }
   }

}
class ViewData extends polls {

	public function ShowData() {
		$datas = $this->getPolls();
		foreach ($datas as $data) {
			$sub_id = $data['id'];
			echo $data['subject'];
		}
	}

   private function getQuery($sql,$returnType = ''){
    $result = $this->connect()->query($sql);
    if($result){
        switch($returnType){
            case 'count':
            $data = $result->num_rows;
            break;
            case 'single':
            $data = $result->fetch_assoc();
            break;
            default:
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
            }
        }
    }
    return !empty($data)?$data:false;
}
public function vote($data = array()){
  if(!isset($data['sub_id']) || !isset($data['poll_option_id']) || isset($_COOKIE[$data['sub_id']])) {
     
    return false;
}else{
   
    $sql = "SELECT * FROM `poll_count` WHERE `sub_id`=".$data['sub_id']." AND `poll_option_id` =".$data['poll_option_id'];
             //$sql = "SELECT * FROM `poll_count` WHERE `sub_id`='1' AND `poll_option_1d` ='3'";
    
            	//$chk = $this->connect()->query($sql);
            	//$preVote = $chk->num_rows;	
			//echo $preVote;
    $preVote = $this->getQuery($sql, 'count');
    if($preVote > 0){
       $query = "UPDATE `poll_count` SET `vote_count`=vote_count+'1' WHERE `sub_id`=".$data['sub_id']." AND `poll_option_id` =".$data['poll_option_id'];

       $update = $this->connect()->query($query);
   }else{
       echo "in else";
       $query = "INSERT INTO `poll_count` (`sub_id`, `poll_option_id`, `vote_count`) VALUES (".$data['sub_id'].",".$data['poll_option_id'].",'1');";
       $insert = $this->connect()->query($query);
   }
   return true;
}
} 


public function getResult($pollID){
    $resultData = array();
    if(!empty($pollID)){
        $sql = "SELECT p.subject, SUM(v.vote_count) as total_votes FROM poll_count as v LEFT JOIN poll_subject as p ON p.id = v.sub_id WHERE sub_id =".$pollID;
        $pollResult = $this->getQuery($sql,'single');
        if(!empty($pollResult)){
            $resultData['poll'] = $pollResult['subject'];
            $resultData['total_votes'] = $pollResult['total_votes'];

            $sql2 = "SELECT o.id, o.poll_option, v.vote_count FROM polls_options as o LEFT JOIN poll_count as v ON v.poll_option_id = o.id WHERE o.sub_id = ".$pollID;

            $optResult = $this->getQuery($sql2);
            if(!empty($optResult)){
                foreach($optResult as $optrow){
                    $resultData['options'][$optrow['poll_option']] = $optrow['vote_count']; 
                }
            }
        }
    }
    return !empty($resultData)?$resultData:false;
}



public function ShowOptions() {
  $datas1 = $this->getOptions();
		//foreach ($datas1 as $data1) {
			//echo '<li><input type="radio" name="voteOpt" value="'.$data1['id'].'" >'.$data1['poll_option'].'</li>';
	//	}
		//foreach ($datas1 as $data1) {
			//echo $data1['poll_option']."<br>";
}
}
?>