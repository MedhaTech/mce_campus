<!-- Content Wrapper. Contains page content -->
<div class="page-content">

    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header bg-dark text-white">ADMISSION DETAILS</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">USN</label>
                            <p><?= $admissionDetails->usn; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Student Name</label>
                            <p><?= $admissionDetails->student_name; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Mobile</label><br>
                            <p><?= $admissionDetails->student_number; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Father Mobile</label>
                            <p><?= $admissionDetails->father_number; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <p><?= $admissionDetails->email; ?></p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Admission Year</label>
                            <p><?= $admissionDetails->admission_year; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Department</label><br>
                            <?= $admissionDetails->department; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Quota</label><br>
                            <?= $admissionDetails->quota; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Sub Quota</label><br>
                            <?= $admissionDetails->sub_quota; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">College Code</label>
                            <p><?= $admissionDetails->college_code; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Current Year</label>
                            <p><?= $admissionDetails->year; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <p><?= $admissionDetails->gender; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Aadhar</label>
                            <p><?= $admissionDetails->aadhar_number; ?></p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Category Alloted</label>
                            <p><?= $admissionDetails->category_alloted; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Category Claimed</label>
                            <p><?= $admissionDetails->category_claimed; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Caste</label>
                            <p><?= $admissionDetails->caste; ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header bg-dark text-white">FEE DETAILS</h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="thead-light text-center align-middle">
                            <tr class="text-center">
                                <th rowspan="2" width="11%" class="align-middle">ACADEMIC YEAR</th>
                                <th rowspan="2" width="11%" class="align-middle">YEAR</th>
                                <th colspan="3" class="">CORPUS FEE (&#8377;)</th>
                                <th colspan="3" class="">COLLEGE FEE (&#8377;)</th>
                                <th rowspan="2" width="11%" class="align-middle">ACTION</th>
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
                                $collection_amount = $this->admin_model->get_total_amount($fee->year, $usn, 1);
                                $paid_amount = $corpus_fee_collection + $collection_amount;
                                $corpus_fee_balance = $corpus_fee_demand - $paid_amount;

                                $college_fee_demand = $fee->college_fee_demand;
                                $college_fee_collection = $fee->college_fee_collection;
                                $college_collection_amount = $this->admin_model->get_total_amount($fee->year, $usn, 0);
                                // var_dump($this->db->last_query());
                                // $college_fee = $fee->college_fee_demand - $fee->college_fee_collection;
                                $college_paid_fee = $college_fee_collection + $college_collection_amount;
                                // $college_fee_balance = $college_fee - $this->admin_model->get_total_amount($fee->year, $student->usn, 0);
                                $college_fee_balance = $college_fee_demand - $college_paid_fee;


                                $voucher_btn = ($college_fee_balance || $corpus_fee_balance) ? anchor('admin/new_voucher/' . $encryptId . '/' . $fee->id, "Create Voucher", 'class="btn btn-danger btn-sm"') : "-";
                                echo "<tr>";
                                echo "<td class='text-center'>" . $fee->academic_year . "</td>";
                                echo "<td class='text-center'>" . $fee->year . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($fee->corpus_fee_demand) . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($paid_amount) . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($corpus_fee_balance) . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($college_fee_demand) . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($college_paid_fee) . "</td>";
                                echo "<td class='text-right'>" . formatIndianCurrency($college_fee_balance) . "</td>";
                                echo "<td class='text-right'>" . $voucher_btn . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->

        </div>

        <div class="card">
            <h5 class="card-header bg-dark text-white">VOUCHERS LIST</h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <?php $rec = 0;   // to update Admisison Date
                    if ($paymentDetail) {
                        $rec = 0;
                        $table_setup = array('table_open' => '<table class="table table-hover font14 mb-0">');
                        $this->table->set_template($table_setup);
                        $print_fields = array('S.No', 'Voucher', 'Amount', 'Voucher Type', 'Date', 'Status', 'Comments', 'Remarks', 'Action');
                        $this->table->set_heading($print_fields);
                        $statusTypes = array("0" => "<span class='text-danger'>Not Paid</span>", "1" => "<span class='text-success'>Paid</span>", "2" => "Failed", "3" => "<span class='text-warning'>Processing</span>");
                        $i = 1;
                        $total = 0;
                        foreach ($paymentDetail as $paymentDetails1) {

                            if ($paymentDetails1->voucher_type == 3) {
                                $url = '-';
                                $button = '-';
                            } else {
                                if ($paymentDetails1->voucher_type == 1 || $paymentDetails1->voucher_type == 5) {
                                    // $url = anchor('admin/cashvoucher/' . $encryptId . '/' . $paymentDetails1->id, "MCE24-25/" . $paymentDetails1->id);
                                    $url = anchor('admin/cashvoucherletter/' . $encryptId . '/' . $paymentDetails1->id, "MCE24-25/" . $paymentDetails1->id);
                                }
                                if ($paymentDetails1->voucher_type == 2) {
                                    $url = anchor('admin/voucherletter/' . $encryptId . '/' . $paymentDetails1->id, "MCE24-25/" . $paymentDetails1->id);
                                }
                                if ($paymentDetails1->voucher_type == 4) {
                                    $url = anchor('admin/onlinevoucher/' . $encryptId . '/' . $paymentDetails1->id, "MCE24-25/" . $paymentDetails1->id);
                                }


                                if ($paymentDetails1->status != 1) {
                                    $button = anchor('admin/mark_paid/' . $encryptId . '/' . $paymentDetails1->id, "Mark as paid", 'class="btn btn-success btn-sm"');
                                    $button .= anchor('admin/update_voucher/' . $encryptId . '/' . $paymentDetails1->id, "Edit", 'class="btn btn-primary btn-sm"');
                                    $button .= anchor('admin/voucher_delete/' . $encryptId . '/' . $paymentDetails1->id, "Delete", 'class="btn btn-danger btn-sm"');
                                } else {
                                    $button = '-';
                                }
                            }


                            if ($paymentDetails1->file != '') {
                                $filee = anchor('assets/voucher/' . $paymentDetails1->file, "Download", 'target="blank" class="btn btn-success btn-sm"');
                            } else {
                                $filee = '';
                            }

                            $result_array = array(
                                $i++,
                                $url,
                                number_format($paymentDetails1->final_fee, 2),
                                $voucher_types[$paymentDetails1->voucher_type],
                                $paymentDetails1->requested_on,
                                $statusTypes[$paymentDetails1->status],
                                $paymentDetails1->comments . '<br>' . $filee,
                                $paymentDetails1->remarks,
                                $button


                            );
                            $this->table->add_row($result_array);
                        }

                        echo $this->table->generate();
                    } else {
                        $rec = 1;
                        echo "<h6 class='text-left'> No voucher details found..! </h6>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header bg-dark text-white">TRANSACTIONS LIST</h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <?php $rec = 0;   // to update Admisison Date
                    //   print_r($transactionDetails);
                    if ($transactionDetails) {
                        $rec = 0;
                        $table_setup = array('table_open' => '<table class="table table-hover font14 mb-0">');
                        $this->table->set_template($table_setup);
                        $print_fields = array('S.No', 'Receipt', 'Date', 'Mode of Payment', 'Amount', 'Comments', 'Status');
                        $this->table->set_heading($print_fields);

                        $transactionTypes = array("1" => "Cash", "2" => "Bank DD", "3" => "Online Payment", "4" => "Bank Transfer", "5" => "DD");

                        $i = 1;
                        $total = 0;
                        foreach ($transactionDetails as $transactionDetails1) {

                            $trans = null;
                            if ($transactionDetails1->transaction_type == 1) {
                                $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                                $receiptprint = $transactionDetails1->receipt_no;
                            }
                            if ($transactionDetails1->transaction_type == 2) {
                                $receiptprint = $transactionDetails1->receipt_no;
                                $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date)) . ' <br> Bank: ' . $transactionDetails1->bank_name;
                            }
                            if ($transactionDetails1->transaction_type == 3) {
                                $receiptprint = ($transactionDetails1->receipt_no) ? anchor('admin/feereceiptonline/' . $admissionDetails->usn . '/' . $transactionDetails1->id, $transactionDetails1->receipt_no) : "-";
                                $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> No:" . $transactionDetails1->reference_no . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
                            }
                            if ($transactionDetails1->transaction_type == 4) {
                                $receiptprint = ($transactionDetails1->receipt_no) ? anchor('admin/feereceipt/' . $admissionDetails->usn . '/' . $transactionDetails1->id, $transactionDetails1->receipt_no) : "-";
                                $trans = $voucher_types[$transactionDetails1->transaction_type] . "<br> Payment Mode:" . $transactionDetails1->transfer_mode . '<br> Dt:' . date('d-m-Y', strtotime($transactionDetails1->transaction_date));
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



                            $result_array = array(
                                $i++,
                                $receiptprint,
                                ($transactionDetails1->transaction_date != "") ? date('d-m-Y', strtotime($transactionDetails1->transaction_date)) : "-",
                                $trans,
                                number_format($transactionDetails1->amount, 2),
                                $transactionDetails1->remarks,
                                $transaction_status
                            );
                            $this->table->add_row($result_array);
                        }

                        echo $this->table->generate();
                    } else {
                        $rec = 1;
                        echo "<h6 class='text-left'> No transaction details found..! </h6>";
                    }
                    ?>
                </div>
            </div>
        </div>



    </div>
</div>