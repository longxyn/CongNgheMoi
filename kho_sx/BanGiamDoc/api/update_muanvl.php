<?php
// Kết nối đến cơ sở dữ liệu
include("./db_connection.php");

// Kiểm tra xem yêu cầu có phương thức POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đọc dữ liệu từ yêu cầu POST
    parse_str(file_get_contents("php://input"), $data);

    // Kiểm tra xem dữ liệu được gửi lên có tồn tại không
    if (!empty($data['id'])) {
        $id = $data['id'];

        // Cập nhật trạng thái trong bảng phieumuanvl
        $update_kehoachsx = mysqli_query($con, "UPDATE `phieumuanvl`
                                                JOIN `bckk` ON `bckk`.`Id`=`phieumuanvl`.`IdBCKK`
                                                JOIN `nvl` ON `nvl`.`Id`=`bckk`.`IdNVL`
                                                SET `phieumuanvl`.`TrangThai` = 1
                                                WHERE `phieumuanvl`.`Id` = '$id'");

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
} else {
    // Trả về phản hồi lỗi nếu không phải yêu cầu POST
    http_response_code(405);
    echo json_encode(array("message" => "Phương thức không được phép."));
}
?>
