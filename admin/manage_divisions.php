<?php
require_once 'db.php';
checkLogin();

// Auto-create table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS divisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    icon VARCHAR(10),
    tasks TEXT,
    head_name VARCHAR(255),
    head_title VARCHAR(255),
    head_photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert default data if table is empty
$res = $conn->query("SELECT COUNT(*) as count FROM divisions");
if ($res && $res->fetch_assoc()['count'] == 0) {
    $defaults = [
        ['div-1', 'ආයතන අංශය', '🏛️', "1. කාර්යාල කළමනාකරණය - දෛනිකව කාර්යාලයේ වැඩකටයුතු සැලසුම් කිරීම සහ ඒවා නිසි පරිදි සිදු වනවාදැයි සොයා බැලීම.\n2. ලේඛන නඩත්තුව - ආයතනයට ලැබෙන සහ ආයතනයෙන් පිටතට යවන ලිපි ලේඛන, ලිපි ගොනු සහ වාර්තා ක්‍රමවත්ව ගොනු කර තැබීම.\n3. සන්නිවේදනය - දුරකථන ඇමතුම් , ඊමේල් සහ අනෙකුත් පණිවිඩ අදාළ අංශ වෙත යොමු කිරීම සහ සම්බන්ධීකරණය.\n4. මානව සම්පත් සහාය - සේවකයින්ගේ පැමිණීම සටහන් කිරීම , නිවාඩු අනුමත කිරීම සහ සේවක සුබසාධන කටයුතු සම්බන්ධීකරණය.\n5. නඩත්තු කටයුතු - කාර්යාල ගොඩනැගිල්ල, ගෘහ භාණ්ඩ සහ විදුලි උපකරණවල අලුත් වැඩියා කටයුතු සහ පිරිසිදු කිරීම් අධීක්ෂණය කිරීම.\n6. අමුත්තන් පිළිගැනීම - කාර්යාලයට පැමිණෙන බාහිර පුද්ගලයින්ට සහ සේවාදායකයින්ට අවශ්‍ය මගපෙන්වීම් ලබා දීම.\n7. උත්සව සහ රැස්වීම් සංවිධානය - ආයතනික රැස්වීම්, සම්මුඛ පරීක්ෂණ සහ විවිධ උත්සව සදහා අවශ්‍ය පහසුකම් සලසා දීම.", 'ප්‍රියදර්ශනී', 'පරිපාලන නිළධාරී', 'img/Division/priyadarsani.png'],
        ['div-2', 'වැඩ අංශය', '🏗️', "1. ඇස්තමේන්තු සකස් කිරීම - අලුත් වැඩියාවක් හෝ අලුත් වැඩක් සදහා වැය වන පිරිවැය ගණනයකර වාර්තා පිළියෙළ කිරීම.\n2. ටෙන්ඩර් කටයුතු - අදාල වැඩ කටයුතු සදහා කොන්ත්‍රාත්කරුවන් තෝරා ගැනීමට අවශ්‍ය ලියකියවිලි සකස් කිරීම සහ ටෙන්ඩර් දැන්වීම් සදහා සහාය වීම.\n3. කොන්ත්‍රාත්කරුවන් අධීක්ෂණය - බාහිර පාර්ශවයන් මගින් සිදු කරන වැඩ නිසි ප්‍රමිතියට සහ නියමිත කාලයට අවසන් කරන්නේදැයි සොයා බැලීම.\n4. දේපළ ආරක්ෂාව - ආයතනයේ භෞතික දේපළවලට හානි සිදු නොවීමට වගබලා ගැනීම සහ ඒවායේ ආරක්ෂාව තහවුරු කිරීම.", 'අංශ ප්‍රධානීන්', 'වැඩ අංශය', ''],
        ['div-3', 'ගිණුම් අංශය', '💹', "මූල්‍ය කළමනාකරණය සහ විගණන කටයුතු", 'අංශ ප්‍රධානීන්', 'ගිණුම් අංශය', '']
    ];
    $stmt = $conn->prepare("INSERT INTO divisions (slug, title, icon, tasks, head_name, head_title, head_photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($defaults as $d) {
        $stmt->bind_param("sssssss", $d[0], $d[1], $d[2], $d[3], $d[4], $d[5], $d[6]);
        $stmt->execute();
    }
}

