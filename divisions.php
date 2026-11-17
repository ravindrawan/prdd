<?php 
include 'includes/header.php'; 
require_once 'includes/db.php';

if(!$conn) {
    echo "<div class='container py-5 text-center'><div class='alert alert-danger'>Database connection failed.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Fetch requested division
$req_slug = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : null;

// Fetch all divisions for the grid
$all_divisions = [];
$res = $conn->query("SELECT * FROM divisions ORDER BY id ASC");
if($res) {
    while($row = $res->fetch_assoc()) {
        $all_divisions[] = $row;
    }
}

// Find current division if requested
$current_division = null;
if($req_slug) {
    foreach($all_divisions as $div) {
        if($div['slug'] === $req_slug) {
            $current_division = $div;
            break;
        }
    }
}

$page_title = $current_division ? $current_division['title'] : 'දෙපාර්තමේන්තුවේ අංශ';
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/2.jpg.jpg') center/cover;">
    <div class="container">
        <h1 id="page-header-title"><?= htmlspecialchars($page_title) ?></h1>
    </div>
</div>

<section class="content-section">
    <div class="container py-5">
        
        <?php if ($current_division): ?>
            <!-- Detail View Header -->
            <a href="divisions.php" class="btn-back">🔙 සියලුම අංශ වෙත (View All Divisions)</a>
        <?php endif; ?>

        <h2 id="section-main-title" class="section-title text-center" style="display: <?= $current_division ? 'none' : 'block' ?>;">දෙපාර්තමේන්තුවේ අංශ</h2>
        
        <style>
            .div-box-card {
                background: #f4f7f6;
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 40px 20px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                min-height: 220px;
                text-decoration: none !important;
            }
            .div-box-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                border-color: var(--secondary-color);
            }
            .div-box-card .div-icon {
                font-size: 3.5rem;
                margin-bottom: 20px;
                transition: transform 0.3s;
            }
            .div-box-card h3 {
                margin: 0;
                font-size: 1.6rem;
                color: var(--primary-color);
                transition: color 0.3s;
            }
            .div-detail-pane {
                background: #ffffff;
                border-radius: 12px;
                padding: 40px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
                border-top: 5px solid var(--primary-color);
                animation: fadeInPane 0.5s ease-out;
            }
            @keyframes fadeInPane {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .task-item {
                display: flex;
                gap: 20px;
                margin-bottom: 1.5rem;
                align-items: flex-start;
                background: #f8fafc;
                padding: 1.5rem;
                border-radius: 10px;
                border-left: 4px solid var(--primary-light);
            }
            .task-item .item-icon {
                background: #ffffff;
                border-radius: 50%;
                min-width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            }
        </style>

        <!-- Grid of Equal Boxes (Select an item) -->
        <div id="divisions-grid" style="display: <?= $current_division ? 'none' : 'grid' ?>; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 50px;">
            <?php foreach($all_divisions as $div): ?>
            <a href="?section=<?= htmlspecialchars($div['slug']) ?>" class="div-box-card">
                <div class="div-icon"><?= htmlspecialchars($div['icon']) ?></div>
                <h3><?= htmlspecialchars($div['title']) ?></h3>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Content Display Area -->
        <div class="division-content-display">
            <?php if ($current_division): ?>
            <div class="div-detail-pane">
                <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                    <div class="division-content" style="flex: 1; min-width: 300px;">
                        <h4 style="color: var(--primary-light); margin-bottom: 1.5rem; font-size: 1.6rem; border-bottom: 2px solid var(--secondary-color); padding-bottom: 10px; display: inline-block;"><?= htmlspecialchars($current_division['title']) ?> - කාර්යයන්</h4>
                        <div class="task-list" style="margin-top: 20px;">
                            <?php 
                            $tasks = explode("\n", $current_division['tasks']);
                            foreach($tasks as $task): 
                                if(trim($task) == "") continue;
                            ?>
                            <div class="task-item">
                                <div class="item-icon">🔹</div>
                                <div style="font-size: 1.1rem; line-height: 1.6;"><?= htmlspecialchars(trim($task)) ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="division-personnel" style="width: 280px; flex-shrink: 0; background: #f8fafc; padding: 35px 25px; border-radius: 16px; border: 1px solid #e2e8f0; text-align: center; align-self: flex-start; position: sticky; top: 120px; box-shadow: 0 10px 15px rgba(0,0,0,0.05);">
                        <?php if($current_division['head_photo']): ?>
                            <img src="<?= htmlspecialchars($current_division['head_photo']) ?>" alt="<?= htmlspecialchars($current_division['head_name']) ?>" style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 6px solid #ffffff; box-shadow: 0 8px 16px rgba(0,0,0,0.15); margin-bottom: 20px; background: #e2e8f0;">
                        <?php else: ?>
                            <div style="width: 180px; height: 180px; border-radius: 50%; border: 6px solid #ffffff; box-shadow: 0 8px 16px rgba(0,0,0,0.15); margin: 0 auto 20px auto; background: var(--bg-light); display: flex; align-items: center; justify-content: center; font-size: 4.5rem;">👤</div>
                        <?php endif; ?>
                        
                        <h4 style="margin-bottom: 10px; color: var(--primary-color); font-size: 1.4rem;"><?= htmlspecialchars($current_division['head_name']) ?></h4>
                        <p style="font-size: 1.1rem; font-weight: 600; margin: 0; color: var(--secondary-hover); background: rgba(234,179,8,0.15); padding: 5px 15px; border-radius: 20px; display: inline-block;"><?= htmlspecialchars($current_division['head_title']) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
