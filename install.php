<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'job_site_reports')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "job_site_reports` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `project_id` int(11) NULL,
      `staff_id` int(11) NOT NULL,
      `title` varchar(255) NOT NULL,
      `description` text,
      `location` varchar(255) NULL,
      `latitude` decimal(10, 8) NULL,
      `longitude` decimal(11, 8) NULL,
      `weather_conditions` varchar(255) NULL,
      `date_created` datetime NOT NULL,
      `date_updated` datetime NULL,
      PRIMARY KEY (`id`),
      KEY `project_id` (`project_id`),
      KEY `staff_id` (`staff_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'job_site_report_photos')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "job_site_report_photos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `report_id` int(11) NOT NULL,
      `file_name` varchar(255) NOT NULL,
      `original_name` varchar(255) NOT NULL,
      `description` text NULL,
      `date_uploaded` datetime NOT NULL,
      PRIMARY KEY (`id`),
      KEY `report_id` (`report_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// Create uploads folder
$CI->load->helper('file');
$dir = FCPATH . 'modules/job_site_reports/uploads/photos';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Add permissions
if (!$CI->db->table_exists(db_prefix() . 'permissions')) {
    $CI->db->query("INSERT INTO `" . db_prefix() . "permissions` (`name`, `shortname`) VALUES ('Job Site Reports', 'job_site_reports')");
}
