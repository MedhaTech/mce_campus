<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
                <div class="col-md-6 col-12 m-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-secondary">PERSONAL DETAILS</h4>

                            <?php echo form_open_multipart($action, 'class="form-horizontal"'); ?>

                            <div class="form-group row mb-0">
                                <label for="student_number" class="col-3 col-form-label">Student Mobile<span
                                class="text-danger">*</span></label>
                                <div class="col-9 col-form-label">
                                    <input type="number" class="form-control" placeholder="Enter Student Mobile Number"
                                        id="student_number"
                                        value="<?php echo (set_value('student_number')) ? set_value('student_number') : $student_number; ?>"
                                        name="student_number">
                                    <span class="text-danger"><?php echo form_error('student_number'); ?></span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="father_number" class="col-3 col-form-label">Parent Mobile <span
                                        class="text-danger">*</span></label>
                                <div class="col-9 col-form-label">
                                    <input type="number" class="form-control" placeholder="Enter Parent Mobile"
                                        id="father_number"
                                        value="<?php echo (set_value('father_number')) ? set_value('father_number') : $father_number; ?>"
                                        name="father_number">
                                    <span class="text-danger"><?php echo form_error('father_number'); ?></span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="email" class="col-3 col-form-label">Student Email <span
                                        class="text-danger">*</span></label>
                                <div class="col-9 col-form-label">
                                    <input type="text" class="form-control" placeholder="Enter Email" id="email"
                                        value="<?php echo (set_value('email')) ? set_value('email') : $email; ?>"
                                        name="email">
                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label for="date_of_birth" class="col-3 col-form-label">Date of Birth<span
                                class="text-danger">*</span></label>
                                <div class="col-9 col-form-label">
                                    <input type="date" class="form-control" placeholder="Enter Date of Birth"
                                        id="date_of_birth"
                                        value="<?php echo (set_value('date_of_birth')) ? set_value('date_of_birth') : $date_of_birth; ?>"
                                        name="date_of_birth">
                                    <span class="text-danger"><?php echo form_error('date_of_birth'); ?></span>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-6">
                                    <?php echo anchor('student/profile', 'BACK', 'class="btn btn-danger btn-square"'); ?>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-info btn-square" name="Update"
                                        id="Update">SAVE</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
        </div>
        <!-- /.col -->
    </section>
</div>