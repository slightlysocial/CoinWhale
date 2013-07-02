<?
 class Ajax_model extends Model{
    
        function __constructor()
        {
            parent::Model();
        }
		
		function myLink($uid)
		{
			$this->db->select("refer");
			$this->db->where("user_id",$uid);
			$query=$this->db->get("user");
			if ($query->num_rows() > 0)
			{
				$row=$query->row();
				return $row->refer;
			}else
			{
				return FALSE;
			}
			
		}
		
		function redeemCoin($clid)
		{
			$args=array("status"=>1);
			$param=array("serial"=>$clid);
			
			return $this->db->update("callback_log",$args,$param);
			
		}
		
		function registerUser($uid=0,$name="",$fname="",$lname="",$email="")
		{
				$date=date("Y-m-d",time());
				$lastLogin=date("Y-m-d H:i:s",time());
				$params=array(
				"fb_id"=>$uid,
				"name"=>$name,
				"fname"=>$fname,
				"lname"=>$lname,
				"email"=>"",
				"credit"=>0,
				"reg_date"=>''.$date,
				"last_login"=>''.$lastLogin
				);
				
				if($this->db->insert("user",$params))
				{
					$user_id=$this->db->insert_id();
					
					return $user_id;
				}else
				{
					return 0;
				}
		}
		
		function insertUserEmail($uid,$email)
		{
			//$params=array("not_email"=>"$email","credit"=>"credit+1");
			//$args=array("user_id"=>$uid);
			$param=array("email"=>"$email");
			$query=$this->db->get_where("email_not",$param);
			if ($query->num_rows() > 0)
			{
				$this->db->where("email",$email);
				$this->db->delete("email_not");
			}
			
			$this->db->set("not_email","".$email);
			$this->db->set("credit","credit+50",FALSE);
			$this->db->where("user_id",$uid);
			
			return $this->db->update("user");
		}
		
		function insertUnregisteredEmail($email,$fname="",$lname="")
		{
			//$params=array("not_email"=>"$email","credit"=>"credit+1");
			//$args=array("user_id"=>$uid);
			
			$param=array("email"=>"$email");
			$query=$this->db->get_where("email_not",$param);
			if ($query->num_rows() > 0)
			{
				$this->db->set("fname","".$fname);
				$this->db->set("lname","".$lname);
				//$this->db->set("email","".$email);
				$this->db->where("email",$email);
				$this->db->update("email_not");
				return 2;//
			}else
			{
				$param=array("not_email"=>"$email");
				$query=$this->db->get_where("user",$param);
				if ($query->num_rows() > 0)
				{	
					return 0;
				}else
				{
					$date=date("Y-m-d",time());
					$this->db->set("email","".$email);	
					$this->db->set("insert_date","$date");
					//$this->db->where("user_id",$uid);
					$this->db->insert("email_not");
					return 1;//
				}
			}
		}
		
		
		function lateRequest($deal_id,$name,$email,$cause)
		{
			$date=date("Y-m-d",time());
			$params=array(
			"deal_id"=>$deal_id,
			"name"=>$name,
			"email"=>$email,
			"cause"=>$cause,
			"insert_date"=>''.$date
			);
			if($this->db->insert("late_request",$params))
			{
				return "<font class='success'>Your request inserted successfully. We will get back to you soon.</font>";
			}else
			{
				return "<font class='error'>Sorry there is a problem. Try again.</font>";
			}
		}
		function checkLateReq($deal_id,$email)
		{
			$query = $this->db->query("select deal_id from late_request where deal_id='$deal_id' AND email='$email'");
			if ($query->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		function getReferelsLeaderboard($tab)
		{
			$data = array();
			
			$q = "SELECT DISTINCT refer_id, user.name, user.fb_id, count( user_refer.user_id ) refer FROM user_refer, user WHERE user.user_id = user_refer.refer_id";
			if($tab == 1)
			{
				$sdate = date("Y-m-d",mktime () - 7 * 3600 * 24); 
				$tdate = date("Y-m-d");
				
				$q .= " AND insert_date between '$sdate' AND '$tdate'";
			}
			else if($tab == 2)
			{
				$sdate = date("Y-m-d",mktime () - 30 * 3600 * 24); 
				$tdate = date("Y-m-d");
				
				$q .= " AND insert_date between '$sdate' AND '$tdate'";
			}
			
			$q .= " GROUP BY refer_id ORDER BY refer DESC Limit 0,25";
			
			//echo $q;
			$query = $this->db->query($q);
			foreach($query->result() as $row)
			{
				$temp = array();
				$temp["refer_id"] = $row->refer_id;
				$temp["name"] = $row->name;
				$temp["fb_id"] = $row->fb_id;
				$temp["refer"] = $row->refer;
				$data[] = $temp;
			}
			return $data;
		}
}
?>