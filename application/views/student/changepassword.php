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
        <?php if (!empty($security_message)): ?>
            <div class="alert alert-warning">
                <?php echo $security_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert <?= $this->session->flashdata('status'); ?>" id="msg">
                <?php echo $this->session->flashdata('message') ?>
            </div>
        <?php } ?>
        <div class="card card-body">
            <div class="row">
                <div class="col-12 col-md-3 d-none d-md-block"></div>
                <div class="col-md-6 col-sm-12">
                    <?php echo form_open($action, 'class="js-validation-signin" method="POST"'); ?>

                    <div class="form-group">
                        <label>Current Password <span class="text-danger">*</span></label>
                        <input class="form-control mb-3" type="password" id="oldpassword"
                            value="<?php echo (set_value('oldpassword')) ? set_value('oldpassword') : $oldpassword; ?>"
                            name="oldpassword" placeholder="Enter Old password" />
                        <span class="text-danger"><?php echo form_error('oldpassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>New Password <span class="text-danger">*</span></label>
                        <input class="form-control mb-3" type="password" id="newpassword"
                            value="<?php echo (set_value('newpassword')) ? set_value('newpassword') : $newpassword; ?>"
                            name="newpassword" placeholder="Enter New Password" />
                        <span class="text-danger"><?php echo form_error('newpassword'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input class="form-control mb-3" type="password" id="confirmpassword" name="confirmpassword"
                            value="<?php echo (set_value('confirmpassword')) ? set_value('confirmpassword') : $confirmpassword; ?>"
                            placeholder="Enter Confirm Password" />
                        <span class="text-danger"><?php echo form_error('confirmpassword'); ?></span>
                    </div>
                    <div class="col-12 text-right">
                        <button class="btn btn-secondary" type="submit">Update Paasword</button>
                    </div>
                    <?php echo form_close(); ?>

                    <h6>Instructions:</h6>
                    <ul>
                        <li>Enter your current valid password to verify your identity.</li>
                        <li>Choose a new password that meets the following criteria:
                            <ul>
                                <li>At least 8 characters long</li>
                                <li>At least one uppercase letter ([A-Z])</li>
                                <li>At least one lowercase letter ([a-z])</li>
                                <li>At least one number ([0-9])</li>
                                <li>At least one special character ([\W])</li>
                            </ul>
                        </li>
                        <li>Re-enter your new password to confirm it. Ensure both fields match to avoid any errors.</li>
                    </ul>
                </div>
                <div class="col-12 col-md-3 d-none d-md-block"></div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->