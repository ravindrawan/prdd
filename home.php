<?php 
include 'includes/header.php'; 

require_once 'includes/db.php';

$home_data = [
    'vision' => 'කාර්යක්ෂම හා ඵලදායි පළාත් මාර්ග පද්ධතියක්', 
    'mission' => 'සීමිත සම්පත් දියුණු තාක්ෂණය හා ශිල්පීය නිපුනතාවය ඵලදායි ලෙස කළමනාකරණය කර ගනිමින් වයඹ පළාත් මාර්ග පද්ධතිය කාර්යක්ෂම ප්‍රවාහන මෙහෙයුම් සදහා නිර්මාණය කිරීම හා යථාවත් කාලීනව පවත්වා ගෙන යාම.'
];

$result = $conn->query("SELECT * FROM home_content");
if($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $home_data[$row['section_key']] = $row['section_text'];
    }
}
?>

<?php
// Fetch banners first to avoid white screen on page load
$banner_dir = 'img/banner/';
$banner_images = [];
if(is_dir($banner_dir)){
    $files = scandir($banner_dir);
    foreach($files as $file) {
        if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $banner_images[] = $file;
        }
    }
    sort($banner_images);
}
if(empty($banner_images)) {
    $banner_images = ['1.jpg.jpg'];
}
$first_banner = $banner_images[0];
$js_banner_array = json_encode($banner_images);
?>

<section class="hero-section" style="position: relative; overflow: hidden; padding: 0; display: flex; align-items: center; border: none; background: #001a33 url('img/banner/<?= $first_banner ?>') center/cover no-repeat;">
    
    <!-- Sliding Background Container -->
    <div id="heroSlider" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
        <!-- Images injected via JavaScript -->
    </div>
    
    <!-- Premium Gradient Overlay for Text Readability -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(0,30,60,0.8) 0%, rgba(0,51,102,0.3) 60%, transparent 100%); z-index: 2;"></div>

    <div class="hero-content" style="position: relative; z-index: 3; padding-left: 8%; width: 100%; max-width: 1400px; margin: 0 auto; animation: fadeInUp 1s ease-out;">
        <div style="background: rgba(255,255,255,0.01); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px); padding: 3rem 4rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 15px 30px -10px rgba(0,0,0,0.3); max-width: 750px;">
            <h1 style="font-size: 3.4rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2; text-shadow: 0 4px 15px rgba(0,0,0,0.4); color: #ffffff;">
                වයඹ පළාත් මාර්ග<br><span style="color: var(--secondary-color);">සංවර්ධන දෙපාර්තමේන්තුව</span>
            </h1>
            <p style="font-size: 1.5rem; color: #e2e8f0; margin-bottom: 2rem; font-weight: 300; letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">ගුණාත්මක හා සුරක්ෂිත මාර්ග පද්ධතියක්</p>
            <a href="about.php" class="btn-primary" style="padding: 12px 35px; font-size: 1.1rem; border-radius: 50px; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 10px 20px rgba(234, 179, 8, 0.3);">වැඩිදුර තොරතුරු <span style="font-size: 1.4rem; line-height: 1;">→</span></a>
        </div>
    </div>
</section>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
    .hero-content { padding: 0 5% !important; margin-top: 30px; }
    .hero-content > div { padding: 2rem 1.5rem !important; text-align: center; }
    .hero-content h1 { font-size: 2.2rem !important; }
    .hero-content p { font-size: 1.1rem !important; }
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sliderContainer = document.getElementById('heroSlider');
    const images = <?php echo $js_banner_array; ?>;
    const slides = [];
    
    // Create absolute positioned slides
    images.forEach((img, index) => {
        const slide = document.createElement('div');
        slide.style.position = "absolute";
        slide.style.top = "0";
        slide.style.left = "0";
        slide.style.width = "100%";
        slide.style.height = "100%";
        slide.style.backgroundImage = `url('img/banner/${img}?v=<?php echo time(); ?>')`;
        slide.style.backgroundSize = "cover";
        slide.style.backgroundPosition = "center";
        slide.style.filter = "brightness(1.2) saturate(1.6)";
        slide.style.zIndex = images.length - index;
        slide.style.transition = "transform 1.2s cubic-bezier(0.7, 0, 0.3, 1)";
        sliderContainer.appendChild(slide);
        slides.push(slide);
    });

    let currentIndex = 0;
    const totalSlides = slides.length;
    
    if (totalSlides <= 1) return;

    setInterval(() => {
        const currentSlide = slides[currentIndex];
        
        // Slide current out to left
        currentSlide.style.transform = "translateX(-100%)";
        
        // Prepare for next cycle
        setTimeout(() => {
            // Move current to bottom of stack and reset position
            currentSlide.style.transition = "none";
            currentSlide.style.zIndex = 1;
            currentSlide.style.transform = "translateX(0)";
            
            // Increment z-index of all other slides
            slides.forEach((s, idx) => {
                if (idx !== currentIndex) {
                    let cz = parseInt(s.style.zIndex);
                    s.style.zIndex = cz + 1;
                }
            });
            
            // Reset transition for next time
            setTimeout(() => {
                currentSlide.style.transition = "transform 1.2s cubic-bezier(0.7, 0, 0.3, 1)";
            }, 50);

            currentIndex = (currentIndex + 1) % totalSlides;
        }, 1200); // Match transition duration

    }, 5000); // 5 seconds per slide
});
</script>

