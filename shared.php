<?php
    include 'db.php';
    include 'encryption.php';

    if (!isset($_GET['token']) || isset($_POST['back']))
        header("Location: /");

    else {
        $token = $_GET['token'];
        $sql = "SELECT id,field FROM storage WHERE token='$token'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $clipboard = decrypt($row['field'], $token);

        } else
            header("Location: /");
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/static/favicon.png">
    <title>Clipboard #<?=$row['id']?></title>
    <link rel="stylesheet" href="/static/css/editor.css"></link>
	<link rel="stylesheet" href="/static/css/style.css"></link>
</head>
<body>
    <div class="container">
        <form>
            <div class="nav" class="top">
                <div class="left"><button type="button" onclick="delButt('clipboard')" id="delete" name="delete-temp" class="btn btn-red form_data">Hapus</button></div>
                <div class="center"><b>Clipboard #<?=$row['id']?></b></div>
                <div class="right"><Button type="button" onclick="this.value='<?=$token?>'; formButton(); this.value=''" name="save-temp" class="btn btn-green form_data">Simpan</Button></div>
            </div>
            <div>
                <p style="margin-block-start: 0.5em; margin-block-end: 0.6em"><textarea id="lineCounter" wrap="off" readonly>1.</textarea>
                    <textarea id="codeEditor" class="form_data" wrap="off" name="field" placeholder="Hapus jika sudah tidak digunakan."><?=$clipboard?></textarea>
                </p>
            </div>
        </form>
        <div class="nav">
            <div class="left"><button class="btn btn-blue" id="copy-link" onclick="copyLink()">Copy Link</button></div>
            <div class="center bottom"><b class="text-red text-mini">Data Akan Dihapus Tiap Minggu</b></div>
            <div class="right"><button class="btn btn-yellow" id="copy-text" onclick="copyEditor()">Copy Text</button></div>
        </div>
    </div>
<script type="text/javascript" src="/static/js/editor.js"></script>
<script type="text/javascript" src="/static/js/button.js"></script>
</body>
</html>