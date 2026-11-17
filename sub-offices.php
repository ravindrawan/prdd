<?php 
include 'includes/header.php'; 

require_once 'includes/db.php';

// Fetch Content and Lists
$content_res = $conn->query("SELECT * FROM sub_offices_content");
$content = [];
if($content_res && $content_res->num_rows > 0) {
    while($r = $content_res->fetch_assoc()) {
        $content[$r['section_key']] = $r['section_text'];
    }
} else {
    // Fallback
    $content = [
        'page_title' => 'උපකාර්යාල (විධායක ඉංජිනේරු කාර්යාල)',
        'page_subtitle' => 'වයඹ පළාත පුරා විසිරී ඇති අපගේ උපකාර්යාල ජාලය',
        'page_desc' => 'පළාතේ මාර්ග සංවර්ධනය වඩාත් කාර්යක්ෂමව සහ කඩිනමින් සිදුකිරීම උදෙසා අපගේ දෙපාර්තමේන්තුව යටතේ විධායක ඉංජිනේරු කාර්යාල 6ක් ප්‍රධාන දිස්ත්‍රික්ක දෙක ආවරණය වන පරිදි ස්ථාපිත කර ඇත.'
    ];
}

$offices_res = $conn->query("SELECT * FROM sub_offices_list ORDER BY display_order ASC");
$offices = [];
if($offices_res && $offices_res->num_rows > 0) {
    while($o = $offices_res->fetch_assoc()) { $offices[] = $o; }
}

// Default fallback offices if database is empty
if(empty($offices)) {
    $offices = [
        ['office_name' => 'කුරුණෑගල', 'district' => 'කුරුණෑගල', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, කුරුණෑගල'],
        ['office_name' => 'කුලියාපිටිය', 'district' => 'කුරුණෑගල', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, කුලියාපිටිය'],
        ['office_name' => 'මහව', 'district' => 'කුරුණෑගල', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, මහව'],
        ['office_name' => 'ආණමඩුව', 'district' => 'පුත්තලම', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, ආණමඩුව'],
        ['office_name' => 'වාරියපොළ', 'district' => 'කුරුණෑගල', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, වාරියපොළ'],
        ['office_name' => 'හලාවත', 'district' => 'පුත්තලම', 'address' => 'විධායක ඉංජිනේරු කාර්යාලය, හලාවත']
    ];
}

if(isset($_GET['office']) && !empty($_GET['office'])) {
    $filter_search = trim($_GET['office']);
    $filtered = [];
    foreach($offices as $o) {
        if(mb_strpos($o['office_name'], $filter_search) !== false) {
            $filtered[] = $o;
        }
    }
    if(!empty($filtered)) {
        $offices = $filtered;
        $content['page_subtitle'] = $filtered[0]['office_name'] . ' උපකාර්යාලය';
        $content['page_desc'] = 'තෝරාගත් උපකාර්යාලයේ විස්තර පහත දැක්වේ.';
    }
}
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/3.jpg.jpg') center/cover;">
    <div class="container">
        <h1><?= htmlspecialchars($content['page_title'] ?? 'උපකාර්යාල') ?></h1>
    </div>
</div>

<section class="content-section" style="background: var(--bg-light); min-height: 50vh;">
    <div class="container py-5">
        <div class="text-center" style="margin-bottom: 3rem;">
            <h2 style="color: var(--primary-color); font-size: 2rem;"><?= htmlspecialchars($content['page_subtitle'] ?? '') ?></h2>
            <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 800px; margin: 15px auto 0;"><?= htmlspecialchars($content['page_desc'] ?? '') ?></p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php if(!empty($offices)): ?>
                <?php foreach($offices as $index => $office): ?>
                    <div style="background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s; border-left: 5px solid <?= ($office['district'] == 'පුත්තලම' ? 'var(--primary-light)' : 'var(--secondary-color)') ?>;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="font-size: 2.5rem; margin-bottom: 15px;">🏢</div>
                        <h3 style="color: var(--primary-color); margin-bottom: 10px; font-size: 1.4rem;"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>. <?= htmlspecialchars($office['office_name']) ?></h3>
                        <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 0;"><strong>දිස්ත්‍රික්කය:</strong> <?= htmlspecialchars($office['district']) ?> <br><?= nl2br(htmlspecialchars($office['address'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">තවමත් දත්ත ඇතුලත් කර නොමැත.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
