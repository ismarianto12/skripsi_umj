/*
 Navicat Premium Data Transfer

 Source Server         : Lokal
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : spk_database

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 05/04/2021 11:47:48
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmbangunan
-- ----------------------------
INSERT INTO `tmbangunan` VALUES (8, 'SEM-CH1cssccssss', 'Kandang Close Housce 2 Ltc cccss', NULL, '16x108cs', 'Semincss', 'Close House', 'Breeding Seminc', '1', '2021-03-26 03:01:46', '2021-03-28 02:58:29');
INSERT INTO `tmbangunan` VALUES (12, 'asda', 'asd', 8, 'asd', 'asdad', 'asdad', 'dd', '1', '2021-03-31 02:11:40', '2021-03-31 02:11:40');
INSERT INTO `tmbangunan` VALUES (13, 'asdad', 'adadad', 8, 'adada', 'adadad', 'adad', 'dadadadad', '1', '2021-03-31 02:12:44', '2021-03-31 02:12:44');
INSERT INTO `tmbangunan` VALUES (14, 'adadasdasdada', 'adaddadad', 8, 'asdadad', 'adadadadad', 'dadada', 'dadad', '1', '2021-03-31 06:22:59', '2021-03-31 06:23:06');
INSERT INTO `tmbangunan` VALUES (15, 'VVV', 'adada', 8, 'adada', 'dadadad', 'adadad', 'adad', '1', '2021-03-31 06:33:46', '2021-03-31 06:33:46');
INSERT INTO `tmbangunan` VALUES (17, 'asd', 'qweqeqwe', 7, 'dasda', 'asdada', 'dadsad', 'asdads', '1', '2021-04-01 14:38:58', '2021-04-01 14:38:58');
INSERT INTO `tmbangunan` VALUES (18, 'SHOLAT', 'SHOLAT', 12, 'asda', 'asda', '2333', '3333', '1', '2021-04-01 14:39:20', '2021-04-01 14:39:27');

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmjenisrap
-- ----------------------------
INSERT INTO `tmjenisrap` VALUES (10, 'A', 'BAHAN', 1, '2021-03-26 02:39:37', '2021-03-26 02:39:37');
INSERT INTO `tmjenisrap` VALUES (11, 'B', 'UPAH', 1, '2021-03-26 02:45:12', '2021-03-26 02:45:12');
INSERT INTO `tmjenisrap` VALUES (12, 'C', 'PERALATAN', 1, '2021-03-26 02:45:31', '2021-03-26 02:45:31');
INSERT INTO `tmjenisrap` VALUES (13, 'D', 'SUBKONTRAKTOR', 1, '2021-03-26 02:45:55', '2021-03-26 02:45:55');
INSERT INTO `tmjenisrap` VALUES (14, 'E', 'BIAYA BANK', 1, '2021-03-26 02:46:12', '2021-03-26 02:46:12');
INSERT INTO `tmjenisrap` VALUES (15, 'F', 'BIAYA UMUM PROYEK', 1, '2021-03-26 02:46:38', '2021-03-26 02:46:38');
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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmmonitoring_pembayaranspk
-- ----------------------------
INSERT INTO `tmmonitoring_pembayaranspk` VALUES (5, 'VVVV', '12', '2021-01-02', '2021-04-05', '123,111', '1,313,213', '12,313', '3.7171715520371716e+', '131,231', '31,231,313', '1,232,132,131', 1, '2021-04-05 02:28:57', '2021-04-05 02:29:23');

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
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tmprogres_spk
-- ----------------------------
INSERT INTO `tmprogres_spk` VALUES (3, 12, '2020-12-31', '2021-04-01', '56', '23', '79', '23', '-23', 1, '2021-04-01 01:56:19', '2021-04-05 02:27:38');
INSERT INTO `tmprogres_spk` VALUES (4, 12, '2021-01-01', '2021-04-29', '23', '23', '46', '23,324,242,424', '13847473096', 1, '2021-04-05 02:27:20', '2021-04-05 02:27:56');

-- ----------------------------
-- Table structure for tmproyek
-- ----------------------------
DROP TABLE IF EXISTS `tmproyek`;
CREATE TABLE `tmproyek`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_proyek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmbangunan_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tmlevel_id` int(10) NULL DEFAULT NULL,
  `tgl_mulai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_selesai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmproyek
-- ----------------------------
INSERT INTO `tmproyek` VALUES (7, 'WMU21-01', 'Broiler Wuryantoroasdad', NULL, NULL, '2021-01-29', '2021-01-01', '1', NULL, '2021-03-25 19:26:27', '2021-03-31 06:37:14');
INSERT INTO `tmproyek` VALUES (8, 'WMU21-02', 'RPA Giritontro', '9', NULL, '2021-01-01', '2021-12-31', '1', NULL, '2021-03-26 01:43:19', '2021-03-26 01:59:32');
INSERT INTO `tmproyek` VALUES (9, 'WMU21-03', 'Breeding Semin', '10', NULL, '2021-01-01', '2021-12-31', '1', NULL, '2021-03-26 03:02:57', '2021-03-26 03:02:57');
INSERT INTO `tmproyek` VALUES (10, 'AAasd', 'Broiler Wuryantoroasdasd', '9', NULL, '2021-03-03', '2021-03-04', '1', NULL, '2021-03-28 16:33:01', '2021-03-28 16:33:01');
INSERT INTO `tmproyek` VALUES (11, 'KAMPRET', 'Broiler Wuryantoro', '8', NULL, '2021-03-24', '2021-03-16', '1', NULL, '2021-03-28 16:44:58', '2021-03-28 16:44:58');
INSERT INTO `tmproyek` VALUES (12, 'AA', 'asdad', '8', NULL, '2021-03-01', '2021-03-25', '1', NULL, '2021-03-28 16:45:16', '2021-03-28 16:45:16');
INSERT INTO `tmproyek` VALUES (13, 'asda', 'sdadsad2343242', '9', NULL, '2021-03-25', '2021-03-24', '1', 'asdad', '2021-03-29 18:36:37', '2021-03-29 18:36:37');
INSERT INTO `tmproyek` VALUES (14, 'asd', 'adad', NULL, NULL, '2021-03-09', '2021-03-22', '1', 'adadadadadsa', '2021-03-31 06:34:47', '2021-03-31 06:34:47');
INSERT INTO `tmproyek` VALUES (15, 'asdad', 'adadda', NULL, NULL, '2021-04-01', '2021-03-02', '1', 'adad', '2021-03-31 06:37:07', '2021-03-31 06:37:07');

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
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmrap
-- ----------------------------
INSERT INTO `tmrap` VALUES (11, '8', '9', '14', 'VVV', 56633.00000000, 'M3ff', '400000000.00', '2250000', '1', '2021-03-26 17:15:31', '2021-04-03 08:54:34');
INSERT INTO `tmrap` VALUES (12, '7', '', '13', 'adasd', 2.00000000, '222ff', '22222222.00', '44444444', '1', '2021-03-26 17:32:21', '2021-03-31 17:43:11');
INSERT INTO `tmrap` VALUES (13, '9', '10', '11', '1231424324', 1232.00000000, '5345435', '3213213.00', '395225199', '1', '2021-03-28 16:45:32', '2021-03-31 17:48:28');
INSERT INTO `tmrap` VALUES (14, '9', '10', '12', '23222432', 111.00000000, '222', '22200234', '24642', '1', '2021-03-31 17:47:40', '2021-03-31 17:47:59');
INSERT INTO `tmrap` VALUES (15, '8', '9', '10', '2432', 4234.00000000, 'GG', '2342', '9916028', '1', '2021-03-31 17:49:56', '2021-03-31 17:49:56');
INSERT INTO `tmrap` VALUES (16, '8', '11', '14', '232', 3232.00000000, '2323', '232', '749824', '8', '2021-03-31 19:16:40', '2021-03-31 19:16:40');

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
  `created_at` timestamp(0) NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tmrspk
-- ----------------------------
INSERT INTO `tmrspk` VALUES (12, '7', '17', '4', '10', 'VV', 'Brelin33', '16', 'VV', 2323232220.0000000, 37171715520.0000000, '2021-04-03', NULL, '2021-04-03 08:10:26', '2021-04-03 08:54:22');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of trvendor
-- ----------------------------
INSERT INTO `trvendor` VALUES ('asda', 'asdad', '1234234', '2sadada', '3424', 'das@asda.com', 1, '2021-03-26 13:25:29', '2021-03-26 13:25:29', 4);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tmlevel_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmproyek_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin LTMP', 'admin', 'admin@ads.com', NULL, '$2y$10$0lr5R1.wHzJG8rgfuUJIn.ntHIOxrb.qQ8sKu9Fx0aVi7DoMP1ac2', '132-21-03-31.png', '1', '1', NULL, '2021-03-26 23:45:09', NULL);
INSERT INTO `users` VALUES (6, 'Operator', 'operator', 'operator@gmail.com', NULL, '$2y$10$dzHvpgoZpD9czsjupOXT7uOrYm71yOYSyhu3AF8N9BL5UW8uMB4oG', NULL, '1', '7', NULL, NULL, '2021-03-25 18:56:57');
INSERT INTO `users` VALUES (8, 'Sumargono', 'margono', 'margono@ptlmp.my.id', NULL, '$2y$10$0lr5R1.wHzJG8rgfuUJIn.ntHIOxrb.qQ8sKu9Fx0aVi7DoMP1ac2', NULL, '2', '8', '27fypOLo8qIOxDuCcaMn2PiDIXqQA02JhzNzI3ruQKddO2LrlHzcriCNGi6e', NULL, '2021-03-31 16:07:21');
INSERT INTO `users` VALUES (9, '1231', 'rezqy', '131@asda.com', NULL, '$2y$10$.o/WdrYx1UV1lx2VnU8rSedTH1pUSNTHkQn9/yRdpMLase.QLZIum', '261-21-03-31.png', '2', '8', NULL, '2021-03-31 02:31:27', '2021-03-31 02:31:27');
INSERT INTO `users` VALUES (10, 'adad', 'asda', 'asd@asda.com', NULL, '$2y$10$gUDlaGidz05EZxUnAdBp2OVVSKvlnfNfk8KCsqVwwbbpMoT8aBvPG', '180-21-03-31.jpg', '2', '7', NULL, '2021-03-31 07:53:19', '2021-03-31 07:53:19');

SET FOREIGN_KEY_CHECKS = 1;
