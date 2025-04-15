<?php
$uploadDir = "uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES["fileToUpload"];

    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "❌ Error during file upload.";
        exit;
    }

    $fileName = basename($file["name"]);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
        echo "✅ File uploaded successfully: <a href='$targetPath'>$fileName</a>";
    } else {
        echo "❌ Failed to move uploaded file.";
    }
} else {
    echo "Invalid request.";
}
?>
