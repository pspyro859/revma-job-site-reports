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
                                <h2 class="job-site-report-title">Job Site Report</h2>
                            </div>
                        </div>
                        
                        <?php echo form_open_multipart(admin_url('job_site_reports/report/' . (isset($report) ? $report->id : '')), ['id' => 'job-site-report-form']); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title"><i class="fa fa-file-text-o"></i> Report Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($report) ? $report->title : ''); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="project_id"><i class="fa fa-folder-open"></i> Related Project</label>
                                    <select class="selectpicker" data-width="100%" name="project_id" id="project_id" data-live-search="true">
                                        <option value="">None</option>
                                        <?php foreach($projects as $project) { ?>
                                        <option value="<?php echo $project['id']; ?>" <?php if(isset($report) && $report->project_id == $project['id']){ echo 'selected'; } ?>><?php echo $project['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="location"><i class="fa fa-map-marker"></i> Job Location</label>
                                    <input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($report) ? $report->location : ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="weather_conditions"><i class="fa fa-cloud"></i> Weather Conditions</label>
                                    <input type="text" class="form-control" name="weather_conditions" id="weather_conditions" value="<?php echo (isset($report) ? $report->weather_conditions : ''); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description"><i class="fa fa-align-left"></i> Job Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="8"><?php echo (isset($report) ? $report->description : ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h4><i class="fa fa-camera"></i> Job Site Photos</h4>
                                
                                <div class="form-group">
                                    <div id="photo-upload-container" class="dropzone dz-clickable">
                                        <div class="dz-default dz-message">
                                            <span>Drop photos here or click to upload</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if(isset($report) && isset($photos)) { ?>
                                <div class="row">
                                    <?php foreach($photos as $photo) { ?>
                                    <div class="col-md-3 col-sm-4">
                                        <div class="photo-preview">
                                            <img src="<?php echo base_url('modules/job_site_reports/uploads/photos/' . $report->id . '/' . $photo['file_name']); ?>" class="img-responsive">
                                            <div class="photo-description"><?php echo $photo['description']; ?></div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> <?php echo (isset($report) ? 'Update Report' : 'Save Report'); ?></button>
                                </div>
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
$(function() {
    // Initialize dropzone for photo uploads
    Dropzone.autoDiscover = false;
    
    var photoDropzone = new Dropzone("#photo-upload-container", {
        url: admin_url + 'job_site_reports/upload_photos/<?php echo isset($report) ? $report->id : '0'; ?>',
        paramName: "job_site_photo",
        maxFilesize: 10,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictRemoveFile: 'Remove',
        dictFileTooBig: 'Image too big ({{filesize}}MB). Max filesize: {{maxFilesize}}MB.',
        dictInvalidFileType: 'Invalid file type. Only image files are allowed.',
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("photo_description", prompt("Add a description for this photo:", ""));
            });
        }
    });
    
    // Get current location if available
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            $('<input>').attr({
                type: 'hidden',
                name: 'latitude',
                value: position.coords.latitude
            }).appendTo('#job-site-report-form');
            
            $('<input>').attr({
                type: 'hidden',
                name: 'longitude',
                value: position.coords.longitude
            }).appendTo('#job-site-report-form');
        });
    }
});
</script>
