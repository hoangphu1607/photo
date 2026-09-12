<?php
require '../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Image;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {

    $imagePaths = [];

    // Duyệt toàn bộ ảnh được upload
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {

        // Kiểm tra lỗi upload
        if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
            continue;
        }

        // Kiểm tra file có thực sự là ảnh
        if (!file_exists($tmpName)) {
            continue;
        }

        if (getimagesize($tmpName) === false) {
            continue;
        }

        $imagePaths[] = $tmpName;
    }

    // Kiểm tra có ảnh hợp lệ hay không
    if (!empty($imagePaths)) {

        $phpWord = new PhpWord();

        // Kích thước ảnh theo point
        // 7.34 cm = khoảng 208 point
        // 10.39 cm = khoảng 295 point
        $width = 208;
        $height = 295;

        // Duyệt từng ảnh
        foreach ($imagePaths as $img) {

            // Mỗi ảnh một trang Word
            $section = $phpWord->addSection([
                'marginTop' => 600,
                'marginBottom' => 600,
                'marginLeft' => 600,
                'marginRight' => 600,
            ]);

            // Thêm ảnh vào section
            $section->addImage($img, [
                'width' => $width,
                'height' => $height,
                'alignment' => Jc::CENTER,
                'posHorizontal' => Image::POSITION_HORIZONTAL_CENTER,
                'posVertical' => Image::POSITION_VERTICAL_CENTER,
            ]);
        }

        // Xuất file Word
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="xuat_anh.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');

        exit;

    } else {
        echo '<p style="color:red">Không có ảnh hợp lệ để xuất!</p>';
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
            margin-bottom: 0px;
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
        .boxType, .boxTypeChild{
            display: flex;
        }
        .boxType{
            gap: 10px
        }
    </style>
</head>
<body>
    <h2>Chọn ảnh để xuất ra file Word</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="images">Ảnh (jpg, jpeg, png):</label><br>
        <input type="file" name="images[]" id="images" multiple accept=".jpg,.jpeg,.png" required><br><br>
        <button type="submit">Tạo file Word</button>
    </form>
</body>
</html>