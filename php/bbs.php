<?php
	//1ページに表示されるコメントの数
	$num = 20;
	
	//データベースに接続
	$dsn = 'mysql:host=localhost;dbname=anyone;charset=utf8';
	$user = 'anyuser';
	$password = 'anyoneuser';

	//ページ数が指定されてる時
	$page = 0;
	if(isset($_GET['page']) && $_GET['page'] > 0){
					$page = intval($_GET['page']) -1;
	}

	try{
					$db = new PDO($dsn, $user, $password);
					$db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					//プリペアドステートメントを作成
					$stmt = $db->prepare(
									"SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num");
					//パラメーターを割り当て
					$page = $page * $num;
					$stmt -> bindParam(':page', $page, PDO::PARAM_INT);
					$stmt -> bindParam(':num', $num, PDO::PARAM_INT);
					//クエリの実行
					$stmt -> execute();
	} catch(PDOException $e){
					echo "Error :". $e -> getMessage();
	}
?>

<!DOCTYPE html>
<html lang = "ja">

	<head>
	
		<meta charset = "UTF-8">
		<title>掲示板</title>
	
	</head>
	<body>
		<h1>掲示板(仮)</h1>
		
		<nav>
			<p><a href="top.php">トップページ</a>に戻る</p>
		</nav>

		<form action = "write.php" method = "post">
			<p>名前：<input type="text" name="name" value="某"></p>
			<p>題：<input type="text" name="title"></p>
			<p>削除パスワード(数字4桁)：<input type = "text" name = "pass"></p>
			<textarea name="body">『　　』</textarea>
			<p><input type = "submit" value = "書き込む"></p>
		</form>
		<hr />
		
<?php
		while ($row = $stmt->fetch()):
						$title = $row['title'] ? $row['title'] : '(無題)';
?>
				<p>名前：<?php echo $row['name'].' @ 投稿日時：'.$row['date']; ?></p>
				<p>題：<?php echo $title; ?></p>
				<p><?php echo nl2br($row['body'], false); ?></p>
<?php
		endwhile;

	//ページ数の表示
	try{
					//プリペアドステートメントを作成
					$stmt = $db -> prepare("SELECT COUNT(*) FROM bbs");
					//クエリの実行
					$stmt -> execute();
	} catch(PDOException $e){
					echo "Error :".$e->getMessage();
	}

	//コメントの件数を取得
	$comments = $stmt -> fetchColumn();
	//ページ数を計算
	$max_page = ceil($comments / $num);
	echo '<p>';
	for ($i = 1; $i <= $max_page; $i++){
					echo '<a href = "bbs.php?page='.$i.'">'.$i.'</a>&nbsp;';
	}
	echo '</p>';
?>
	</body>
</html>
