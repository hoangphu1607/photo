<?php
ob_start(); // Thêm dòng này
require_once '../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $uploadDir = __DIR__ . '/uploads/';
    $hasImage = false;

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        if (is_uploaded_file($tmpName)) {
            $filename = $_FILES['images']['name'][$key];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Kiểm tra định dạng mở rộng hợp lệ
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            // Kiểm tra MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            if (!in_array($mime, ['image/jpeg', 'image/png'])) {
                continue;
            }

            // Đổi tên file tránh trùng
            $newFileName = time() . '_' . uniqid() . '.' . $ext;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($tmpName, $destination)) {
                $hasImage = true;

                $section->addImage(
                    $destination,
                    [
                        'width' => Converter::cmToPixel(3),
                        'height' => Converter::cmToPixel(4),
                        'wrappingStyle' => 'inline',
                    ]
                );
                $section->addTextBreak(1);
            }
        }
    }

    if ($hasImage) {
        $fileName = 'exported_images_' . time() . '.docx';
        $filePath = __DIR__ . '/' . $fileName;

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Xóa file ảnh sau khi sử dụng (tùy chọn)
        foreach (glob($uploadDir . '*') as $file) {
            unlink($file);
        }

        // Đảm bảo không có dữ liệu HTML nào gửi ra trước file Word
        ob_clean();
        flush();

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate");
        header("Expires: 0");

        readfile($filePath);

        // Xoá file Word sau khi gửi
        unlink($filePath);
        exit;
    } else {
        echo "<p style='color:red'>Không có ảnh hợp lệ được tải lên!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh và Xuất Word 3x4cm</title>
</head>
<body>
    <h2>Upload ảnh và Tạo file Word (3x4cm mỗi ảnh)</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Chọn ảnh (jpg, jpeg, png):</label><br>
        <input type="file" name="images[]" multiple accept=".jpg,.jpeg,.png"><br><br>
        <button type="submit">Tạo file Word</button>
    </form>
</body>
</html>
