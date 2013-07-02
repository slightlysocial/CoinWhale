<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:app_id" content="167246169967286">
<meta property="og:title" content="Goblins Guns and Gore" />
<meta property="og:site_name" content="Coin Whale" />
<meta property="og:description" content="Do you like big discounts? Do you like Facebook Games? Get $50 free at 3 really sweet Facebook games at CoinWhale.com!  $10 gets you $60 at Tyrant, Mercenaries of War and Dawn of the Dragons." />
<meta property="og:image" content="<?=base_url()?>images/CoinWhale_Logo.png" />
<title>Coin Whale</title>
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/core.css?a" />
<script src="<?php echo base_url(); ?>javascript/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>javascript/jquery.fancybox-1.3.3/fancybox/jquery.fancybox-1.3.3.pack.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>javascript/jquery.fancybox-1.3.3/fancybox/jquery.fancybox-1.3.3.css" type="text/css" media="screen" />

</head>
<body>
<?
error_reporting(0);
?>
	<div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
               /* FB.init({appId: '167246169967286', status: true, cookie: true, xfbml: true});*/
			   FB.init({appId: '167246169967286', status: true, cookie: true, xfbml: true});

                /* All the events registered */
               // FB.Event.subscribe('auth.login', function(response) {
//                    // do something with response
//                    login();
//                });
//                FB.Event.subscribe('auth.logout', function(response) {
//                    // do something with response
//                    logout();
//                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
			
			function fbLogin(reg)
            {
				
				
				FB.getLoginStatus(function(response) 
                {
                    
					//alert(""+response.status);
					if(response.status=='notConnected')
					{
							$(document).ready(function() {
							$.fancybox({
								'autoScale'				: true,
								'autoDimensions'	: true,
								'transitionIn'		: 'none',
								'transitionOut'		: 'none',
								'type'						: 'ajax',
								'height'					: 425,
								'href'              : '<?=base_url()."ajax/showregistration/"?>'
							});
							
					
						});
						
					}else
					{
							if(reg==0)
							{
								
								$(document).ready(function() {
								$.fancybox({
									'autoScale'				: true,
									'autoDimensions'	: true,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'type'						: 'ajax',
									'height'					: 425,
									'href'              : '<?=base_url()."ajax/showregistration/"?>'
								});
								
						
							});
								
							}else
							{
								
								if (response.session)
								{
									
									document.location.href = "<?=base_url()."/home/login/"?>";
								}else
								{
									FB.login(function(response) 
									{
										if (response.session) 
										{
										   
											document.location.href = "<?=base_url()."/home/login/"?>";
										}
										else 
										{
											// user cancelled login
										}
									}, {perms:'read_stream,publish_stream,email'}
									
									);
								}
								
							}
							
							
						}
                });
              } 
			
			function fbLogout()
			{
				document.location.href = "<?=base_url()."/home/logout/"?>";
				/*FB.logout(function(response) {
				 
				});*/

			}
			
            function login(){
                document.location.href = "<?=base_url()?>";
            }
            function logout(){
                document.location.href = "<?=base_url()?>";
            }
			
			 function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
                FB.ui(
                {
                    method: 'stream.publish',
                    message: '',
                    attachment: {
                        name: name,
                        caption: '',
                        description: (description),
                        href: hrefLink
                    },
                    action_links: [
                        { text: hrefTitle, href: hrefLink }
                    ],
                    user_prompt_message: userPrompt
                },
                function(response) {

                });

            }
			
			function publishFeed(slink)
			{

				
				FB.ui(
				   {
					 method: 'feed',
					 name: 'I just got $50 in free game credits!',
					 link: ''+slink,
					 picture: '<?=base_url()?>images/CoinWhale_Logo.png',
					 caption: '',
					 description: 'I just spent $10 and got $50 in free game currency at Tyrant, Mercenaries of War & Dawn of the Dragons at CoinWhale.com!',
					 message: ''
				   },
				   function(response) {
					 if (response && response.post_id) {
					   //alert('Post was published.');
					 } else {
					   //alert('Post was not published.');
					 }
				   }
				 );

			}
            function showStream(){
                FB.api('/me', function(response) {
                    //console.log(response.id);
                    streamPublish(response.name, 'Coin Whale', 'hrefTitle', 'http://www.coinwhale.com/', "Share Coin Whale");
                });
            }

            function share(url){
                var share = {
                    method: 'stream.share',
                    u: ''+url
                };

                FB.ui(share, function(response) { console.log(response); });
            }

            function graphStreamPublish(){
                var body = 'I just spent $10 and got $50 in free game currency at Tyrant, Mercenaries of War & Dawn of the Dragons at CoinWhale.com!';
                FB.api('/me/feed', 'post', { message: body }, function(response) {
                    if (!response || response.error) {
                        alert('Error occured');
                    } else {
                        alert('Post ID: ' + response.id);
                    }
                });
            }

            function fqlQuery(){
                FB.api('/me', function(response) {
                     var query = FB.Data.query('select name, hometown_location, sex, pic_square from user where uid={0}', response.id);
                     query.wait(function(rows) {

                       document.getElementById('name').innerHTML =
                         'Your name: ' + rows[0].name + "<br />" +
                         '<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";
                     });
                });
            }

            function setStatus(){
                status1 = document.getElementById('status').value;
                FB.api(
                  {
                    method: 'status.set',
                    status: status1
                  },
                  function(response) {
                    if (response == 0){
                        alert('Your facebook status not updated. Give Status Update Permission.');
                    }
                    else{
                        alert('Your facebook status updated');
                    }
                  }
                );
            }
