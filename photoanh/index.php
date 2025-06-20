<?php
require '../vendor/autoload.php'; // Đảm bảo đã cài đặt phpoffice/phpword qua Composer

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $imagePaths = [];
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
            $imagePaths[] = $tmpName;
        }
    }

    if (!empty($imagePaths)) {
        // Định dạng kích thước theo inch -> mm
        $heightInch = 1.58;
        $widthInch = 1.18;
        $heightMM = $heightInch * 25.4;
        $widthMM = $widthInch * 25.4;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        foreach ($imagePaths as $img) {
            $section->addImage($img, [
    		'width' => $widthInch ,   // 1.18 inch sang mm
    		'height' => $heightInch ,  // 1.58 inch sang mm
		]);
            $section->addTextBreak(1);
        }

        // Xuất file về trình duyệt
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="anh_xuat_word.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save("php://output");
        exit;
    } else {
        echo '<p style="color:red">Không có ảnh hợp lệ được tải lên!</p>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh & Xuất Word (3x4 cm)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h2 {
            color: #0056b3;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="file"] {
            border: 1px solid #ccc;
            padding: 8px;
            border-radius: 4px;
            width: calc(100% - 18px);
            margin-bottom: 15px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        p {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #ffe0e0;
            border: 1px solid #ff0000;
        }
        p[style*="color:red"] {
            color: #d8000c;
        }
    </style>
</head>
<body>
    <h2>Chọn ảnh để xuất ra file Word (ảnh 3x4 cm)</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="images">Ảnh (jpg, jpeg, png):</label><br>
        <input type="file" name="images[]" id="images" multiple accept=".jpg,.jpeg,.png" required><br><br>
        <button type="submit">Tạo file Word</button>
    </form>
</body>
</html>