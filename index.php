<?php
	session_set_cookie_params(600000, $secure=true);
	session_start();
	include 'db.php';
	include 'encryption.php';

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
	<link rel="icon" type="image/x-icon" href="/favicon.png">
	<title>Simple Clipboard</title>
	<link rel="stylesheet" href="/editor.css"></link>
	<link rel="stylesheet" href="/style.css"></link>
</head>
<body>
	<div class="container">
	<form>
		<div class="nav" class="top">
			<?php if (!isset($_SESSION['username'])) { ?>
			<div class="left"><button type="button" onclick="window.location.href='account.php'" name="login" class="btn btn-green">Login</button></div>
			<?php } else { ?>
			<div class="left"><button type="button" onclick="this.value='logout'; formButton(); this.value=''" name="logout" class="btn btn-red form_data">Logout</button></div>
			<?php } ?>
			<div class="center"><b><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; else echo "Simple" ?> Clipboard</b></div>
			<div class="right"><Button type="button" onclick="this.value='save'; formButton(); this.value=''" name="save-acc" class="btn btn-blue form_data" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Simpan</Button></div>
		</div>
		<div>
			<p style="margin-block-start: 0.5em; margin-block-end: 0.6em"><textarea id="lineCounter" wrap="off" readonly>1.</textarea>
				<textarea placeholder="<?php if (!isset($_SESSION['username'])) echo 'Login untuk menyimpan ke Akun&#10selamanya. Atau bagikan secara&#10langsung dengan tombol dibawah.'; else echo 'Hapus jika sudah tidak digunakan.'?>" class="form_data" id="codeEditor" wrap="off" name="field"><?php if (isset($_SESSION['username'])) echo $clipboard?></textarea>
			</p>
		</div>
		<div class="nav">
			<div class="left"><button type="button" onclick="delButt('akun')" id="delete" name="delete-acc" class="btn btn-red form_data" <?php if (!isset($_SESSION['username'])) echo 'disabled'?>>Hapus Akun</button></div>
			<div class="center bottom"><b class="text-green text-mini">Bagikan Langsung -></b></div>
			<div class="right"><Button type="button" onclick="this.value='share'; formButton(); this.value=''" name="share" class="btn btn-yellow form_data">Bagikan</Button></div>
		</div>
	</form>
	</div>
<script type="text/javascript" src="/editor.js"></script>
<script type="text/javascript" src="/button.js"></script>
</body>
</html>