<?php
?>
<html>
  <head>
  </head>
  <body>
    <h1 id="fb-welcome"></h1>
    <h2>スマイルでポイントが貯まるアプリへようこそ</h2>
    <input type='text' id='message'>
    <button onclick='javascript:postFeed()'>フィードへポストする</button>
    <a href='photo.php'>スマイルを投稿する</a>
    <script>
      <?php // アプリケーション設定 ?>
      window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo(getenv('SUMATAMA_APPID'));?>',
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

    <script src='//code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src='sumatama.js'></script>
  </body>
</html>
