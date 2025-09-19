<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: REVMA Job Site Reports
Description: Create job site reports with photos and SWMS management
Version: 1.0.0
Author: REVMA PTY LTD
*/

define('JOB_SITE_REPORTS_MODULE_NAME', 'job_site_reports');
define('JOB_SITE_REPORTS_MODULE_UPLOAD_FOLDER', module_dir_path(JOB_SITE_REPORTS_MODULE_NAME, 'uploads'));

hooks()->add_action('admin_init', 'job_site_reports_module_init_menu_items');
hooks()->add_action('app_admin_head', 'job_site_reports_add_head_components');
hooks()->add_filter('module_' . JOB_SITE_REPORTS_MODULE_NAME . '_action_links', 'job_site_reports_module_action_links');

/**
 * Register activation module hook
 */
register_activation_hook(JOB_SITE_REPORTS_MODULE_NAME, 'job_site_reports_module_activation_hook');

function job_site_reports_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(JOB_SITE_REPORTS_MODULE_NAME, [JOB_SITE_REPORTS_MODULE_NAME]);

/**
 * Init module menu items in setup in admin_init hook
 * @return null
 */
function job_site_reports_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('job-site-reports', [
        'name'     => _l('job_site_reports'),
        'href'     => admin_url('job_site_reports'),
        'position' => 30,
        'icon'     => 'fa fa-clipboard',
    ]);

    $capabilities = [];
    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('job_site_reports') . ')',
        'create' => _l('permission_create') . '(' . _l('job_site_reports') . ')',
        'edit'   => _l('permission_edit') . '(' . _l('job_site_reports') . ')',
        'delete' => _l('permission_delete') . '(' . _l('job_site_reports') . ')',
    ];

    register_staff_capabilities('job_site_reports', $capabilities, _l('job_site_reports'));
}

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */
function job_site_reports_module_action_links($actions)
{
    $actions[] = '<a href="' . admin_url('settings?group=job_site_reports') . '">' . _l('settings') . '</a>';
    return $actions;
}

/**
 * Add head components to admin
 */
function job_site_reports_add_head_components()
{
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    
    if (!(strpos($viewuri, '/admin/job_site_reports') === false)) {
        echo '<link href="' . module_dir_url(JOB_SITE_REPORTS_MODULE_NAME, 'assets/css/job_site_reports.css') . '?v=' . get_app_version() . '"  rel="stylesheet" type="text/css" />';
        echo '<script src="' . module_dir_url(JOB_SITE_REPORTS_MODULE_NAME, 'assets/js/job_site_reports.js') . '?v=' . get_app_version() . '"></script>';
    }
}
