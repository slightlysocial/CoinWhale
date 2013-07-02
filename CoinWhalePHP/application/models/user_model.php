<?
 class User_model extends Model{
    
        function __constructor()
        {
            parent::Model();
        }
		
		function getUserId($uid)
		{
			//$user=array();
			
			$params=array("fb_id"=>"".$uid);
			$query=$this->db->get_where("user",$params);
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				/*$user["user_id"]=$row->user_id;
				$user["fb_id"]=$row->fb_id;
				$user["name"]=$row->name;
				$user["fname"]=$row->fname;
				$user["lname"]=$row->lname;
				$user["email"]=$row->email;
				$user["not_email"]=$row->not_email;
				$user["credit"]=$row->credit;
				$user["reg_date"]=$row->reg_date;
				$user["last_login"]=$row->last_login;*/
				return $row->user_id;
				
			}else
			{
				return 0;
			}
			
			
		}
		
		
		
		function registerUser($uid,$uinfo,$rid)
		{
			$params=array("fb_id"=>"$uid");
			$query=$this->db->get_where("user",$params);
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				return $row->user_id;
				
			}
			else
			{
				$name=(isset($uinfo["name"])?$uinfo["name"]:"");
				$fname=(isset($uinfo["first_name"])?$uinfo["first_name"]:"");
				$lname=(isset($uinfo["last_name"])?$uinfo["last_name"]:"");
				$email=(isset($uinfo["email"])?$uinfo["email"]:"");
				$date=date("Y-m-d",time());
				$lastLogin=date("Y-m-d H:i:s",time());
				$params=array(
				"fb_id"=>$uid,
				"name"=>$name,
				"fname"=>$fname,
				"lname"=>$lname,
				"email"=>$email,
				"not_email"=>$email,
				"credit"=>0,
				"reg_date"=>''.$date,
				"last_login"=>''.$lastLogin
				);
				
				if($this->db->insert("user",$params))
				{
					$user_id=$this->db->insert_id();
					if($user_id>0)
					{
						
						$refer=md5($user_id);
						$param=array("refer"=>"".$refer);
						
						$this->db->set("refer",$refer,FALSE);
						$this->db->where("user_id",$user_id);
						$this->db->update("user",$param);
						
						$this->db->select("user_id");
						$this->db->where("refer",$rid);
						$res=$this->db->get("user");
						
						if ($res->num_rows() > 0)
						{
							
							$row=$res->row();
							
							$refer_id=$row->user_id;
							
							$param=array("user_id"=>$user_id,
										"refer_id"=>$refer_id,
										"insert_date"=>$date);
							$this->db->insert("user_refer",$param);
							
							
							//$this->db->set("not_email","".$email);
							$this->db->set("credit","credit+25",FALSE);
							$this->db->where("user_id",$refer_id);
							$this->db->update("user");
						
						
	
						}
						$param=array("user_id"=>$user_id,
										"is_visit"=>0);
						$this->db->insert("user_log",$param);
						
						$this->trackSignup();
						
					}
					return $user_id;
				}
				
				return 0;
			}
				
			
		}
		function isNewUser($uid)
		{
			$args=array("user_id"=>$uid);
			$query=$this->db->get_where("user_log",$args);
			$row=$query->row();
			$status=$row->is_visit;
			if(!$status)
			{
				$this->db->set("is_visit","1",FALSE);
				$this->db->where("user_id",$uid);
				$this->db->update("user_log");
			}
			return $status;
			
			
		}
		
		function getUserInfo($uid=0)
		{
			//$user=array();
			$params=array("user_id"=>"$uid");
			$query=$this->db->get_where("user",$params);
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				$user["user_id"]=$row->user_id;
				$user["fb_id"]=$row->fb_id;
				$user["name"]=$row->name;
				$user["fname"]=$row->fname;
				$user["lname"]=$row->lname;
				$user["email"]=$row->email;
				$user["not_email"]=$row->not_email;
				$user["credit"]=$row->credit;
				$user["reg_date"]=$row->reg_date;
				$user["last_login"]=$row->last_login;
				$user["refer"]=$row->refer;
				
			}else
			{
				$user["user_id"]=$uid;
				$user["fb_id"]=0;
				$user["name"]="";
				$user["fname"]="";
				$user["lname"]="";
				$user["email"]="";
				$user["not_email"]="";
				$user["credit"]=0;
				//$user["reg_date"]=;
				//$user["last_login"]=$row->last_login;
				$user["refer"]="";
			}
			return $user;
		}
		
		function accountInfo($uid)
		{
			$account=array();
			$buy_deal=array();
			$sent_gift=array();
			$receive_gift=array();
			$this->db->select('serial');
			$this->db->from('user_refer');
			$this->db->where('refer_id',$uid);
			$refer_count=$this->db->count_all_results();
			
			$this->db->select('serial');
			$this->db->from('buy_refer');
			$this->db->where('refer_id',$uid);
			$refer_buy=$this->db->count_all_results();
			
			
			$q="select d.deal_id,d.deal_title,ub.buy_date,ub.buy_id from deal d,user_buy ub where d.deal_id=ub.deal_id and ub.user_id=$uid and ub.status=1 and buy_for=0 order by ub.buy_id desc,ub.buy_date desc";
			$query=$this->db->query($q);
			
			foreach($query->result() as $row)
			{
				$deals=array();
				$deals["buy_id"]=$row->buy_id;
				$deals["deal_id"]=$row->deal_id;
				$deals["deal_title"]=$row->deal_title;
				$deals["buy_date"]=$this->common_functions->showDate($row->buy_date,false);
				$buy_deal[]=$deals;
			}
			
			$q="select d.deal_id,d.deal_title,ub.buy_date,ub.buy_id,fg.status from deal d,user_buy ub,friend_gift fg where d.deal_id=ub.deal_id and ub.deal_id=fg.deal_id and ub.buy_id=fg.buy_id and fg.user_id=$uid and ub.status=1 and buy_for=1 order by ub.buy_id desc,ub.buy_date desc";
			$query=$this->db->query($q);
			
			foreach($query->result() as $row)
			{
				$deals=array();
				$deals["buy_id"]=$row->buy_id;
				$deals["deal_id"]=$row->deal_id;
				$deals["deal_title"]=$row->deal_title;
				$deals["buy_date"]=$this->common_functions->showDate($row->buy_date,false);
				$deals["status"]=$row->status;
				$sent_gift[]=$deals;
			}
			
			$q="select d.deal_id,d.deal_title,ub.buy_date,ub.buy_id from deal d,user_buy ub,friend_gift fg where d.deal_id=ub.deal_id and ub.deal_id=fg.deal_id and ub.buy_id=fg.buy_id and fg.receiver_id=$uid and ub.status=1 and buy_for=1 order by ub.buy_id desc,ub.buy_date desc";
			$query=$this->db->query($q);
			
			foreach($query->result() as $row)
			{
				$deals=array();
				$deals["buy_id"]=$row->buy_id;
				$deals["deal_id"]=$row->deal_id;
				$deals["deal_title"]=$row->deal_title;
				$deals["buy_date"]=$this->common_functions->showDate($row->buy_date,false);
				$receive_gift[]=$deals;
			}
			
			$account["refer_count"]=$refer_count;
			$account["refer_buy"]=$refer_buy;
			$account["buy_deal"]=$buy_deal;
			$account["sent_gift"]=$sent_gift;
			$account["receive_gift"]=$receive_gift;
			return $account;
		}
		
		function userGetLastDealStatus($uid)
		{
			
			
			$deal_status=array();
			$q="select buy_id,count(status) count from callback_log cl where buy_id=(select buy_id from user_buy where user_id=$uid and status=1 order by buy_id desc limit 0,1) and cl.status=0";
			$query=$this->db->query($q);
			$count=0;
			//foreach($query->result() as $row)
			//{
				$row=$query->row();
				$deal_status['count']=$row->count;
				$deal_status['buy_id']=$row->buy_id;
			//}
			
			
			return $deal_status;
		}
		
		function getUserProfileStatus($uid,$email)
		{
			
			if($uid)
			{
				$q="select fname,lname,not_email from user where user_id=$uid";
				$query=$this->db->query($q);
				//$count=0;
				//foreach($query->result() as $row)
				//{
				$row=$query->row();
				$fname=$row->fname;
				$lname=$row->lname;
				$not_email=$row->not_email;
				
				if(isset($not_email) && !empty($not_email))
				{
					if(isset($fname) && !empty($fname))
					{
						return 0;	
					}else
					{
						return 1;
					}
					
				}else
				{
					$params=array("email"=>"$email");
					$query=$this->db->get_where("email_not",$params);
					if ($query->num_rows() > 0)
					{
						return 4;
					}else
					{
						return 2;
					}
				}
			}else
			{
				$q="select fname,lname,email from email_not where email='$email'";
				$query=$this->db->query($q);
				//$count=0;
				//foreach($query->result() as $row)
				//{
					if ($query->num_rows() > 0)
					{		
						$row=$query->row();
						$fname=$row->fname;
						$lname=$row->lname;
						$not_email=$row->email;
						
						if(isset($fname) && !empty($fname))
						{
								return 0;	
						}else
						{
								return 3;
						}
						
					}else
					{
						return 0;
					}
				
				
			}
			
			return 0;
		}
		
		function isValidCode($code,$user_id)
		{
			$this->db->select("varification_code");
			$this->db->select("status");
			$this->db->select("user_id");
			$this->db->where("varification_code",$code);
			//$this->db->where("status",0);
			$query=$this->db->get("friend_gift");
			if ($query->num_rows() > 0)
			{
				$row=$query->row();
				$status=$row->status;
				$uid=$row->user_id;
				
				if($status==0)
				{
					if($uid==$user_id)
					{
						return 3;
						
					}else
					{
						return 1;
					}
				}else
				{
					return 2;
				}
				
			}else
			{
				return 0;
			}
			
		}
		
		function claimGift($code,$user_id)
		{
			$this->db->select("buy_id");
			$this->db->select("deal_id");
			$this->db->select("friend_email");
			$this->db->where("varification_code",$code);
			$this->db->where("status",0);
			$query=$this->db->get("friend_gift");
			
			if ($query->num_rows() > 0)
			{
				$row=$query->row();
				$buy_id=$row->buy_id;
				$deal_id=$row->deal_id;
				$email=$row->friend_email;
				
				$this->db->select('gift_id');
				$this->db->where('receiver_id',$user_id);
				$this->db->where('deal_id',$deal_id);
				$this->db->where('status',1);
				
				$query=$this->db->get("friend_gift");
				if ($query->num_rows() > 0)
				{
					return 0;
					
				}else
				{
					$this->db->set("status",1);
					$this->db->set("receiver_id",$user_id);
					$this->db->where("varification_code",$code);
					$this->db->update("friend_gift");
					$this->processGift($buy_id,$deal_id,$user_id);
					
					return 1;
					
				}
			}else
			{
				return 1;
			}
		}
		
		
		function processGift($buy_id,$deal_id,$user_id)
		{
			$this->db->set("user_id",$user_id);
			$this->db->where("buy_id",$buy_id);
			$this->db->where("status",1);
			$this->db->update("user_buy");
			$this->call_callback($deal_id,$buy_id);
			
		}
		
		
		function getGameByDeal($deal_id)
		{
			$games=array();
			$param=array("deal_id"=>$deal_id);
			$this->db->select("serial");
			$query = $this->db->get_where("deal_content",$param);
			$count=0;
			foreach($query->result() as $row)
			{
				$games[$count]=$row->serial;
				$count++;
			}
			return $games;
			
			
		}
		
		function getUserBuyInfo($buy_id)
		{
			$buyInfo=array();
			$param=array("buy_id"=>$buy_id);
			//$this->db->select("serial");
			$query = $this->db->get_where("user_buy",$param);
			
			foreach($query->result() as $row)
			{
				$buyInfo["buy_id"]=$row->buy_id;
				$buyInfo["deal_id"]=$row->deal_id;
				$buyInfo["user_id"]=$row->user_id;
				$buyInfo["buy_qty"]=$row->buy_qty;
				
				
			}
			return $buyInfo;
		}
		
		function getGameInfo($serial)
		{
			$gamesInfo=array();
			$param=array("serial"=>$serial);
			//$this->db->select("serial");
			$query = $this->db->get_where("deal_content",$param);
			
			foreach($query->result() as $row)
			{
				$gamesInfo["serial"]=$row->serial;
				$gamesInfo["deal_id"]=$row->deal_id;
				$gamesInfo["game_name"]=$row->game_name;
				$gamesInfo["callback_url"]=$row->callback_url;
				$gamesInfo["credit_amt"]=$row->credit_amt;
				
			}
			return $gamesInfo;
		}
		
		function call_callback($deal_id,$buy_id)
		{
			$games = $this->getGameByDeal($deal_id);
			$buyInfo = $this->getUserBuyInfo($buy_id);
			$userInfo=$this->getUserInfo($buyInfo['user_id']);
			//echo '<pre>';
			
			for($i=0; $i<count($games); $i++)
			{
				$gamesInfo = $this->getGameInfo($games[$i]);
				//echo "<pre>";
				//print_r($gamesInfo);
					
				$path="";
				if(strstr($gamesInfo['callback_url'],"?"))
				{
					$path=$gamesInfo['callback_url']."&";
				}else
				{
					$path=$gamesInfo['callback_url']."?";
				}
				$signature=md5($deal_id."".$buy_id."".$gamesInfo['credit_amt']."".$userInfo['fb_id']);
				$path = $path."deal_id=".$deal_id."&buy_id=".$buy_id."&point=".$gamesInfo['credit_amt']."&user_id=".$userInfo['fb_id']."&signature=$signature";
				//echo $path; //exit(0);
				
				try{
						$blank=TRUE;
						$handle = fopen($path, "r");
						if($handle) 
						{
							while (!feof($handle)) 
							{
								
								$this->insertCallbacklog($buy_id,$gamesInfo['serial']);
								$blank=FALSE;
								$buffer = fgets($handle, 4096);
								if($buffer == '1')
								{
									$this->updateCallbacklog($buy_id,$gamesInfo['serial']);
									//echo '1';
								}
								else{
									//echo '0';
								}
							}
							if($blank)
							{
								$this->insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
							}
							fclose($handle);
						}
						else{
							//echo '0';
							$this->insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
							
						}	
				}catch(Exception $e)
				{
					$this->insertErrorCallbacklog($buy_id,$gamesInfo['serial']);
				}
			}
		}
		function insertCallbacklog($buy_id,$game_id)
		{
			$date=date("Y-m-d H:i:s",time());
			$param=array("buy_id"=>$buy_id,
						"game_id"=>$game_id,
						"status"=>0,
						"send_time"=>$date);
						
			$this->db->insert("callback_log",$param);
		}
		
		function insertErrorCallbacklog($buy_id,$game_id)
		{
			$date=date("Y-m-d H:i:s",time());
			$param=array("buy_id"=>$buy_id,
						"game_id"=>$game_id,
						"status"=>-1,
						"send_time"=>$date);
						
			$this->db->insert("callback_log",$param);
		}
		
		function updateCallbacklog($buy_id,$game_id)
		{
			
			$this->db->set("status",1);
			$this->db->where("buy_id",$buy_id);
			$this->db->where("game_id",$game_id);
			$this->db->update("callback_log");
		
		}
		
		function trackSignup()
		{
		
		try{
				
				$path="http://www.coinwhale.com/admin/tanalyticssignup.php";
				$handle = fopen($path, "r");
				if($handle) 
				{
					while (!feof($handle)) 
					{
						//insertCallbacklog($buy_id,$gamesInfo['serial']);
						$buffer = fgets($handle, 4096);
						//echo "$buffer";
						
					}
					fclose($handle);
				}
		}catch(Exception $ex)
		{
			
		}
		
		}
}
?>