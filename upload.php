<?php
// 设置时区和错误显示（可选）
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 获取当前用户名（脚本所有者，应该是 gg888）
$username = get_current_user();
if (empty($username)) {
    echo "❌ 无法获取当前用户名。";
    exit;
}

// 获取上传信息
$filename = $_FILES["fileToUpload"]["name"] ?? '';
$tmp_path = $_FILES["fileToUpload"]["tmp_name"] ?? '';

if (!$filename || !$tmp_path) {
    echo "❌ 没有文件被上传。";
    exit;
}

// 判断是否是特殊文件名
if ($filename === "ips_global.txt") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . $filename;

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已保存到 uploads/<br>";

        // 执行 Python 脚本，并捕获输出
        $cmd = "python uploads/ss.py -f uploads/ips_global.txt --geoip 2>&1";
        $output = shell_exec($cmd);

        // 显示 Python 脚本的输出
        echo "<h3>Python 脚本输出：</h3>";
        echo "<pre>$output</pre>";
    } else {
        echo "❌ 移动文件失败。";
    }

} elseif ($filename === "x.py" || $filename === "ss.py") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($filename);

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已上传到 uploads/<br>";

        // 如果是 x.py，重命名 uploads/x.py 为 upload.py
        if ($filename === "x.py") {
            $dist_file = "uploads/x.py";
            $new_file = "uploads/upload.py";
            if (file_exists($dist_file)) {
                if (rename($dist_file, $new_file)) {
                    echo "✅ 已将 uploads/x.py 重命名为 upload.py<br>";
                } else {
                    echo "❌ 重命名 uploads/x.py 失败<br>";
                }
            } else {
                echo "❌ uploads/x.py 不存在，无法重命名。可能是 pyarmor 未生成文件。<br>";
            }
        }
    } else {
        echo "❌ 上传失败。";
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
      background: #1e1e1e;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <div class="main">
    <div class="upload-box">
      <!-- 你的上传表单代码 -->
    </div>
  </div>
</body>
</html>