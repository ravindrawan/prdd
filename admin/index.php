<?php
require_once 'db.php';
checkLogin();

// Fetch counts for dashboard stats
$news_count = $conn->query("SELECT COUNT(*) as c FROM news")->fetch_assoc()['c'] ?? 0;
$msg_count = $conn->query("SELECT COUNT(*) as c FROM messages")->fetch_assoc()['c'] ?? 0;
$div_count = $conn->query("SELECT COUNT(*) as c FROM divisions")->fetch_assoc()['c'] ?? 0;
$off_count = $conn->query("SELECT COUNT(*) as c FROM sub_offices_list")->fetch_assoc()['c'] ?? 0;
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Dashboard - PRD Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <style>
        .stat-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 1.5rem;
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }
        .stat-info .count {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 5px;
            color: var(--admin-primary);
        }
        .stat-info .label {
            color: var(--admin-text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="admin-main">
        <div class="admin-header fade-in">
            <div>
                <h1>ප්‍රධාන පාලක පුවරුව (Dashboard)</h1>
                <p style="color: var(--admin-text-muted); margin-top: 5px;">වෙබ් අඩවියේ අන්තර්ගතය මෙතැන් සිට පහසුවෙන් මනාව කළමනාකරණය කරන්න.</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="../index.php" target="_blank" class="admin-btn" style="background: white; border: 1px solid #e2e8f0; color: #334155;">🔭 View Site</a>
                <a href="logout.php" class="admin-btn admin-btn-danger">Logout</a>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="admin-grid fade-in" style="margin-bottom: 2.5rem;">
            <div class="admin-card stat-card" style="border-left: 5px solid var(--admin-accent);">
                <div class="stat-icon" style="background: var(--admin-accent);">📰</div>
                <div class="stat-info">
                    <div class="count"><?= $news_count ?></div>
                    <div class="label">පුවත් (News Updates)</div>
                </div>
            </div>
            <div class="admin-card stat-card" style="border-left: 5px solid var(--admin-success);">
                <div class="stat-icon" style="background: var(--admin-success);">✉️</div>
                <div class="stat-info">
                    <div class="count"><?= $msg_count ?></div>
                    <div class="label">පණිවිඩ (Messages)</div>
                </div>
            </div>
            <div class="admin-card stat-card" style="border-left: 5px solid var(--admin-warning);">
                <div class="stat-icon" style="background: var(--admin-warning);">🏢</div>
                <div class="stat-info">
                    <div class="count"><?= $off_count ?></div>
                    <div class="label">උපකාර්යාල (Offices)</div>
                </div>
            </div>
        </div>

        <div class="admin-header fade-in" style="margin-bottom: 1.5rem;">
            <h2>ප්‍රධාන අංශ (Management Units)</h2>
        </div>

        <div class="admin-grid fade-in">
            <div class="admin-card">
                <h3>🏠 මුල් පිටුව සැකසීම</h3>
                <p style="color:#64748b; margin-bottom: 20px;">මුල් පිටුවේ දැක්ම, මෙහෙවර සහ අධ්‍යක්ෂ මණ්ඩල තොරතුරු වෙනස් කරන්න.</p>
                <a href="manage_home.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කළමනාකරණය</a>
            </div>
            <div class="admin-card">
                <h3>📖 අප ගැන සැකසීම</h3>
                <p style="color:#64748b; margin-bottom: 20px;">දෙපාර්තමේන්තුවේ ඉතිහාසය සහ අනෙකුත් විස්තර යාවත්කාලීන කරන්න.</p>
                <a href="manage_about.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කළමනාකරණය</a>
            </div>
            <div class="admin-card">
                <h3>🏛️ අංශ කළමනාකරණය</h3>
                <p style="color:#64748b; margin-bottom: 20px;">ආයතන, වැඩ සහ ගිණුම් අංශවල තොරතුරු සහ ප්‍රධානීන් වෙනස් කරන්න.</p>
                <a href="manage_divisions.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කළමනාකරණය</a>
            </div>
            <div class="admin-card">
                <h3>📑 ප්‍රසම්පාදන (Tenders)</h3>
                <p style="color:#64748b; margin-bottom: 20px;">ටෙන්ඩර් නිවේදන සහ ලේඛන කළමනාකරණය කරන්න.</p>
                <a href="manage_procurements.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කළමනාකරණය</a>
            </div>
            <div class="admin-card">
                <h3>📥 බාගත කිරීම්</h3>
                <p style="color:#64748b; margin-bottom: 20px;">මහජනතාව සඳහා වැදගත් ෆෝර්ම් සහ ලේඛන උඩුගත කරන්න.</p>
                <a href="manage_downloads.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">කළමනාකරණය</a>
            </div>
            <div class="admin-card">
                <h3>✉️ පණිවිඩ ලැබීම්</h3>
                <p style="color:#64748b; margin-bottom: 20px;">වෙබ් අඩවිය හරහා ජනතාවගෙන් ලැබෙන පණිවිඩ පරීක්ෂා කරන්න.</p>
                <a href="manage_messages.php" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center;">පණිවිඩ බලන්න</a>
            </div>
        </div>
    </main>
</body>
</html>
