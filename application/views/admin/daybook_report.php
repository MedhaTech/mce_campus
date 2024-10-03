  <!-- Content Wrapper. Contains page content -->
  <div class="page-content">
      <section class="content-header">
          <div class="container-fluid">
              <div class="card card-info shadow">
              <div class="card-header d-flex justify-content-between align-items-center"  style="background-color:#2f4050;">
                    <h3 class="card-title text-white">
                        <?= $page_title; ?>
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <?php echo anchor('admin/reports', '<span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text text-white">Back to List</span>', 'class="btn btn-secondary btn-sm btn-icon-split d-none d-sm-inline-block shadow-sm"'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
                  <div class="card-body">
                      <?php echo form_open_multipart($action, 'class="user"'); ?>

                      <div class="form-row">

                          <div class="col-md-4 col-sm-12">
                          <div class="form-group">
                                  <label class="label">From Date<span class="text-danger">*</span></label>

                                  <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo (set_value('from_date')) ? set_value('from_date') : $from_date; ?>" placeholder="Enter From Date">
                                  <span class="text-danger"><?php echo form_error('from_date'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-4 col-sm-12">
                          <div class="form-group">
                                  <label class="label">To Date<span class="text-danger">*</span></label>

                                  <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo (set_value('to_date')) ? set_value('to_date') : $to_date; ?>" placeholder="Enter To Date">
                                  <span class="text-danger"><?php echo form_error('to_date'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-4 col-sm-12 mt-4 mb-2">
                              <div class="form-group">
                              <label for="course">&nbsp;
                                  </label>
                                  <button class="btn btn-danger btn-sm" id="get_details" type="submit">Download</button>
                              </div>
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


              var to_date = $("#to_date").val();
              var from_date = $("#from_date").val();

              $("#get_details").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...');
              $("#get_details").prop('disabled', true);

              //$("#res").hide();
              //$("#process").show();


    
                  $.ajax({
                      'type': 'POST',
                      'url': base_url + 'admin/dayBookReportDownload/',
                      'data': {
                          'to_date': to_date,
                          'from_date': from_date
                      },
                      'dataType': 'json',
                      'cache': false,
                      'success': function(data) {
                          var filename = "Day Book Report.xls";
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
