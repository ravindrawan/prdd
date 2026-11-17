<?php
require_once 'db.php';
checkLogin();

// Update Home Content
if(isset($_POST['update_home'])) {
    foreach($_POST['content'] as $key => $text) {
        $clean_text = $conn->real_escape_string($text);
        $clean_key = $conn->real_escape_string($key);
        $conn->query("UPDATE home_content SET section_text='$clean_text' WHERE section_key='$clean_key'");
    }
    $message = "මුල් පිටුවේ විස්තර සාර්ථකව යාවත්කාලීන කරන ලදී! (Home content updated successfully!)";
}

// Upload Banner Image
if(isset($_POST['upload_banner'])) {
    if(isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $upload_dir = "../img/banner/";
        if(!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
        $filename = time() . "_" . basename($_FILES['banner_image']['name']);
        $target_path = $upload_dir . $filename;
        if(move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_path)) {
             $banner_msg = "නව බැනරය සාර්ථකව උඩුගත කරන ලදී! (Banner uploaded!)";
        }
    }
}

// Delete Banner Image
if(isset($_POST['delete_banner'])) {
    $banner_file = $_POST['banner_file'];
    $path = "../img/banner/" . basename($banner_file);
    if(file_exists($path) && is_file($path)) {
        unlink($path);
        $banner_msg = "බැනර් ඡායාරූපය සාර්ථකව මකා දැමුවා! (Banner deleted!)";
    }
}

