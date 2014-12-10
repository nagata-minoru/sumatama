<?php
?>
<h1>笑顔をポイントに変えましょう</h1>
<img src="images/ic_camera_alt_black_36dp.png" width="10%"
     id="select_image_button">
<div id="message"></div>

<input type='text' id='post_message'>
<button onclick='javascript:postFeed()'>フィードへポストする</button>

<script>
  <?php // アプリケーション設定 ?>
  window.fbAsyncInit = function() {
      FB.init({
        appId      : '<?php echo(getenv('SUMATAMA_FACEBOOK_APPID'));?>',
        xfbml      : true,
        version    : 'v2.2'
      });

    <?php // ログイン処理 ?>
    function onLogin(response) {
      if (response.status != 'connected') {
	  alert('ログインして下さい');
      }
    }

    <?php // 認証処理 ?>
    FB.getLoginStatus(function(response) {
      // Check login status on load, and if the user is
      // already logged in, go directly to the welcome message.
      if (response.status == 'connected') {
        onLogin(response);
      } else {
        // Otherwise, show Login dialog first.
        FB.login(function(response) {
          onLogin(response);
        }, {scope: 'publish_actions'});
      }
    });
  };

  <?php // facebook javascript sdk の読み込み ?>
  (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="upload.js"></script>

<script src='sumatama.js'></script>
