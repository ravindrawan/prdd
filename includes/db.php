<?php

$host = getenv('DB_HOST') ?: 'prdd-mariadb';
$user = getenv('DB_USER') ?: 'prdd_user';
$pass = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'prd_db';

$conn = @new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    error_log("PRDD Database connection failed: " . $conn->connect_error);

    http_response_code(500);

    die(
        "<div style='padding:20px; background:#fee2e2; color:#b91c1c;
        border-radius:8px; font-family:sans-serif; border:1px solid #fecaca;'>
            <h3>දත්ත පද්ධතිය හා සම්බන්ධ වීමට නොහැකි විය</h3>
            <p>Database connection failed. Please contact the system administrator.</p>
        </div>"
    );
}

$conn->set_charset("utf8mb4");

?>
