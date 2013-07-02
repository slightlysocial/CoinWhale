<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coin Whale</title>
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?php echo base_url(); ?>css/core.css" />
<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<?=base_url()?>css/modal.css" />
</head>
<body class="splash-body">

	<div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({appId: '167246169967286', status: true, cookie: true, xfbml: true});

                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    // do something with response
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
                });
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
			
			function fbLogin()
            {
			FB.getLoginStatus(function(response) 
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
                });
              } 
			
			function fbLogout()
			{
				document.location.href = "<?=base_url()."/home/logout/"?>";
				/*FB.logout(function(response) {
				 
				});*/

			}
</script>
