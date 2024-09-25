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

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <h4 class="card-title text-secondary">ADMISSION DETAILS</h4>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">USN</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->usn != NULL) {
                                    echo $details->usn;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-3">
                            <label for="example-static" class="mb-0">Student Name</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->student_name != NULL) {
                                    echo $details->student_name;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-3">
                            <label for="example-static" class="mb-0">Stream</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->stream != NULL) {
                                    echo $details->stream;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-4">
                            <label for="example-static" class="mb-0">Department</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->department != NULL) {
                                    echo $details->department;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">College Code</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->college_code != NULL) {
                                    echo $details->college_code;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">Quota</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->quota != NULL) {
                                    echo $details->quota;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">Sub Quota</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->sub_quota != NULL) {
                                    echo $details->sub_quota;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">Category Alloted</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->category_allotted != NULL) {
                                    echo $details->category_allotted;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">Category Claimed</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->category_claimed != NULL) {
                                    echo $details->category_claimed;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-2">
                            <label for="example-static" class="mb-0">Caste</label>
                            <span class="form-control-plaintext">
                                <?php
                                if ($details->caste != NULL) {
                                    echo $details->caste;
                                } else {
                                    echo "--";
                                }
                                ?>
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- <h4 class="card-title">Buttons example</h4> -->
                        <!-- <p class="card-subtitle mb-4">
                            The Buttons extension for DataTables provides a common set of options, API methods and
                            styling to display buttons on a page
                            that will interact with a DataTable. The core library provides the based framework upon
                            which plug-ins can built.
                        </p> -->
                        <?php
                        // echo "<pre>";
                        // print_r($details);
                        // print_r($fees);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light text-center align-middle">
                                    <tr class="text-center">
                                        <th rowspan="2" width="11%" class="align-middle">ACADEMIC YEAR</th>
                                        <th rowspan="2" width="11%" class="align-middle">YEAR</th>
                                        <th colspan="3" class="">CORPUS FEE (&#8377;)</th>
                                        <th colspan="3" class="">COLLEGE FEE (&#8377;)</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th width="13%">DEMAND</th>
                                        <th width="13%">COLLECTION</th>
                                        <th width="13%">BALANCE</th>
                                        <th width="13%">DEMAND</th>
                                        <th width="13%">COLLECTION</th>
                                        <th width="13%">BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($fees as $fee) {

                                        // print_r($fee);
                                        $corpus_fee_demand = $fee->corpus_fee_demand;
                                        $corpus_fee_collection = $fee->corpus_fee_collection;
                                        $collection_amount = $this->admin_model->get_total_amount($fee->year, $student->usn, 1);
                                        $paid_amount = $corpus_fee_collection + $collection_amount;
                                        $corpus_fee_balance = $corpus_fee_demand - $paid_amount;

                                        if ($corpus_fee_balance > 0) {
                                            $corpus_pay_btn = '<form action="' . base_url(htmlspecialchars($action)) . '" method="post" class="user">
                                            <input type="hidden" name="usn" id="usn" value="' . htmlspecialchars($student->usn) . '">
                                            <input type="hidden" name="name" id="name" value="' . htmlspecialchars($student->student_name) . '">
                                            <input type="hidden" name="email" id="email" value="' . htmlspecialchars($student->email) . '">
                                            <input type="hidden" name="aided_unaided" id="aided_unaided" value="' . htmlspecialchars($student->sub_quota) . '">
                                            <input type="hidden" name="mobile" id="mobile" value="' . htmlspecialchars($student->student_number) . '">
                                            <input type="hidden" name="amount" id="amount" value="' . htmlspecialchars($corpus_fee_balance) . '">
                                            <input type="hidden" name="year" id="year" value="' . htmlspecialchars($fee->year) . '">
                                            <input type="hidden" name="payment_mode" id="payment_mode" value="1">
                                            <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update">PAY FEE</button>
                                            </form>';
                                        } else {
                                            $corpus_pay_btn = '';
                                        }

                                        $college_fee_demand = $fee->college_fee_demand;
                                        $college_fee_collection = $fee->college_fee_collection;
                                        $college_collection_amount = $this->admin_model->get_total_amount($fee->year, $student->usn, 0);
                                        // $college_fee = $fee->college_fee_demand - $fee->college_fee_collection;
                                        $college_paid_fee = $college_fee_collection + $college_collection_amount;
                                        // $college_fee_balance = $college_fee - $this->admin_model->get_total_amount($fee->year, $student->usn, 0);
                                        $college_fee_balance = $college_fee_demand - $college_paid_fee;

                                        if ($college_fee_balance > 0) {
                                            $college_pay_btn = '<form action="' . base_url(htmlspecialchars($action)) . '" method="post" class="user">
                                            <input type="hidden" name="usn" id="usn" value="' . htmlspecialchars($student->usn) . '">
                                            <input type="hidden" name="name" id="name" value="' . htmlspecialchars($student->student_name) . '">
                                            <input type="hidden" name="email" id="email" value="' . htmlspecialchars($student->email) . '">
                                            <input type="hidden" name="aided_unaided" id="aided_unaided" value="' . htmlspecialchars($student->sub_quota) . '">
                                            <input type="hidden" name="mobile" id="mobile" value="' . htmlspecialchars($student->student_number) . '">
                                            <input type="hidden" name="amount" id="amount" value="' . htmlspecialchars($college_fee_balance) . '">
                                            <input type="hidden" name="year" id="year" value="' . htmlspecialchars($fee->year) . '">
                                            <input type="hidden" name="payment_mode" id="payment_mode" value="0">
                                            <button type="submit" class="btn btn-danger btn-sm" name="Update" id="Update">PAY FEE</button>
                                            </form>';
                                        } else {
                                            $college_pay_btn = '';
                                        }
                                        // $college_pay_btn = ($college_fee_balance) ? anchor('', "PAY FEE", 'class="btn btn-danger btn-sm"') : null;
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . $fee->academic_year . "</td>";
                                        echo "<td class='text-center'>" . $fee->year . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($fee->corpus_fee_demand) . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($fee->corpus_fee_collection) . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($corpus_fee_balance) . '  ' . $corpus_pay_btn . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($college_fee_demand) . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($college_fee_collection) . "</td>";
                                        echo "<td class='text-center'>" . formatIndianCurrency($college_fee_balance) . '  ' . $college_pay_btn . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>


                        </div>
                    </div> <!-- end card body-->

                </div> <!-- end card -->
                <p><b>Note : FEE ONCE PAID WILL NOT BE REFUNDED UNDER ANY CIRCUMSTANCES-KINDLY VERIFY THE DATA ENTERED BEFORE FINAL SUBMISSION </b></p>
            </div><!-- end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $rec = 0;   // to update Admisison Date
                        //   print_r($transactionDetails);
                        if ($transactionDetails) {
                            $rec = 0;
                            $table_setup = array('table_open' => '<table class="table table-hover font14">');
                            $this->table->set_template($table_setup);
                            $print_fields = array('S.No', 'Receipt', 'Date', 'Mode of Payment', 'Amount', 'Status');
                            $this->table->set_heading($print_fields);

                            // $transactionTypes = array("1" => "Cash", "2" => "DD", "3" => "Online Payment", "4" => "Online Transfer");
                            $transactionTypes = array("1" => "Cash", "2" => "Bank DD", "3" => "Online Payment", "4" => "Bank Transfer","5"=>"DD");
                            $i = 1;
                            $total = 0;
                            foreach ($transactionDetails as $transactionDetails1) {

                                $trans = null;
                                // if ($transactionDetails1->transaction_type == 1) {
                                //     $trans = $transactionTypes[$transactionDetails1->transaction_type];
                                // }
                                // if ($transactionDetails1->transaction_type == 2) {
                                //     $trans = $transactionTypes[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->reference_date)) . ' <br> Bank: ' . $transactionDetails1->bank_name;
                                // }
                                // if ($transactionDetails1->transaction_type == 3) {
                                //     $trans = $transactionTypes[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->reference_date));
                                // }

                                if ($transactionDetails1->transaction_type == 1) {
                                    $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                                    $receiptprint = $transactionDetails1->receipt_no;
                                }
                                if ($transactionDetails1->transaction_type == 2) {
                                    $receiptprint = $transactionDetails1->receipt_no;
                                    $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date)) . ' <br> Bank: ' . $transactionDetails1->bank_name;
                                }
                                if ($transactionDetails1->transaction_type == 3) {
                                    $receiptprint = $transactionDetails1->receipt_no;
                                    $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                                }
                                if ($transactionDetails1->transaction_type == 4) {
                                    $receiptprint = $transactionDetails1->receipt_no;
                                    $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                                }
                                if ($transactionDetails1->transaction_type == 5) {
                                    $receiptprint = $transactionDetails1->receipt_no;
                                    $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                                }


                                if ($transactionDetails1->transaction_status == 1) {
                                    $transaction_status = "<span class='text-success'>Verified</span>";
                                } else if ($transactionDetails1->transaction_status == 2) {
                                    $transaction_status = "<span class='text-danger'>Cancelled</span>";
                                    // $transaction_status = "<span class='text-danger'>Cancelled</span><br><span class='text-dark'>".nl2br($transactionDetails1->remarks)."</span>";
                                } else {
                                    $transaction_status = "<span class='text-warning'>Processing</span>";
                                    // $transaction_status = "<span class='text-warning'>Processing</span> <br>".anchor('admin/approvePayment/'.$transactionDetails1->id,'Approve','class="btn btn-info btn-sm"').' '.anchor('admin/deletePayment/'.$transactionDetails1->id.'/'.$transactionDetails1->admissions_id,'Delete','class="btn btn-danger btn-sm"');
                                }
                                if ($transactionDetails1->transaction_status == 1) {
                                    $result_array = array(
                                        $i++,
                                        ($transactionDetails1->receipt_no) ? anchor('student/downloadReceipt/' . $transactionDetails1->reg_no . '/' . $transactionDetails1->id, $transactionDetails1->receipt_no) : "-",
                                        // $transactionDetails1->receipt_no,
                                        ($transactionDetails1->transaction_date != "") ? date('d-m-Y', strtotime($transactionDetails1->transaction_date)) : "-",
                                        $trans,
                                        number_format($transactionDetails1->amount, 2),
                                        $transaction_status
                                    );
                                    $this->table->add_row($result_array);
                                }
                            }

                            echo $this->table->generate();
                        } else {
                            $rec = 1;
                            echo "<h6 class='text-left'> No transaction details found..! </h6>";
                        }
                        ?>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
    <!-- end row-->

</div>
</div>
<!-- /.col -->