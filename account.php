<?php
    session_set_cookie_params(600000, $secure=true);
    session_start();
    include 'db.php';

    if (isset($_SESSION['username']))
        header("Location: index.php");

    $title = "Login";
    if (isset($_GET['daftar']) or isset($_POST['daftar']))
        $title = "Daftar";

    if (isset($_POST['login'])) {
        if ($_POST['captcha'] != $_SESSION['captcha'])
            echo "<script>alert('captcha salah')</script>";

        else {
            $username = sha1($_POST['username'], true);
            $sql = "SELECT password FROM user WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            $password = mysqli_fetch_assoc($result)['password'];

            if (password_verify($_POST['password'], $password)) {
                $_SESSION['username'] = $_POST['username'];
                header("Location: index.php");

            } else
                echo "<script>alert('username atau password salah')</script>";
        }

    } elseif (isset($_POST['daftar'])) {
        if ($_POST['captcha'] != $_SESSION['captcha'])
            echo "<script>alert('captcha salah')</script>";

        else {
            $username = sha1($_POST['username'], true);
            $password = password_hash($_POST['password'], 1);

            if ($_POST['password'] == $_POST['cpassword']) {
                $sql = "SELECT id FROM user WHERE username='$username'";
                $result = mysqli_query($conn, $sql);

                if (!$result->num_rows > 0) {
                    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $_SESSION['username'] = $_POST['username'];
                        header("Location: index.php");

                    } else
                        echo "<script>alert('terjadi kesalahan')</script>";

                } else
                    echo "<script>alert('username sudah terdaftar')</script>";

            } else
                echo "<script>alert('password tidak sesuai')</script>";
        }
    }

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
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/style.css"></link>
</head>
<body>
    <div class="account">
    <b><?=$title?> Akun</b>
    <form action="/account.php" method="POST" style="margin-bottom: 0">
        <table>
            <tr>
                <td style="padding-right: 4px">Username</td>
                <td><input type="text" placeholder="username" minlength="2" name="username" value="<?=$_POST['username']?>" required></td>
            </tr>
            <tr>
                <td style="padding-right: 4px">Password</td>
                <td><input type="password" placeholder="password" minlength="4" name="password" value="<?=$_POST['password']?>" required></td>
            </tr>
            <?php if (isset($_GET['daftar']) or isset($_POST['daftar'])) { ?>
            <tr>
                <td style="padding-right: 4px">Password</td>
                <td><input type="password" placeholder="konfirmasi password" minlength="4" name="cpassword" value="<?=$_POST['cpassword']?>" required></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="padding-right: 4px"><?=$cap1?> + <?=$cap2?></td>
                <td><input type="number" placeholder="captcha" name="captcha" required></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 6px">
                    <?php if (isset($_GET['daftar']) or isset($_POST['daftar'])) { ?>
                    <button type="submit" name="daftar" class="btn btn-blue">Daftar</button>
                    <a href="/account.php" class="btn btn-green">Login Saja</a>
                    <?php } else { ?>
                    <button type="submit" name="login" class="btn btn-green">Login</button>
                    <a href="/account.php?daftar" class="btn btn-blue">Daftar Baru</a>
                    <?php } ?>
                    <a href="/" class="btn btn-red">Kembali</a>
                </td>
            </tr>
        </table>
    </form>
    </div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );}
</script>
</body>
</html>