<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container">
        <section class="content-header" style="margin-top: 10px;">

            <div class="card-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                    if (count($students)) {
                                        // Table setup
                                        $table_setup = array('table_open' => '<table class="table dt-responsive nowrap table-bordered" border="1" id="basic-datatable">');
                                        $this->table->set_template($table_setup);

                                        // Table headings
                                        $print_fields = array('S.NO', 'USN', 'Applicant Name', 'Mobile', 'Course', 'Quota', 'Sub Quota', 'Status');
                                        $this->table->set_heading($print_fields);

                                        $i = 1;
                                        foreach ($students as $admissions1) {

                                            // Encrypting ID
                                            $encryptId = base64_encode($admissions1->id);

                                            // Filling table rows dynamically
                                            $result_array = array(
                                                $i++,
                                                $admissions1->usn,
                                                $admissions1->student_name,
                                                $admissions1->student_number,
                                                $admissions1->department,
                                                $admissions1->quota,
                                                $admissions1->sub_quota,
                                                '<strong class="text-' . $admissionStatusColor[$admissions1->status] . '">' . $admissionStatus[$admissions1->status] . '</strong>'
                                            );
                                            $this->table->add_row($result_array);
                                        }
                                        // Generating and displaying the table
                                        echo $this->table->generate();
                                    } else {
                                        // No data available message
                                        echo "<div class='text-center'><img src='" . base_url() . "assets/img/no_data.jpg' class='nodata'></div>";
                                    }
                                    ?>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>

            </div>
        </section>
    </div>
</div>
<!-- /.content-wrapper -->