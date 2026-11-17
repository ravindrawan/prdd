<?php
require_once 'db.php';
checkLogin();

// Delete Message
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM messages WHERE id=$id");
    header("Location: manage_messages.php");
    exit();
}

$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>✉️ ලැබුණු පණිවිඩ (Received Messages)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">වෙබ් අඩවිය හරහා ජනතාවගෙන් ලැබුණු අදහස් සහ විමසීම් සියල්ල මෙහි දැක්වේ.</p>
            </div>
        </div>

        <div class="admin-table-container fade-in">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">දිනය & වේලාව</th>
                        <th style="width: 20%;">නම (Name)</th>
                        <th style="width: 25%;">විද්‍යුත් තැපෑල (Email)</th>
                        <th style="width: 30%;">පණිවිඩය (Message)</th>
                        <th style="width: 10%;">ක්‍රියාවන්</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result === false) {
                        echo "<tr><td colspan='5' style='text-align:center;'>Database error.</td></tr>";
                    } elseif($result->num_rows == 0) {
                        echo "<tr><td colspan='5' style='text-align:center; padding: 3rem; color: var(--admin-text-muted);'>
                            <div style='font-size: 3rem; margin-bottom: 1rem;'>📭</div>
                            දැනට ලැබුණු පණිවිඩ කිසිවක් නොමැත. (No messages right now.)
                        </td></tr>";
                    } else {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><span style='color: var(--admin-text-muted); font-size: 0.85rem;'>" . date("M d, Y", strtotime($row['created_at'])) . "<br>" . date("H:i", strtotime($row['created_at'])) . "</span></td>";
                            echo "<td><div style='font-weight: 700; color: var(--admin-primary);'>" . htmlspecialchars($row['name']) . "</div></td>";
                            echo "<td><a href='mailto:" . htmlspecialchars($row['email']) . "' style='color: var(--admin-accent); text-decoration: none; font-weight: 500;'>" . htmlspecialchars($row['email']) . "</a></td>";
                            echo "<td><div style='background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.9rem; line-height: 1.5; color: #475569;'>" . nl2br(htmlspecialchars($row['message'])) . "</div></td>";
                            echo "<td>
                                <a href='?delete=" . $row['id'] . "' class='admin-btn admin-btn-danger' style='padding: 8px 12px; font-size: 0.8rem;' onclick='return confirm(\"මෙම පණිවිඩය මකා දැමීමට ඔබට විශ්වාසද?\")'>
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
