<?
 class Deal_model extends Model{
    
        function __constructor()
        {
            parent::Model();
        }
		
		function getCurrentDeal()
		{
			$deal=array();
			$param=array("status >"=>0);
			$this->db->orderby('deal_id','desc');	
			$this->db->limit(1);
			$query=$this->db->get_where('deal',$param);
			
			
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				$deal_content=array();
				$deal["deal_id"]=$row->deal_id;
				$deal["deal_title"]=$row->deal_title;
				$deal["short_desc"]=$row->short_desc;
				$deal["price"]=number_format($row->price,0);
				$deal["retail_price"]=number_format($row->retail_price,0);
				$deal["start_date"]=$row->start_date;
				$deal["end_date"]=$this->formatDealTime($row->end_date);
				$deal["deal_date"]=$this->formatDealTime($row->start_date);
				//$deal["current_date"]=$this->formatDealTime($this->common_functions->getSystemDate());
				$deal["deal_quantity"]=$row->deal_quantity;
				$deal["deal_buy_qty"]=0;
				$deal["video_link"]=$row->vedio_link;
				$deal["deal_status"]=$row->status;
				$this->db->select_sum("buy_qty");
				$this->db->where("deal_id",$deal["deal_id"]);
				$this->db->where("status >",0);
				$res=$this->db->get("user_buy");
				if ($res->num_rows() > 0)
				{
					$row=$res->row();
					$deal["deal_buy_qty"]=$row->buy_qty;
				}
				$deal_closed=FALSE;
				
				if($this->common_functions->current_date_diff($deal["end_date"])>0)
				{
					$deal_closed=TRUE;
				}else
				{
					if($deal["deal_buy_qty"]>=$deal["deal_quantity"])
					{
						$deal_closed=TRUE;
					}
				}
				
				$deal["deal_closed"]=$deal_closed;
				$param=array('deal_id'=>''.$deal["deal_id"]);
				$res=$this->db->get_where('deal_content',$param);	
				
				foreach($res->result() as $row)
				{
					$content=array();
					$content["serial"]=$row->serial;
					$content["game_name"]=$row->game_name;
					$content["short_title"]=$row->short_title;
					$content["game_image"]=$row->game_image;
					$content["credit_amt"]=number_format($row->credit_amt,0);
					$content["credit_val"]=number_format($row->credit_val,0);
					$content["currency_name"]=$row->currency_name;
					$content["callback_url"]=$row->callback_url;
					$deal_content[]=$content;
				}
				
				$deal["deal_content"]=$deal_content;
				
			}
			
			return $deal;
			
		}
		
		function getDeal($did)
		{
			$deal=array();
			$this->db->where('deal_id',$did);
			$this->db->where('status >',0);
			$this->db->orderby('deal_id','desc');	
			$this->db->limit(1);
			$query=$this->db->get('deal');
			
			
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				$deal_content=array();
				$deal["deal_id"]=$row->deal_id;
				$deal["deal_title"]=$row->deal_title;
				$deal["short_desc"]=$row->short_desc;
				$deal["price"]=number_format($row->price,0);
				$deal["retail_price"]=number_format($row->retail_price,0);
				$deal["start_date"]=$row->start_date;
				$deal["end_date"]=$this->formatDealTime($row->end_date);
				$deal["deal_date"]=$this->formatDealTime($row->start_date);
				$deal["deal_quantity"]=$row->deal_quantity;
				$deal["deal_buy_qty"]=0;
				$deal["deal_status"]=$row->status;
				$deal["video_link"]=$row->vedio_link;
				$this->db->select_sum("buy_qty");
				$this->db->where("deal_id",$deal["deal_id"]);
				$this->db->where("status > ",0);
				$res=$this->db->get("user_buy");
				if ($res->num_rows() > 0)
				{
					$row=$res->row();
					$deal["deal_buy_qty"]=$row->buy_qty;
				}
				
				$deal_closed=FALSE;
				
				if($this->common_functions->current_date_diff($deal["end_date"])>0)
				{
					$deal_closed=TRUE;
				}else
				{
					if($deal["deal_buy_qty"]>=$deal["deal_quantity"])
					{
						$deal_closed=TRUE;
					}
				}
				$deal["deal_closed"]=$deal_closed;
				
				$param=array('deal_id'=>''.$deal["deal_id"]);
				$res=$this->db->get_where('deal_content',$param);	
				
				foreach($res->result() as $row)
				{
					$content=array();
					$content["serial"]=$row->serial;
					$content["game_name"]=$row->game_name;
					$content["short_title"]=$row->short_title;
					$content["game_image"]=$row->game_image;
					$content["credit_amt"]=number_format($row->credit_amt,0);
					$content["credit_val"]=number_format($row->credit_val,0);
					$content["currency_name"]=$row->currency_name;
					$content["callback_url"]=$row->callback_url;
					$deal_content[]=$content;
				}
				
				$deal["deal_content"]=$deal_content;
				
			}
			
			return $deal;
			
		}
		function processDeal($deal_id,$user_id,$deal,$pay_type=1)
		{
			$buy_id=0;
			$purchase_type=$this->input->post('purchase_type');
			$friend_email=$this->input->post('friend_email');
			$date=date("Y-m-d",time());
			
			if($purchase_type==0)
			{
				$args=array("deal_id"=>$deal_id,
							"user_id"=>$user_id,
							"buy_for"=>0,
							"status"=>1);
							
				$query=$this->db->get_where("user_buy",$args);
				
				if ($query->num_rows() > 0)
				{
					return 0;	
				}else
				{			
				
					$params=array("user_id"=>$user_id,
					"deal_id"=>$deal_id,
					"buy_qty"=>1,
					"pro_price"=>"".$deal["price"],
					"total_price"=>"".$deal["price"],
					"total_retail"=>"".$deal["retail_price"],
					"pay_type"=>$pay_type,
					"status"=>0,
					"buy_for"=>$purchase_type,
					"buy_date"=>"$date"
					);
				
					if($this->db->insert("user_buy",$params))
					{
						$buy_id=$this->db->insert_id();
					}
					return $buy_id;
				}
			}else
			{
					$params=array("user_id"=>$user_id,
					"deal_id"=>$deal_id,
					"buy_qty"=>1,
					"pro_price"=>"".$deal["price"],
					"total_price"=>"".$deal["price"],
					"total_retail"=>"".$deal["retail_price"],
					"pay_type"=>$pay_type,
					"status"=>0,
					"buy_for"=>$purchase_type,
					"buy_date"=>"$date"
					);
				
					if($this->db->insert("user_buy",$params))
					{
						$buy_id=$this->db->insert_id();
						$varification_code=md5("".$buy_id."".$friend_email);
						$params=array("buy_id"=>$buy_id,
						"user_id"=>$user_id,
						"deal_id"=>$deal_id,
						"friend_email"=>"".$friend_email,
						"varification_code"=>$varification_code,
						"status"=>0,
						"date"=>"".$date);
						$this->db->insert("friend_gift",$params);
							
					}
					return $buy_id;
			}
		}
		/*function processDeal($deal_id,$user_id,$deal,$pay_type=1)
		{
			$buy_id=0;
			$purchase_type=$this->input->post('purchase_type');
			$friend_email=$this->input->post('friend_email');
			$date=date("Y-m-d",time());
			
			$args=array("deal_id"=>$deal_id,
						"user_id"=>$user_id,
						"status"=>1);
						
			$query=$this->db->get_where("user_buy",$args);
			
			if ($query->num_rows() > 0)
			{
				return 0;	
			}else
			{			
			
			$params=array("user_id"=>$user_id,
			"deal_id"=>$deal_id,
			"buy_qty"=>1,
			"pro_price"=>"".$deal["price"],
			"total_price"=>"".$deal["price"],
			"total_retail"=>"".$deal["retail_price"],
			"pay_type"=>$pay_type,
			"status"=>0,
			"buy_for"=>$purchase_type,
			"buy_date"=>"$date"
			);
			
				if($this->db->insert("user_buy",$params))
				{
					$buy_id=$this->db->insert_id();
					
					if($purchase_type==1)
					{
						$varification_code=md5($buy_id);
						$params=array("buy_id"=>$buy_id,
						"user_id"=>$user_id,
						"deal_id"=>$deal_id,
						"friend_email"=>"".$friend_email,
						"varification_code"=>$varification_code,
						"status"=>0,
						"date"=>"".$date);
						$this->db->insert("friend_gift",$params);
						
					}
				}
				return $buy_id;
			}
		}*/
		
		function processHash($buy_id,$hash)
		{
			//$buy_id=0;
			$date=date("Y-m-d",time());
			
			$params=array("buy_id"=>$buy_id,
						"refer_id"=>"".$hash);
						
			
			
				return $this->db->insert("user_buy_refer",$params);
				
				
			
		}
		
		function processSpareDeal($deal_id,$user_id,$deal,$pay_type=1)
		{
			$buy_id=0;
			$date=date("Y-m-d",time());
			
			/*$args=array("deal_id"=>$deal_id,
						"user_id"=>$user_id,
						"status"=>1);
						
			$query=$this->db->get_where("user_buy",$args);
			
			if ($query->num_rows() > 0)
			{
				return 0;	
			}else
			{		*/	
			
			$params=array("user_id"=>$user_id,
			"deal_id"=>$deal_id,
			"buy_qty"=>1,
			"pro_price"=>"".$deal["price"],
			"total_price"=>"".$deal["price"],
			"total_retail"=>"".$deal["retail_price"],
			"pay_type"=>$pay_type,
			"status"=>0,
			"buy_date"=>"$date"
			);
			
				if($this->db->insert("user_buy",$params))
				{
					$buy_id=$this->db->insert_id();
				}
				return $buy_id;
			//}
		}
		
		function getRecentDeals()
		{
			$all_deal=array();
			$this->db->where('status >',0);
			$this->db->orderby('deal_id','desc');	
			//$this->db->limit(1);
			$query=$this->db->get('deal');
			
			$i=0;
			foreach($query->result() as $row)
			{
				if($i!=0){
				$deal=array();
				//$row=$query->row();
				$deal_content=array();
				$deal["deal_id"]=$row->deal_id;
				$deal["deal_title"]=$row->deal_title;
				$deal["short_desc"]=$row->short_desc;
				$deal["price"]=number_format($row->price,0);
				$deal["retail_price"]=number_format($row->retail_price,0);
				$deal["start_date"]=$this->common_functions->showDate($row->start_date,false);
				$deal["end_date"]=$this->common_functions->showDate($row->end_date,false);
				$deal["deal_quantity"]=$row->deal_quantity;
				$deal["deal_buy_qty"]=0;
				$this->db->select_sum("buy_qty");
				$this->db->where("deal_id",$deal["deal_id"]);
				$this->db->where("status",1);
				$res=$this->db->get("user_buy");
				if ($res->num_rows() > 0)
				{
					$row=$res->row();
					$deal["deal_buy_qty"]=$row->buy_qty;
				}
				
				$deal_closed=FALSE;
				
				if($this->common_functions->current_date_diff($deal["end_date"])>0)
				{
					$deal_closed=TRUE;
				}else
				{
					if($deal["deal_buy_qty"]>=$deal["deal_quantity"])
					{
						$deal_closed=TRUE;
					}
				}
				$deal["deal_closed"]=$deal_closed;
				
				$param=array('deal_id'=>''.$deal["deal_id"]);
				$res=$this->db->get_where('deal_content',$param);	
				
				foreach($res->result() as $row)
				{
					$content=array();
					$content["serial"]=$row->serial;
					$content["game_name"]=$row->game_name;
					$content["short_title"]=$row->short_title;
					$content["game_image"]=$row->game_image;
					$content["credit_amt"]=number_format($row->credit_amt,0);
					$content["credit_val"]=number_format($row->credit_val,0);
					$content["currency_name"]=$row->currency_name;
					$content["callback_url"]=$row->callback_url;
					$deal_content[]=$content;
				}
				
				$deal["deal_content"]=$deal_content;
				
				$all_deal[]=$deal;
				}
				$i++;
			}
			
			return $all_deal;
			
		}
		
		function formatDealTime($date)
		{
			
			//return 
			
			$fdatetime="";
			$dateTime=strtotime($date);
			
			return date("m/d/Y h:i:s A",$dateTime);
			
		}
		
		function getDealSummery()
		{
			$summery=array();
			//$query=$this->db->get();
			$member=0;
			$total=0;
			$total_price=0;
			$total_retail=0;
			$total_save=0;
			$member=$this->db->count_all("user");
			$this->db->select_sum("buy_qty");
			$this->db->select_sum("total_price");
			$this->db->select_sum("total_retail");
			$this->db->where("status",1);
			$query=$this->db->get("user_buy");
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				$total=$row->buy_qty;
				$total_price=$row->total_price;
				$total_retail=$row->total_retail;
				$total_save=$total_retail-$total_price;
			}
			
			$summery["member"]=number_format($member,0);
			$summery["save"]=number_format($total_save,2);
			$summery["total"]=number_format($total,0);
			$summery["total_price"]=number_format($total_price,2);
			$summery["total_retail"]=number_format($total_retail,2);
			
			return $summery;
			
		}
		
		function hasGift($deal_id,$email)
		{
			$param=array("deal_id"=>$deal_id,
						  "friend_email"=>$email);
			$query=$this->db->get_where("friend_gift",$param);
			
			if ($query->num_rows() > 0)
			{
				return TRUE;
			}else
			{
				return FALSE;
			}
		}
		
		function isMyEmail($user_id,$email)
		{
			$this->db->select('user_id');
			
			$this->db->where('user_id',$user_id);
			$this->db->like('not_email', $email);
			
			$query=$this->db->get("user");
			if ($query->num_rows() > 0)
			{
				return TRUE;
			}else
			{
				return FALSE;
			}  
		}
		
		function resendGift($buy_id,$email)
		{
			$varification_code=md5("".$buy_id."".$email);
			$this->db->set("friend_email",$email);
			$this->db->set("varification_code",$varification_code);
			$this->db->where("buy_id",$buy_id);
			$this->db->where("status",0);
			
			return $this->db->update("friend_gift");
			
			
			
		}
		
		function getVerificationCode($buy_id)
		{
			$code="";
			
			$this->db->select('varification_code');
			$this->db->where('buy_id',$buy_id);
			$query=$this->db->get('friend_gift');
			if ($query->num_rows() > 0)
			{
				
				$row=$query->row();
				$code=$row->varification_code;
			}
			
			return $code;
		}
		
		function getDealTextContent($deal_id)
		{
			$content="";
			$this->db->select('game_name');
			$this->db->select('game_url');
			$this->db->where('deal_id',$deal_id);
			$res=$this->db->get('deal_content');
			$count=1;
			foreach($res->result() as $row)
			{
				$name=$row->game_name;
				$url=$row->game_url;
				if($count==1)
				{
					$content.="<a href='$url'>$name</a>";
					
				}else
				{
					$content.=", <a href='$url'>$name</a>";
				}
				
				$count++;
			}
			
			return $content;
			
			
		}
}
?>