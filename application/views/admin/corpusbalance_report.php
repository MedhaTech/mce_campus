  <!-- Content Wrapper. Contains page content -->
  <div class="page-content">
      <section class="content-header mt-2">
          <div class="container-fluid">
              <div class="card card-info shadow">
                  <div class="card-header d-flex justify-content-between align-items-center"
                      style="background-color:#2f4050;">
                      <h3 class="card-title text-white mb-0">
                          <?= $page_title; ?>
                      </h3>
                      <div class="card-tools">
                          <ul class="nav nav-pills ml-auto">
                              <li class="nav-item d-inline-flex">
                                  <button type="submit" class="btn btn-danger btn-sm" name="download" id="get_details">
                                      <i class="fas fa-download"></i> Download
                                  </button>
                                  <?php echo anchor('admin/reports', 
                                        '<span class="icon"><i class="fas fa-arrow-left"></i></span> 
                                        <span class="text text-white">Back to List</span>', 
                                        'class="btn btn-secondary btn-sm btn-icon-split ml-2 shadow-sm"'); ?>
                              </li>
                          </ul>
                      </div>
                  </div>
                  <!-- <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                          <?php
                          echo $table;
                          ?>
                        </div>
            
                      </div> -->
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
                                  <label class="label font-13">Student studying year<span
                                          class="text-danger">*</span></label>
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

                              <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update"><i
                                      class="fas fa-edit"></i> Filter </button>
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

    $("#get_details").click(function(event) {
        event.preventDefault();

        var admissions = $("#admissions").val();

        $("#get_details").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...'
        );
        $("#get_details").prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: base_url + 'admin/corpusbalance_report/1',
            data: {
                admissions: admissions
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                // Get current date and time
                var now = new Date();
                var day = String(now.getDate()).padStart(2, '0');
                var month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0!
                var year = now.getFullYear();
                var hours = String(now.getHours()).padStart(2, '0');
                var minutes = String(now.getMinutes()).padStart(2, '0');

                // Format: Corpus Balance Report - ddmmyyyyhhmm.xls
                var formattedDateTime = day + month + year + hours + minutes;
                var filename = "Corpus Balance Report - " + formattedDateTime + ".xls";

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
