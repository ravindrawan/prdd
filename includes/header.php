
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව (වයඹ පළාත)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Noto+Sans+Sinhala:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <script src="js/app.js" defer></script>
</head>
<body>
    <header class="main-header">
        <div class="top-bar" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="contact-info">
                <span><a href="tel:0372231381" style="color: inherit; text-decoration: none;">📞 037-2231381</a></span>
                <span><a href="mailto:prddhead@gmail.com" style="color: inherit; text-decoration: none;">✉️ prddhead@gmail.com</a></span>
                <span><a href="https://www.google.com/maps/search/?api=1&query=Provincial+Road+Development+Department+NWP+Kurunegala" target="_blank" style="color: inherit; text-decoration: none;">📌 කුරුණෑගල</a></span>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div class="language-selector" style="display: flex; align-items: center; gap: 10px;">
                    <!-- Hidden Google Translate Element (Must not be display:none) -->
                    <div id="google_translate_element" style="position: absolute; left: -9999px; visibility: hidden; width: 0; height: 0; overflow: hidden;"></div>
                    <button onclick="changeLanguage('si')" class="lang-btn notranslate">සිංහල</button>
                    <button onclick="changeLanguage('ta')" class="lang-btn notranslate">தமிழ்</button>
                    <button onclick="changeLanguage('en')" class="lang-btn notranslate">English</button>
                </div>
            </div>
        </div>
        <div class="header-logo-container">
            <img src="img/logo/logo.jpeg" alt="Logo" style="height: 70px; width: auto; border-radius: 4px; box-shadow: var(--shadow-sm);">
            <div class="header-logo-text">
                <h1>පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව</h1>
                <h2>වයඹ පළාත</h2>
            </div>
        </div>
        <nav class="main-nav">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <ul>
                <li><a href="home.php" class="<?= ($current_page == 'home.php' || $current_page == 'index.php') ? 'active' : '' ?>">මුල් පිටුව</a></li>
                <li><a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : '' ?>">අප ගැන</a></li>
                <li class="has-dropdown">
                    <a href="divisions.php" class="nav-dropdown-link <?= ($current_page == 'divisions.php') ? 'active' : '' ?>">අංශ</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="divisions.php?section=div-1">ආයතන අංශය</a></li>
                        <li><a href="divisions.php?section=div-2">වැඩ අංශය</a></li>
                        <li><a href="divisions.php?section=div-3">ගිණුම් අංශය</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="sub-offices.php" class="nav-dropdown-link <?= ($current_page == 'sub-offices.php') ? 'active' : '' ?>">උපකාර්යාල</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="sub-offices.php?office=කුරුණෑගල">කුරුණෑගල</a></li>
                        <li><a href="sub-offices.php?office=කුලියාපිටිය">කුලියාපිටිය</a></li>
                        <li><a href="sub-offices.php?office=මහව">මහව</a></li>
                        <li><a href="sub-offices.php?office=ආණමඩුව">ආණමඩුව</a></li>
                        <li><a href="sub-offices.php?office=වාරියපොළ">වාරියපොළ</a></li>
                        <li><a href="sub-offices.php?office=හලාවත">හලාවත</a></li>
                    </ul>
                </li>
                <li><a href="procurement.php" class="<?= ($current_page == 'procurement.php') ? 'active' : '' ?>">ප්‍රසම්පාදන</a></li>
                <li><a href="news.php" class="<?= ($current_page == 'news.php') ? 'active' : '' ?>">පුවත්</a></li>
                <li><a href="downloads.php" class="<?= ($current_page == 'downloads.php') ? 'active' : '' ?>">බාගත කිරීම්</a></li>
                <li><a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : '' ?>">අප අමතන්න</a></li>
            </ul>
        </nav>
    </header>
    <main class="page-content">
