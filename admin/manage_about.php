<?php
require_once 'db.php';
checkLogin();

// Auto-create table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS about_content (
    section_key VARCHAR(50) PRIMARY KEY,
    section_title VARCHAR(255),
    section_text TEXT
)");

// Insert default data if table is empty
$res = $conn->query("SELECT COUNT(*) as count FROM about_content");
if ($res && $res->fetch_assoc()['count'] == 0) {
    $defaults = [
        ['intro', 'හැදින්වීම', 'වයඹ පළාත් සභාව යටතේ ක්‍රියාත්මක වන ප්‍රධානතම තාක්ෂණික ආයතනයක් වන්නේ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුවයි. කුරුණෑගල සහ පුත්තලම යන දිස්ත්‍රික්ක දෙකම ආවරණය වන පරිදි පළාතේ පොදු ප්‍රවාහන ජාලය ශක්තිමත් කිරීම සහ ග්‍රාමීය මෙන්ම නාගරික මාර්ග පද්ධතිය නඩත්තු කිරීම මෙහි ප්‍රධාන වගකීම වේ.'],
        ['task_01', '01. පළාත් මාර්ග ඉදිකිරීම සහ සංවර්ධනය', 'නව මාර්ග පද්ධති සැලසුම් කිරීම සහ පවතින මාර්ග කාපට් (Asphalt) යොදා නවීකරණය කිරීම.'],
        ['task_02', '02. නඩත්තු කටයුතු', 'මාර්ග දෙපස කාණු පද්ධති, පාලම් සහ බෝක්කු නිසි ලෙස නඩත්තු කිරීම.'],
        ['task_03', '03. ගමනාගමන පහසුකම් සැලසීම', 'ජනතාවට බාධාවකින් තොරව ගමනා ගමන කටයුතු සිදුකිරීම සදහා අවශ්‍ය යටිතල පහසුකම් සැලසීම.'],
        ['offices', 'විධායක ඉංජිනේරු කාර්යාල', 'වයඹ පළාත පුරා විසිරී ඇති මාර්ග ජාලය කාර්යක්ෂමව පාලනය කිරීම සහ අධීක්ෂණය කිරීම සදහා විධායක ඉංජිනේරු කාර්යාල 6ක් ස්ථාපිත කර ඇත. මෙම සෑම කාර්යාලයක්ම අදාල ප්‍රදේශයට අයත් මාර්ගවල ප්‍රමිතිය සහ ඉදිකිරීම් කටයුතු පිළිබඳ සෘජු වගකීම දරනු ලබයි. වයඹ පළාතේ ආර්ථික සංවර්ධනයට සෘජුවම දායක වන මෙම දෙපාර්තමේන්තුව කෘෂිකාර්මික නිපැයුම් වෙළඳපොළ කරා ප්‍රවාහනය කිරීමට අවශ්‍ය මංමාවත් සකසා දීම මගින් ප්‍රදේශයේ ජන ජීවිතය ඉහළ නැංවීමට විශාල මෙහෙවරක් ඉටු කරයි.'],
        ['org_chart', 'සංවිධාන සැලැස්ම අන්තර්ගතය', '...... (සංවිධාන සැලැස්ම ඉදිරියේදී යාවත්කාලීන වේ)']
    ];
    $stmt = $conn->prepare("INSERT INTO about_content (section_key, section_title, section_text) VALUES (?, ?, ?)");
    foreach ($defaults as $d) {
        $stmt->bind_param("sss", $d[0], $d[1], $d[2]);
        $stmt->execute();
    }
}

// Update About Content
if(isset($_POST['update_about'])) {
    foreach($_POST['content'] as $key => $text) {
        $clean_text = $conn->real_escape_string($text);
        $clean_key = $conn->real_escape_string($key);
        $conn->query("UPDATE about_content SET section_text='$clean_text' WHERE section_key='$clean_key'");
    }
    $message = "අප ගැන පිටුවේ විස්තර සාර්ථකව යාවත්කාලීන කරන ලදී! (About content updated successfully!)";
}

$result = $conn->query("SELECT * FROM about_content");
$about_data = [];
if($result) {
    while($row = $result->fetch_assoc()) {
        $about_data[$row['section_key']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Page - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>📖 අප ගැන සැකසීම (Manage About Page)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">දෙපාර්තමේන්තුවේ ඉතිහාසය, කාර්යභාරය සහ අනෙකුත් විස්තර මෙතැනින් පාලනය කරන්න.</p>
            </div>
            <a href="../about.php" target="_blank" class="admin-btn" style="background: white; border: 1px solid #e2e8f0; color: #334155;">🔭 View Page</a>
        </div>

        <?php if(isset($message)) echo "<div class='admin-alert admin-alert-success fade-in'>✅ $message</div>"; ?>

        <div class="admin-card fade-in" style="border-top: 5px solid var(--admin-accent);">
            <form method="post" class="admin-form">
                <?php if(!empty($about_data)): ?>
                    <?php foreach($about_data as $key => $data): ?>
                        <div style="margin-bottom: 2rem;">
                            <label style="font-size: 1.1rem; color: var(--admin-primary); margin-bottom: 0.8rem;"><?= htmlspecialchars($data['section_title']) ?></label>
                            <textarea name="content[<?= $key ?>]" class="admin-textarea" rows="<?= (in_array($key, ['intro', 'offices'])) ? 6 : 4 ?>" required><?= htmlspecialchars($data['section_text']) ?></textarea>
                            <div style="width: 100%; height: 1px; background: #f1f5f9; margin-top: 1rem;"></div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div style="display: flex; justify-content: flex-end; position: sticky; bottom: 20px;">
                        <button type="submit" name="update_about" class="admin-btn admin-btn-primary" style="box-shadow: var(--shadow-lg);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            විස්තර යාවත්කාලීන කරන්න (Save All Changes)
                        </button>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: var(--admin-text-muted);">දත්ත පූරණය කිරීමේ දෝෂයක්. (Error loading data)</p>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>
</html>
