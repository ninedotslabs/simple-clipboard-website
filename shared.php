<?php
    include 'db.php';

    if (!isset($_GET['token']) || isset($_POST['back']))
        header("Location: index.php");

    else {
        $token = $_GET['token'];
        $sql = "SELECT id,field FROM storage WHERE token='$token'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $field = $row['field'];

        if (isset($_POST['save'])) {
            $field = htmlspecialchars($_POST['field']);

            if ($row['field'] == $field)
                echo "<script>alert('tidak ada perubahan')</script>";

            else {
                if (!isset($field) || trim($field) == "") {
                    $sql = "DELETE FROM storage WHERE token='$token'";
                    mysqli_query($conn, $sql);
                    header("Location: index.php");

                } else {
                    $sql = "UPDATE storage SET field='$field' WHERE token='$token'";
                    mysqli_query($conn, $sql);
                    echo "<script>alert('sukses')</script>";
                }
            }
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
    <title>Clipboard #<?=$row['id']?></title>
    <link rel="stylesheet" href="/editor.css"></link>
	<link rel="stylesheet" href="/style.css"></link>
</head>
<body>
    <div class="container">
        <form action="/shared.php?token=<?=$token?>" method="POST">
            <div class="nav" class="top">
                <div class="left"><button type="submit" name="back" class="btn btn-red">Kembali</button></div>
                <div class="center"><b>Clipboard #<?=$row['id']?></b></div>
                <div class="right"><Button type="submit" name="save" class="btn btn-green">Simpan</Button></div>
            </div>
            <div>
                <p style="margin-block-start: 0.5em; margin-block-end: 0.6em"><textarea id="lineCounter" wrap="off" readonly>1.</textarea>
                    <textarea id="codeEditor" wrap="off" name="field" placeholder="Kosongkan lalu simpan untuk menghapus."><?=$field?></textarea>
                </p>
            </div>
        </form>
        <div class="nav">
            <div class="left"><button class="btn btn-blue" id="copy-link" onclick="alert('link dicopy')">Copy Link</button></div>
            <div class="center bottom"><b class="text-red text-mini">Data Akan Dihapus Tiap Minggu</b></div>
            <div class="right"><button class="btn btn-yellow" id="copy-text" data-clipboard-target="#codeEditor" onclick="alert('text dicopy')">Copy Text</button></div>
        </div>
    </div>
<script type="text/javascript" src="/editor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
<script>
    new ClipboardJS('#copy-link', {
        text: function(trigger) {
            return window.location.href;;
        }
    });
    new ClipboardJS('#copy-text');
</script>
</body>
</html>