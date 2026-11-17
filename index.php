<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව | Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Sinhala:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        body.index-page {
            margin: 0;
            padding: 0;
            /* Professional background with a dark, premium overlay */
            background: linear-gradient(rgba(0, 20, 40, 0.75), rgba(0, 30, 60, 0.85)), url('img/banner/1.jpg.jpg') center/cover no-repeat fixed;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Noto Sans Sinhala', 'Inter', sans-serif;
            overflow: hidden;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem 4rem;
            text-align: center;
            max-width: 900px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease-out;
        }

        .glass-panel img {
            height: 110px;
            width: auto;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            border: 2px solid rgba(255,255,255,0.1);
        }

        .welcome-text h1 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.3;
        }

        .welcome-text h2 {
            font-size: 1.5rem;
            margin-bottom: 0.8rem;
            color: #e2e8f0;
            font-weight: 400;
        }

        .welcome-text h3 {
            font-size: 1.3rem;
            margin-bottom: 3rem;
            color: #cbd5e1;
            font-weight: 300;
        }

        .language-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 2rem;
        }

        .lang-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
        }

        .lang-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .lang-card span {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .lang-card small {
            font-size: 0.85rem;
            opacity: 0.7;
            margin-top: 5px;
            font-family: 'Inter', sans-serif;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .language-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .glass-panel {
                padding: 2rem;
            }
            .welcome-text h1 { font-size: 1.6rem; }
            .welcome-text h2 { font-size: 1.2rem; }
            .welcome-text h3 { font-size: 1rem; }
        }
    </style>
</head>
<body class="index-page">

    <div class="glass-panel">
        <img src="img/logo/logo.jpeg" alt="Department Logo">
        
        <div class="welcome-text">
            <h1>පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුවේ නිල වෙබ් අඩවිය වෙත සාදරයෙන් පිළිගනිමු</h1>
            <h2>மாகாண வீதி அபிவிருத்தி திணைக்களத்தின் உத்தியோகபூர்வ இணையதளத்திற்கு நல்வரவு</h2>
            <h3>Welcome to the Official Website of the Provincial Road Development Department</h3>
        </div>
        
        <div class="language-grid">
            <div class="lang-card" onclick="selectLanguageAndEnter('si')">
                <span>සිංහල</span>
                <small>Sinhala</small>
            </div>
            <div class="lang-card" onclick="selectLanguageAndEnter('ta')">
                <span>தமிழ்</span>
                <small>Tamil</small>
            </div>
            <div class="lang-card" onclick="selectLanguageAndEnter('en')">
                <span>English</span>
                <small>English</small>
            </div>
        </div>
    </div>

    <!-- Hidden element for translation plugin if needed -->
    <div id="google_translate_element" style="position: absolute; left: -9999px; visibility: hidden; width: 0; height: 0; overflow: hidden;"></div>

    <script>
        // Set cookie and immediately redirect to home.php
        function selectLanguageAndEnter(lang) {
            const domain = window.location.hostname;
            if (lang === 'si') {
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + domain + ';';
            } else {
                document.cookie = 'googtrans=/si/' + lang + '; path=/;';
                document.cookie = 'googtrans=/si/' + lang + '; path=/; domain=.' + domain + ';';
            }
            
            // Redirect smoothly to the main site
            setTimeout(() => {
                window.location.href = 'home.php';
            }, 150);
        }
    </script>

</body>
</html>
