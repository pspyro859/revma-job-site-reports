<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_site_reports_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get report by ID
     * @param  mixed $id report id
     * @return object
     */
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'job_site_reports')->row();
        }

        return $this->db->get(db_prefix() . 'job_site_reports')->result_array();
    }

    /**
     * Add new report
     * @param array $data report data
     */
    public function add($data)
    {
        $data['staff_id'] = get_staff_user_id();
        $data['date_created'] = date('Y-m-d H:i:s');
        
        // Get GPS coordinates if provided
        if (isset($data['latitude']) && isset($data['longitude'])) {
            $data['latitude'] = $data['latitude'];
            $data['longitude'] = $data['longitude'];
        }

        $this->db->insert(db_prefix() . 'job_site_reports', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('New Job Site Report Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    /**
     * Update report
     * @param  array $data report data
     * @param  mixed $id   report id
     * @return boolean
     */
    public function update($data, $id)
    {
        $data['date_updated'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'job_site_reports', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Job Site Report Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    /**
     * Delete report
     * @param  mixed $id report id
     * @return boolean
     */
    public function delete($id)
    {
        // Delete photos
        $photos = $this->get_report_photos($id);
        foreach ($photos as $photo) {
            $path = FCPATH . 'modules/job_site_reports/uploads/photos/' . $id . '/' . $photo['file_name'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->db->where('report_id', $id);
        $this->db->delete(db_prefix() . 'job_site_report_photos');

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'job_site_reports');

        if ($this->db->affected_rows() > 0) {
            log_activity('Job Site Report Deleted [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    /**
     * Get report photos
     * @param  mixed $report_id report id
     * @return array
     */
    public function get_report_photos($report_id)
    {
        $this->db->where('report_id', $report_id);
        return $this->db->get(db_prefix() . 'job_site_report_photos')->result_array();
    }
}
