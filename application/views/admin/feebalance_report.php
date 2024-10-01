  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <section class="content-header m-2">
          <div class="container-fluid">
              <div class="card card-info shadow">
                <div class="card-header" style="background-color:#2f4050;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white">
                            <?= $page_title; ?>
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto d-flex">
                                <li class="nav-item mr-2">
                                    <button type="submit" class="btn btn-danger btn-sm" name="download" id="get_details">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <?php echo anchor('admin/reports', '<span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text">Back to List</span>', 'class="btn btn-secondary btn-sm btn-icon-split d-none d-sm-inline-block shadow-sm"'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                 </div>
                  <div class="card-body">

                      <?php echo form_open_multipart($action, 'class="user" id="enquiry_list"'); ?>

                      <div class="form-row">
                
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
                                  <?php $Syear =array("0"=>"Select Student studying year","I"=>"I","II"=>"II","III"=>"III","IV"=>"IV");
                                        echo form_dropdown('year', $Syear, (set_value('year')) ? set_value('year') : 'year', 'class="form-control form-control-md" id="year"'); 
                                    ?>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                              <label class="label font-13">Academic year</label>
                              <?php
                                 echo form_dropdown('academic_year', $academicYears, (set_value('academic_year')) ? set_value('academic_year') : 'academic_year', 'class="form-control " id="academic_year"');
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

        // Correct form submission for downloading fee balance report
        $("#get_details").click(function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // Get the values of the form fields
            var department = $("#department").val();
            var year = $("#year").val();
            var academic_year = $("#academic_year").val();

            // Show loading spinner and disable the download button
            $("#get_details").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...');
            $("#get_details").prop('disabled', true);

            // AJAX request to download the fee balance report
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/feebalance_report/1',  // Make sure the URL points to the correct controller function
                data: {
                    'department': department,
                    'year': year,
                    'academic_year': academic_year
                },
                dataType: 'json',
                cache: false,
                success: function(data) {
                    // Handle success - trigger the file download
                    var filename = "Fee_Balance_Report.xls";
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", filename);
                    $a[0].click();
                    $a.remove();

                    // Reset the download button state
                    $("#get_details").html('<i class="fas fa-download"></i> Download');
                    $("#get_details").prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    // Handle errors - show an error message or alert
                    alert('Error occurred while downloading the report: ' + error);
                    $("#get_details").html('<i class="fas fa-download"></i> Download');
                    $("#get_details").prop('disabled', false);
                }
            });
        });
    });
</script>
