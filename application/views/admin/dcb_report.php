  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <section class="content-header">
          <div class="container-fluid">
              <div class="card card-info shadow">
                  <div class="card-header">
                      <h3 class="card-title">
                          <?= $page_title; ?>
                      </h3>
                      <div class="card-tools">
                          <ul class="nav nav-pills ml-auto">
                              <li class="nav-item">
                                  <button type="submit" class="btn btn-danger btn-sm" name="download" id="get_details"><i class="fas fa-download"></i> Download </button>
                                  <?php echo anchor('admin/reports', '<span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text">Back to List</span>', 'class="btn btn-secondary btn-sm btn-icon-split d-none d-sm-inline-block shadow-sm"'); ?>
                              </li>
                          </ul>
                      </div>
                  </div>
                  <div class="card-body">
                      <?php echo form_open_multipart($action, 'class="user" id="enquiry_list"'); ?>

                      <div class="form-row">
                          <div class="col-md-2 col-sm-12">
                              <div class="form-group">

                                  <label class="label font-13">Stream</label>
                                  <?php $Stream = array("" => "Select Stream", "BE" => "BE");
                                    echo form_dropdown('Stream', $Stream, (set_value('Stream')) ? set_value('Stream') : 'Stream', 'class="form-control form-control-md" id="Stream"');
                                    ?>
                              </div>
                          </div>

                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">

                                  <label class="label font-13">Course<span class="text-danger">*</span></label>
                                  <?php
                                    echo form_dropdown('department', $department_options, (set_value('department')) ? set_value('department') : 'department', 'class="form-control " id="department"');
                                    ?>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="label font-13">Student studying year<span class="text-danger">*</span></label>
                                  <?php $Syear = array("" => "Select Student studying year", "I" => "I", "II" => "II", "III" => "IIII", "IV" => "IV");
                                    echo form_dropdown('year', $Syear, (set_value('Syear')) ? set_value('year') : 'Syear', 'class="form-control form-control-md" id="year"');
                                    ?>
                              </div>
                          </div>
                          <div class="col-md-2 col-sm-12">
                              <div class="form-group">
                                  <label class="label font-13">Academic year</label>
                                  <?php $Syear = array("" => "Select Academic year", "2024-2025" => "2024-2025");
                                    echo form_dropdown('Syear', $Syear, (set_value('Syear')) ? set_value('Syear') : 'Syear', 'class="form-control form-control-md" id="Syear"');
                                    ?>
                              </div>
                          </div>
                          <div class="col-md-2 col-sm-12">
                              <div class="form-group">
                                  <label class="label font-13">Type</label>
                                  <?php $type = array("" => "Select Type", "Aided" => "Aided", "UnAided" => "UnAided");
                                    echo form_dropdown('type', $type, (set_value('type')) ? set_value('type') : 'type', 'class="form-control form-control-md" id="type"');
                                    ?>
                              </div>
                          </div>
                      </div>



                      <div class="form-group row">
                          <div class="col-sm-2"> &nbsp;</div>
                          <div class="col-sm-10 text-right">

                              <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update"><i class="fas fa-edit"></i> Filter </button>
                          </div>
                      </div>

                      </form>
                      <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                          <?php
                            echo $table;
                            ?>
                      </div>

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


              var admissions = $("#admissions").val();
              var course = $("#course").val();
              var year = $("#year").val();
              var type = $("#type").val();

              $("#get_details").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...');
              $("#get_details").prop('disabled', true);

              //$("#res").hide();
              //$("#process").show();



              $.ajax({
                  'type': 'POST',
                  'url': base_url + 'admin/dcb_report/1',
                  'data': {
                    'course': course,
                    'year': year,
                    'type': type

                  },
                  'dataType': 'json',
                  'cache': false,
                  'success': function(data) {
                      var filename = "Dcb Report.xls";
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