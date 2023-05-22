<?php 
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
	<title>会員登録フォーム画面</title>
</head>
<body>
<?php

if(isset($_POST['signup'])) { // 新規登録ボタンが押下されたときに実行

	$username = $mysqli->real_escape_string($_POST['username']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$password = password_hash($password, PASSWORD_DEFAULT);
	$birth_year = $mysqli->real_escape_string($_POST['birth_year']);

	//SQL命令文を$queryへ代入
	$query = "INSERT INTO users(username,email,password,birth_year) VALUES('$username','$email','$password','$birth_year')";

	//$queryを実行
	if($mysqli->query($query)) {  ?>
		<div role="alert">登録しました</div>
	<?php } else { ?>
		<div role="alert">エラーが発生しました。</div>
	<?php
	}
}
?>
	<form method="post">
		<dl>
			<dt><label for="q1">氏名</label></dt>
			<dd><input type="text" name="username" id="q1" size="30" placeholder="○○ ○○" required></dd>
			<dt><label for="q2">メールアドレス</label></dt>
			<dd><input type="email" name="email" id="q2"  size="50" placeholder="○○○@○○○.com" required></dd>
			<dt><label for="q3">パスワード</label></dt>
			<dd><input type="password" name="password" id="q3" size="30" placeholder="○○○○○○○○" required></dd>
			<dt><label for="q4">誕生年</label></dt>
			<dd><select name="birth_year" id="q4">
				<option value="" selected required>選択してください</option>
				<option value="1989">1989</option>
				<option value="1990">1990</option>
				<option value="1991">1991</option>
				<option value="1992">1992</option>
				<option value="1993">1993</option>
			</select>年</dd>
		</dl>
		<button type="submit" name="signup">新規登録</button>
		<a href="index.php">ログインはこちら</a>
	</form>
</body>
</html>