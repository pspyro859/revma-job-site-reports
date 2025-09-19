<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="revma-header">
                                    <img src="<?php echo module_dir_url('job_site_reports', 'assets/images/revma_logo.png'); ?>" alt="REVMA PTY LTD" class="revma-logo">
                                    <h4 class="revma-tagline">for all your electrical solutions</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="job-site-report-title"><?php echo $report->title; ?></h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php if (has_permission('job_site_reports', '', 'edit')) { ?>
                                <a href="<?php echo admin_url('job_site_reports/report/' . $report->id); ?>" class="btn btn-default">
                                    <i class="fa fa-pencil"></i> <?php echo _l('edit'); ?>
                                </a>
                                <?php } ?>
                                <a href="<?php echo admin_url('job_site_reports'); ?>" class="btn btn-default">
                                    <i class="fa fa-list"></i> <?php echo _l('back_to_list'); ?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="row report-info">
                            <div class="col-md-6">
                                <div class="report-info-item">
                                    <span class="report-info-label"><i class="fa fa-calendar"></i> <?php echo _l('date_created'); ?>:</span>
                                    <?php echo _dt($report->date_created); ?>
                                </div>
                                
                                <div class="report-info-item">
                                    <span class="report-info-label"><i class="fa fa-user"></i> <?php echo _l('created_by'); ?>:</span>
                                    <?php
                                    $staff = get_staff($report->staff_id);
                                    if ($staff) {
                                        echo staff_profile_image($staff->staffid, ['staff-profile-image-small'], 'thumb') . ' ' . $staff->firstname . ' ' . $staff->lastname;
                                    }
                                    ?>
                                </div>
                                
                                <div class="report-info-item">
                                    <span class="report-info-label"><i class="fa fa-folder-open"></i> <?php echo _l('project'); ?>:</span>
                                    <?php
                                    if ($report->project_id) {
                                        $this->load->model('projects_model');
                                        $project = $this->projects_model->get($report->project_id);
                                        if ($project) {
                                            echo '<a href="' . admin_url('projects/view/' . $report->project_id) . '">' . $project->name . '</a>';
                                        }
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="report-info-item">
                                    <span class="report-info-label"><i class="fa fa-map-marker"></i> <?php echo _l('location'); ?>
