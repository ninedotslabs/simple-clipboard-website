<?php
    session_set_cookie_params(7 * 24 * 60 * 60);
	session_start();
	include 'db.php';
	include 'encryption.php';

    //share clipboard
    if (!empty($_POST['share'])) {
        //if textarea still empty
        if (!isset($_POST['field']) || trim($_POST['field']) == "")
            echo "text masih kosong";

        else {
            $token = bin2hex(random_bytes(10));
            $field = encrypt(htmlspecialchars($_POST['field']), $token);
            $sql = "INSERT INTO storage (token, field) VALUES ('$token', '$field')";
            $result = mysqli_query($conn, $sql);
            echo $token;
        }

    //delete temporary clipboard
    } elseif (!empty($_POST['delete-temp'])) {
        $token = $_POST['delete-temp'];
        $sql = "DELETE FROM storage WHERE token='$token'";
        mysqli_query($conn, $sql);
        echo "deleted";

    //save temporary clipboard
    } elseif (!empty($_POST['save-temp'])) {
        $token = $_POST['save-temp'];
        $field = htmlspecialchars($_POST['field']);
        $field = encrypt($field, $token);
        $sql = "UPDATE storage SET field='$field' WHERE token='$token'";
        mysqli_query($conn, $sql);
        echo "berhasil disimpan";

    //user do login
    } elseif (!empty($_POST['login'])) {
        if ($_POST['captcha'] != $_SESSION['captcha'])
            echo "wrcap";

        else {
            $username = sha1($_POST['username'], true);
            $sql = "SELECT password FROM user WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            $password = mysqli_fetch_assoc($result)['password'];

            if (password_verify($_POST['password'], $password)) {
                $_SESSION['username'] = $_POST['username'];
                unset($_SESSION['captcha']);
                echo "login";

            } else
                echo "wrpass";
        }

    //user do register
    } elseif (!empty($_POST['daftar'])) {
        if ($_POST['captcha'] != $_SESSION['captcha'])
            echo "wrcap";

        else {
            $username = sha1($_POST['username'], true);
            $password = password_hash($_POST['password'], 1);

            if ($_POST['password'] == $_POST['cpassword']) {
                $sql = "SELECT id FROM user WHERE username='$username'";
                $result = mysqli_query($conn, $sql);

                if (!$result->num_rows > 0) {
                    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
                    $result = mysqli_query($conn, $sql);
                    $_SESSION['username'] = $_POST['username'];
                    unset($_SESSION['captcha']);
                    echo "register";

                } else
                    echo "registered";

            } else
                echo "wrpass";
        }
    }

    //if the user is already logged in
    if (isset($_SESSION['username'])) {
        $username = sha1($_SESSION['username'], true);

        //destroy session to logout
        if (!empty($_POST['logout'])) {
            session_destroy();
            echo "logout";

        //user do saving
        } elseif (!empty($_POST['save-acc'])) {
            $field = htmlspecialchars($_POST['field']);
            $field = encrypt($field, $username);
            $sql = "UPDATE user SET field='$field' WHERE username='$username'";
            mysqli_query($conn, $sql);
            echo "berhasil disimpan";

        //user deleting account
		} elseif (!empty($_POST['delete-acc'])) {
			$sql = "DELETE FROM user WHERE username='$username'";
			mysqli_query($conn, $sql);
			session_destroy();
            echo "deleted";
		}
    }

    if (!$_POST)
        header("Location: /")
?>