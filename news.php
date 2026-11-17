<?php 
include 'includes/header.php'; 
require_once 'includes/db.php';

// Database Connection for Frontend
$result = $conn->query("SELECT * FROM news ORDER BY date DESC");
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/5.jpg.jpg') center/cover;">
    <div class="container">
        <h1>පුවත් (News)</h1>
    </div>
</div>

<section class="content-section">
    <div class="container py-5">
        <?php if($result === false): ?>
            <!-- Fallback if database is not imported yet -->
            <div class="text-center">
                <h2 class="text-muted">පද්ධතිය යාවත්කාලීන වෙමින් පවතී</h2>
                <p>කරුණාකර admin panel එක භාවිතා කිරීම සඳහා දත්ත සමුදාය (Database) Import කරන්න.</p>
            </div>
        <?php elseif($result->num_rows > 0): ?>
            <!-- Dynamic News Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                <?php while($news = $result->fetch_assoc()): ?>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="color: var(--secondary-hover); font-weight: bold; margin-bottom: 10px; font-size: 0.9rem;">
                            📅 <?= htmlspecialchars($news['date']) ?>
                        </div>
                        <h3 style="color: var(--primary-color); font-size: 1.4rem; margin-top: 0; margin-bottom: 15px;">
                            <?= htmlspecialchars($news['title']) ?>
                        </h3>
                        <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
                            <?= htmlspecialchars($news['content']) ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center">
                <h2 class="text-muted">නව පුවත් නොමැත</h2>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
