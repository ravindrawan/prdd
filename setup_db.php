<?php
require 'admin/db.php';
$conn->query("INSERT IGNORE INTO home_content (section_key, section_title, section_text) VALUES 
('director_name', 'මාණ්ඩලික නිලධාරී නම', 'එන්. පී. කුමාරසිංහ මයා'), 
('director_title', 'තනතුර', 'පළාත් අධ්‍යක්ෂ'), 
('director_quote', 'ප්‍රකාශය', 'වයඹ පළාත් මාර්ග සංවර්ධන දෙපාර්තමේන්තුව, ගුණාත්මක හා කාර්යක්ෂම මාර්ග පද්ධතියක් තුළින් පළාතේ අනාගත සංවර්ධනය වේගවත් කිරීම සඳහා නිරන්තරයෙන්ම කැපවී සිටී.')");
echo "DB Updated: " . $conn->error;
?>
