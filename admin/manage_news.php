<?php
require_once 'db.php';
checkLogin();

// Add News
if(isset($_POST['add_news'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $date = $conn->real_escape_string($_POST['date']);
    
    $conn->query("INSERT INTO news (title, content, date) VALUES ('$title', '$content', '$date')");
    $message = "පුවත සාර්ථකව එකතු කරන ලදී! (News added successfully!)";
}

// Delete News
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM news WHERE id=$id");
    header("Location: manage_news.php");
    exit();
}

$result = $conn->query("SELECT * FROM news ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>📰 පුවත් කළමනාකරණය (News Management)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">වෙබ් අඩවියේ ප්‍රවෘත්ති සහ විශේෂ පණිවිඩ මෙතැන් සිට යාවත්කාලීන කරන්න.</p>
            </div>
        </div>

        <?php if(isset($message)) echo "<div class='admin-alert admin-alert-success fade-in'>✅ $message</div>"; ?>

        <div class="admin-card fade-in" style="border-top: 5px solid var(--admin-accent);">
            <h3>නව පුවතක් එකතු කරන්න (Add New)</h3>
            <form method="post" class="admin-form">
                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 1.5rem;">
                    <div>
                        <label>පුවතේ මාතෘකාව (News Title)</label>
                        <input type="text" name="title" class="admin-input" placeholder="පුවතේ මාතෘකාව ඇතුළත් කරන්න" required>
                    </div>
                    <div>
                        <label>ප්‍රකාශිත දිනය (Date)</label>
                        <input type="date" name="date" class="admin-input" required>
                    </div>
                </div>
                <label>පුවතේ විස්තරය (News Content)</label>
                <textarea name="content" class="admin-textarea" rows="6" placeholder="පුවතේ සම්පූර්ණ විස්තරය මෙහි ඇතුළත් කරන්න..." required></textarea>
                
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" name="add_news" class="admin-btn admin-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        පුවත සුරකින්න (Save News)
                    </button>
                </div>
            </form>
        </div>

        <div class="admin-header fade-in" style="margin-top: 3rem; margin-bottom: 1.5rem;">
            <h2>ප්‍රකාශිත පුවත් (Published News)</h2>
        </div>

        <div class="admin-table-container fade-in">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">දිනය</th>
                        <th style="width: 25%;">මාතෘකාව</th>
                        <th style="width: 50%;">විස්තරය</th>
                        <th style="width: 10%;">ක්‍රියාවන්</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result === false) {
                        echo "<tr><td colspan='4' style='text-align:center;'>Database error.</td></tr>";
                    } else {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><span style='background: #f1f5f9; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: #475569;'>" . $row['date'] . "</span></td>";
                            echo "<td><div style='font-weight: 700; color: var(--admin-primary);'>" . htmlspecialchars($row['title']) . "</div></td>";
                            echo "<td><div style='color: #64748b; font-size: 0.9rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;'>" . htmlspecialchars($row['content']) . "</div></td>";
                            echo "<td>
                                <a href='?delete=" . $row['id'] . "' class='admin-btn admin-btn-danger' style='padding: 8px 12px; font-size: 0.8rem;' onclick='return confirm(\"ඔබට මෙම පුවත මකා දැමීමට අවශ්‍යද?\")'>
                                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"3 6 5 6 21 6\"></polyline><path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path><line x1=\"10\" y1=\"11\" x2=\"10\" y2=\"17\"></line><line x1=\"14\" y1=\"11\" x2=\"14\" y2=\"17\"></line></svg>
                                </a>
                            </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
