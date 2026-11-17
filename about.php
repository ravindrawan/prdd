<?php 
include 'includes/header.php'; 

require_once 'includes/db.php';

// Fetch About Content
$res = $conn->query("SELECT * FROM about_content");
$about = [];
if($res && $res->num_rows > 0) {
    while($r = $res->fetch_assoc()) {
        $about[$r['section_key']] = $r['section_text'];
    }
} else {
    // Fallback defaults
    $about = [
        'intro' => 'වයඹ පළාත් සභාව යටතේ ක්‍රියාත්මක වන ප්‍රධානතම තාක්ෂණික ආයතනයක් වන්නේ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුවයි. කුරුණෑගල සහ පුත්තලම යන දිස්ත්‍රික්ක දෙකම ආවරණය වන පරිදි පළාතේ පොදු ප්‍රවාහන ජාලය ශක්තිමත් කිරීම සහ ග්‍රාමීය මෙන්ම නාගරික මාර්ග පද්ධතිය නඩත්තු කිරීම මෙහි ප්‍රධාන වගකීම වේ.',
        'task_01' => 'නව මාර්ග පද්ධති සැලසුම් කිරීම සහ පවතින මාර්ග කාපට් (Asphalt) යොදා නවීකරණය කිරීම.',
        'task_02' => 'මාර්ග දෙපස කාණු පද්ධති, පාලම් සහ බෝක්කු නිසි ලෙස නඩත්තු කිරීම.',
        'task_03' => 'ජනතාවට බාධාවකින් තොරව ගමනා ගමන කටයුතු සිදුකිරීම සදහා අවශ්‍ය යටිතල පහසුකම් සැලසීම.',
        'offices' => 'වයඹ පළාත පුරා විසිරී ඇති මාර්ග ජාලය කාර්යක්ෂමව පාලනය කිරීම සහ අධීක්ෂණය කිරීම සදහා විධායක ඉංජිනේරු කාර්යාල 6ක් ස්ථාපිත කර ඇත. මෙම සෑම කාර්යාලයක්ම අදාල ප්‍රදේශයට අයත් මාර්ගවල ප්‍රමිතිය සහ ඉදිකිරීම් කටයුතු පිළිබඳ සෘජු වගකීම දරනු ලබයි. වයඹ පළාතේ ආර්ථික සංවර්ධනයට සෘජුවම දායක වන මෙම දෙපාර්තමේන්තුව කෘෂිකාර්මික නිපැයුම් වෙළඳපොළ කරා ප්‍රවාහනය කිරීමට අවශ්‍ය මංමාවත් සකසා දීම මගින් ප්‍රදේශයේ ජන ජීවිතය ඉහළ නැංවීමට විශාල මෙහෙවරක් ඉටු කරයි.',
        'org_chart' => '...... (සංවිධාන සැලැස්ම ඉදිරියේදී යාවත්කාලීන වේ)'
    ];
}
?>

<div class="page-header" style="background: linear-gradient(rgba(0,30,60,0.6), rgba(0,30,60,0.6)), url('img/banner/About%20us/1.jpg.jpg') center/cover; padding: 6rem 0;">
    <div class="container">
        <h1 style="font-size: 3.5rem; text-transform: uppercase; letter-spacing: 2px;">අප ගැන <span style="display: block; font-size: 1.2rem; font-weight: 300; margin-top: 10px; letter-spacing: 1px; color: var(--secondary-color);">About PRDD North Western Province</span></h1>
    </div>
</div>

