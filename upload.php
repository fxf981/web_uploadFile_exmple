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

} elseif ($filename === "x.py") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($filename);

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已上传到 uploads/<br>";

        // 执行 pyarmor 命令
        $pyarmor_cmd = "~/.local/bin/pyarmor gen uploads/x.py 2>&1";
        $pyarmor_output = shell_exec($pyarmor_cmd);
        echo "<h3>Pyarmor 输出：</h3>";
        echo "<pre>$pyarmor_output</pre>";

        // 删除 uploads/x.py
        if (file_exists($target_file)) {
            unlink($target_file);
            echo "✅ 已删除 uploads/x.py<br>";
        } else {
            echo "❌ uploads/x.py 不存在，无法删除<br>";
        }

        // 重命名 uploads/dist/x.py 为 upload.py
        $dist_file = "uploads/dist/x.py";
        $new_file = "Uploads/dist/upload.py";
        if (file_exists($dist_file)) {
            if (rename($dist_file, $new_file)) {
                echo "✅ 已将 uploads/dist/x.py 重命名为 upload.py<br>";
            } else {
                echo "❌ 重命名 uploads/dist/x.py 失败<br>";
            }
        } else {
            echo "❌ uploads/dist/x.py 不存在，无法重命名<br>";
        }
    } else {
        echo "❌ 上传失败。";
    }

} elseif ($filename === "ss.py") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($filename);

    if (move_uploaded_file($tmp_path, $target_file)) {
        echo "✅ 文件已上传到 uploads/<br>";

        // 执行 pyarmor 命令
        $pyarmor_cmd = "~/.local/bin/pyarmor gen uploads/ss.py 2>&1";
        $pyarmor_output = shell_exec($pyarmor_cmd);
        echo "<h3>Pyarmor 输出：</h3>";
        echo "<pre>$pyarmor_output</pre>";

        // 删除 uploads/ss.py
        if (file_exists($target_file)) {
            unlink($target_file);
            echo "✅ 已删除 uploads/ss.py<br>";
        } else {
            echo "❌ uploads/ss.py 不存在，无法删除<br>";
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