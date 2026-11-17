<?php
require_once 'db.php';
checkLogin();

// Auto-create tables
$conn->query("CREATE TABLE IF NOT EXISTS sub_offices_content (
    section_key VARCHAR(50) PRIMARY KEY,
    section_title VARCHAR(255),
    section_text TEXT
)");

$conn->query("CREATE TABLE IF NOT EXISTS sub_offices_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_name VARCHAR(255),
    district VARCHAR(100),
    address TEXT,
    display_order INT DEFAULT 0
)");

// Initial data for content
$res = $conn->query("SELECT COUNT(*) as count FROM sub_offices_content");
if ($res && $res->fetch_assoc()['count'] == 0) {
    $defaults = [
        ['page_title', 'පිටු මාතෘකාව', 'උපකාර්යාල (විධායක ඉංජිනේරු කාර්යාල)'],
        ['page_subtitle', 'පිටු උප මාතෘකාව', 'වයඹ පළාත පුරා විසිරී ඇති අපගේ උපකාර්යාල ජාලය'],
        ['page_desc', 'පිටු විස්තරය', 'පළාතේ මාර්ග සංවර්ධනය වඩාත් කාර්යක්ෂමව සහ කඩිනමින් සිදුකිරීම උදෙසා අපගේ දෙපාර්තමේන්තුව යටතේ විධායක ඉංජිනේරු කාර්යාල 6ක් ප්‍රධාන දිස්ත්‍රික්ක දෙක ආවරණය වන පරිදි ස්ථාපිත කර ඇත.']
    ];
    $stmt = $conn->prepare("INSERT INTO sub_offices_content (section_key, section_title, section_text) VALUES (?, ?, ?)");
    foreach ($defaults as $d) {
        $stmt->bind_param("sss", $d[0], $d[1], $d[2]);
        $stmt->execute();
    }
}

// Handling updates
if(isset($_POST['update_content'])) {
    foreach($_POST['content'] as $key => $text) {
        $clean_text = $conn->real_escape_string($text);
        $clean_key = $conn->real_escape_string($key);
        $conn->query("UPDATE sub_offices_content SET section_text='$clean_text' WHERE section_key='$clean_key'");
    }
    $message = "විස්තර සාර්ථකව යාවත්කාලීන කරන ලදී!";
}

if(isset($_POST['add_office'])) {
    $name = $conn->real_escape_string($_POST['office_name']);
    $dist = $conn->real_escape_string($_POST['district']);
    $addr = $conn->real_escape_string($_POST['address']);
    $order = (int)$_POST['display_order'];
    $conn->query("INSERT INTO sub_offices_list (office_name, district, address, display_order) VALUES ('$name', '$dist', '$addr', '$order')");
    $message = "නව කාර්යාලය සාර්ථකව එක් කරන ලදී!";
}

if(isset($_POST['delete_office'])) {
    $id = (int)$_POST['office_id'];
    $conn->query("DELETE FROM sub_offices_list WHERE id=$id");
    $message = "කාර්යාලය සාර්ථකව මකා දමන ලදී!";
}

$content_res = $conn->query("SELECT * FROM sub_offices_content");
$content_data = [];
while($row = $content_res->fetch_assoc()) {
    $content_data[$row['section_key']] = $row;
}

$offices_res = $conn->query("SELECT * FROM sub_offices_list ORDER BY display_order ASC");
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sub Offices - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>🏢 උපකාර්යාල සැකසීම (Manage Sub Offices)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">විධායක ඉංජිනේරු කාර්යාල සහ අනෙකුත් උපකාර්යාල ජාලය මෙතැනින් කළමනාකරණය කරන්න.</p>
            </div>
            <a href="../sub-offices.php" target="_blank" class="admin-btn" style="background: white; border: 1px solid #e2e8f0; color: #334155;">🔭 View Page</a>
        </div>

        <?php if(isset($message)) echo "<div class='admin-alert admin-alert-success fade-in'>✅ $message</div>"; ?>

        <div class="admin-grid fade-in">
            <!-- Left: Page Content -->
            <div class="admin-card" style="border-top: 5px solid var(--admin-accent);">
                <h3>පිටුවේ විස්තර (Page Header Content)</h3>
                <form method="post" class="admin-form">
                    <?php foreach($content_data as $key => $data): ?>
                        <label style="margin-top: 15px;"><?= htmlspecialchars($data['section_title']) ?></label>
                        <?php if($key == 'page_desc'): ?>
                            <textarea name="content[<?= $key ?>]" class="admin-textarea" rows="4"><?= htmlspecialchars($data['section_text']) ?></textarea>
                        <?php else: ?>
                            <input type="text" name="content[<?= $key ?>]" class="admin-input" value="<?= htmlspecialchars($data['section_text']) ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <button type="submit" name="update_content" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">විස්තර සුරකින්න</button>
                </form>
            </div>

            <!-- Right: Add Office -->
            <div class="admin-card" style="border-top: 5px solid var(--admin-success);">
                <h3>නව කාර්යාලයක් එක් කරන්න (Add New)</h3>
                <form method="post" class="admin-form">
                    <label>කාර්යාලයේ නම</label>
                    <input type="text" name="office_name" class="admin-input" placeholder="උදා: මහව කාර්යාලය" required>
                    
                    <label>දිස්ත්‍රික්කය</label>
                    <input type="text" name="district" class="admin-input" placeholder="උදා: කුරුණෑගල" required>
                    
                    <label>ලිපිනය / විස්තරය</label>
                    <textarea name="address" class="admin-textarea" rows="3" required></textarea>
                    
                    <label>පෙළගැස්මේ අංකය (Order)</label>
                    <input type="number" name="display_order" class="admin-input" value="0">
                    
                    <button type="submit" name="add_office" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කාර්යාලය එක් කරන්න</button>
                </form>
            </div>
        </div>

        <div class="admin-header fade-in" style="margin-top: 3rem; margin-bottom: 1.5rem;">
            <h2>දැනට පවතින කාර්යාල (Existing Offices)</h2>
        </div>

        <div class="admin-table-container fade-in">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">අංකය</th>
                        <th style="width: 30%;">කාර්යාලයේ නම</th>
                        <th style="width: 20%;">දිස්ත්‍රික්කය</th>
                        <th style="width: 30%;">ලිපිනය</th>
                        <th style="width: 10%;">ක්‍රියාවන්</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($office = $offices_res->fetch_assoc()): ?>
                    <tr>
                        <td style="font-weight: 700; color: var(--admin-accent);">#<?= $office['display_order'] ?></td>
                        <td><div style="font-weight: 700; color: var(--admin-primary);"><?= htmlspecialchars($office['office_name']) ?></div></td>
                        <td><span style="background: #f1f5f9; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: #475569;"><?= htmlspecialchars($office['district']) ?></span></td>
                        <td><div style="font-size: 0.9rem; color: #64748b;"><?= htmlspecialchars($office['address']) ?></div></td>
                        <td>
                            <form method="post" onsubmit="return confirm('මෙම කාර්යාලය මකා දැමීමට අවශ්‍ය බව විශ්වාසද?');">
                                <input type="hidden" name="office_id" value="<?= $office['id'] ?>">
                                <button type="submit" name="delete_office" class="admin-btn admin-btn-danger" style="padding: 8px 12px; font-size: 0.8rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
