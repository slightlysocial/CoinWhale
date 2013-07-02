<?
$url=site_url();
$menu=array(array('todays-deal',$url.'home/'),
			array('recent-deals',$url.'deals/'),
			array('how-it-works',$url.'howitworks/'),
			array('contact-us',$url.'contactus/'));
echo '<ul>';

		for($i=0;$i<count($menu);$i++)
		{
			$mn=$menu[$i];
			if($m==$i)
			{
				echo '<li id="'.$menu[$i][0].'" class="selected"><a href="'.$menu[$i][1].'"></a></li>';
			}else
			{
				echo '<li id="'.$menu[$i][0].'"><a href="'.$menu[$i][1].'"></a></li>';
			}
			
		}
echo'</ul>';
?>