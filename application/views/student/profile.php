<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">

            <div class="card m-5 shadow card-info">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-2">
                        PERSONAL DETAILS
                    </h3>
                    <div class="card-tools">
                        <?php echo anchor('student/personaldetails', '<i class="fas fa-edit"></i> Edit ', 'class="btn btn-dark btn-sm"'); ?>
                    </div>
                </div>

                <div class="card-body">

                <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Student Name</label><br>
                                <?php
                                if($admissionDetails->student_name != NULL)
                                    {
                                        echo $admissionDetails->student_name;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Mobile</label><br>
                                <?php
                                if($admissionDetails->mobile != NULL)
                                    {
                                        echo $admissionDetails->mobile;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Email</label><br>
                                <?php
                                if($admissionDetails->email != NULL)
                                    {
                                        echo $admissionDetails->email;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">AAdhar Number</label><br>
                                <?php
                                if($admissionDetails->aadhaar != NULL)
                                    {
                                        echo $admissionDetails->aadhaar;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Country of Birth</label><br>
                                <?php
                                if($admissionDetails->country_of_birth != NULL)
                                    {
                                        echo $admissionDetails->country_of_birth;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            <?php if (!empty($student_photo)): ?>
                                <div class="student-photo" style="width: 120px; height: 160px; border: 1px solid #000; overflow: hidden;">
                                    <img src="<?php echo base_url($student_photo); ?>" alt="Student Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <p>No photo available.</p>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Date of Birth</label><br>
                                <?php
                                if($admissionDetails->date_of_birth != NULL)
                                    {
                                        echo $admissionDetails->date_of_birth;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Gender</label><br>
                                <?php
                                if($admissionDetails->gender != NULL)
                                    {
                                        echo $admissionDetails->gender;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Sports</label><br>
                                <?php
                                if($admissionDetails->sports != NULL)
                                    {
                                        echo $admissionDetails->sports;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Blood Group</label><br>
                                <?php
                                if($admissionDetails->blood_group != NULL)
                                    {
                                        echo $admissionDetails->blood_group;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Place of Birth</label><br>
                                <?php
                                if($admissionDetails->place_of_birth != NULL)
                                    {
                                        echo $admissionDetails->place_of_birth;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Nationality</label><br>
                                <?php
                                if($admissionDetails->nationality != NULL)
                                    {
                                        echo $admissionDetails->nationality;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Religion</label><br>
                                <?php
                                if($admissionDetails->religion != NULL)
                                    {
                                        echo $admissionDetails->religion;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Mother Tongue</label><br>
                                <?php
                                if($admissionDetails->mother_tongue != NULL)
                                    {
                                        echo $admissionDetails->mother_tongue;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Caste</label><br>
                                <?php
                                if($admissionDetails->caste != NULL)
                                    {
                                        echo $admissionDetails->caste;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Current Address</label><br>
                                <?php
                                if($admissionDetails->current_address != NULL)
                                    {
                                        echo $admissionDetails->current_address;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label mb-0">Present Address</label><br>
                                <?php
                                if($admissionDetails->present_address != NULL)
                                    {
                                        echo $admissionDetails->present_address;
                                    }
                                else{
                                        echo "--" ;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
            <!-- /.col -->