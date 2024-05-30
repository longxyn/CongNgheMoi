-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 22, 2024 lúc 07:02 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_thienlong`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocaosx`
--

CREATE TABLE `baocaosx` (
  `Id` int(11) NOT NULL,
  `NgayBC` datetime(5) NOT NULL,
  `IdKHSX` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `baocaosx`
--

INSERT INTO `baocaosx` (`Id`, `NgayBC`, `IdKHSX`) VALUES
(1, '2024-05-01 13:14:26.00000', 5),
(2, '2024-05-16 22:36:00.00000', 5),
(3, '2024-05-16 22:36:00.00000', 5),
(4, '2024-05-22 01:07:00.00000', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bckk`
--

CREATE TABLE `bckk` (
  `Id` int(11) NOT NULL,
  `IdPKK` int(11) NOT NULL,
  `IdNVL` int(11) NOT NULL,
  `SoLuongThieu` int(30) NOT NULL,
  `ChatLuong` varchar(50) DEFAULT '0',
  `TrangThai` varchar(50) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bckk`
--

INSERT INTO `bckk` (`Id`, `IdPKK`, `IdNVL`, `SoLuongThieu`, `ChatLuong`, `TrangThai`) VALUES
(64, 22, 4, 200, '', ''),
(65, 22, 5, 200, '', ''),
(66, 22, 8, -13, '', ''),
(67, 22, 2, 0, '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ct_sp`
--

CREATE TABLE `ct_sp` (
  `IdSP` int(11) NOT NULL,
  `IdNVL` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ct_sp`
--

INSERT INTO `ct_sp` (`IdSP`, `IdNVL`, `SoLuong`) VALUES
(27, 2, 2),
(27, 4, 2),
(27, 5, 2),
(28, 8, 1),
(28, 9, 2),
(28, 10, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhsachquyen`
--

CREATE TABLE `danhsachquyen` (
  `Id` int(11) NOT NULL,
  `IdNV` int(11) NOT NULL,
  `IdQuyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhsachquyen`
--

INSERT INTO `danhsachquyen` (`Id`, `IdNV`, `IdQuyen`) VALUES
(2, 2, 1),
(5, 5, 6),
(6, 6, 3),
(7, 7, 8),
(8, 8, 9),
(9, 9, 10),
(10, 10, 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dgcl`
--

CREATE TABLE `dgcl` (
  `Id` int(11) NOT NULL,
  `NgayDG` datetime(5) NOT NULL,
  `IdNV` int(11) NOT NULL,
  `IdLoSX` int(11) NOT NULL,
  `ChatLuong` varchar(50) NOT NULL,
  `SoLuongDat` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dgcl`
--

INSERT INTO `dgcl` (`Id`, `NgayDG`, `IdNV`, `IdLoSX`, `ChatLuong`, `SoLuongDat`) VALUES
(90, '2024-05-15 00:41:00.00000', 2, 3, '1', 21),
(91, '2024-05-01 00:41:00.00000', 2, 7, '1', 21);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dgcl_nvl`
--

CREATE TABLE `dgcl_nvl` (
  `Id` int(11) NOT NULL,
  `NgayDG` datetime(5) NOT NULL,
  `IdNV` int(11) NOT NULL,
  `IdPNVL` int(11) NOT NULL,
  `ChatLuong` varchar(50) NOT NULL,
  `SoLuongDat` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dgcl_nvl`
--

INSERT INTO `dgcl_nvl` (`Id`, `NgayDG`, `IdNV`, `IdPNVL`, `ChatLuong`, `SoLuongDat`) VALUES
(21, '2024-05-22 23:56:00.00000', 2, 37, '2', 70);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donvitinh`
--

CREATE TABLE `donvitinh` (
  `Id` int(10) NOT NULL,
  `DonVi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donvitinh`
--

INSERT INTO `donvitinh` (`Id`, `DonVi`) VALUES
(1, 'Thùng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kehoachsx`
--

CREATE TABLE `kehoachsx` (
  `Id` int(11) NOT NULL,
  `NgayLapKH` datetime(5) NOT NULL,
  `NgayBD` datetime(5) NOT NULL,
  `NgayHT` datetime(5) NOT NULL,
  `IdLoSX` int(11) NOT NULL,
  `TrangThai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kehoachsx`
--

INSERT INTO `kehoachsx` (`Id`, `NgayLapKH`, `NgayBD`, `NgayHT`, `IdLoSX`, `TrangThai`) VALUES
(5, '2024-04-29 18:06:36.00000', '2024-04-30 18:06:36.00000', '2024-06-05 18:06:36.00000', 7, '999'),
(12, '0000-00-00 00:00:00.00000', '2024-05-18 08:08:00.00000', '2024-05-24 08:08:00.00000', 7, '2'),
(13, '2024-05-07 08:10:00.00000', '2024-05-16 08:10:00.00000', '2024-05-25 08:10:00.00000', 3, '2'),
(14, '2024-05-09 08:58:00.00000', '2024-05-17 08:58:00.00000', '2024-05-23 08:58:00.00000', 3, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `Id` int(11) NOT NULL,
  `TenKH` varchar(50) NOT NULL,
  `Dia_Chi` varchar(150) NOT NULL,
  `SDT` int(10) NOT NULL,
  `Email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho_nvl`
--

CREATE TABLE `kho_nvl` (
  `id_kho_nvl` int(11) NOT NULL,
  `ten_kho_nvl` varchar(50) NOT NULL,
  `dia_chi` varchar(150) NOT NULL,
  `suc_chua` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kho_nvl`
--

INSERT INTO `kho_nvl` (`id_kho_nvl`, `ten_kho_nvl`, `dia_chi`, `suc_chua`) VALUES
(1, 'Kho Tổng', '', '0'),
(2, 'Kho Gò Vấp', '16 Nguyễn Văn Bảo', '5000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho_sp`
--

CREATE TABLE `kho_sp` (
  `id_kho_sp` int(10) NOT NULL,
  `ten_kho_sp` varchar(50) NOT NULL,
  `dia_chi` varchar(150) NOT NULL,
  `suc_chua` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kho_sp`
--

INSERT INTO `kho_sp` (`id_kho_sp`, `ten_kho_sp`, `dia_chi`, `suc_chua`) VALUES
(3, 'Kho Hàng Bình Lợi', '2C Bình Lợi', '50000'),
(4, 'Kho Hàng Gò Vấp', '16 NVB', '400000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lohangsx`
--

CREATE TABLE `lohangsx` (
  `Id` int(11) NOT NULL,
  `IdSP` int(11) NOT NULL,
  `TrangThai` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lohangsx`
--

INSERT INTO `lohangsx` (`Id`, `IdSP`, `TrangThai`, `SoLuong`) VALUES
(3, 28, '2', 20),
(7, 27, '2', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `Id` int(11) NOT NULL,
  `TenNCC` varchar(50) NOT NULL,
  `DienThoai` int(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `DiaChi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`Id`, `TenNCC`, `DienThoai`, `Email`, `DiaChi`) VALUES
(1, 'Thiên Long', 878179279, 'thienlong@long.xyn', '2C BL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `Id` int(11) NOT NULL,
  `TenNV` varchar(50) NOT NULL,
  `DienThoai` int(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DiaChi` varchar(150) NOT NULL,
  `TaiKhoan` varchar(100) NOT NULL,
  `MatKhau` varchar(250) NOT NULL,
  `IsActive` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`Id`, `TenNV`, `DienThoai`, `Email`, `DiaChi`, `TaiKhoan`, `MatKhau`, `IsActive`) VALUES
(2, 'Nguyễn Việt Long', 878179279, 'longxyn@gmail.com', '2C BL', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(5, 'LOng', 123233323, 'thinh@gmail.com', 'addsad', 'qlkho', '21232f297a57a5a743894a0e4a801fc3', 1),
(6, 'kiểm kê', 12039102, 'kiemke@gmail.com', 'kiemkeee', 'kiemke', '21232f297a57a5a743894a0e4a801fc3', 1),
(7, 'Tạ Thị Như Quỳnh', 2131231, 'nhuquynh@gmail.com', '2cBL', 'nvht', '21232f297a57a5a743894a0e4a801fc3', 1),
(8, 'NVSX', 123123312, 'sad@gmail.com', '2C BL', 'nvsx', '21232f297a57a5a743894a0e4a801fc3', 1),
(9, 'Nhân viên đánh giá chất lượng', 878279279, 'longviet@gmail.com', '3C BL', 'nvdgcl', '21232f297a57a5a743894a0e4a801fc3', 1),
(10, 'Như Quỳnh', 92313213, 'nhuquynh1508@gmail.com', '135/6 TQT', 'nvk', '21232f297a57a5a743894a0e4a801fc3', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nvl`
--

CREATE TABLE `nvl` (
  `Id` int(11) NOT NULL,
  `TenNVL` varchar(150) NOT NULL,
  `IdDVT` int(11) NOT NULL,
  `IdNCC` int(11) NOT NULL,
  `GiaMua` double NOT NULL,
  `NgayMua` datetime(6) NOT NULL,
  `SoLuong` int(20) NOT NULL,
  `ChatLuong` varchar(50) NOT NULL,
  `TrangThai` varchar(50) NOT NULL,
  `id_kho_nvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nvl`
--

INSERT INTO `nvl` (`Id`, `TenNVL`, `IdDVT`, `IdNCC`, `GiaMua`, `NgayMua`, `SoLuong`, `ChatLuong`, `TrangThai`, `id_kho_nvl`) VALUES
(2, 'Nguyên liệu 1', 1, 1, 32, '2024-04-24 17:03:00.000000', 60, '1', '1', 2),
(4, 'nguyên liệu 2', 1, 1, 21, '2024-05-22 20:28:00.000000', 310, '1', '0', 1),
(5, 'nguyên liệu 3', 1, 1, 231, '2024-05-24 23:52:00.000000', 305, '1', '1', 2),
(8, 'Vỏ nhựa', 1, 1, 21, '2024-05-18 17:10:00.000000', 441, '1', '0', 1),
(9, 'Bi mực', 1, 1, 200, '2024-04-26 21:29:34.000000', 260, '1', '1', 2),
(10, 'Mực', 1, 1, 1500, '2024-04-26 21:30:07.000000', 380, '1', '1', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieukk`
--

CREATE TABLE `phieukk` (
  `Id` int(11) NOT NULL,
  `NgayLap` datetime(5) NOT NULL,
  `NguoiLap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieukk`
--

INSERT INTO `phieukk` (`Id`, `NgayLap`, `NguoiLap`) VALUES
(22, '2024-04-28 22:58:00.00000', 7),
(23, '2024-04-09 23:00:00.00000', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieumuanvl`
--

CREATE TABLE `phieumuanvl` (
  `Id` int(11) NOT NULL,
  `IdBCKK` int(11) NOT NULL,
  `GiaMua` int(11) NOT NULL,
  `NgayMua` datetime(6) NOT NULL,
  `TrangThai` varchar(50) DEFAULT '0',
  `NguoiMua` int(11) NOT NULL,
  `ChatLuong` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieumuanvl`
--

INSERT INTO `phieumuanvl` (`Id`, `IdBCKK`, `GiaMua`, `NgayMua`, `TrangThai`, `NguoiMua`, `ChatLuong`) VALUES
(33, 66, 21, '2024-05-18 17:10:00.000000', '3', 2, 1),
(35, 65, 231, '2024-05-24 23:52:00.000000', '2', 2, 1),
(37, 64, 21, '2024-05-22 20:28:00.000000', '3', 2, 1),
(38, 67, 234, '2024-05-14 23:47:00.000000', '', 2, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `Id` int(10) NOT NULL,
  `TenQuyen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`Id`, `TenQuyen`) VALUES
(1, 'Ban giám đốc'),
(3, 'Nhân viên kiểm kê'),
(6, 'Quản lý kho'),
(8, 'Nhân viên hệ thống'),
(9, 'Nhân viên sản xuất'),
(10, 'Nhân viên đánh giá chất lượng'),
(11, 'Nhân viên kho');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `Id` int(10) NOT NULL,
  `TenSP` varchar(50) NOT NULL,
  `IdDVT` int(10) NOT NULL,
  `IdNCC` int(10) NOT NULL,
  `GiaBan` float NOT NULL,
  `NgaySX` datetime(6) NOT NULL,
  `SoLuong` int(50) NOT NULL,
  `ChatLuong` varchar(50) NOT NULL DEFAULT '''0''',
  `TrangThai` varchar(50) NOT NULL,
  `id_kho_sp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`Id`, `TenSP`, `IdDVT`, `IdNCC`, `GiaBan`, `NgaySX`, `SoLuong`, `ChatLuong`, `TrangThai`, `id_kho_sp`) VALUES
(27, 'test SP', 1, 1, 2.31344, '2024-06-05 18:06:36.000000', 632, '1', '1', 3),
(28, 'Bút Bi', 1, 1, 30000, '2024-05-25 08:10:00.000000', 841, '1', '1', 3);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baocaosx`
--
ALTER TABLE `baocaosx`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_bcsx_1` (`IdKHSX`);

--
-- Chỉ mục cho bảng `bckk`
--
ALTER TABLE `bckk`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_kk_1` (`IdPKK`),
  ADD KEY `fk_kk_2` (`IdNVL`);

--
-- Chỉ mục cho bảng `ct_sp`
--
ALTER TABLE `ct_sp`
  ADD PRIMARY KEY (`IdSP`,`IdNVL`),
  ADD KEY `IdNVL` (`IdNVL`);

--
-- Chỉ mục cho bảng `danhsachquyen`
--
ALTER TABLE `danhsachquyen`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_q_1` (`IdNV`),
  ADD KEY `fk_q_2` (`IdQuyen`);

--
-- Chỉ mục cho bảng `dgcl`
--
ALTER TABLE `dgcl`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_dg_1` (`IdLoSX`),
  ADD KEY `fk_dg_2` (`IdNV`);

--
-- Chỉ mục cho bảng `dgcl_nvl`
--
ALTER TABLE `dgcl_nvl`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_dg_nvl1` (`IdNV`),
  ADD KEY `fk_dg_nvl2` (`IdPNVL`);

--
-- Chỉ mục cho bảng `donvitinh`
--
ALTER TABLE `donvitinh`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `kehoachsx`
--
ALTER TABLE `kehoachsx`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_khsx_1` (`IdLoSX`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `kho_nvl`
--
ALTER TABLE `kho_nvl`
  ADD PRIMARY KEY (`id_kho_nvl`);

--
-- Chỉ mục cho bảng `kho_sp`
--
ALTER TABLE `kho_sp`
  ADD PRIMARY KEY (`id_kho_sp`);

--
-- Chỉ mục cho bảng `lohangsx`
--
ALTER TABLE `lohangsx`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_lohang_1` (`IdSP`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fqr` (`id_kho_nvl`),
  ADD KEY `fqr2` (`IdNCC`),
  ADD KEY `fqr3` (`IdDVT`);

--
-- Chỉ mục cho bảng `phieukk`
--
ALTER TABLE `phieukk`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `qwe1` (`NguoiLap`);

--
-- Chỉ mục cho bảng `phieumuanvl`
--
ALTER TABLE `phieumuanvl`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_pmnvl_1` (`IdBCKK`),
  ADD KEY `fk_pmnvl_2` (`NguoiMua`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_sp_1` (`IdDVT`),
  ADD KEY `fk_sp_2` (`IdNCC`),
  ADD KEY `fk_sp_3` (`id_kho_sp`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baocaosx`
--
ALTER TABLE `baocaosx`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `bckk`
--
ALTER TABLE `bckk`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `danhsachquyen`
--
ALTER TABLE `danhsachquyen`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `dgcl`
--
ALTER TABLE `dgcl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT cho bảng `dgcl_nvl`
--
ALTER TABLE `dgcl_nvl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `donvitinh`
--
ALTER TABLE `donvitinh`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `kehoachsx`
--
ALTER TABLE `kehoachsx`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `kho_nvl`
--
ALTER TABLE `kho_nvl`
  MODIFY `id_kho_nvl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `kho_sp`
--
ALTER TABLE `kho_sp`
  MODIFY `id_kho_sp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `lohangsx`
--
ALTER TABLE `lohangsx`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `nvl`
--
ALTER TABLE `nvl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `phieukk`
--
ALTER TABLE `phieukk`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `phieumuanvl`
--
ALTER TABLE `phieumuanvl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `quyen`
--
ALTER TABLE `quyen`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocaosx`
--
ALTER TABLE `baocaosx`
  ADD CONSTRAINT `fk_bcsx_1` FOREIGN KEY (`IdKHSX`) REFERENCES `kehoachsx` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `bckk`
--
ALTER TABLE `bckk`
  ADD CONSTRAINT `fk_kk_1` FOREIGN KEY (`IdPKK`) REFERENCES `phieukk` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kk_2` FOREIGN KEY (`IdNVL`) REFERENCES `nvl` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ct_sp`
--
ALTER TABLE `ct_sp`
  ADD CONSTRAINT `ct_sp_ibfk_1` FOREIGN KEY (`IdSP`) REFERENCES `sanpham` (`Id`),
  ADD CONSTRAINT `ct_sp_ibfk_2` FOREIGN KEY (`IdNVL`) REFERENCES `nvl` (`Id`);

--
-- Các ràng buộc cho bảng `danhsachquyen`
--
ALTER TABLE `danhsachquyen`
  ADD CONSTRAINT `fk_q_1` FOREIGN KEY (`IdNV`) REFERENCES `nhanvien` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_q_2` FOREIGN KEY (`IdQuyen`) REFERENCES `quyen` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dgcl`
--
ALTER TABLE `dgcl`
  ADD CONSTRAINT `fk_dg_1` FOREIGN KEY (`IdLoSX`) REFERENCES `lohangsx` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dg_2` FOREIGN KEY (`IdNV`) REFERENCES `nhanvien` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dgcl_nvl`
--
ALTER TABLE `dgcl_nvl`
  ADD CONSTRAINT `fk_dg_nvl1` FOREIGN KEY (`IdNV`) REFERENCES `nhanvien` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dg_nvl2` FOREIGN KEY (`IdPNVL`) REFERENCES `phieumuanvl` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `kehoachsx`
--
ALTER TABLE `kehoachsx`
  ADD CONSTRAINT `fk_khsx_1` FOREIGN KEY (`IdLoSX`) REFERENCES `lohangsx` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lohangsx`
--
ALTER TABLE `lohangsx`
  ADD CONSTRAINT `fk_lohang_1` FOREIGN KEY (`IdSP`) REFERENCES `sanpham` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD CONSTRAINT `fqr` FOREIGN KEY (`id_kho_nvl`) REFERENCES `kho_nvl` (`id_kho_nvl`),
  ADD CONSTRAINT `fqr2` FOREIGN KEY (`IdNCC`) REFERENCES `nhacungcap` (`Id`),
  ADD CONSTRAINT `fqr3` FOREIGN KEY (`IdDVT`) REFERENCES `donvitinh` (`Id`);

--
-- Các ràng buộc cho bảng `phieukk`
--
ALTER TABLE `phieukk`
  ADD CONSTRAINT `qwe1` FOREIGN KEY (`NguoiLap`) REFERENCES `nhanvien` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieumuanvl`
--
ALTER TABLE `phieumuanvl`
  ADD CONSTRAINT `fk_pmnvl_1` FOREIGN KEY (`IdBCKK`) REFERENCES `bckk` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pmnvl_2` FOREIGN KEY (`NguoiMua`) REFERENCES `nhanvien` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sp_1` FOREIGN KEY (`IdDVT`) REFERENCES `donvitinh` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sp_2` FOREIGN KEY (`IdNCC`) REFERENCES `nhacungcap` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sp_3` FOREIGN KEY (`id_kho_sp`) REFERENCES `kho_sp` (`id_kho_sp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
