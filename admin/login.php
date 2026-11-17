<?php
$isHttps = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
     strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttps,
        'samesite' => 'Lax'
    ]);
    session_start();
}

require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {

        $stmt = $conn->prepare(
            "SELECT id, username, password
             FROM admin_users
             WHERE username = ?
             LIMIT 1"
        );

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($adminId, $adminUsername, $passwordHash);

            if ($stmt->fetch() && password_verify($password, $passwordHash)) {

                session_regenerate_id(true);

                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $adminId;
                $_SESSION['admin_username'] = $adminUsername;

                $stmt->close();

                header("Location: index.php");
                exit();

            } else {
                $error = "පරිශීලක නාමය හෝ මුරපදය වැරදියි (Invalid login)";
            }

            $stmt->close();

        } else {
            $error = "Login සේවාව තාවකාලිකව ක්‍රියාත්මක නොවේ.";
        }

    } else {
        $error = "කරුණාකර Username සහ Password ඇතුළත් කරන්න.";
    }
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRD Admin Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eaefe9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            max-width: calc(100% - 40px);
            box-sizing: border-box;
            text-align: center;
            border-top: 5px solid #003366;
        }
        h2 { color: #003366; margin-bottom: 20px; }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover { background: #042f2e; }
        .error {
            color: #b91c1c;
            background: #fee2e2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>PRD Admin Panel</h2>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" autocomplete="on">
            <input
                type="text"
                name="username"
                placeholder="පරිශීලක නාමය (Username)"
                autocomplete="username"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="මුරපදය (Password)"
                autocomplete="current-password"
                required
            >

            <button type="submit" name="login">
                ඇතුල් වන්න (Login)
            </button>
        </form>
    </div>
</body>
</html>
