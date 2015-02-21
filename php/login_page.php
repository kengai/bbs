<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ログイン画面</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
  //When form was submitted
  function when_submit(){
    //サブミットチェック用の変数を宣言
    var checkSubmit = true;
    
    //ログインパスの入力チェック
    if ($("#login_pass").val() == ""){
      //未入力のためサブミットさせない
      checkSubmit = false;
    }
    
    //ユーザー名の入力チェック
    if ($("#uname").val() == ""){
      //空なのでサブミットさせない
      checkSubmit = false;
    }
    //チェックサブミット用の変数をチェック
    return checkSubmit;
  }
  $("form").submit(when_submit());
</script>
</head>
<body>
  
</body>
</html>