// Update Division Content
if(isset($_POST['update_division'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $icon = $conn->real_escape_string($_POST['icon']);
    $tasks = $conn->real_escape_string($_POST['tasks']);
    $head_name = $conn->real_escape_string($_POST['head_name']);
    $head_title = $conn->real_escape_string($_POST['head_title']);
    
    // Photo upload
    $head_photo = $_POST['existing_photo'];
    if(isset($_FILES['head_photo']) && $_FILES['head_photo']['error'] == 0) {
        $upload_dir = "../img/Division/";
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_name = time() . "_" . basename($_FILES["head_photo"]["name"]);
        $target_file = $upload_dir . $file_name;
        
        if(move_uploaded_file($_FILES["head_photo"]["tmp_name"], $target_file)) {
            $head_photo = "img/Division/" . $file_name;
        }
    }

    $conn->query("UPDATE divisions SET title='$title', icon='$icon', tasks='$tasks', head_name='$head_name', head_title='$head_title', head_photo='$head_photo' WHERE id=$id");
    $message = "අංශයේ විස්තර සාර්ථකව යාවත්කාලීන කරන ලදී! (Division updated successfully!)";
}

$result = $conn->query("SELECT * FROM divisions ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Divisions - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <style>
        .head-section {
            background: #f8fafc;
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }
        .head-photo-container {
            width: 140px;
            text-align: center;
        }
        .head-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: var(--shadow-lg);
            margin-bottom: 1rem;
            background: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>🏛️ අංශ කළමනාකරණය (Manage Divisions)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">දෙපාර්තමේන්තුවේ ප්‍රධාන අංශවල තොරතුරු සහ ප්‍රධානීන්ගේ විස්තර පාලනය කරන්න.</p>
            </div>
            <a href="../divisions.php" target="_blank" class="admin-btn" style="background: white; border: 1px solid #e2e8f0; color: #334155;">🔭 View Page</a>
        </div>

        <?php if(isset($message)) echo "<div class='admin-alert admin-alert-success fade-in'>✅ $message</div>"; ?>

        <div class="div-list fade-in">
            <?php while($division = $result->fetch_assoc()): ?>
            <div class="admin-card" style="margin-bottom: 2rem; border-top: 5px solid var(--admin-accent);">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $division['id'] ?>">
                    <input type="hidden" name="existing_photo" value="<?= $division['head_photo'] ?>">
                    
                    <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 2rem;">
                        <div>
                            <label>අංශයේ නම (Division Title)</label>
                            <input type="text" name="title" class="admin-input" value="<?= htmlspecialchars($division['title']) ?>" required>
                        </div>
                        <div>
                            <label>අයිකනය (Icon - Emoji)</label>
                            <input type="text" name="icon" class="admin-input" value="<?= htmlspecialchars($division['icon']) ?>" required>
                        </div>
                    </div>

                    <label>කාර්යයන් (Tasks)</label>
                    <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-top: -10px; margin-bottom: 10px;">එක් කාර්යයක් බැගින් අලුත් පේළියක ඇතුළත් කරන්න. (New line per task)</p>
                    <textarea name="tasks" class="admin-textarea" rows="5"><?= htmlspecialchars($division['tasks']) ?></textarea>

                    <h4 style="margin-top: 1.5rem; margin-bottom: 1rem; color: var(--admin-primary); border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">අංශ ප්‍රධානියාගේ තොරතුරු (Head of Division)</h4>
                    
                    <div class="head-section">
                        <div class="head-photo-container">
                            <?php if($division['head_photo']): ?>
                                <img src="../<?= $division['head_photo'] ?>" class="head-preview" alt="Head Photo">
                            <?php else: ?>
                                <div class="head-preview">👤</div>
                            <?php endif; ?>
                            <input type="file" name="head_photo" accept="image/*" style="font-size: 0.75rem; width: 130px;">
                        </div>
                        <div style="flex: 1;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label>නම (Name)</label>
                                    <input type="text" name="head_name" class="admin-input" value="<?= htmlspecialchars($division['head_name']) ?>" placeholder="උදා: ජයන්ත පෙරේරා">
                                </div>
                                <div>
                                    <label>තනතුර (Designation)</label>
                                    <input type="text" name="head_title" class="admin-input" value="<?= htmlspecialchars($division['head_title']) ?>" placeholder="උදා: ප්‍රධාන ලිපිකරු">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
                        <button type="submit" name="update_division" class="admin-btn admin-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            විස්තර සුරකින්න (Update Division)
                        </button>
                    </div>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>
