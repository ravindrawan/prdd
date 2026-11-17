<?php 
require_once 'includes/db.php';
$success_msg = "";
$error_msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    
    if(!empty($name) && !empty($message)) {
        $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if($conn->query($sql)) {
            // Send Email Notification
            $to = "prddhead@gmail.com";
            $subject = "New Website Message from: $name";
            $email_body = "You have received a new contact form submission.\n\n".
                         "Name: $name\n".
                         "Email: $email\n".
                         "Message:\n$message\n\n".
                         "--- This message was sent from the PRD Website Contact Form ---";
            
            $headers = "From: no-reply@prd.nwp.gov.lk\r\n".
                       "Reply-To: $email\r\n".
                       "X-Mailer: PHP/" . phpversion();
            
            @mail($to, $subject, $email_body, $headers);

            $success_msg = "ඔබගේ පණිවිඩය සාර්ථකව යවන ලදී. අප විසින් ඉක්මනින් ඔබව සම්බන්ධ කර ගනු ඇත!";
        } else {
            $error_msg = "පණිවිඩය යැවීමේදී දෝෂයක් මතු විය. කරුණාකර නැවත උත්සාහ කරන්න.";
        }
    } else {
        $error_msg = "කරුණාකර සියලුම තොරතුරු නිවැරදිව ඇතුළත් කරන්න.";
    }
}
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.45)), url('img/banner/7.jpg.jpg') center/cover;">
    <div class="container">
        <h1>අප අමතන්න (Contact Us)</h1>
    </div>
</div>

<section class="content-section" style="background: var(--bg-light);">
    <div class="container py-5">
        <div class="contact-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            <div class="contact-info-card" style="background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary-color);">
                <h2 style="color: var(--primary-color); margin-top: 0; margin-bottom: 30px;">ප්‍රධාන කාර්යාලය</h2>
                <div class="contact-item" style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 25px;">
                    <span class="c-icon" style="font-size: 2rem; color: var(--secondary-color);">📍</span>
                    <div>
                        <strong style="display: block; font-size: 1.1rem; color: var(--text-main); margin-bottom: 5px;">ලිපිනය</strong>
                        <p style="color: var(--text-muted); line-height: 1.6; margin: 0;">පළාත් අධ්‍යක්ෂ,<br>
                        පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව,<br>
                        තුන්වන මහල, පළාත් සභා කාර්යාල සංකීර්ණය,<br>
                        කුරුණෑගල.</p>
                    </div>
                </div>
                
                <div class="contact-item mt-3" style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 25px;">
                    <span class="c-icon" style="font-size: 2rem; color: var(--secondary-color);">📞</span>
                    <div>
                        <strong style="display: block; font-size: 1.1rem; color: var(--text-main); margin-bottom: 5px;">දුරකථන අංකය</strong>
                        <p style="color: var(--text-muted); margin: 0; font-size: 1.1rem;">037-2231381</p>
                    </div>
                </div>

                <div class="contact-item mt-3" style="display: flex; align-items: flex-start; gap: 15px;">
                    <span class="c-icon" style="font-size: 2rem; color: var(--secondary-color);">✉️</span>
                    <div>
                        <strong style="display: block; font-size: 1.1rem; color: var(--text-main); margin-bottom: 5px;">විද්‍යුත් තැපෑල</strong>
                        <p style="margin: 0;"><a href="mailto:prddhead@gmail.com" style="color: var(--primary-light); text-decoration: none; font-size: 1.1rem;">prddhead@gmail.com</a></p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-card" style="background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--secondary-color);">
                <h2 style="color: var(--primary-color); margin-top: 0; margin-bottom: 20px;">පණිවිඩයක් එවන්න (Send a Message)</h2>
                
                <?php if($success_msg): ?>
                    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #22c55e;">
                        <?= $success_msg ?>
                    </div>
                <?php endif; ?>
                
                <?php if($error_msg): ?>
                    <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #ef4444;">
                        <?= $error_msg ?>
                    </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" class="mt-4">
                    <div class="form-group mb-3" style="margin-bottom: 20px;">
                        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">ඔබගේ නම (Your Name) *</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="නම ඇතුලත් කරන්න" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit;">
                    </div>
                    <div class="form-group mb-3" style="margin-bottom: 20px;">
                        <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">විද්‍යුත් තැපෑල (Your Email)</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email ලිපිනය" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit;">
                    </div>
                    <div class="form-group mb-4" style="margin-bottom: 25px;">
                        <label for="message" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">පණිවිඩය (Message) *</label>
                        <textarea name="message" id="message" rows="5" class="form-control" placeholder="ඔබගේ අදහස හෝ ගැටළුව මෙහි සටහන් කරන්න..." required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit; resize: vertical;"></textarea>
                    </div>
                    <button type="submit" name="send_message" class="btn-primary" style="width: 100%; font-size: 1.1rem; padding: 14px;">පණිවිඩය යවන්න (Send Message)</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
