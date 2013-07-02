<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coin Whale</title>
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/core.css" />
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?=base_url()?>css/modal.css" />
</head>
<body id="waves">

	<div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({appId: '167246169967286', status: true, cookie: true, xfbml: true});

                /* All the events registered */
               /* FB.Event.subscribe('auth.login', function(response) {
                    // do something with response
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
                });*/
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
			
			
			
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
                var body = 'Coin Whale';
                FB.api('/me/feed', 'post', { message: body }, function(response) {
                    if (!response || response.error) {
                        alert('Error occured');
                    } else {
                        alert('Post ID: ' + response.id);
                    }
                });
            }
			
			
			function fbLogin()
            {
				
				
			FB.getLoginStatus(function(response) 
                {
                    
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
                });
              } 
			
			
			function fbLogout()
			{
				document.location.href = "<?=base_url()."/home/logout/"?>";
				/*FB.logout(function(response) {
				 
				});*/

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
