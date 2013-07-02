<?
 class Purchase_model extends Model{
    
        function __constructor()
        {
            parent::Model();
        }
		
		function getDealInfo($bid)
		{
			$deal=array();
			
			$output="";
			$title="";
			$price=0;
			$retail_price=0;
			$deal_id=0;
			//$param=array("deal_id"=>$did);
			//$this->db->select('deal_title,price,retail_price');
			$q="SELECT d.deal_id,d.deal_title,price,retail_price from deal d,user_buy ub where d.deal_id=ub.deal_id and ub.buy_id=$bid";
			$query=$this->db->query($q);
			
			if($query->num_rows()>0)
			{
				$row=$query->row();
				$title=$row->deal_title;	
				$price=$row->price;
				$retail_price=$row->retail_price;
				$deal_id=$row->deal_id;
			}
			
			
			$q="SELECT dc.game_name,cl.status,cl.serial FROM deal_content dc left join callback_log cl on (dc.serial=cl.game_id and cl.buy_id=$bid) where dc.deal_id=$deal_id";
			$query=$this->db->query($q);
			
			foreach($query->result() as $row)
			{
				$output .= "<tr>";
              	$output .= "<td><a href='#'>".$row->game_name."</a></td>";
              	if($row->status==1)
				{
					$output .= "<td>CLAIMED</td>";
				}else if($row->status==NULL)
				{
					$output .= "<td>&nbsp;</td>";
				}
				else if($row->status==0)
				{
					$output .= "<td><div id='claim_".$row->serial."'>UNCLAIMED &nbsp;&nbsp;<a href='#anchr' class='f1' onclick='redeemCoin(".$row->serial.")'>CLAIM NOW</a></div></td>";
				}else if($row->status==-1)
				{
					$output .= "<td><div id='claim_".$row->serial."'>UNCLAIMED &nbsp;&nbsp;<a href='#anchr' class='f1' onclick='redeemCoin(".$row->serial.")'>CLAIM NOW</a></div></td>";
				}
				
          		$output .= "</tr>";
			}
			
			$deal["title"]=$title;
			$deal["output"]=$output;
			$deal["retail_price"]=$retail_price;
			$deal["price"]=$price;
			return $deal;
			
		}
		
		
		function getSentDealInfo($bid)
		{
			$deal=array();
			
			$output="";
			$title="";
			$price=0;
			$retail_price=0;
			$deal_id=0;
			$resend=1;
			$friend_email="";
			$verification_code="";
			//$param=array("deal_id"=>$did);
			//$this->db->select('deal_title,price,retail_price');
			$q="SELECT d.deal_id,d.deal_title,price,retail_price from deal d,user_buy ub where d.deal_id=ub.deal_id and ub.buy_id=$bid";
			$query=$this->db->query($q);
			
			if($query->num_rows()>0)
			{
				$row=$query->row();
				$title=$row->deal_title;	
				$price=$row->price;
				$retail_price=$row->retail_price;
				$deal_id=$row->deal_id;
			}
			
			
			$q="SELECT dc.game_name FROM deal_content dc where dc.deal_id=$deal_id";
			$query=$this->db->query($q);
			
			foreach($query->result() as $row)
			{
				$output .= "<tr>";
              	$output .= "<td><a href='#'>".$row->game_name."</a></td>";
              
				$output .= "<td>&nbsp;</td>";
				
          		$output .= "</tr>";
			}
			
			$q="select friend_email,status,varification_code from friend_gift where buy_id=$bid";
			$query=$this->db->query($q);
			
			if($query->num_rows()>0)
			{
				$row=$query->row();
				$resend=$row->status;
				$friend_email=$row->friend_email;
				$verification_code=$row->varification_code;
			}
			
			$deal["buy_id"]=$bid;
			$deal["deal_id"]=$deal_id;
			$deal["title"]=$title;
			$deal["output"]=$output;
			$deal["retail_price"]=$retail_price;
			$deal["price"]=$price;
			$deal["resend"]=$resend;
			$deal["friend_email"]=$friend_email;
			$deal["verification_code"]=$verification_code;
			return $deal;
			
		}
		
		function getDealInstallInfo($bid)
		{
			$deal=array();
			
			$output="";
			$gameNames="";
			$gameLinks="";
			$title="";
			$price=0;
			$retail_price=0;
			$deal_id=0;
			//$param=array("deal_id"=>$did);
			//$this->db->select('deal_title,price,retail_price');
			$q="SELECT d.deal_id,d.deal_title,price,retail_price from deal d,user_buy ub where d.deal_id=ub.deal_id and ub.buy_id=$bid";
			$query=$this->db->query($q);
			
			if($query->num_rows()>0)
			{
				$row=$query->row();
				$title=$row->deal_title;	
				$price=$row->price;
				$retail_price=$row->retail_price;
				$deal_id=$row->deal_id;
			}
			
			
			
			$q="SELECT dc.game_name,dc.game_url,cl.status,cl.serial FROM deal_content dc left join callback_log cl on (dc.serial=cl.game_id and cl.buy_id=$bid) where dc.deal_id=$deal_id and cl.status=0";
			$query=$this->db->query($q);
			$c=0;
			foreach($query->result() as $row)
			{
				
              	
					$gameNames =strtoupper($row->game_name);
					$gameLinks .= "<div style='text-align:left'>$gameNames (<a href='".$row->game_url."' target='_blank'>".$row->game_url."</a>)</div><div class='sp'></div>";
				
					//$c++;
			}
			$deal["buy_id"]=$bid;
			$deal["title"]=$title;
			$deal["game_names"]=$gameNames;
			$deal["game_links"]=$gameLinks;
			$deal["retail_price"]=$retail_price;
			$deal["price"]=$price;
			return $deal;
			
		}
}
?>