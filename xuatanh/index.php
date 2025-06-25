<?php
require '../vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $soLuong = 0;

    // Lấy danh sách ảnh hợp lệ
    $imagePaths = [];
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK && getimagesize($tmpName) !== false) {
            $imagePaths[] = $tmpName;
            $soLuong++;
        }
    }
    if (!empty($imagePaths)) {
        $phpWord = new PhpWord();
        // Kích thước ảnh
        $widthMM = 7.34 * 72;   
        $heightMM = 10.39 * 72; 
        for ($i = 0; $i < $soLuong; $i++) {
            $img = $imagePaths[$i % count($imagePaths)];
            
            // Tạo section mới cho mỗi ảnh
            $section = $phpWord->addSection([
                'marginTop' => 600,
                'marginBottom' => 600,
                'marginLeft' => 600,
                'marginRight' => 600,
            ]);
            
            // Thêm ảnh vào giữa trang
            $section->addImage($img, [
                'width' => $widthMM,
                'height' => $heightMM,
                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_CENTER,
            ]);
        }


        // Xuất file về trình duyệt
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="xuat_anh.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save("php://output");
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