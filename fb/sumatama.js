function postFeed() {
  FB.getLoginStatus(function(status) {
    if (status.status != 'connected') {
      alert('ログインして下さい');
      return;
    }

    auth = status.authResponse;
    var postData = {
      'user_id': auth.userID,
      'access_token': auth.accessToken,
      'message': $('#message').val()
    }

    console.log(postData);

    $.post('post_feed.php', postData).done(function(result) {
      if (result == 'success') alert('タイムラインに投稿しました');
      else                     alert(result);
    });
  });
}
