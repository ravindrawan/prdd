    </main>
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>අපව අමතන්න</h3>
                <p><a href="https://www.google.com/maps/search/?api=1&query=Provincial+Road+Council+Complex+Kurunegala" target="_blank" style="color: inherit; text-decoration: none;">📌 <strong>පළාත් අධ්‍යක්ෂ,</strong><br>
                පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව,<br>
                තුන්වන මහල, පළාත් සභා කාර්යාල සංකීර්ණය,<br>
                කුරුණෑගල.</a></p>
                <div class="contact-details">
                    <span><a href="tel:0372231381" style="color: inherit; text-decoration: none;">📞 037-2231381</a></span>
                    <span><a href="mailto:prddhead@gmail.com" style="color: inherit; text-decoration: none;">✉️ prddhead@gmail.com</a></span>
                </div>
            </div>
            <div class="footer-section">
                <h3>ඉක්මන් සබැඳි</h3>
                <ul class="footer-links">
                    <li><a href="home.php">මුල් පිටුව</a></li>
                    <li><a href="about.php">අප ගැන</a></li>
                    <li><a href="divisions.php">අංශ</a></li>
                    <li><a href="contact.php">අප අමතන්න</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>සමාජ මාධ්‍ය</h3>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">YouTube</a>
                </div>
            </div>
        </div>
        </div>
        <div class="footer-bottom" style="display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 15px;">
            <div>&copy; <?php echo date("Y"); ?> පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව (වයඹ පළාත). සියලුම හිමිකම් ඇවිරිණි.</div>
            
            <?php
            $last_updated = date("Y-m-d"); // Default fallback
            if (isset($conn) && $conn) {
                // Get the most recent update across tables. For now we use the news table dynamically updated by Admin.
                $res = $conn->query("SELECT MAX(created_at) as last_update FROM news");
                if ($res && $row = $res->fetch_assoc()) {
                    if (!empty($row['last_update'])) {
                        $last_updated = date('Y-m-d', strtotime($row['last_update']));
                    }
                }
            }
            ?>
            <div title="Last Updated Date (අවසන් වරට යාවත්කාලීන කළ දිනය)" style="font-size: 0.85rem; color: #facc15; font-weight: 600; margin-top: 5px;">
                <span class="notranslate">🔄</span> අවසන් යාවත්කාලීනය: <span class="notranslate"><?php echo $last_updated; ?></span>
            </div>
        </div>
    </footer>

    <!-- Google Translate Script -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'si', includedLanguages: 'si,ta,en', autoDisplay: false}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
