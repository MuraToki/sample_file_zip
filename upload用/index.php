<?php 
	ob_start();
	session_start();
	if( isset($_SESSION['user']) != "") {
	  // ログイン済みの場合は、マイページへリダイレクト
	  header("Location: home.php");
	}

	// DBとの接続
	include_once 'dbconnect.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログインフォーム画面</title>
</head>
<body>
<?php
	if(isset($_GET['delete'])) { // 会員退会でリダイレクトされたときに実行
		echo '<div role="alert">会員退会が完了しました。</div>';
	}
?>
<?php
	
	if(isset($_POST['login'])) { // ログインボタンが押下されたときに実行

	  $email = $mysqli->real_escape_string($_POST['email']);
	  $password = $mysqli->real_escape_string($_POST['password']);

	  //SQL命令文を$queryへ代入
	  $query = "SELECT * FROM users WHERE email='$email'"; // 入力されたメールアドレスがDB上にあるか

	  //$queryを実行
	  $result = $mysqli->query($query);
	  if (!$result) {
	    print('ログインに失敗しました。メールアドレスが違う可能性があります。' . $mysqli->error);
	    $mysqli->close();// データベースの切断
	    exit();
	  }

	  // DB上から該当ユーザのパスワード(暗号化済み）とユーザーIDを取得
	  while ($row = $result->fetch_assoc()) {
	    $db_hashed_pwd = $row['password'];
	    $user_id = $row['user_id'];
	  }

	  // データベースの切断
	  $result->close();

	  // ハッシュ化されたパスワードがマッチするかどうかを確認
	  if (password_verify($password, $db_hashed_pwd)) {
	    $_SESSION['user'] = $user_id;
	    header("Location: home.php");// ログイン
	    exit;
	  } else { ?>
	    <div role="alert">メールアドレスとパスワードが一致しません。</div>
	  <?php }
	}

?>
	<form method="post">
		<dl>
			<dt><label for="q1">メールアドレス</label></dt>
			<dd><input type="email" name="email" id="q1"  size="50" placeholder="○○○@○○○.com" required></dd>
			<dt><label for="q2">パスワード</label></dt>
			<dd><input type="password" name="password" id="q2" size="30" placeholder="○○○○○○○○" required></dd>
		</dl>
		<button type="submit" name="login">ログイン</button>
		<a href="register.php">会員登録はこちら</a>
	</form>
</body>
</html>