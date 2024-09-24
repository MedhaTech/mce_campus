<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">





            <!-- /.col -->
            <div class="card m-2 shadow card-info">
                <div class="card-header ">
                    <h3 class="card-title">
                        Payment Details
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">

                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <?php echo form_open_multipart($action, 'class="user"'); ?>
                    <?php if ($this->session->flashdata('message')) { ?>
                        <div align="center" class="alert <?= $this->session->flashdata('status'); ?>" id="msg">
                            <?php echo $this->session->flashdata('message') ?>
                        </div>
                    <?php } ?>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Paid Date:</label>
                                <input type="date" class="form-control" placeholder="Enter Date" id="transaction_date" name="transaction_date" value="">
                                <span class="text-danger"><?php echo form_error('transaction_date'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Receipt Number(Tally):</label>
                                <input type="text" class="form-control" placeholder="Enter Receipt Number(Tally)" id="receipt_no" name="receipt_no" value="">
                                <span class="text-danger"><?php echo form_error('receipt_no'); ?></span>
                            </div>
                        </div>



                        <?php if ($voucherDetails->voucher_type == 2) { ?>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">DD Date:</label>
                                    <input type="date" class="form-control" placeholder="Enter Date" id="dd_date" name="dd_date" value="<?=$voucherDetails->dd_date;?>">
                                    <span class="text-danger"><?php echo form_error('dd_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">DD Number:</label>
                                    <input type="text" class="form-control" placeholder="Enter number" id="dd_number" name="dd_number" value="<?=$voucherDetails->dd_number;?>">
                                    <span class="text-danger"><?php echo form_error('dd_number'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bank Name :</label>
                                    <input type="text" class="form-control" placeholder="Enter bank name" id="dd_bank" name="dd_bank" value="<?=$voucherDetails->dd_bank;?>">
                                    <span class="text-danger"><?php echo form_error('dd_bank'); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($voucherDetails->voucher_type == 5) { ?>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">DD Date:</label>
                                    <input type="date" class="form-control" placeholder="Enter Date" id="dd_date" readonly name="dd_date" value="<?=$voucherDetails->dd_date;?>">
                                    <span class="text-danger"><?php echo form_error('dd_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">DD Number:</label>
                                    <input type="text" class="form-control" placeholder="Enter number" readonly id="dd_number" name="dd_number" value="<?=$voucherDetails->dd_number;?>">
                                    <span class="text-danger"><?php echo form_error('dd_number'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bank Name :</label>
                                    <input type="text" class="form-control" placeholder="Enter bank name" readonly id="dd_bank" name="dd_bank" value="<?=$voucherDetails->dd_bank;?>">
                                    <span class="text-danger"><?php echo form_error('dd_bank'); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($voucherDetails->voucher_type == 4) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Mode of Payments :</label>
                                    <?php $payment_modes = array("" => "Select", "RTGS" => "RTGS", "IMPS" => "IMPS", "NEFT" => "NEFT", "UPI" => "UPI");
                                    echo form_dropdown('payment_mode', $payment_modes, '', 'class="form-control input-xs" id="payment_mode"'); ?>
                                    <span class="text-danger"><?php echo form_error('payment_mode'); ?></span>
                                </div>
                            </div>

                        <?php } ?>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Comments:</label>
                                <textarea class="form-control" placeholder="Enter Comments" id="remarks" name="remarks"> </textarea>
                                <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-danger btn-sm" type="submit">Amount Paid</button>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>

</div>


</section>
<!-- /.content -->
</div>