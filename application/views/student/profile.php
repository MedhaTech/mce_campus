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

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card card-body">
                    <h4 class="card-title text-secondary">ADMISSION DETAILS</h4>
                    <form class="form-horizontal">
                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">USN</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->usn != NULL) {
                                    echo $details->usn;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Student Name</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->student_name != NULL) {
                                    echo $details->student_name;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Joining Year</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->admission_year != NULL) {
                                    echo $details->admission_year;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Stream</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->stream != NULL) {
                                    echo $details->stream;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Department</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->department != NULL) {
                                    echo $details->department;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Current Year</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->year != NULL) {
                                    echo $details->year;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">College Code</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->college_code != NULL) {
                                    echo $details->college_code;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Quota</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->quota != NULL) {
                                    echo $details->quota;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Sub Quota</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->sub_quota != NULL) {
                                    echo $details->sub_quota;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Category Alloted</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->category_allotted != NULL) {
                                    echo $details->category_allotted;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Category Claimed</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->category_claimed != NULL) {
                                    echo $details->category_claimed;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Caste</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->caste != NULL) {
                                    echo $details->caste;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="inputEmail3" class="col-3 col-form-label">Sub Caste</label>
                            <div class="col-9 col-form-label">
                                <?php
                                if ($details->sub_caste != NULL) {
                                    echo $details->sub_caste;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </div>
                        </div>
                        <h6 class="text-warning">Note: Please contact the Admissions Department/SA section for any
                            changes to the data mentioned above.</h6>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right position-relative">
                            <?php if ($student->edit_status == 0) : ?>
                                <a href="personaldetails" class="btn btn-info btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            <?php else : ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            <?php endif; ?>
                        </div>
                        <h4 class="card-title text-secondary">PERSONAL DETAILS</h4>

                        <form class="form-horizontal">
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Student Mobile</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->student_number != NULL) {
                                        echo $details->student_number;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Parent Mobile</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->father_number != NULL) {
                                        echo $details->father_number;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">State</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->state != NULL) {
                                        echo $details->state;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Country</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->country != NULL) {
                                        echo $details->country;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Student Email</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->email != NULL) {
                                        echo $details->email;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Gender</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->gender != NULL) {
                                        echo $details->gender;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Aadhar Number</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->aadhar_number != NULL) {
                                        echo $details->aadhar_number;
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="inputEmail3" class="col-3 col-form-label">Date of Birth</label>
                                <div class="col-9 col-form-label">
                                    <?php
                                    if ($details->date_of_birth != "0000-00-00" && $details->date_of_birth != NULL) {
                                        echo date('d-m-Y', strtotime($details->date_of_birth));
                                    } else {
                                        echo "--";
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.col -->