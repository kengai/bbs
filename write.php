<?php
	#データ受け取り
	$body = $_POST['body'];
	$pass = $_POST['pass'];
	$title = $_POST['title'];
	$name = $_POST['name'];

	#必須項目チェック(本文が空ではないか)
	if($body == '' || $name == '')
	{
		header('location: bbs.php'); //bbs.phpへ移動
		exit();
	}
	#必須項目チェック(パスワードは4桁の数字か)
	if(!preg_match("/^[0-9]{4}$/", $pass))
	{
		header('Location: bbs.php');
		exit();
	}
	
	#データベースに接続
	$dsn = 'mysql:host=localhost;dbname=anyone;charset=utf8';
	$user = 'anyuser';
	$password = 'anyoneuser'; //anyuserに設定したパスワード
	
	try
	{
		$db = new PDO($dsn, $user, $password);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		#プリペアドステートメントを作成
		$stmt = $db->prepare("
			INSERT INTO bbs (name, title, body, date, pass)
			VALUES (:name, :title, :body, now(), :pass)"
			);
		#パラメータ割り当て
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':body', $body, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		#クエリの実行
		$stmt -> execute();
		
		#bbs.phpに戻る
		header('Location: bbs.php');
		exit();
	}
	catch(PDOException $e)
	{
		die('Error!：' . $e->getMessage());
	}
	
?>
