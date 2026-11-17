<?php 
include 'includes/header.php'; 
require_once 'includes/db.php';

// Database Connection
$result = $conn->query("SELECT * FROM downloads ORDER BY created_at DESC");
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/6.jpg.jpg') center/cover;">
    <div class="container">
        <h1>බාගත කිරීම් (Downloads)</h1>
    </div>
</div>

<section class="content-section" style="background: var(--bg-light); min-height: 50vh;">
    <div class="container py-5">
        <?php if($result === false): ?>
            <div class="text-center" style="background: #ffffff; padding: 50px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <h2 class="text-muted" style="margin-bottom: 15px;">පද්ධතිය යාවත්කාලීන වෙමින් පවතී</h2>
                <p>කරුණාකර admin panel එක භාවිතා කිරීම සඳහා දත්ත සමුදාය (Database) Import කරන්න.</p>
            </div>
        <?php elseif($result->num_rows > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; border-top: 4px solid var(--primary-light); padding: 35px 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; align-items: center; text-align: center;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                         <span style="font-size: 3.5rem; margin-bottom: 20px; display: block; color: var(--primary-light);">📄</span>
                        <h3 style="color: var(--primary-color); font-size: 1.3rem; margin-top: 0; margin-bottom: 25px; line-height: 1.4;">
                            <?= htmlspecialchars($row['title']) ?>
                        </h3>
                        <a href="<?= htmlspecialchars($row['file_path']) ?>" class="btn-primary" style="margin-top: auto; display: inline-block; padding: 12px 30px; font-size: 1rem;" download>බාගත කරන්න (Download)</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center" style="background:#ffffff; padding: 60px 40px; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 5px solid var(--secondary-hover);">
                <span style="font-size: 5rem; display:block; margin-bottom: 20px;">📥</span>
                <h2 style="color: var(--primary-color); font-size: 2rem; margin-bottom: 15px;">දැනට බාගත කිරීම් (Downloads) කිසිවක් නොමැත</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">අවශ්‍ය ආකෘති පත්‍ර සහ ලේඛන ඉදිරියේදී මෙහි පළ කරනු ඇත.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
