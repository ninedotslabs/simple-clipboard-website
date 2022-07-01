<?php
	session_set_cookie_params(600000);
	session_start();
	include 'db.php';
	include 'encryption.php';

	if (isset($_SESSION['username'])) {
		$username = sha1($_SESSION['username'], true);
		$sql = "SELECT field FROM user WHERE username='$username'";
		$result = mysqli_query($conn, $sql);
		$clipboard = decrypt(mysqli_fetch_assoc($result)['field'], $username);

		if (isset($_POST['save'])) {
			$field = htmlspecialchars($_POST['field']);

			if ($clipboard == $field)
				echo "<script>alert('tidak ada perubahan')</script>";

			else {
				$clipboard = $field;
				$field = encrypt($field, $username);
				$sql = "UPDATE user SET field='$field' WHERE username='$username'";
				mysqli_query($conn, $sql);
				echo "<script>alert('sukses')</script>";
			}

		} elseif (isset($_POST['delete'])) {
			$sql = "DELETE FROM user WHERE username='$username'";
			mysqli_query($conn, $sql);
			session_destroy();
			header("Location: index.php");
		}
	}

    if (isset($_POST['login']))
	    header("Location: account.php");

	elseif (isset($_POST['logout'])) {
        session_destroy();
		header("Location: index.php");

	} elseif (isset($_POST['share'])) {
		if (!isset($_POST['field']) || trim($_POST['field']) == "")
			echo "<script>alert('text masih kosong')</script>";

		else {
			$token = bin2hex(random_bytes(10));
			$field = encrypt(htmlspecialchars($_POST['field']), $token);
			$sql = "INSERT INTO storage (token, field) VALUES ('$token', '$field')";
			$result = mysqli_query($conn, $sql);

			if ($result) {
				header("Location: shared.php?token=".$token);

			} else
				echo "<script>alert('terjadi kesalahan')</script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="/favicon.png">
	<title>Simple Clipboard</title>
	<link rel="stylesheet" href="/editor.css"></link>
	<link rel="stylesheet" href="/style.css"></link>
</head>
<body>
	<div class="container">
	<form action="/index.php" method="POST">
		<div class="nav" class="top">
			<?php if (!isset($_SESSION['username'])) { ?>
			<div class="left"><button type="submit" name="login" class="btn btn-green">Login</button></div>
			<?php } else { ?>
			<div class="left"><button type="submit" name="logout" class="btn btn-red">Logout</button></div>
			<?php } ?>
			<div class="center"><b><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; else echo "Simple" ?> Clipboard</b></div>
			<div class="right"><Button type="submit" name="save" class="btn btn-blue" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Simpan</Button></div>
		</div>
		<div>
			<p style="margin-block-start: 0.5em; margin-block-end: 0.6em"><textarea id="lineCounter" wrap="off" readonly>1.</textarea>
				<textarea <?php if (!isset($_SESSION['username'])) echo "placeholder='Login untuk menyimpan ke Akun&#10selamanya. Atau bagikan secara&#10langsung dengan tombol dibawah.'"?> id="codeEditor" wrap="off" name="field"><?php if (isset($_SESSION['username'])) echo $clipboard?></textarea>
			</p>
		</div>
		<div class="nav">
			<div class="left"><button type="submit" name="delete" class="btn btn-red" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Hapus Akun</button></div>
			<div class="center bottom"><b class="text-green text-mini">Bagikan Langsung -></b></div>
			<div class="right"><Button type="submit" name="share" class="btn btn-yellow">Bagikan</Button></div>
		</div>
	</form>
	</div>
<script type="text/javascript" src="/editor.js"></script>
</body>
</html>