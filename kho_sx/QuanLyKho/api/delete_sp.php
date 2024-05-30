<?php
// Include file kết nối đến cơ sở dữ liệu
include("./db_connection.php");

// Kiểm tra xem yêu cầu có phải là phương thức DELETE không
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Nhận dữ liệu từ yêu cầu
    parse_str(file_get_contents("php://input"), $data);
    $Id = isset($data['id']) ? $data['id'] : '';

    // Kiểm tra xem Id có tồn tại không
    if ($Id != '') {
        // Câu lệnh SQL để xóa sản phẩm từ cơ sở dữ liệu
        $sql = "DELETE FROM `SanPham` WHERE `Id` = '$Id'";

        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($con) {
            if ($con->query($sql) === TRUE) {
                // Trả về mã 200 (OK) nếu xóa thành công
                http_response_code(200);
                echo json_encode(array("message" => "Sản phẩm đã được xóa thành công."));
            } else {
                // Trả về mã 500 (Internal Server Error) nếu có lỗi xảy ra khi thực thi câu lệnh SQL
                http_response_code(500);
                echo json_encode(array("message" => "Lỗi khi xóa sản phẩm: " . $con->error));
            }
        } else {
            // Trả về mã 500 (Internal Server Error) nếu không thể kết nối đến cơ sở dữ liệu
            http_response_code(500);
            echo json_encode(array("message" => "Lỗi kết nối đến cơ sở dữ liệu."));
        }
    } else {
        // Trả về mã 400 (Bad Request) nếu dữ liệu 'Id' không tồn tại
        http_response_code(400);
        echo json_encode(array("message" => "Dữ liệu 'Id' không tồn tại."));
    }
} else {
    // Trả về mã 405 (Method Not Allowed) nếu yêu cầu không phải là DELETE
    http_response_code(405);
    echo json_encode(array("message" => "Phương thức yêu cầu không được phép."));
}

// Đóng kết nối đến cơ sở dữ liệu
if ($con) {
    $con->close();
}
?>
