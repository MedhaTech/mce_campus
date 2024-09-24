<!-- Content Wrapper. Contains page content -->
<div class="page-content">

    <div class="container-fluid pb-5">

        <div class="card m-2 shadow card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Admission Details
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">

                    </ul>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Student Name</label><br>
                            <?= $admissionDetails->student_name; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Mobile</label><br>
                            <?= $admissionDetails->student_number; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Email</label><br>
                            <?= $admissionDetails->email; ?>
                        </div>
                    </div>

                    <div class="col-md-2">
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
                </div>

            </div>
        </div>

        <div class="card m-2 shadow card-info">
            <div class="card-header">
                <h3 class="card-title">Student Fee Details</h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">

                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="table-responsive">
                                <table class="table table-striped mb-60">
                                    <thead class="thead-light text-center align-middle">
                                        <tr class="text-center">
                                            <th rowspan="2" width="11%" class="align-middle">ACADEMIC YEAR</th>
                                            <th rowspan="2" width="11%" class="align-middle">YEAR</th>
                                            <th colspan="3" class="">CORPUS FEE (&#8377;)</th>
                                            <th colspan="3" class="">COLLEGE FEE (&#8377;)</th>
                                            <th></th>
                                        </tr>
                                        <tr class="text-center">
                                            <th width="13%">DEMAND</th>
                                            <th width="13%">COLLECTION</th>
                                            <th width="13%">BALANCE</th>
                                            <th width="13%">DEMAND</th>
                                            <th width="13%">COLLECTION</th>
                                            <th width="13%">BALANCE</th>
                                            <th width="13%"></th>
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


                                            $voucher_btn = ($college_fee_balance || $corpus_fee_balance) ? anchor('admin/new_voucher/' . $encryptId . '/' . $fee->id, "Create Voucher", 'class="btn btn-danger btn-sm"') : null;
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $fee->academic_year . "</td>";
                                            echo "<td class='text-center'>" . $fee->year . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($fee->corpus_fee_demand) . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($paid_amount) . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($corpus_fee_balance)  . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($college_fee_demand) . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($college_paid_fee) . "</td>";
                                            echo "<td class='text-center'>" . formatIndianCurrency($college_fee_balance)  . "</td>";
                                            echo "<td class='text-center'>" . $voucher_btn  . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div> <!-- end card body-->

                    </div> <!-- end card -->

                </div><!-- end col-->
            </div>

        </div>

        <div class="card m-2 shadow card-info">
                <div class="card-header">
                    <h3 class="card-title">Voucher Details</h3>
               
                </div>
                <div class="card-body">

                </div>
                <?php $rec = 0;   // to update Admisison Date

                if ($paymentDetail) {
                    $rec = 0;
                    $table_setup = array('table_open' => '<table class="table table-hover font14">');
                    $this->table->set_template($table_setup);
                    $print_fields = array('S.No', 'Voucher', 'Amount', 'Voucher Type', 'Date',  'Status', 'Action');
                    $this->table->set_heading($print_fields);

                    $statusTypes = array("0" => "Not Paid", "1" => "Paid", "2" => "Failed", "3" => "Processing");

                    $i = 1;
                    $total = 0;
                    foreach ($paymentDetail as $paymentDetails1) {

                        if ($paymentDetails1->voucher_type == 3) {
                            $url = '-';
                            $button = '-';
                        } else {
                            if ($paymentDetails1->voucher_type == 1 ||  $paymentDetails1->voucher_type == 5) {
                                $url = anchor('admin/cashvoucher/' . $encryptId . '/' . $paymentDetails1->id, "TF24-25/" . $paymentDetails1->id);
                            }
                            if ($paymentDetails1->voucher_type == 2) {
                                $url = anchor('admin/voucherletter/' . $encryptId . '/' . $paymentDetails1->id, "TF24-25/" . $paymentDetails1->id);
                            }
                            if ($paymentDetails1->voucher_type == 4) {
                                $url = anchor('admin/onlinevoucher/' . $encryptId . '/' . $paymentDetails1->id, "TF24-25/" . $paymentDetails1->id);
                            }


                            if ($paymentDetails1->status != 1) {
                                $button = anchor('admin/mark_paid/' . $encryptId . '/' . $paymentDetails1->id, "Mark as paid", 'class="btn btn-success btn-sm"');
                            } else {
                                $button = '-';
                            }
                        }




                        $result_array = array(
                            $i++,
                            $url,
                            number_format($paymentDetails1->final_fee, 2),
                            $voucher_types[$paymentDetails1->voucher_type],
                            $paymentDetails1->requested_on,
                            $statusTypes[$paymentDetails1->status],
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