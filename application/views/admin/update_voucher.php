<!-- Main content -->
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $page_title; ?>
                        </h3>
                    </div>

                    <div class="card-body">
                        <?php echo form_open_multipart($action, 'class="user"'); ?>
                        <div class="col-md-12">


                            <div class="form-group row">

                                <label for="staticEmail" class="col-md-4 col-form-label  ">Select All</label>
                                <div class="col-md-2">
                                    <input type="checkbox" value="0" id="selectAllCheckbox">
                                </div>


                            </div>


                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Fees</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        Final Amount

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        Already Paid

                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">
                                        Balance Amount
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">

                                    </label>
                                </div>

                            </div>
                            <hr>



                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Renewal of registration fees</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->renewal_of_registration_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'renewal_of_registration_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->renewal_of_registration_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="renewal_of_registration_fees" id="renewal_of_registration_fees" class="form-control" value="<?php echo ($voucherData->renewal_of_registration_fees>0) ? $voucherData->renewal_of_registration_fees : $fee_structure->renewal_of_registration_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'renewal_of_registration_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->renewal_of_registration_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="renewal_of_registration_fees_checkbox" value="<?php echo ($voucherData->renewal_of_registration_fees>0) ? $voucherData->renewal_of_registration_fees : $fee_structure->renewal_of_registration_fees; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">e
                                    Consortium
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->e_consortium_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'e_consortium_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->e_consortium_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="e_consortium_fees" id="e_consortium_fees" class="form-control" value="<?php echo ($voucherData->e_consortium_fees>0) ? $voucherData->e_consortium_fees : $fee_structure->e_consortium_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'e_consortium_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->e_consortium_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="e_consortium_fees_checkbox" value="<?php echo ($voucherData->e_consortium_fees>0) ? $voucherData->e_consortium_fees : $fee_structure->e_consortium_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Sport
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->students_sports_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'students_sports_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->students_sports_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="students_sports_fees" id="students_sports_fees" class="form-control" value="<?php echo ($voucherData->students_sports_fees>0) ? $voucherData->students_sports_fees : $fee_structure->students_sports_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'students_sports_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->students_sports_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="students_sports_fees_checkbox" value="<?php echo ($voucherData->students_sports_fees>0) ? $voucherData->students_sports_fees : $fee_structure->students_sports_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Sports
                                    Development
                                    fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->students_sports_development_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'students_sports_development_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->students_sports_development_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="students_sports_development_fees" id="students_sports_development_fees" class="form-control" value="<?php echo ($voucherData->students_sports_development_fees>0) ? $voucherData->students_sports_development_fees : $fee_structure->students_sports_development_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'students_sports_development_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->students_sports_development_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="students_sports_development_fees_checkbox" value="<?php echo ($voucherData->students_sports_development_fees>0) ? $voucherData->students_sports_development_fees : $fee_structure->students_sports_development_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Career
                                    Guidance &
                                    Counseling fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->career_guideliness_and_counselling_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'career_guideliness_and_counselling_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->career_guideliness_and_counselling_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="career_guideliness_and_counselling_fees" id="career_guideliness_and_counselling_fees" class="form-control" value="<?php echo ($voucherData->career_guideliness_and_counselling_fees>0) ? $voucherData->career_guideliness_and_counselling_fees : $fee_structure->career_guideliness_and_counselling_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'career_guideliness_and_counselling_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->career_guideliness_and_counselling_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="career_guideliness_and_counselling_fees_checkbox" value="<?php echo ($voucherData->career_guideliness_and_counselling_fees>0) ? $voucherData->career_guideliness_and_counselling_fees : $fee_structure->career_guideliness_and_counselling_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">University
                                    Development
                                    fund</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->university_development_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'university_development_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->university_development_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="university_development_fees" id="university_development_fees" class="form-control" value="<?php echo ($voucherData->university_development_fees>0) ? $voucherData->university_development_fees : $fee_structure->university_development_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'university_development_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->university_development_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="university_development_fees_checkbox" value="<?php echo ($voucherData->university_development_fees>0) ? $voucherData->university_development_fees : $fee_structure->university_development_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Cultural Activities Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->cultural_activities_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'cultural_activities_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->cultural_activities_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="cultural_activities_fees" id="cultural_activities_fees" class="form-control" value="<?php echo ($voucherData->cultural_activities_fees>0) ? $voucherData->cultural_activities_fees : $fee_structure->cultural_activities_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'cultural_activities_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->cultural_activities_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="cultural_activities_fees_checkbox" value="<?php echo ($voucherData->cultural_activities_fees>0) ? $voucherData->cultural_activities_fees : $fee_structure->cultural_activities_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Teachers
                                    Development
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->teachers_development_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'teachers_development_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->teachers_development_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="teachers_development_fees" id="teachers_development_fees" class="form-control" value="<?php echo ($voucherData->teachers_development_fees>0) ? $voucherData->teachers_development_fees : $fee_structure->teachers_development_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'teachers_development_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->teachers_development_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="teachers_development_fees_checkbox" value="<?php echo ($voucherData->teachers_development_fees>0) ? $voucherData->teachers_development_fees : $fee_structure->teachers_development_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Student
                                    Development
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->student_development_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'student_development_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->student_development_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="student_development_fees" id="student_development_fees" class="form-control" value="<?php echo ($voucherData->student_development_fees>0) ? $voucherData->student_development_fees : $fee_structure->student_development_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'student_development_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->student_development_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="student_development_fees_checkbox" value="<?php echo ($voucherData->student_development_fees>0) ? $voucherData->student_development_fees : $fee_structure->student_development_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Indian
                                    Red Cross
                                    Membership Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->indian_red_cross_membership_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'indian_red_cross_membership_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->indian_red_cross_membership_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="indian_red_cross_membership_fees" id="indian_red_cross_membership_fees" class="form-control" value="<?php echo ($voucherData->indian_red_cross_membership_fees>0) ? $voucherData->indian_red_cross_membership_fees : $fee_structure->indian_red_cross_membership_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'indian_red_cross_membership_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->indian_red_cross_membership_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="indian_red_cross_membership_fees_checkbox" value="<?php echo ($voucherData->indian_red_cross_membership_fees>0) ? $voucherData->indian_red_cross_membership_fees : $fee_structure->indian_red_cross_membership_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Women
                                    Cell
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->women_cell_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'women_cell_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->women_cell_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="women_cell_fees" id="women_cell_fees" class="form-control" value="<?php echo ($voucherData->women_cell_fees>0) ? $voucherData->women_cell_fees : $fee_structure->women_cell_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'women_cell_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->women_cell_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="women_cell_fees_checkbox" value="<?php echo ($voucherData->women_cell_fees>0) ? $voucherData->women_cell_fees : $fee_structure->women_cell_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">NSS
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->nss_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'nss_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->nss_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="nss_fees" id="nss_fees" class="form-control" value="<?php echo ($voucherData->nss_fees>0) ? $voucherData->nss_fees : $fee_structure->nss_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'nss_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->nss_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="nss_fees_checkbox" value="<?php echo ($voucherData->nss_fees>0) ? $voucherData->nss_fees : $fee_structure->nss_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Teachers Flag Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->teachers_flag_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'teachers_flag_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->teachers_flag_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="teachers_flag_fees" id="teachers_flag_fees" class="form-control" value="<?php echo ($voucherData->teachers_flag_fees>0) ? $voucherData->teachers_flag_fees : $fee_structure->teachers_flag_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'teachers_flag_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->teachers_flag_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="teachers_flag_fees_checkbox" value="<?php echo ($voucherData->teachers_flag_fees>0) ? $voucherData->teachers_flag_fees : $fee_structure->teachers_flag_fees; ?>">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-12 col-form-label   font-weight-bold">
                                    <hr />
                                </label>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">College Other Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->college_other_fees; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'college_other_fees', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->college_other_fees - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="college_other_fees" id="college_other_fees" class="form-control" value="<?php echo ($voucherData->college_other_fees>0) ? $voucherData->college_other_fees : $fee_structure->college_other_fees; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'college_other_fees', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->college_other_fees > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="college_other_fees_checkbox" value="<?php echo ($voucherData->college_other_fees>0) ? $voucherData->college_other_fees : $fee_structure->college_other_fees; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Exam Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->exam_fee; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'exam_fee', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->exam_fee - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="exam_fee" id="exam_fee" class="form-control" value="<?php echo ($voucherData->exam_fee>0) ? $voucherData->exam_fee : $fee_structure->exam_fee; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'exam_fee', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->exam_fee > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="exam_fee_checkbox" value="<?php echo ($voucherData->exam_fee>0) ? $voucherData->exam_fee : $fee_structure->exam_fee; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label  ">Tution
                                    Fee</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->tuition_fee; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'tuition_fee', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->tuition_fee - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="tuition_fee" id="tuition_fee" class="form-control" value="<?php echo ($voucherData->tuition_fee>0) ? $voucherData->tuition_fee : $fee_structure->tuition_fee; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'tuition_fee', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->tuition_fee > 0)
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }

                                    ?>
                                    <input type="checkbox"  <?=$check;?> <?= $readonly; ?> name="fees[]" id="tuition_fee_checkbox" value="<?php echo ($voucherData->tuition_fee>0) ? $voucherData->tuition_fee : $fee_structure->tuition_fee; ?>">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label   font-weight-bold">CORPUS
                                    FUND</label>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php echo  $fee_structure->corpus_fee_demand; ?>

                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label for="staticEmail" class="col-form-label  ">
                                        <?php $paid = $this->admin_model->checkFieldGreaterThanZerovalue($fee_structure->id, 'corpus_fee_demand', $usn, $fee_structure->year); ?>
                                        <?= $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <label for="staticEmail" class="col-form-label  ">

                                        <?= $fee_structure->corpus_fee_demand - $paid; ?>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" readonly name="corpus_fee_demand" id="corpus_fee_demand" class="form-control" value="<?php echo ($voucherData->corpus_fee_demand>0) ? $voucherData->corpus_fee_demand : $fee_structure->corpus_fee_demand; ?>">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-1">
                                    <?php $readonlyvalue = $this->admin_model->checkFieldGreaterThanZero1($fee_structure->id, 'corpus_fee_demand', $usn, $fee_structure->year);

                                    if ($readonlyvalue) {
                                        $readonly = "disabled";
                                    } else {
                                        $readonly = "";
                                    }
                                    if($voucherData->corpus_fee_demand >0 )
                                    {
                                        $check = "checked";
                                    }
                                  else{
                                    $check = "";
                                    }
                                    

                                    ?>
                                    <input type="checkbox"   <?=$check;?> <?= $readonly; ?> name="fees[]" id="corpus_fee_demand_checkbox" value="<?php echo ($voucherData->corpus_fee_demand>0) ? $voucherData->corpus_fee_demand : $fee_structure->corpus_fee_demand; ?>">
                                </div>
                            </div>
                            <hr />

                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 col-form-label   font-weight-bold">TOTAL AMOUNT</label>
                                <div class="col-md-7">
                                    <input type="hidden" name="year" id="year" class="form-control" value="<?= $fee_structure->year; ?>">
                                    <input type="text" name="final_fee" id="final_fee" class="form-control" value="" placeholder="<?php echo $voucherData->final_fee; ?>" readonly>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">



                                <label class="form-label text-primary">Voucher Type</label>
                                <div class="form-group col-sm-12">
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="voucher_type" value="1" <?php echo ($voucherData->voucher_type == 1) ? 'checked' : ''; ?>> Cash
                                    </label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="voucher_type" value="2" <?php echo ($voucherData->voucher_type == 2) ? 'checked' : ''; ?>> Bank DD
                                    </label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="voucher_type" value="5" <?php echo ($voucherData->voucher_type == 5) ? 'checked' : ''; ?>> DD
                                    </label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="voucher_type" value="4" <?php echo ($voucherData->voucher_type == 4) ? 'checked' : ''; ?>> Bank Transfer
                                    </label>
                                    <span class="text-danger"><?php echo form_error('voucher_type'); ?></span>
                                </div>

                                <div id="dd_details" style="display: <?php echo ($voucherData->voucher_type == 2 || $voucherData->voucher_type == 5) ? 'block' : 'none'; ?>;">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="form-label">DD Date:</label>
                                        <input type="date" class="form-control" placeholder="Enter Date" id="dd_date" name="dd_date" value="<?php echo $voucherData->dd_date; ?>">
                                        <span class="text-danger"><?php echo form_error('dd_date'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="form-label">DD Number:</label>
                                        <input type="text" class="form-control" placeholder="Enter number" id="dd_number" name="dd_number" value="<?php echo $voucherData->dd_number; ?>">
                                        <span class="text-danger"><?php echo form_error('dd_number'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="form-label">Bank Name & Branch:</label>
                                        <input type="text" class="form-control" placeholder="Enter bank name" id="dd_bank" name="dd_bank" value="<?php echo $voucherData->dd_bank; ?>">
                                        <span class="text-danger"><?php echo form_error('dd_bank'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label class="form-label">Comments:</label>
                                    <textarea class="form-control" placeholder="Enter your comments" id="comments" name="comments"><?php echo $voucherData->comments; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('comments'); ?></span>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label class="form-label">Remarks:</label>
                                    <textarea class="form-control" placeholder="Enter remarks" id="remarks" name="remarks"><?php echo $voucherData->remarks; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label class="form-label">Document:</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    <span class="text-danger"><?php echo form_error('file'); ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo anchor('admin/paymentDetail/' . $encryptId, 'BACK', 'class="btn btn-dark btn-square" '); ?>
                            </div>
                            <div class="col-md-6  ">
                                <button type="submit" class="btn btn-info btn-square" name="create" id="create"> UPDATE </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<script>
    $(document).ready(function() {

<?php if($voucherData->voucher_type==2 || $voucherData->voucher_type== 5)
{
    ?>
    $("#dd_details").show();
<?php
}
else
{
    ?>
    $("#dd_details").hide();
<?php
}
?>
        


        $('input[type=radio][name=voucher_type]').change(function() {

            if (this.value == "5" || this.value == "2") {

                $("#dd_details").show();

            } else {
                $("#dd_details").hide();
            }


        });
        // Function to update final fee based on selected checkboxes
        function updateFinalFee() {
            var sum = 0;
            var corpusFundChecked = false;

            // Iterate over each checkbox that needs to be considered
            $('input[type="checkbox"]').each(function() {
                if ($(this).prop('checked')) {
                    var inputId = $(this).attr('id').replace('_checkbox', '');
                    $('#' + inputId).removeAttr('readonly');
                    var inputValue = parseFloat($('#' + inputId).val());

                    if ($(this).attr('id') === 'corpus_fee_demand_checkbox') {
                        // If corpus_fee_demand_checkbox is checked, uncheck all others
                        corpusFundChecked = true;
                        sum = inputValue; // Set sum to only the corpus fund value
                    } else {
                        // Add value to sum only if it's not corpus_fee_demand_checkbox
                        sum += inputValue;
                    }
                }
            });

            // Update the final_fee input with the calculated sum
            $('#final_fee').val(sum.toFixed(2));

            // If corpus_fee_demand_checkbox is checked, uncheck all other checkboxes
            if (corpusFundChecked) {
                $('input[type="checkbox"]').each(function() {
                    if ($(this).attr('id') !== 'corpus_fee_demand_checkbox' && $(this).prop('checked')) {
                        $(this).prop('checked', false);
                    }
                });
            }
        }
        $('#selectAllCheckbox').change(function() {
            // Check if the master checkbox is checked
            var isChecked = $(this).is(':checked');

            // Select or deselect all checkboxes that are not disabled and not with the ID 'corpus_fee_demand_checkbox'
            $('input[type="checkbox"]:not(:disabled):not(#corpus_fee_demand_checkbox)').prop('checked', isChecked);
        });
        // Attach change event listener to relevant checkboxes
        $('input[type="checkbox"]').change(function() {
            updateFinalFee(); // Update the final fee whenever a checkbox changes
        });
        $('input[type="text"]').change(function() {
            updateFinalFee(); // Update the final fee whenever a checkbox changes
        });
        // Initialize final fee on page load
        updateFinalFee();
    });
</script>

<script>
    $(document).ready(function() {
        // Listen for form submission
        $('form').submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Array to store selected checkbox values
            var selectedFees = [];

            // Iterate over each checked checkbox
            $('input[name="fees[]"]:checked').each(function() {
                // Get the value of the checkbox (e.g., 'e_learning_fee')
                var feeValue = $(this).val();
                var inputId = $(this).attr('id').replace('_checkbox', '');
                var inputValue = parseFloat($('#' + inputId).val());
                // Find the corresponding text field value based on feeValue
                var textFieldValue = $('#' + feeValue).val();

                // Prepare data for submission
                selectedFees.push({
                    name: $(this).attr('id'),
                    value: feeValue,
                    textFieldValue: textFieldValue,
                    newvalue: inputValue
                });
            });
            var finalFee = $('#final_fee').val();

            // Add final fee and selectedFees array as hidden input fields to the form
            $('<input>').attr({
                type: 'hidden',
                name: 'final_fee',
                value: finalFee
            }).appendTo('form');

            // Add selectedFees array as a hidden input field to the form
            $('<input>').attr({
                type: 'hidden',
                name: 'selected_fees',
                value: JSON.stringify(selectedFees)
            }).appendTo('form');

            // Submit the form programmatically
            this.submit();
        });
    });
</script>