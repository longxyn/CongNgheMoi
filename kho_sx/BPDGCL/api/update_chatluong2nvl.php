<?php
// Kết nối đến cơ sở dữ liệu
include("./db_connection.php");

// Đọc dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"));

// Kiểm tra xem dữ liệu được gửi lên có tồn tại không
if (!empty($data)) {
    foreach ($data as $item) {
        // Trích xuất dữ liệu từ mỗi mục trong dữ liệu gửi lên
        $id = $item->Id;

        // Cập nhật trạng thái trong bảng kehoachsx
        $update_kehoachsx = mysqli_query($con, "UPDATE dgcl_nvl 
        SET dgcl_nvl.ChatLuong = 0
        WHERE dgcl_nvl.Id = '$id';
        ");

        // Cập nhật trạng thái trong bảng lohangsx (nếu cần)
        // $update_lohangsx = mysqli_query($con, "UPDATE lohangsx SET TrangThai = '$newStatus' WHERE ...");
    }

    // Kiểm tra xem cập nhật có thành công không
    if ($update_kehoachsx) {
        // Trả về phản hồi thành công nếu cập nhật thành công
        http_response_code(200);
        echo json_encode(array("message" => "Cập nhật trạng thái thành công."));
    } else {
        // Trả về phản hồi lỗi nếu cập nhật thất bại
        http_response_code(500);
        echo json_encode(array("message" => "Có lỗi xảy ra khi cập nhật trạng thái."));
    }
} else {
    // Trả về phản hồi lỗi nếu dữ liệu không hợp lệ
    http_response_code(400);
    echo json_encode(array("message" => "Dữ liệu không hợp lệ."));
}
?>
