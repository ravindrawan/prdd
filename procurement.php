<?php 
include 'includes/header.php'; 
require_once 'includes/db.php';

// Database Connection
$result = $conn->query("SELECT * FROM procurements ORDER BY created_at DESC");
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/4.jpg.jpg') center/cover;">
    <div class="container">
        <h1>ප්‍රසම්පාදන (Procurements & Tenders)</h1>
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
            <div style="overflow-x: auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--primary-color); color: white; text-align: left;">
                            <th style="padding: 18px 25px;">අවසන් දිනය (Deadline)</th>
                            <th style="padding: 18px 25px;">මාතෘකාව (Title)</th>
                            <th style="padding: 18px 25px;">විස්තරය (Description)</th>
                            <th style="padding: 18px 25px; text-align: center;">බාගත කිරීම් (File)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#eaefe9'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 18px 25px; font-weight: bold; color: var(--secondary-hover);">
                                    <?= htmlspecialchars($row['deadline'] ? $row['deadline'] : 'දින නියම කර නැත') ?>
                                </td>
                                <td style="padding: 18px 25px; font-weight: 600; color: var(--primary-color);">
                                    <?= htmlspecialchars($row['title']) ?>
                                </td>
                                <td style="padding: 18px 25px; color: var(--text-muted);">
                                    <?= htmlspecialchars($row['description']) ?>
                                </td>
                                <td style="padding: 18px 25px; text-align: center;">
                                    <?php if(!empty($row['file_path'])): ?>
                                        <a href="<?= htmlspecialchars($row['file_path']) ?>" class="btn-primary" style="padding: 8px 20px; font-size: 0.9rem;" download>බාගත කරන්න</a>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.9rem; background: #f1f5f9; padding: 5px 12px; border-radius: 20px;">ගොනු නොමැත</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center" style="background:#ffffff; padding: 60px 40px; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 5px solid var(--secondary-hover);">
                <span style="font-size: 5rem; display:block; margin-bottom: 20px;">📂</span>
                <h2 style="color: var(--primary-color); font-size: 2rem; margin-bottom: 15px;">දැනට ප්‍රසම්පාදන (ටෙන්ඩර්) නිවේදන කිසිවක් නොමැත</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">ඉදිරියේදී නිකුත් වීමට නියමිත ටෙන්ඩර් හා ප්‍රසම්පාදන දැන්වීම් මෙම ස්ථානයෙන් ලබා ගත හැකිය.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
