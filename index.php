<?php
	session_start();
	include 'db.php';
	include 'encryption.php';

	if (isset($_COOKIE['username']))
		$_SESSION['username'] = $_COOKIE['username'];

	if (isset($_SESSION['username'])) {
		$username = sha1($_SESSION['username'], true);
		$sql = "SELECT field FROM user WHERE username='$username'";
		$result = mysqli_query($conn, $sql);
		$clipboard = decrypt(mysqli_fetch_assoc($result)['field'], $username);
	}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="/static/favicon.png">
	<title>Simple Clipboard</title>
	<link rel="stylesheet" href="/static/css/editor.css"></link>
	<link rel="stylesheet" href="/static/css/style.css"></link>
</head>
<body>
	<div class="container">
	<form>
		<div class="nav" class="top">
			<?php if (!isset($_SESSION['username'])) { ?>
			<div class="left"><button type="button" onclick="window.location.href='account.php'" name="login" class="btn btn-green">Login</button></div>
			<?php } else { ?>
			<div class="left"><button type="button" onclick="formButton('logout')" id="logout" name="logout" class="btn btn-red form_data">Logout</button></div>
			<?php } ?>
			<div class="center"><b><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; else echo "Simple" ?> Clipboard</b></div>
			<div class="right"><Button type="button" onclick="formButton('save')" id="save" name="save-acc" class="btn btn-blue form_data" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Simpan</Button></div>
		</div>
		<div>
			<p style="margin-block-start: 0.5em; margin-block-end: 0.6em"><textarea id="lineCounter" wrap="off" readonly>1.</textarea>
				<textarea placeholder="<?php if (!isset($_SESSION['username'])) echo 'Login untuk menyimpan ke Akun&#10selamanya. Atau bagikan secara&#10langsung dengan tombol dibawah.'; else echo 'Hapus jika sudah tidak digunakan.'?>" class="form_data" id="codeEditor" wrap="off" name="field"><?php if (isset($_SESSION['username'])) echo $clipboard?></textarea>
			</p>
		</div>
		<div class="nav">
			<div class="left"><button type="button" onclick="delButt('akun')" id="akun" name="delete-acc" class="btn btn-red form_data" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Hapus Akun</button></div>
			<div class="center bottom"><b class="text-green text-mini">Bagikan Langsung -></b></div>
			<div class="right"><Button type="button" onclick="formButton('share')" id="share" name="share" class="btn btn-yellow form_data">Bagikan</Button></div>
		</div>
	</form>
	</div>
<script type="text/javascript" src="/static/js/editor.js"></script>
<script type="text/javascript" src="/static/js/button.js"></script>
</body>
</html>
