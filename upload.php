<?php
// 设置时区和错误显示（可选）
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 获取上传信息
$filename = $_FILES["fileToUpload"]["name"] ?? '';
$tmp_path = $_FILES["fileToUpload"]["tmp_name"] ?? '';

if (!$filename || !$tmp_path) {
    echo "❌ 没有文件被上传。";
    exit;
}

// 判断是否是特殊文件名
if ($filename === "ips_global.txt") {
    $target_dir = "uploads/dist/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . $filename;

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已保存到 uploads/dist/<br>";

        // 执行 Python 脚本，并捕获输出
        $cmd = "python3 uploads/dist/ss.py -f uploads/dist/ips_global.txt --geoip 2>&1";
        $output = shell_exec($cmd);

        // 显示 Python 脚本的输出
        echo "<h3>Python 脚本输出：</h3>";
        echo "<pre>$output</pre>";
    } else {
        echo "❌ 移动文件失败。";
    }

} else {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($filename);

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已上传到 uploads/";
    } else {
        echo "❌ 上传失败。";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>File Upload</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #121212;
      color: #eeeeee;
      height: 100vh;
      overflow: hidden;
    }

    .main {
      height: calc(100% - 80px);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .upload-box {
      backg
