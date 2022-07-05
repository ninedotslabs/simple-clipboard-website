<?php
    session_start();

    if (isset($_SESSION['username']))
        header("Location: /");

    $title = "Login";
    if (isset($_GET['daftar']))
        $title = "Daftar";

    $cap1 = rand(1,9);
    $cap2 = rand(1,9);
    $_SESSION['captcha'] = $cap1 + $cap2
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/static/favicon.png">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/static/css/style.css"></link>
</head>
<body>
    <div class="account">
    <b><?=$title?> Akun</b>
    <form>
        <table>
            <tr>
                <td style="padding-right: 4px">Username</td>
                <td><input type="text" placeholder="username" maxlength="20" class="form_data" name="username" value="<?=$_POST['username']?>"></td>
            </tr>
            <tr>
                <td style="padding-right: 4px">Password</td>
                <td><input type="password" placeholder="password" maxlength="36" class="form_data" name="password" value="<?=$_POST['password']?>"></td>
            </tr>
            <?php if (isset($_GET['daftar']) or isset($_POST['daftar'])) { ?>
            <tr>
                <td style="padding-right: 4px">Password</td>
                <td><input type="password" placeholder="konfirmasi password" maxlength="36" class="form_data" name="cpassword" value="<?=$_POST['cpassword']?>"></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="padding-right: 4px"><?=$cap1?> + <?=$cap2?></td>
                <td><input type="number" placeholder="captcha" max="18" class="form_data" name="captcha"></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 6px">
                    <?php if (isset($_GET['daftar']) or isset($_POST['daftar'])) { ?>
                    <button type="button" onclick="formButton('register')" id="register" name="daftar" class="btn btn-blue form_data">Daftar</button>
                    <button type="button" onclick="window.location.href='/account.php'" class="btn btn-green">Login Saja</button>
                    <?php } else { ?>
                    <button type="button" onclick="formButton('login')" id="login" name="login" class="btn btn-green form_data">Login</button>
                    <button type="button" onclick="window.location.href='/account.php?daftar'" class="btn btn-blue">Daftar Baru</button>
                    <?php } ?>
                    <button type="button" onclick="window.location.href='/'" class="btn btn-red">Kembali</button>
                </td>
            </tr>
        </table>
    </form>
    </div>
<script type="text/javascript" src="/static/js/button.js"></script>
</body>
</html>