<?php

// Kiểm tra xem yêu cầu có phải là phương thức POST không
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kiểm tra xem có dữ liệu được gửi từ trình duyệt không
    $postData = json_decode(file_get_contents("php://input"), true);

    if (isset($postData['selectedIds'])) {
        // Lấy danh sách ID sản phẩm được gửi từ trình duyệt
        $selectedIds = $postData['selectedIds'];

        // Kết nối đến cơ sở dữ liệu
        require_once('./db_connection.php');

        // Chuẩn bị câu lệnh SQL để cập nhật sản phẩm
        $sql = "UPDATE sanpham SET TrangThai = '1' WHERE id IN ($selectedIds)";

        // Thực hiện câu lệnh SQL
        if ($conn->query($sql) === TRUE) {
            // Kết quả xử lý thành công
            http_response_code(200);
            echo json_encode(array("message" => "Cập nhật sản phẩm thành công."));
        } else {
            // Xảy ra lỗi khi thực hiện câu lệnh SQL
            http_response_code(500);
            echo json_encode(array("message" => "Lỗi khi cập nhật sản phẩm: " .$con->error));
        }

        // Đóng kết nối
       $con->close();
    } else {
        // Dữ liệu không hợp lệ
        http_response_code(400);
        echo json_encode(array("message" => "Dữ liệu không hợp lệ."));
    }
} else {
    // Phương thức không được hỗ trợ
    http_response_code(405);
    echo json_encode(array("message" => "Phương thức không được hỗ trợ."));
}

?>
