<?php
require_once 'db.php';
checkLogin();

// Add Procurement
if(isset($_POST['add_procurement'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $file_path = "";

    // File Upload handling
    if(isset($_FILES["document"]) && $_FILES["document"]["error"] == 0) {
        $upload_dir = "../uploads/procurements/";
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_name = time() . "_" . basename($_FILES["document"]["name"]);
        $target_file = $upload_dir . $file_name;
        
        if(move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $file_path = "uploads/procurements/" . $file_name;
        }
    }
    
    $conn->query("INSERT INTO procurements (title, description, deadline, file_path) VALUES ('$title', '$description', '$deadline', '$file_path')");
    $message = "ප්‍රසම්පාදන විස්තරය සාර්ථකව රාමුවට එක් කරන ලදී! (Added successfully!)";
}

// Delete Procurement
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Optional: Delete physical file
    $res = $conn->query("SELECT file_path FROM procurements WHERE id=$id");
    if($res && $row = $res->fetch_assoc()) {
        if(!empty($row['file_path']) && file_exists("../" . $row['file_path'])) {
            unlink("../" . $row['file_path']);
        }
    }
    $conn->query("DELETE FROM procurements WHERE id=$id");
    header("Location: manage_procurements.php");
    exit();
}

$result = $conn->query("SELECT * FROM procurements ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Manage Procurements - PRD Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eaefe9; margin: 0; }
        .sidebar { width: 250px; background: #003366; height: 100vh; position: fixed; color: white; padding-top: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 20px; border-bottom: 1px solid #042f2e; padding-bottom: 20px; }
        .sidebar a { display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #042f2e; transition: 0.3s; }
        .sidebar a:hover { background: #042f2e; border-left: 5px solid #eab308; }
        .sidebar a.active { background: #042f2e; border-left: 5px solid #eab308; }
        .main-content { margin-left: 250px; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; border-top: 4px solid #003366; }
        h1 { color: #003366; margin-bottom: 20px; }
        h3 { color: #003366; margin-top: 0; font-size: 1.2rem; }
        input[type="text"], input[type="date"], input[type="file"], textarea { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
        button { background: #003366; color: white; padding: 12px 25px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #042f2e; transform: translateY(-2px); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; color: #334155; }
        .delete-btn { background: #ef4444; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .delete-btn:hover { background: #dc2626; }
        .msg { background: #dcfce7; color: #166534; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #bbf7d0; }
        .view-link { color: #2563eb; text-decoration: none; font-weight: bold; }
        .view-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>PRD Admin Panel</h2>
        <a href="index.php">🏠 මුල් පිටුව (Dashboard)</a>
        <a href="manage_home.php">🏠 මුල් පිටුව සැකසීම</a>
        <a href="manage_about.php">📖 අප ගැන සැකසීම (About)</a>
        <a href="manage_sub_offices.php">🏢 උපකාර්යාල සැකසීම (Sub Offices)</a>
        <a href="manage_news.php">📰 පුවත් කළමනාකරණය</a>
        <a href="manage_procurements.php" class="active">📑 ප්‍රසම්පාදන කළමනාකරණය</a>
        <a href="manage_downloads.php">📥 බාගත කිරීම්</a>
        <a href="manage_messages.php">✉️ පණිවිඩ (Messages)</a>
        <a href="logout.php">🚪 පිටවීම (Logout)</a>
    </div>

    <div class="main-content">
        <h1>📑 ප්‍රසම්පාදන (Procurements & Tenders)</h1>
        
        <?php if(isset($message)) echo "<div class='msg'>$message</div>"; ?>

        <div class="card">
            <h3>නව ප්‍රසම්පාදනයක් එක් කරන්න (Add New Tender)</h3>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="මාතෘකාව (Title)" required>
                <textarea name="description" rows="3" placeholder="කෙටි විස්තරය (Description)" required></textarea>
                <input type="date" name="deadline" title="අවසන් දින" required>
                <input type="file" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx">
                <small style="display:block; margin:-10px 0 15px 5px; color:#64748b;">බාගත කිරීම සඳහා අදාළ ලිපිය අමුණන්න (Attach file)</small>
                <button type="submit" name="add_procurement">එකතු කරන්න (Save)</button>
            </form>
        </div>

        <div class="card">
            <h3>දැනට පවතින ප්‍රසම්පාදන</h3>
            <table>
                <thead>
                    <tr>
                        <th>අවසන් දිනය</th>
                        <th>මාතෘකාව</th>
                        <th>ගොනුව</th>
                        <th>ක්‍රියාව</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result === false) {
                        echo "<tr><td colspan='4'>Database error.</td></tr>";
                    } else {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['deadline'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                            echo "<td>" . (!empty($row['file_path']) ? "<a href='../" . htmlspecialchars($row['file_path']) . "' class='view-link' target='_blank'>View File</a>" : "නැත (None)") . "</td>";
                            echo "<td><a href='?delete=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\"මකා දැමීමට අවශ්‍යද?\")'>මකා දමන්න</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
