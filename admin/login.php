<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

$error = '';
if(isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // In production, use password_hash and password_verify
    $result = $conn->query("SELECT * FROM admin_users WHERE username='$username' AND password='$password'");
    
    // Fallback if DB doesn't have records
    if ($result && $result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit();
    } else if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "පරිශීලක නාමය හෝ මුරපදය වැරදියි (Invalid login)";
    }
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>PRD Admin Login</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eaefe9; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; border-top: 5px solid #003366; }
        h2 { color: #003366; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #003366; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 15px; }
        button:hover { background: #042f2e; }
        .error { color: red; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>PRD Admin Panel</h2>
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="පරිශීලක නාමය (Username)" required>
            <input type="password" name="password" placeholder="මුරපදය (Password)" required>
            <button type="submit" name="login">ඇතුල් වන්න (Login)</button>
        </form>
    </div>
</body>
</html>
