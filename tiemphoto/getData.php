<?php
// Kết nối MySQL
include  'database.php';
 
function getAllData_System() {
    global $conn; // Khai báo sử dụng biến toàn cục
    // Gọi Stored Procedure
    $sql = "SELECT * FROM system WHERE id = 1 "; 
    $result = $conn->query($sql);

    // Kiểm tra kết quả và hiển thị dữ liệu
    if ($result) {
        return $result->fetch_assoc();        
    } else {
        return "Lỗi: " . $conn->error;
    }    
}

?>
