<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_site_reports extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('job_site_reports_model');
    }

    /* List all reports */
    public function index()
    {
        if (!has_permission('job_site_reports', '', 'view')) {
            access_denied('job_site_reports');
        }

        $data['title'] = _l('job_site_reports');
        $data['reports'] = $this->job_site_reports_model->get();
        $this->load->view('job_site_reports/manage', $data);
    }

    /* Add new report or edit existing */
    public function report($id = '')
    {
        if (!has_permission('job_site_reports', '', 'view')) {
            access_denied('job_site_reports');
        }

        if ($this->input->post()) {
            if ($id == '') {
                if (!has_permission('job_site_reports', '', 'create')) {
                    access_denied('job_site_reports');
                }
                $id = $this->job_site_reports_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('job_site_report')));
                    redirect(admin_url('job_site_reports/view/' . $id));
                }
            } else {
                if (!has_permission('job_site_reports', '', 'edit')) {
                    access_denied('job_site_reports');
                }
                $success = $this->job_site_reports_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('job_site_report')));
                }
                redirect(admin_url('job_site_reports/view/' . $id));
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('job_site_report'));
        } else {
            $data['report'] = $this->job_site_reports_model->get($id);
            $data['photos'] = $this->job_site_reports_model->get_report_photos($id);
            $title = _l('edit', _l('job_site_report'));
        }

        $data['title'] = $title;
        $this->load->model('projects_model');
        $data['projects'] = $this->projects_model->get('', ['status !=' => 4]); // Get active projects
        $this->load->view('job_site_reports/report_form', $data);
    }

    /* View report */
    public function view($id)
    {
        if (!has_permission('job_site_reports', '', 'view')) {
            access_denied('job_site_reports');
        }

        $data['report'] = $this->job_site_reports_model->get($id);
        
        if (!$data['report']) {
            show_404();
        }

        $data['title'] = $data['report']->title;
        $data['photos'] = $this->job_site_reports_model->get_report_photos($id);
        
        $this->load->view('job_site_reports/view_report', $data);
    }

    /* Upload report photos */
    public function upload_photos($report_id)
    {
        handle_job_site_report_photos_upload($report_id);
    }

    /* Delete report */
    public function delete($id)
    {
        if (!has_permission('job_site_reports', '', 'delete')) {
            access_denied('job_site_reports');
        }

        if ($this->job_site_reports_model->delete($id)) {
            set_alert('success', _l('deleted', _l('job_site_report')));
        }

        redirect(admin_url('job_site_reports'));
    }
}

/* Helper function to handle photo uploads */
function handle_job_site_report_photos_upload($report_id)
{
    $CI = &get_instance();
    $path = FCPATH . 'modules/job_site_reports/uploads/photos/' . $report_id . '/';
    
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }

    $config = array(
        'upload_path'   => $path,
        'allowed_types' => 'jpg|jpeg|png|gif',
        'max_size'      => '10000', // 10MB
    );

    $CI->load->library('upload', $config);
    
    if ($CI->upload->do_upload('job_site_photo')) {
        $uploadData = $CI->upload->data();
        
        $CI->db->insert(db_prefix() . 'job_site_report_photos', [
            'report_id'     => $report_id,
            'file_name'     => $uploadData['file_name'],
            'original_name' => $uploadData['orig_name'],
            'description'   => $CI->input->post('photo_description'),
            'date_uploaded' => date('Y-m-d H:i:s')
        ]);
        
        return true;
    }
    
    return false;
}
