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
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th rowspan="2">ACADEMIC YEAR</th>
                                        <th rowspan="2">YEAR</th>
                                        <th colspan="3">CORPUS FEE (&#8377;)</th>
                                        <th colspan="3">COLLEGE FEE (&#8377;)</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>DEMAND</th>
                                        <th>COLLECTION</th>
                                        <th>BALANCE</th>
                                        <th>DEMAND</th>
                                        <th>COLLECTION</th>
                                        <th>BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($fees as $fee) {
                                        $college_fee_demand = $fee->college_fee_demand;
                                        $college_fee_collection = $fee->college_fee_collection;
                                        $college_fee_balance = number_format($fee->college_fee_demand - $fee->college_fee_collection, 2);
                                        $college_pay_btn = ($college_fee_balance) ? anchor('', "PAY FEE", 'class="btn btn-danger btn-sm"') : null;
                                        echo "<tr>";
                                        echo "<td>" . $fee->academic_year . "</td>";
                                        echo "<td class='text-center'>" . $fee->year . "</td>";
                                        echo "<td class='text-right'>" . $fee->corpus_fee_demand . "</td>";
                                        echo "<td class='text-right'>0</td>";
                                        echo "<td class='text-right'>0</td>";
                                        echo "<td class='text-right'>" . indian_number_format($college_fee_demand) . "</td>";
                                        echo "<td class='text-right'>" . indian_number_format($college_fee_collection) . "</td>";
                                        echo "<td class='text-right'>" . indian_number_format($college_fee_balance) . '  ' . $college_pay_btn . "</td>";
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
    <!-- end row-->

</div>
</div>
<!-- /.col -->