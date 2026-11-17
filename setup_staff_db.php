<?php
require 'admin/db.php';
$sql = "CREATE TABLE IF NOT EXISTS `staff_officers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if($conn->query($sql)) {
    echo "Table created successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>