<section class="vision-mission-section">
    <div class="container">
        <div class="vm-grid">
            <div class="vm-card" style="padding: 0; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1471107340929-a87cd0f5b5f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="දැක්ම - Vision" style="width: 100%; height: 250px; object-fit: cover; border-bottom: 4px solid var(--secondary-color);">
                <div style="padding: 35px;">
                    <h2 class="vm-title" style="margin-top: 0; margin-bottom: 15px;">දැක්ම</h2>
                    <div class="vm-text">
                        <p style="font-size: 1.15rem;"><?= htmlspecialchars($home_data['vision']) ?></p>
                    </div>
                </div>
            </div>
            <div class="vm-card" style="padding: 0; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="මෙහෙවර - Mission" style="width: 100%; height: 250px; object-fit: cover; border-bottom: 4px solid var(--secondary-color);">
                <div style="padding: 35px;">
                    <h2 class="vm-title" style="margin-top: 0; margin-bottom: 15px;">මෙහෙවර</h2>
                    <div class="vm-text">
                        <p style="font-size: 1.15rem;"><?= htmlspecialchars($home_data['mission']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.director-profile-card {
    display: grid;
    grid-template-columns: 250px 1fr;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    max-width: 900px;
    margin: 0 auto;
    border-bottom: 5px solid var(--primary-color);
}
.dir-img-wrapper {
    background: var(--bg-light);
}
.dir-img-wrapper img {
    width: 100%;
    height: 100%;
    min-height: 250px;
    object-fit: contain;
    object-position: center;
    background: #f8fafc;
}
.dir-info-wrapper {
    padding: 3.5rem 4rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
@media (max-width: 768px) {
    .director-profile-card {
        grid-template-columns: 1fr;
    }
    .dir-img-wrapper img {
        height: 300px;
    }
    .dir-info-wrapper {
        padding: 2rem 1.5rem;
        text-align: center;
    }
}
</style>

<?php
// Get Director Image
$dir_dir = 'img/directer/';
$director_img = 'https://via.placeholder.com/400x500?text=No+Photo';
if(is_dir($dir_dir)){
    $files = scandir($dir_dir);
    foreach($files as $file) {
        if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $director_img = $dir_dir . $file;
            break;
        }
    }
}

// Get Staff Officers from DB
$staff_officers = [];
$staff_res = $conn->query("SELECT * FROM staff_officers ORDER BY display_order ASC, id DESC");
if($staff_res) {
    while($row = $staff_res->fetch_assoc()) {
        $staff_officers[] = $row;
    }
}
?>
<section class="director-section" style="padding: 5rem 0; background: var(--bg-light);">
    <div class="container text-center">
        
        <div class="director-profile-card" style="text-align: left;">
            <div class="dir-img-wrapper">
                <img src="<?= $director_img ?>" alt="<?= htmlspecialchars($home_data['director_name'] ?? 'අධ්‍යක්ෂ') ?>">
            </div>
            
            <div class="dir-info-wrapper">
                <h2 style="font-size: 2.2rem; color: var(--primary-color); margin-bottom: 0.3rem; font-weight: 700;"><?= htmlspecialchars($home_data['director_name'] ?? 'එන්. පී. කුමාරසිංහ මයා') ?></h2>
                <h3 style="font-size: 1.15rem; color: var(--secondary-color); font-weight: 600; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.5px;"><?= htmlspecialchars($home_data['director_title'] ?? 'පළාත් අධ්‍යක්ෂ') ?></h3>
                
                <div style="width: 60px; height: 4px; background: var(--primary-light); margin-bottom: 1.5rem; border-radius: 2px;"></div>
                
                <p style="color: var(--text-main); font-size: 1.15rem; line-height: 1.8; margin-bottom: 1.5rem; font-style: italic;">
                    "<?= htmlspecialchars($home_data['director_quote'] ?? 'වයඹ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව, ගුණාත්මක හා කාර්යක්ෂම මාර්ග පද්ධතියක් තුළින් පළාතේ අනාගත සංවර්ධනය වේගවත් කිරීම සඳහා නිරන්තරයෙන්ම කැපවී සිටී.') ?>"
                </p>
                
                <div style="margin-top: auto; padding-top: 1rem;">
                    <span style="font-weight: 600; color: var(--primary-color);">පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව, වයඹ පළාත</span>
                </div>
            </div>
        </div>

        <?php if(!empty($staff_officers)): ?>
        <div class="staff-section" style="margin-top: 4rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; justify-content: center;">
                <?php foreach($staff_officers as $staff): ?>
                <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: transform 0.3s ease; border-bottom: 4px solid var(--primary-color); max-width: 250px; margin: 0 auto; width: 100%;">
                    <div style="height: 220px; overflow: hidden; background: #f8fafc;">
                        <img src="<?= $staff['image_path'] ?>?v=<?= time() ?>" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div style="padding: 15px; text-align: center;">
                        <h4 style="font-size: 1.1rem; color: var(--primary-color); margin-bottom: 5px; font-weight: 700;"><?= htmlspecialchars($staff['name']) ?></h4>
                        <p style="color: var(--secondary-color); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;"><?= htmlspecialchars($staff['designation']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<section class="features-section">
    <div class="container text-center">
        <h2 class="section-title">අපගේ සේවාවන්</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🛣️</div>
                <h3>මාර්ග සංවර්ධනය</h3>
                <p>වයඹ පළාතේ මාර්ග පද්ධතිය නවීකරණය කිරීම</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏗️</div>
                <h3>පාලම් ඉදි කිරීම</h3>
                <p>ප්‍රවාහන පහසුව සදහා නව පාලම් නිර්මාණය</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔧</div>
                <h3>නඩත්තු කටයුතු</h3>
                <p>පවතින මාර්ග පද්ධති කාර්යක්ෂමව නඩත්තු කිරීම</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
