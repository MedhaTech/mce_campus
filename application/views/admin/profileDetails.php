<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card card-body">
                                <h4 class="card-title text-secondary">ADMISSION DETAILS</h4>
                                <form class="form-horizontal">
                                    <div class="form-group row mb-0">
                                        <label for="inputEmail3" class="col-3 col-form-label">USN</label>
                                        <div class="col-9 col-form-label">
                                            <?php
                                if ($admissionDetails->usn != NULL) {
                                    echo $admissionDetails->usn;
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
                                if ($admissionDetails->student_name != NULL) {
                                    echo $admissionDetails->student_name;
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
                                if ($admissionDetails->admission_year != NULL) {
                                    echo $admissionDetails->admission_year;
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
                                if ($admissionDetails->stream != NULL) {
                                    echo $admissionDetails->stream;
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
                                if ($admissionDetails->department != NULL) {
                                    echo $admissionDetails->department;
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
                                if ($admissionDetails->year != NULL) {
                                    echo $admissionDetails->year;
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
                                if ($admissionDetails->college_code != NULL) {
                                    echo $admissionDetails->college_code;
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
                                if ($admissionDetails->quota != NULL) {
                                    echo $admissionDetails->quota;
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
                                if ($admissionDetails->sub_quota != NULL) {
                                    echo $admissionDetails->sub_quota;
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
                                if ($admissionDetails->category_allotted != NULL) {
                                    echo $admissionDetails->category_allotted;
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
                                if ($admissionDetails->category_claimed != NULL) {
                                    echo $admissionDetails->category_claimed;
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
                                if ($admissionDetails->caste != NULL) {
                                    echo $admissionDetails->caste;
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

    </section>
    <!-- /.content -->
</div>