<?php
?>
<html>
  <head>
  </head>
  <body>
    <h1 id="fb-welcome"></h1>
    <h2>スマイルでポイントが貯まるアプリへようこそ</h2>
    <script>
     <?php // アプリケーション設定 ?>
     window.fbAsyncInit = function() {
	 FB.init({
	   appId      : '980956188585558',
	   xfbml      : true,
	   version    : 'v2.2'
	 });

       <?php // ログイン処理 ?>
       function onLogin(response) {
	 if (response.status == 'connected') {
	   FB.api('/me?fields=first_name&locale=ja_JP', function(data) {
	     var welcomeBlock = document.getElementById('fb-welcome');
	     welcomeBlock.innerHTML =
               'こんにちは、' + data.first_name + 'さん！';
	   });
	 }
       }

       FB.getLoginStatus(function(response) {
	 // Check login status on load, and if the user is
	 // already logged in, go directly to the welcome message.
	 if (response.status == 'connected') {
	   onLogin(response);
	 } else {
	   // Otherwise, show Login dialog first.
	   FB.login(function(response) {
	     onLogin(response);
	   }, {scope: 'user_friends, email'});
	 }
       });
     };

     (function(d, s, id){
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) {return;}
	 js = d.createElement(s); js.id = id;
	 js.src = "//connect.facebook.net/ja_JP/sdk.js";
	 fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
    </script>
  </body>
</html>
