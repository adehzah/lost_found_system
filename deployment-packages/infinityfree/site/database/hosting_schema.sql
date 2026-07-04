SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `student_otps`;
DROP TABLE IF EXISTS `claims`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `found_items`;
DROP TABLE IF EXISTS `lost_items`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) NOT NULL,
    `batch` int NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint unsigned DEFAULT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text,
    `payload` longtext NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
    `key` varchar(255) NOT NULL,
    `value` mediumtext NOT NULL,
    `expiration` bigint NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` varchar(255) NOT NULL,
    `owner` varchar(255) NOT NULL,
    `expiration` bigint NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `queue` varchar(255) NOT NULL,
    `payload` longtext NOT NULL,
    `attempts` smallint unsigned NOT NULL,
    `reserved_at` int unsigned DEFAULT NULL,
    `available_at` int unsigned NOT NULL,
    `created_at` int unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `total_jobs` int NOT NULL,
    `pending_jobs` int NOT NULL,
    `failed_jobs` int NOT NULL,
    `failed_job_ids` longtext NOT NULL,
    `options` mediumtext,
    `cancelled_at` int DEFAULT NULL,
    `created_at` int NOT NULL,
    `finished_at` int DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `connection` varchar(255) NOT NULL,
    `queue` varchar(255) NOT NULL,
    `payload` longtext NOT NULL,
    `exception` longtext NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
    KEY `failed_jobs_connection_queue_failed_at_index` (`connection`, `queue`, `failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `students` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `full_name` varchar(255) NOT NULL,
    `matric_number` varchar(255) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `phone_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `profile_picture` varchar(255) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `students_matric_number_unique` (`matric_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lost_items` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `reported_by` varchar(255) DEFAULT NULL,
    `matric_number` varchar(255) DEFAULT NULL,
    `item_name` varchar(255) NOT NULL,
    `category` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `location_lost` varchar(255) NOT NULL,
    `date_lost` date NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `contact_number` varchar(255) NOT NULL,
    `status` varchar(255) NOT NULL DEFAULT 'pending',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `lost_items_matric_number_index` (`matric_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `found_items` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `reporter_name` varchar(255) DEFAULT NULL,
    `reported_by` varchar(255) DEFAULT NULL,
    `matric_number` varchar(255) DEFAULT NULL,
    `item_name` varchar(255) NOT NULL,
    `category` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `location_found` varchar(255) NOT NULL,
    `date_found` date NOT NULL,
    `contact_number` varchar(255) NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `status` varchar(255) NOT NULL DEFAULT 'pending',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `found_items_matric_number_index` (`matric_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contact_messages` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `subject` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `status` varchar(255) NOT NULL DEFAULT 'unread',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `claims` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `found_item_id` bigint unsigned NOT NULL,
    `claimant_name` varchar(255) NOT NULL,
    `matric_number` varchar(255) NOT NULL,
    `contact_number` varchar(255) NOT NULL,
    `proof_description` text NOT NULL,
    `proof_image` varchar(255) DEFAULT NULL,
    `status` varchar(255) NOT NULL DEFAULT 'pending',
    `notification_read_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `claims_found_item_id_index` (`found_item_id`),
    KEY `claims_matric_number_index` (`matric_number`),
    CONSTRAINT `claims_found_item_id_foreign` FOREIGN KEY (`found_item_id`) REFERENCES `found_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `student_otps` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `student_id` bigint unsigned NOT NULL,
    `purpose` varchar(255) NOT NULL,
    `channel` varchar(255) NOT NULL,
    `destination` varchar(255) NOT NULL,
    `code_hash` varchar(255) NOT NULL,
    `attempts` tinyint unsigned NOT NULL DEFAULT 0,
    `expires_at` timestamp NOT NULL,
    `verified_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `student_otps_student_id_purpose_channel_index` (`student_id`, `purpose`, `channel`),
    CONSTRAINT `student_otps_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_06_04_005319_create_lost_items_table', 1),
('2026_06_04_080641_create_found_items_table', 1),
('2026_06_04_081353_add_reported_by_to_lost_items_table', 1),
('2026_06_04_081401_add_reported_by_to_found_items_table', 1),
('2026_06_04_084930_add_matric_number_to_lost_items_table', 1),
('2026_06_04_095032_add_extra_fields_to_found_items_table', 1),
('2026_06_04_125506_create_claims_table', 1),
('2026_06_04_220425_create_contact_messages_table', 1),
('2026_06_05_093642_create_students_table', 1),
('2026_06_07_125318_add_profile_picture_to_students_table', 1),
('2026_06_11_151518_add_proof_image_to_claims_table', 1),
('2026_06_19_234227_add_reporter_fields_to_found_items_table', 1),
('2026_06_21_223001_create_contact_messages_table', 1),
('2026_06_24_000000_add_profile_picture_to_students_table', 1),
('2026_06_26_201657_add_notification_read_at_to_claims_table', 1),
('2026_06_26_205931_add_notification_read_at_to_claims_table', 1),
('2026_06_30_000001_add_verification_fields_to_students_table', 1),
('2026_06_30_000002_create_student_otps_table', 1);

SET FOREIGN_KEY_CHECKS=1;
