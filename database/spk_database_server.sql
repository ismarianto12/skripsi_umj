/*
 Navicat Premium Data Transfer

 Source Server         : LTMP
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : 202.157.176.210:3306
 Source Schema         : spk_database

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 05/04/2021 11:50:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2021_02_23_055730_tmlevel', 1);
INSERT INTO `migrations` VALUES (5, '2021_03_23_165654_tmrap', 1);
INSERT INTO `migrations` VALUES (6, '2021_03_23_165707_tmspk', 1);
INSERT INTO `migrations` VALUES (7, '2021_03_23_165733_trspk_progress', 1);
INSERT INTO `migrations` VALUES (8, '2021_03_23_165839_tmproyek', 1);
INSERT INTO `migrations` VALUES (9, '2021_03_23_165849_tmbangunan', 1);
INSERT INTO `migrations` VALUES (10, '2021_03_23_165901_tmjenis_rap', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for tmbangunan
-- ----------------------------
DROP TABLE IF EXISTS `tmbangunan`;
CREATE TABLE `tmbangunan`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bangunan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmproyek_id` int(30) NULL DEFAULT NULL,
  `ukuran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmbangunan
-- ----------------------------
INSERT INTO `tmbangunan` VALUES (14, 'WUR-CH7', 'Kandang-7', 12, '16x120', 'Wuryantoro', 'Kandang', 'Closed House', '1', '2021-03-31 16:02:18', '2021-04-02 01:54:38');
INSERT INTO `tmbangunan` VALUES (15, 'NGA-01', 'Infrastruktur', 10, '7m x 2000m', 'Ngawi', 'Jalan', 'Infrastruktur', '8', '2021-04-01 13:41:31', '2021-04-02 02:12:02');
INSERT INTO `tmbangunan` VALUES (16, 'NGA-02', 'Finished Good Warehouse', 10, '105m x  60m', 'Ngawi', 'Gudang', 'Warehouse', '8', '2021-04-01 13:44:41', '2021-04-02 02:12:17');
INSERT INTO `tmbangunan` VALUES (17, 'NGA-00', 'Persiapan & Prelim', 10, 'ls', 'Ngawi', 'Persiapan', 'Persiapan', '8', '2021-04-02 06:51:44', '2021-04-04 03:15:27');

-- ----------------------------
-- Table structure for tmjenisrap
-- ----------------------------
DROP TABLE IF EXISTS `tmjenisrap`;
CREATE TABLE `tmjenisrap`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_rap` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_rap` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmjenisrap
-- ----------------------------
INSERT INTO `tmjenisrap` VALUES (10, 'A-BHN', 'BAHAN', 1, '2021-03-26 02:39:37', '2021-03-28 05:30:15');
INSERT INTO `tmjenisrap` VALUES (11, 'B-UPH', 'UPAH', 1, '2021-03-26 02:45:12', '2021-03-28 05:30:29');
INSERT INTO `tmjenisrap` VALUES (12, 'C-ALT', 'PERALATAN', 1, '2021-03-26 02:45:31', '2021-03-28 05:30:43');
INSERT INTO `tmjenisrap` VALUES (13, 'D-SUB', 'SUBKONTRAKTOR', 1, '2021-03-26 02:45:55', '2021-03-28 05:30:56');
INSERT INTO `tmjenisrap` VALUES (14, 'E', 'BIAYA BANK', 1, '2021-03-26 02:46:12', '2021-03-26 02:46:12');
INSERT INTO `tmjenisrap` VALUES (15, 'F-BTL', 'BIAYA UMUM PROYEK', 1, '2021-03-26 02:46:38', '2021-03-28 05:31:17');
INSERT INTO `tmjenisrap` VALUES (16, 'G', 'ASURANSI', 1, '2021-03-26 02:48:24', '2021-03-26 02:48:24');
INSERT INTO `tmjenisrap` VALUES (17, 'H', 'PENYELESAIAN', 1, '2021-03-26 02:49:13', '2021-03-26 02:49:13');
INSERT INTO `tmjenisrap` VALUES (18, 'I', 'PPh FINAL', 1, '2021-03-26 02:49:30', '2021-03-26 02:49:30');

-- ----------------------------
-- Table structure for tmlevel
-- ----------------------------
DROP TABLE IF EXISTS `tmlevel`;
CREATE TABLE `tmlevel`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmlevel
-- ----------------------------
INSERT INTO `tmlevel` VALUES (1, 'Aaa', 'Administrator', '1', '2021-03-25 15:36:57', '2021-03-25 15:36:57');
INSERT INTO `tmlevel` VALUES (2, 'OP1', 'Operator', '1', '2021-03-25 18:56:22', '2021-03-25 18:56:22');

-- ----------------------------
-- Table structure for tmmonitoring_pembayaranspk
-- ----------------------------
DROP TABLE IF EXISTS `tmmonitoring_pembayaranspk`;
CREATE TABLE `tmmonitoring_pembayaranspk`  (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `no_spk` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpspk_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `spk_harga_progres` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_bayar_lalu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_bayar_sekarang` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_bayar_tot` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_byr_sisa_lalu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_bayar_sisa_skrg` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_byr_sisa_total` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmmonitoring_pembayaranspk
-- ----------------------------

-- ----------------------------
-- Table structure for tmprogres_spk
-- ----------------------------
DROP TABLE IF EXISTS `tmprogres_spk`;
CREATE TABLE `tmprogres_spk`  (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `tmrspk_id` int(15) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `spk_progress_lalu` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_progress_skg` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_progress_tot` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_harga_progres` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `spk_harga_sisa` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(14) NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmprogres_spk
-- ----------------------------
INSERT INTO `tmprogres_spk` VALUES (1, 6, '2019-03-29', '2020-03-29', '23', '12', '35', '1,029,822', '-1029822', 1, '2021-03-29 00:03:32', '2021-04-03 08:57:45');

-- ----------------------------
-- Table structure for tmproyek
-- ----------------------------
DROP TABLE IF EXISTS `tmproyek`;
CREATE TABLE `tmproyek`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmbangunan_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_proyek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmlevel_id` int(10) NULL DEFAULT NULL,
  `tmproyek_id` int(30) NULL DEFAULT NULL,
  `tgl_mulai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_selesai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmproyek
-- ----------------------------
INSERT INTO `tmproyek` VALUES (7, 'WMU21-01', NULL, 'Wuryantoro Broiler', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-25 19:26:27', '2021-03-31 15:52:48', 'Wonogiri');
INSERT INTO `tmproyek` VALUES (8, 'WMU21-02', NULL, 'Giritontro RPA', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-26 01:43:19', '2021-03-31 15:53:24', 'Wonogiri');
INSERT INTO `tmproyek` VALUES (9, 'WMU21-03', NULL, 'Pracimantoro Broiler', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-26 03:02:57', '2021-03-31 15:54:34', 'Wonogiri');
INSERT INTO `tmproyek` VALUES (10, 'WMU21-04', NULL, 'Ngawi FeedMill', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-28 05:21:05', '2021-03-31 15:55:14', 'Ngawi');
INSERT INTO `tmproyek` VALUES (11, 'WMU21-05', NULL, 'Semin Breeding', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-28 05:22:01', '2021-03-31 15:56:00', 'Gunung Kidul');
INSERT INTO `tmproyek` VALUES (12, 'WMU21-06', NULL, 'Kwangen Hatchery', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-28 05:22:44', '2021-03-31 15:56:48', 'Gunung Kidul');
INSERT INTO `tmproyek` VALUES (13, 'WMU21-07', NULL, 'Cianjur RPA', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-28 05:23:43', '2021-03-31 15:57:36', 'Cianjur');
INSERT INTO `tmproyek` VALUES (14, 'WMU21-08', NULL, 'Cianjur Broiler', NULL, NULL, '2021-01-01', '2021-12-31', '1', '2021-03-31 15:58:23', '2021-03-31 15:58:23', 'Cianjur');

-- ----------------------------
-- Table structure for tmrap
-- ----------------------------
DROP TABLE IF EXISTS `tmrap`;
CREATE TABLE `tmrap`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tmproyek_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmbangunan_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmjenisrap_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` double(15, 8) NOT NULL,
  `satuan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_harga` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmrap
-- ----------------------------
INSERT INTO `tmrap` VALUES (6, '9', '', '10', 'Beton K-275', 484.00000000, 'm3', '845000.00', '408980000', '1', '2021-03-26 03:13:38', '2021-03-29 09:19:58');

-- ----------------------------
-- Table structure for tmrspk
-- ----------------------------
DROP TABLE IF EXISTS `tmrspk`;
CREATE TABLE `tmrspk`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tmproyek_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmbangunan_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trvendor_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmjenisrap_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_spk` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk_volume` varchar(59) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk_harga_satuan` double(50, 7) NOT NULL,
  `spk_jumlah_harga` double(50, 7) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmrspk
-- ----------------------------
INSERT INTO `tmrspk` VALUES (6, '10', 'undefined', '4', '10', 'AA23', 'Paku Bumi', '2', 'M3', 3400000.0000000, 6.0000000, '2021-04-03', NULL, '2021-04-03 16:59:57', '2021-04-03 09:59:57');

-- ----------------------------
-- Table structure for trvendor
-- ----------------------------
DROP TABLE IF EXISTS `trvendor`;
CREATE TABLE `trvendor`  (
  `kode` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `npwp` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(10) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of trvendor
-- ----------------------------
INSERT INTO `trvendor` VALUES ('LDBN0917', 'Lintasarta', '1234234', 'Bandung', '3424', 'das@asda.com', 1, '2021-03-26 13:25:29', '2021-03-29 00:02:01', 4);
INSERT INTO `trvendor` VALUES ('HLCIM135', 'HOLCHIM Powered cements', '123213', 'asdad', '13123', 'aads@ptlm.com', 1, '2021-03-26 13:30:59', '2021-04-02 02:30:24', 5);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `foto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tmlevel_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmproyek_id` int(30) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin LTMP', 'admin', 'admin@ads.com', NULL, '$2y$10$0lr5R1.wHzJG8rgfuUJIn.ntHIOxrb.qQ8sKu9Fx0aVi7DoMP1ac2', '132-21-03-31.png', NULL, '1', NULL, 'W0C0e9hMn0Z0USNSuHHozYOcbbGoAFmAqTwAtewhrlsdcbVpEx1b9ORUDVCs', NULL, '2021-03-31 08:13:55');
INSERT INTO `users` VALUES (6, 'Operator', 'operator', 'operator@gmail.com', NULL, '$2y$10$dzHvpgoZpD9czsjupOXT7uOrYm71yOYSyhu3AF8N9BL5UW8uMB4oG', NULL, NULL, '2', NULL, NULL, '2021-03-25 18:56:57', '2021-03-25 18:56:57');
INSERT INTO `users` VALUES (8, 'Sumargono', 'margono', 'margono@ptlmp.my.id', NULL, '$2y$10$0lr5R1.wHzJG8rgfuUJIn.ntHIOxrb.qQ8sKu9Fx0aVi7DoMP1ac2', NULL, NULL, '2', 10, NULL, '2021-03-31 16:07:21', '2021-03-31 16:07:21');

SET FOREIGN_KEY_CHECKS = 1;
