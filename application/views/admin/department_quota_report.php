  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <section class="content-header m-3">
          <div class="container-fluid">
              <div class="card card-info shadow">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#2f4050;">
                <h3 class="card-title text-white">
                    <?= $page_title; ?>
                </h3>

                    <div class="card-tools d-flex">
                        <button class="btn btn-danger btn-sm mr-2" id="get_details" type="submit">Download</button>
                        <?php echo anchor('admin/reports', '<span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text">Back to List</span>', 'class="btn btn-secondary btn-sm btn-icon-split shadow-sm"'); ?>
                    </div>
                </div>
                  <div class="card-body">
                      <?php echo form_open_multipart($action, 'class="user"'); ?>

                      <div class="form-row">

                        <div class="form-group">
                            <select class="form-control" id="academic_year" name="academic_year">
                                <option value="">Select Academic Year</option> <!-- Manually added option -->
                                <option value="<?= $currentAcademicYear; ?>" <?= set_select('academic_year', $currentAcademicYear, ($academic_year == $currentAcademicYear)); ?>>
                                    <?= $currentAcademicYear; ?>
                                </option>
                            </select>
                            <span class="text-danger"><?php echo form_error('academic_year'); ?></span>
                        </div>
                          <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                 
                                 <?php echo form_dropdown('course', $course_options, (set_value('course')) ? set_value('course') : $course, 'class="form-control" id="course"'); ?>
                                 <span class="text-danger"><?php echo form_error('course'); ?></span>
                             </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                 
                                  <?php echo form_dropdown('quota', $quota_options, (set_value('quota')) ? set_value('quota') : $quota, 'class="form-control" id="quota"'); ?>
                                  <span class="text-danger"><?php echo form_error('quota'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                              <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update"><i
                              class="fas fa-edit"></i> Filter </button>
                              </div>
                          </div>

                      </div>
                      <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                          <?php
                          echo $admissions;
                          ?>
                      </div>
                  </div>
                
              </div>
          </div>
      </section>
  </div>


  <script>
      $(document).ready(function() {
          var base_url = '<?php echo base_url(); ?>';


          $("#get_details").click(function() {
              event.preventDefault();

              var academic_year = $("#academic_year").val();
              var course = $("#course").val();
              var quota = $("#quota").val();

              $("#get_details").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...');
              $("#get_details").prop('disabled', true);

              //$("#res").hide();
              //$("#process").show();


    
                  $.ajax({
                      'type': 'POST',
                      'url': base_url + 'admin/department_quota_report/1',
                      'data': {
                          'academic_year': academic_year,
                          'course': course,
                          'quota': quota
                      },
                      'dataType': 'json',
                      'cache': false,
                      'success': function(data) {
                          var filename = "Academic Year wise Admission Report.xls";
                          var $a = $("<a>");
                          $a.attr("href", data.file);
                          $("body").append($a);
                          $a.attr("download", filename);
                          $a[0].click();
                          $a.remove();
                          $("#get_details").html('Download');
                          $("#get_details").prop('disabled', false);
                      }
                  });
            


          });


      });
  </script>