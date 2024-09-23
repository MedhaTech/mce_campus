<!-- Content Wrapper. Contains page content -->
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18"><?= $page_title; ?></h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert <?= $this->session->flashdata('status'); ?>" id="msg">
                <?php echo $this->session->flashdata('message') ?>
            </div>
        <?php } ?>

        <div class="card card-body">
            <div class="row">
                <div class="col-12 col-md-3 d-none d-md-block"></div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-3 col-form-label">Academic Year</label>
                        <div class="col-9">
                            <?php
                            echo form_dropdown('academic_year', $academicYears, (set_value('academic_year')) ? set_value('academic_year') : 'academic_year', 'class="form-control " id="academic_year"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-3 col-form-label">Department</label>
                        <div class="col-9">
                            <?php
                            echo form_dropdown('department', $department_options, (set_value('department')) ? set_value('department') : 'department', 'class="form-control " id="department"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-3 col-form-label">Quota</label>
                        <div class="col-9">
                            <?php
                            echo form_dropdown('quota', $quota_options, (set_value('quota')) ? set_value('quota') : 'quota', 'class="form-control " id="quota"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputEmail3" class="col-3 col-form-label">Year</label>
                        <div class="col-9">
                            <?php $year_options = array('0'=>"All",'I'=>'I','II'=>'II','III'=>'III','IV'=>'IV');
                            echo form_dropdown('year', $year_options, (set_value('year')) ? set_value('year') : 'year', 'class="form-control " id="year"');
                            ?>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button class="btn btn-danger" type="button" id="get_details" disabled><i
                                class="fa fa-download"></i>
                            Download</button>
                    </div>

                </div>
                <div class="col-12 col-md-3 d-none d-md-block"></div>
            </div>
        </div>
    </div>
    <!-- end row-->

</div>
</div>
<!-- /.col -->

<script>
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';

        $('#academic_year').change(function () {
            // Get the selected value
            var selectedValue = $(this).val();

            // If a valid option is selected, enable the button, else disable it
            if (selectedValue) {
                $('#get_details').prop('disabled', false); // Enable the button
            } else {
                $('#get_details').prop('disabled', true);  // Disable the button
            }
        });

        $("#get_details").click(function () {
            event.preventDefault();

            var academic_year = $("#academic_year").val();
            var department = $("#department").val();
            var quota = $("#quota").val();
            var year = $("#year").val();

            $("#get_details").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Downloading...'
            );
            $("#get_details").prop('disabled', true);

            //$("#res").hide();
            //$("#process").show();

            $.ajax({
                'type': 'POST',
                'url': base_url + 'admin/fee_details_report/',
                'data': {
                    'academic_year': academic_year,
                    'department': department,
                    'quota': quota,
                    'year':year
                },
                'dataType': 'json',
                'cache': false,
                'success': function (data) {
                    // console.log(data);
                    var filename = academic_year +" Fee Report.xls";
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