<section class="content-section" style="padding: 6rem 0; background: #fff;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; align-items: center; margin-bottom: 5rem;">
            <div class="about-text">
                <h2 style="font-size: 2.2rem; margin-bottom: 2rem; border-left: 6px solid var(--secondary-color); padding-left: 20px; line-height: 1.3;">පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව <br><span style="color: var(--text-muted); font-size: 1.5rem;">වයඹ පළාත (PRDD NWP)</span></h2>
                <div style="font-size: 1.2rem; color: var(--text-main); line-height: 1.8; text-align: justify;">
                    <p style="margin-bottom: 1.5rem;"><?= htmlspecialchars($about['intro'] ?? '') ?></p>
                    <p>වයඹ පළාතේ ආර්ථික සංවර්ධනයට සෘජුවම දායක වන මෙම දෙපාර්තමේන්තුව කෘෂිකාර්මික නිපැයුම් වෙළඳපොළ කරා ප්‍රවාහනය කිරීමට අවශ්‍ය මංමාවත් සකසා දීම මගින් ප්‍රදේශයේ ජන ජීවිතය ඉහළ නැංවීමට විශාල මෙහෙවරක් ඉටු කරයි.</p>
                </div>
            </div>
            <div style="position: relative;">
                <div style="background: var(--bg-light); border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-lg); border: 1px solid var(--border-color);">
                    <img src="https://images.unsplash.com/photo-1574169208507-84376144848b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="About PRDD" style="width: 100%; height: 350px; object-fit: cover; opacity: 0.9;">
                    <div style="padding: 2.5rem; background: var(--primary-color); color: #fff; text-align: center;">
                        <span style="font-size: 3rem; font-weight: 800; display: block; line-height: 1;">30+</span>
                        <span style="font-size: 1.1rem; text-transform: uppercase;">වසරක සේවය</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 6rem;">
            <h3 style="font-size: 2rem; text-align: center; margin-bottom: 4rem; position: relative;">ප්‍රධාන කාර්යභාරයන් <span style="display: block; width: 60px; height: 4px; background: var(--secondary-color); margin: 15px auto;"></span></h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
                <div style="background: var(--bg-light); padding: 3.5rem 2.5rem; border-radius: 20px; text-align: center; transition: all 0.3s; border: 1px solid transparent; box-shadow: var(--shadow-md);">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">🛣️</div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--primary-color);">මාර්ග ඉදිකිරීම සහ සංවර්ධනය</h4>
                    <p style="color: var(--text-main); line-height: 1.6;"><?= htmlspecialchars($about['task_01'] ?? '') ?></p>
                </div>
                <div style="background: var(--bg-light); padding: 3.5rem 2.5rem; border-radius: 20px; text-align: center; transition: all 0.3s; border: 1px solid transparent; box-shadow: var(--shadow-md);">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">🔧</div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--primary-color);">නඩත්තු කටයුතු (Maintenance)</h4>
                    <p style="color: var(--text-main); line-height: 1.6;"><?= htmlspecialchars($about['task_02'] ?? '') ?></p>
                </div>
                <div style="background: var(--bg-light); padding: 3.5rem 2.5rem; border-radius: 20px; text-align: center; transition: all 0.3s; border: 1px solid transparent; box-shadow: var(--shadow-md);">
                    <div style="font-size: 3.5rem; margin-bottom: 1.5rem;">🚌</div>
                    <h4 style="font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--primary-color);">ගමනාගමන පහසුකම් සැලසීම</h4>
                    <p style="color: var(--text-main); line-height: 1.6;"><?= htmlspecialchars($about['task_03'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <div style="margin-top: 8rem; background: var(--bg-light); padding: 5rem 4rem; border-radius: 30px; border: 1px solid var(--border-color);">
            <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 4rem; align-items: center;">
                <div>
                    <h3 style="font-size: 2rem; margin-bottom: 1.5rem; color: var(--primary-color);">සංවිධාන සැලැස්ම <br><span style="color: var(--text-muted); font-size: 1.2rem; font-weight: 400;">Organization Structure</span></h3>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);"><?= htmlspecialchars($about['org_chart'] ?? '') ?></p>
                </div>
                <div style="background: #fff; padding: 4rem; border-radius: 20px; box-shadow: var(--shadow-sm); border: 2px dashed #cbd5e1; text-align: center; color: var(--text-muted);">
                    <div style="font-size: 3rem; opacity: 0.3; margin-bottom: 1.5rem;">📊</div>
                    <p>[ සංවිධාන සැලසුම් සටහන (Organization Chart) මෙහි දිස්වනු ඇත ]</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
