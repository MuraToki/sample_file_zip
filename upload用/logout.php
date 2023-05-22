<?php
	session_start();
	
	// DBとの接続
	include_once 'dbconnect.php';

	if(isset($_GET['delete'])) { // 会員退会ボタンが押下されたときに実行
		$query = "DELETE FROM users WHERE user_id=".$_SESSION['user']."";// ユーザーIDをキーにDBからユーザ情報を削除
		$result = $mysqli->query($query);

		if (!$result) {
		  print('クエリーが失敗しました。' . $mysqli->error);
		  $mysqli->close();
		  exit();
		}
	}

	if(isset($_GET['delete'])) { // URLクエリパラメータがdeleteだった場合、
	  session_destroy();
	  unset($_SESSION['user']);
	  header("Location: index.php?delete");
	} elseif(isset($_GET['logout'])) { // URLクエリパラメータがlogoutだった場合、
	  session_destroy();
	  unset($_SESSION['user']);
	  header("Location: index.php");
	} else {
	  header("Location: index.php");
	}
?>