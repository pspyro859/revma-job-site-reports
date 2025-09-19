<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin">
                                    <?php echo _l('job_site_reports'); ?>
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php if (has_permission('job_site_reports', '', 'create')) { ?>
                                <a href="<?php echo admin_url('job_site_reports/report'); ?>" class="btn btn-danger">
                                    <i class="fa fa-plus"></i> <?php echo _l('new_job_site_report'); ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table dt-table" data-order-col="5" data-order-type="desc">
                                        <thead>
                                            <tr>
                                                <th><?php echo _l('id'); ?></th>
                                                <th><?php echo _l('title'); ?></th>
                                                <th><?php echo _l('project'); ?></th>
                                                <th><?php echo _l('location'); ?></th>
                                                <th><?php echo _l('created_by'); ?></th>
                                                <th><?php echo _l('date_created'); ?></th>
                                                <th><?php echo _l('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reports as $report) { ?>
                                            <tr>
                                                <td><?php echo $report['id']; ?></td>
                                                <td>
                                                    <a href="<?php echo admin_url('job_site_reports/view/' . $report['id']); ?>">
                                                        <?php echo $report['title']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($report['project_id']) {
                                                        $this->load->model('projects_model');
                                                        $project = $this->projects_model->get($report['project_id']);
                                                        if ($project) {
                                                            echo '<a href="' . admin_url('projects/view/' . $report['project_id']) . '">' . $project->name . '</a>';
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $report['location'] ? $report['location'] : '-'; ?></td>
                                                <td>
                                                    <?php
                                                    $staff = get_staff($report['staff_id']);
                                                    if ($staff) {
                                                        echo staff_profile_image($staff->staffid, ['staff-profile-image-small'], 'thumb') . ' ' . $staff->firstname . ' ' . $staff->lastname;
                                                    }
                                                    ?>
                                                </td>
                                                <td data-order="<?php echo strtotime($report['date_created']); ?>"><?php echo _dt($report['date_created']); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo admin_url('job_site_reports/view/' . $report['id']); ?>" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>
                                                        <?php if (has_permission('job_site_reports', '', 'edit')) { ?>
                                                        <a href="<?php echo admin_url('job_site_reports/report/' . $report['id']); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
                                                        <?php } ?>
                                                        <?php if (has_permission('job_site_reports', '', 'delete')) { ?>
                                                        <a href="<?php echo admin_url('job_site_reports/delete/' . $report['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
