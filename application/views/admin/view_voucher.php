<div class="row">
    <div class="col-lg-12">

        <div class="card-body">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="staticEmail" class="col-md-5 col-form-label">Challan No. : MCE24-25/<?= $fee_structure->id; ?></label>
                    <div class="col-md-3">
                        <label class="col-form-label">Final Amount</label>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Voucher Amount</label>
                    </div>
                </div>
                <hr />

                <?php if ($voucherData->renewal_of_registration_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Renewal of registration fees</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->renewal_of_registration_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->renewal_of_registration_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->e_consortium_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">e Consortium Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->e_consortium_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->e_consortium_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->students_sports_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Sport Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->students_sports_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->students_sports_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->students_sports_development_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Sports Development Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->students_sports_development_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->students_sports_development_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->career_guideliness_and_counselling_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Career Guidance & Counseling fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->career_guideliness_and_counselling_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->career_guideliness_and_counselling_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->university_development_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">University Development fund</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->university_development_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->university_development_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->cultural_activities_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Cultural Activities Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->cultural_activities_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->cultural_activities_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->teachers_development_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Teachers Development Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->teachers_development_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->teachers_development_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->student_development_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Student Development Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->student_development_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->student_development_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->indian_red_cross_membership_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Indian Red Cross Membership Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->indian_red_cross_membership_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->indian_red_cross_membership_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->women_cell_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Women Cell Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->women_cell_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->women_cell_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->nss_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">NSS Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->nss_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->nss_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->teachers_flag_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Teachers Flag Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->teachers_flag_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->teachers_flag_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->college_other_fees > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">College Other Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->college_other_fees; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->college_other_fees; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->exam_fee > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Exam Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->exam_fee; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->exam_fee; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->tuition_fee > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Tuition Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->tuition_fee; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->tuition_fee; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($voucherData->corpus_fee_demand > 0): ?>
                    <div class="form-group row">
                        <label class="col-md-5 col-form-label">Corpus Fee</label>
                        <div class="col-md-3">
                            <label class="col-form-label"><?= $fee_structure->corpus_fee_demand; ?></label>
                        </div>
                        <div class="col-md-3"><?= $voucherData->corpus_fee_demand; ?></div>
                    </div>
                <?php endif; ?>


                <div class="form-group row">
                    <label for="staticEmail" class="col-md-5 col-form-label   font-weight-bold">TOTAL AMOUNT</label>
                    <div class="col-md-5 font-weight-bold">
                        <?php echo $voucherData->final_fee; ?>

                    </div>
                </div>
            </div>
        </div>



    </div>

</div>
</div>