</script>

<script type="text/javascript">

function submitEmail()
{
	var value=document.getElementById('email').value;
	 var div=document.getElementById('mail-div');
	 
	 if(div)
	 {
		 $.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/submitEmail/",
			data: "email=" + value,
			success: function(msg){
				div.innerHTML=msg;
			},
			error: function(msg){
				alert(msg);
			}
		});
		
	 }
}
	$(document).ready(function() {
		var mylink=document.getElementById('mylink');
		if(mylink)
		{
			$("a.link").fancybox({
				'autoScale'				: true,
				'autoDimensions'	: true,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'						: 'ajax'
			});
		
		}

	});
	
	function spendCredits()
	{
		$.fancybox({
									
									'titlePosition'		: 'inside',
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'content'			: '<div style="padding:20px;"><b>This spend credits feature is currently unavailable. We will be adding it soon.</b></div>'
								});
	}
</script>
    
  <div id="container">
	<div id="header">
  	<div id="branding">
    	<a href="<?=base_url()?>"><img src="<?php echo base_url(); ?>images/logo.png" width="348" height="128" /></a></div>
    <div id="site-phone"><h1>1-866-838-6203</h1></div>    
    <div id="site-social">
      <ul>
        <li><a href="http://www.facebook.com/pages/CoinWhale/136211083095994" title="Connect With Us on Facebook" target="_blank"><img src="<?php echo base_url(); ?>images/facebook.gif" width="24" height="24" /></a></li>
        <li><a href="http://twitter.com/#!/coinwhale" title="Follow Us on Twitter" target="_blank"><img src="<?php echo base_url(); ?>images/twitter.gif" width="24" height="24" /></a></li>
        <li><fb:like href="http://www.facebook.com/pages/CoinWhale/136211083095994" layout="button_count" show_faces="false"></fb:like></li>
       
      </ul>
    </div>
  <div id="member">
  		 <?
        if($isLogin)
		{
			//echo '<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>';
		?>
        
      	<ul id="member-nav">
       
        	<li><? echo anchor("account/","My Account");?></li>
          <li><span class="separator">|</span><a href="<?=base_url()?>ajax/mylink/" class="link" id="mylink">Get My Link</a> <span class="coin">+10</span> </li>
          <li><span class="separator">|</span><a href="#" onclick="fbLogout()">Logout</a></li>
        </ul>
        <div id="member-profile">
        	<img src="<? echo "https://graph.facebook.com/$uid/picture"; ?>" height="50" width="50" />
          <ul>
          	<li class="name"><?=$name?></li>
            <li><?=$not_email?></li>
            <li><span class="coin"><?=$credit?> Credits</span> <span class="separator"></span><a href="#" onclick="spendCredits()" title="Spend Credits">Spend</a> (soon)</li>
          </ul>
          <div class="clear"></div>
        </div>
        <?
		}else
		{
			//echo '<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>';
			if($isRegistered)
			{
				echo "<a href='#' onclick='fbLogin(0)'><img src='".base_url()."images/facebook-connect.gif'/></a>";
			}else
			{
				echo "<a href='#' onclick='fbLogin(0)'><img src='".base_url()."images/facebook-connect.gif'/></a>";
			}
			echo ' <p>
          Login with your facebook account <br /><span class="coin">+ 1 CoinWhale Credit</span>        </p>';
		}
		?>
        <div id="mail-div">
        <?
		//echo "email:$not_email";
        if(isset($not_email) && !empty($not_email))
		{
			
			
		}else
		{
		?>
        <div id="member-email">
        	
        	<input type="text" class="input" value="" name="email" id="email" />
            <input type="image" class="submit" src="<?php echo base_url(); ?>images/submit.png" alt="submit" onclick="submitEmail()">
         
        </div>
       <?
		   if($isLogin)
			{
		   
			echo '<p>
			  Get the latest deals to your inbox <br /><span class="coin">+ 50 CoinWhale Credit</span>        </p>';
			 
			}
		}
	   	?>
       </div>
      
    </div>
  </div>
  <div id="navigation">
    <? $this->load->view('menu',$m);?>
    <div class="clear"></div>
  </div>