// Upload Director Photo 
if(isset($_POST['upload_director'])) {
    if(isset($_FILES['director_image']) && $_FILES['director_image']['error'] == 0) {
        $upload_dir = "../img/directer/";
        if(!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
        $files = glob($upload_dir.'*');
        foreach($files as $file){ if(is_file($file)) unlink($file); }
        $filename = "director_" . time() . "." . strtolower(pathinfo($_FILES['director_image']['name'], PATHINFO_EXTENSION));
        if(move_uploaded_file($_FILES['director_image']['tmp_name'], $upload_dir . $filename)) {
             $dir_msg = "පළාත් අධ්‍යක්ෂ ඡායාරූපය යාවත්කාලීන කෙරිණි!";
        }
    }
}

// Upload Staff Photo and Info
if(isset($_POST['upload_staff'])) {
    $name = $conn->real_escape_string($_POST['staff_name']);
    $designation = $conn->real_escape_string($_POST['staff_designation']);
    
    if(isset($_FILES['staff_image']) && $_FILES['staff_image']['error'] == 0) {
        $upload_dir = "../img/staff/";
        if(!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
        $filename = time() . "_" . basename($_FILES['staff_image']['name']);
        if(move_uploaded_file($_FILES['staff_image']['tmp_name'], $upload_dir . $filename)) {
             $conn->query("INSERT INTO staff_officers (name, designation, image_path) VALUES ('$name', '$designation', 'img/staff/$filename')");
             $staff_msg = "මාණ්ඩලික නිලධාරී විස්තර සාර්ථකව ඇතුළත් කරන ලදී!";
        }
    }
}

// Delete Staff Officer
if(isset($_POST['delete_staff'])) {
    $staff_id = (int)$_POST['staff_id'];
    $staff_res = $conn->query("SELECT * FROM staff_officers WHERE id=$staff_id");
    if($staff_row = $staff_res->fetch_assoc()) {
        $path = "../" . $staff_row['image_path'];
        if(file_exists($path) && is_file($path)) {
            unlink($path);
        }
        $conn->query("DELETE FROM staff_officers WHERE id=$staff_id");
        $staff_msg = "නිලධාරී විස්තර සාර්ථකව මකා දැමුවා!";
    }
}

$result = $conn->query("SELECT * FROM home_content");
$home_data = [];
if($result) {
    while($row = $result->fetch_assoc()) {
        $home_data[$row['section_key']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Home Page - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <style>
        .banner-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
        .banner-item { background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid #e2e8f0; }
        .banner-item img { width: 100%; height: 140px; object-fit: cover; }
        .banner-item .actions { padding: 12px; }
        .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; }
        .staff-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; }
        .staff-item img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: var(--shadow-md); margin-bottom: 12px; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>🏠 මුල් පිටුව සැකසීම (Manage Home Page)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">මුල් පිටුවේ පාඨයන්, බැනර් ඡායාරූප සහ නිලධාරී මණ්ඩල තොරතුරු කළමනාකරණය කරන්න.</p>
            </div>
        </div>

        <?php if(isset($message)) echo "<div class='admin-alert admin-alert-success fade-in'>✅ $message</div>"; ?>

        <!-- Vision & Mission Section -->
        <div class="admin-card fade-in" style="border-top: 5px solid var(--admin-accent);">
            <h3 style="margin-bottom: 2rem;">දැක්ම සහ මෙහෙවර (Vision & Mission)</h3>
            <form method="post" class="admin-form">
                <?php if(!empty($home_data)): ?>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <?php foreach($home_data as $key => $data): ?>
                            <div>
                                <label><?= htmlspecialchars($data['section_title']) ?></label>
                                <textarea name="content[<?= $key ?>]" class="admin-textarea" rows="4" required><?= htmlspecialchars($data['section_text']) ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" name="update_home" class="admin-btn admin-btn-primary">යාවත්කාලීන කරන්න (Update Content)</button>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Banner Images Section -->
        <div class="admin-card fade-in" style="border-top: 5px solid var(--admin-warning);">
            <h3 style="margin-bottom: 1.5rem;">බැනර් ඡායාරූප (Main Slider Banners)</h3>
            <?php if(isset($banner_msg)) echo "<div class='admin-alert admin-alert-success'>$banner_msg</div>"; ?>
            
            <form method="post" enctype="multipart/form-data" style="margin-bottom: 2rem; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <label>අලුත් බැනරයක් එක් කරන්න (Upload New Banner):</label>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <input type="file" name="banner_image" accept="image/*" required>
                    <button type="submit" name="upload_banner" class="admin-btn admin-btn-primary">උඩුගත කරන්න (Upload)</button>
                </div>
            </form>

            <div class="banner-grid">
                <?php
                $banner_dir = '../img/banner/';
                if(is_dir($banner_dir)){
                    $files = scandir($banner_dir);
                    foreach($files as $file) {
                        if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            echo '<div class="banner-item">
                                    <img src="'.$banner_dir.$file.'">
                                    <div class="actions">
                                        <form method="post" onsubmit="return confirm(\'Delete this banner?\');">
                                            <input type="hidden" name="banner_file" value="'.$file.'">
                                            <button type="submit" name="delete_banner" class="admin-btn admin-btn-danger" style="width:100%; justify-content:center; padding: 6px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11\" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                  </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Director Section -->
        <div class="admin-card fade-in" style="border-top: 5px solid var(--admin-success);">
            <h3 style="margin-bottom: 1.5rem;">පළාත් අධ්‍යක්ෂ ඡායාරූපය (Director Profile)</h3>
            <?php if(isset($dir_msg)) echo "<div class='admin-alert admin-alert-success'>$dir_msg</div>"; ?>
            <div style="display: flex; gap: 40px; align-items: center; background: #f8fafc; padding: 25px; border-radius: 12px;">
                <div style="text-align: center;">
                    <?php
                    $dir_dir = '../img/directer/';
                    $d_found = false;
                    if(is_dir($dir_dir)){
                        $files = scandir($dir_dir);
                        foreach($files as $file) {
                            if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                echo "<img src='$dir_dir$file' style='height: 180px; width: 160px; object-fit: cover; border-radius: 12px; border: 4px solid white; box-shadow: var(--shadow-md);'>";
                                $d_found = true;
                                break;
                            }
                        }
                    }
                    if(!$d_found) echo '<div style="height: 180px; width:160px; background:#e2e8f0; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:3rem;">👤</div>';
                    ?>
                </div>
                <div style="flex: 1;">
                    <form method="post" enctype="multipart/form-data" class="admin-form">
                        <label>නව ඡායාරූපය තෝරන්න (Select New Photo):</label>
                        <input type="file" name="director_image" accept="image/*" required>
                        <button type="submit" name="upload_director" class="admin-btn admin-btn-primary" style="margin-top: 10px;">ඡායාරූපය යාවත්කාලීන කරන්න</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Staff Officers Section -->
        <div class="admin-card fade-in" style="border-top: 5px solid #6366f1; margin-bottom: 4rem;">
            <h3 style="margin-bottom: 2rem;">මාණ්ඩලික නිලධාරීන් (Staff Officers)</h3>
            <?php if(isset($staff_msg)) echo "<div class='admin-alert admin-alert-success'>$staff_msg</div>"; ?>
            
            <form method="post" enctype="multipart/form-data" class="admin-form" style="margin-bottom: 3rem; background: #f8fafc; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label>නම (Name):</label>
                        <input type="text" name="staff_name" class="admin-input" placeholder="නිලධාරියාගේ නම" required>
                    </div>
                    <div>
                        <label>තනතුර (Designation):</label>
                        <input type="text" name="staff_designation" class="admin-input" placeholder="නිලධාරියාගේ තනතුර" required>
                    </div>
                </div>
                <label>ඡායාරූපය (Profile Photo):</label>
                <div style="display: flex; gap: 20px; align-items: center;">
                    <input type="file" name="staff_image" accept="image/*" required>
                    <button type="submit" name="upload_staff" class="admin-btn admin-btn-primary">නිලධාරියා එක් කරන්න (Add Staff)</button>
                </div>
            </form>

            <div class="staff-grid">
                <?php
                $staff_res = $conn->query("SELECT * FROM staff_officers ORDER BY id DESC");
                while($staff = $staff_res->fetch_assoc()) {
                    echo "<div class='staff-item'>
                            <img src='../{$staff['image_path']}'>
                            <div style='font-weight: 800; color: var(--admin-primary); margin-bottom: 4px;'>".htmlspecialchars($staff['name'])."</div>
                            <div style='color: var(--admin-accent); font-weight: 600; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 15px;'>".htmlspecialchars($staff['designation'])."</div>
                            <form method='post' onsubmit=\"return confirm('මකා දැමීමට අවශ්‍ය බව සහතිකද?');\">
                                <input type='hidden' name='staff_id' value='{$staff['id']}'>
                                <button type='submit' name='delete_staff' class='admin-btn admin-btn-danger' style='width:100%; justify-content:center; padding: 8px; font-size: 0.8rem;'>මකා දමන්න (Delete)</button>
                            </form>
                          </div>";
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
