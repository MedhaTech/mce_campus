
  <!-- Content Wrapper. Contains page content -->
<div class="page-content">
    <section class="content-header m-3">
        <div class="container-fluid">
            <div class="card card-info shadow">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#2f4050;">
                    <h3 class="card-title text-white"><?= $page_title; ?></h3>
                    <div class="card-tools d-flex">
                        <button class="btn btn-danger btn-sm mr-2" id="get_details" type="submit">Download</button>
                        <?php echo anchor('admin/reports', '<span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text">Back to List</span>', 'class="btn btn-secondary btn-sm btn-icon-split shadow-sm"'); ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo form_open_multipart($download_action, 'class="user"'); ?>
                    <div class="form-row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <?php
                                echo form_dropdown('academic_year', $academicYears, set_value('academic_year', $currentAcademicYear), 'class="form-control" id="academic_year"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <?php
                                $year_options = array('0' => "All", 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV');
                                echo form_dropdown('year', $year_options, set_value('year'), 'class="form-control" id="year"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update">
                                    <i class="fas fa-edit"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <?php echo $table; ?>
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
        event.preventDefault(); // Prevent default form submission

        var academic_year = $("#academic_year").val();
        var year = $("#year").val();

        $("#get_details").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...');
        $("#get_details").prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: base_url + 'admin/academic_report/1',  // The download action
            data: {
                'academic_year': academic_year,
                'year': year
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                var filename = "Academic_Report_" + academic_year + ".xls";
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
