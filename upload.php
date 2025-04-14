<?php
$target_dir = "uploads/";

// 确保上传目录存在
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// 获取上传文件名
$target_file = $target_dir . basename($_FILES["file"]["name"]);

// 移除旧文件（如果存在）
if (file_exists($target_file)) {
    unlink($target_file);
}

// 尝试保存上传文件
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "File uploaded successfully: " . htmlspecialchars(basename($_FILES["file"]["name"]));
} else {
    echo "Error uploading the file.";
}
?>
