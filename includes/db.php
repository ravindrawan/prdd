<?php
// --- Deployment Settings ---
// සර්වර් එකේදී වෙබ් අඩවිය ක්‍රියා නොකරයි නම් පමණක් පහත පේළි දෙකේ ඇති '//' ඉවත් කරන්න.
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "prd_db";

// mysqli සම්බන්ධතාවය ඇති කිරීම
$conn = @new mysqli($host, $user, $pass, $dbname);

// සම්බන්ධතාවය පරීක්ෂා කිරීම
if ($conn->connect_error) {
    die("<div style='padding:20px; background:#fee2e2; color:#b91c1c; border-radius:8px; font-family:sans-serif; border:1px solid #fecaca;'>
            <h3>දත්ත පද්ධතිය හා සම්බන්ධ වීමට නොහැකි විය (Database Connection Failed)</h3>
            <p>කරුණාකර <b>includes/db.php</b> ගොනුවේ ඇති දත්ත පද්ධති විස්තර (Host, User, Pass, DB Name) නිවැරදි දැයි පරීක්ෂා කරන්න.</p>
            <p>විශේෂයෙන්ම සර්වර් එකේදී User සහ DB Name එකට පෙර ඔබේ සර්වර් එකේ User ID එක (Prefix) ඇතුළත් කළ යුතු විය හැක.</p>
            <hr>
            <p><b>Error Details:</b> " . $conn->connect_error . "</p>
         </div>");
}

// අකුරු වල ප්‍රමිතිය සැකසීම (Unicode support)
$conn->set_charset("utf8mb4");
?>
