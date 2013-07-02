<?
class Common_functions
{
	public function __construct() 
	{
		
	}
	
	function renderBox($width=0,$height=18,$value="",$c1="",$c2="",$maxWidth=250)
	{
		$h1=($height-4)/2;
		$t1=2;
		$t2=$h1+$t1;
		
		echo '<div style="position: relative; width: '.$maxWidth.'px; height: '.$height.'px; background-color:#ffffff;border 1px solid #7CADC4;">
			<div style="position: absolute; top: '.$t1.'px; left: 2px; width: '.$width.'px; height: '.$h1.'px; background-color:'.$c1.';"> </div>
			<div style="position: absolute; top: '.$t2.'px; left: 2px; width: '.$width.'px; height: '.$h1.'px; background-color:'.$c2.';"> </div>
			
			<div style="position: absolute; top: 2px; left: 1px; width: '.$maxWidth.'px; height: '.$height.'px; text-align: center; color: rgb(0, 0, 0); font-size:12px;"> <table cellspacing="0" width="100%" cellpading="0"><tbody><tr><td style="height: '.$height.'px; text-align: center;">'.$value.'</td></tr></tbody></table></div>
			</div>';
	}
	
	function getSystemDate($hr = 0, $datetime = true){
	
			$time = time() + ($hr * 60 * 60);
			if($datetime){
				return date("Y-m-d H:i:s", $time);
			}else{
				return date("Y-m-d", $time);
			}
		}
		
		function getSystemDateOnly($d = 0)
		{
			$time = time() + ($d * 24 * 60 * 60);
			return date("Y-m-d", $time);
		}
		
		function pv($id, $defaultValue = "")
		{
			if(isset($_POST[$id]))
			{
				return trim($_POST[$id]);
			}else
			{
				return $defaultValue;
			}
		}
		
		function gv($id, $defaultValue = "")
		{
			if(isset($_GET[$id]))
			{
				return trim($_GET[$id]);
			}else
			{
				return $defaultValue;
			}
		}
		
		function showDate($date, $time = true)
		{ 
			if($time)
			{
				return $this->format_datetime($date, "F j, Y, g:i a");
			}else
			{
				return $this->format_datetime($date, "F j, Y");
			}
		}
		
		function showDateShort($date)
		{
			return $this->format_datetime($date, "h:i a").format_datetime($date, " M d, Y");
		}
		
		function showMonthDate($date)
		{ 
			return $this->format_datetime($date, "M Y");
		}
		
		
		function format_datetime($datetime, $format)
		{
			$pieces = explode(" ", $datetime);
			$date = $pieces[0];
			if(isset($pieces[1]))
			{
				$time = $pieces[1];
			}else
			{
				$time = -1;
			}
		
			$dpieces = explode("-", $date);
			$year = $dpieces[0]; 
			$month = $dpieces[1]; 
			
			$day = $dpieces[2];
			if($time != -1)
			{
				$tpieces = explode(":", $time);
				$hour = $tpieces[0]; $min = $tpieces[1]; $sec = $tpieces[2];	
		
				return date($format, mktime($hour, $min, $sec, $month, $day, $year));
			}else
			{
				return date($format, mktime(0, 0, 0, $month, $day, $year));
			}
		}
		
		function format_date($date, $format)
		{
			$dpieces = explode("-", $date);
			$year = $dpieces[0]; 
			$month = $dpieces[1]; 
			$day = $dpieces[2];
			echo $year;
			echo $month;
			echo $day;
			return date($format, mktime(0, 0, 0, $month, $day, $year));
			
		}
		
		function current_date_diff($date)
		{
			$time=strtotime($date);
			
			$current=time();
			
			return ($current-$time);
		}
		
	function listUnsubscribe($email,$list_id="934d229e2c")
	{
		// Validation
		//if(!$_GET['email']){ return "No email address provided"; } 
	
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email)) {
			return "Email address is invalid"; 
		}
	
		require_once('MCAPI.php');
		// grab an API Key from http://admin.mailchimp.com/account/api/
		$api = new MCAPI('d5aceafc493bcad5615c9c66ef3ef969-us2');
		
		// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
		// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
		if($api->listUnsubscribe($list_id, $email, true) === true) 
		{
			// It worked! 
			echo "1";
		}else{
			$date = date("Y-m-d H:i:s");
			$q = "insert into mailchimp_error values('','List UnSubscribe','$email','".$api->errorCode."','".$api->errorMessage."','$date')";
			executeQuery($q);
			// An error ocurred, return error message 
			echo "0";
		}
	}		
	function updateListSubscribe($email,$list_id="934d229e2c",$marge)
	{
		// Validation
		//if(!$_GET['email']){ return "No email address provided"; } 
		
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email)) {
			return "Email address is invalid"; 
		}
	
		require_once('MCAPI.php');
		// grab an API Key from http://admin.mailchimp.com/account/api/
		$api = new MCAPI('d5aceafc493bcad5615c9c66ef3ef969-us2');
		
		// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
		// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
		if($api->listUpdateMember($list_id, $email, $marge) === true) 
		{
			// It worked! 
			return 'Congratulation! Your information has been updated.';
		}else{
			$date = date("Y-m-d H:i:s");
			$q = "insert into mailchimp_error values('','Update List Subscribe','$email','".$api->errorCode."','".$api->errorMessage."','$date')";
			executeQuery($q);
			// An error ocurred, return error message 
			return 'Error: ' . $api->errorMessage;
		}
	}		
	function storeAddress($email,$list_id="934d229e2c",$merge=''){
		
		// Validation
		//if(!$_GET['email']){ return "No email address provided"; } 
	
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email)) {
			return "Email address is invalid"; 
		}
	
		require_once('MCAPI.php');
		// grab an API Key from http://admin.mailchimp.com/account/api/
		$api = new MCAPI('d5aceafc493bcad5615c9c66ef3ef969-us2');
		
		// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
		// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
		
	
		if($api->listSubscribe($list_id, $email, $merge, 'html', true) === true) {
			// It worked!	
			
			
				return 'Thanks, confirm your registration to be entered.';
			
			
		}else{
			$date = date("Y-m-d H:i:s");
			$q = "insert into mailchimp_error values('','List Subscribe','$email','".$api->errorCode."','".$api->errorMessage."','$date')";
			executeQuery($q);
			// An error ocurred, return error message	
			if($api->errorCode==214)
			{
				return $this->updateListSubscribe($email,$list_id,$merge);
			}else
			{
				return 'Error: ' . $api->errorMessage;
			}
		}
		
	}
		
}