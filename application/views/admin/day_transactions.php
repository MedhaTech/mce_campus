<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Day & Mode of Payment wise Transaction Details <span
                            class="h6 text-secondary">(as of <?php echo date('d-m-Y h:i A'); ?>)</span></h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mb-60 text-dark">
                                <thead class="thead-light text-center align-middle">
                                    <tr class="text-center">
                                        <th class="align-middle">DATE</th>
                                        <th class="align-middle">CASH</th>
                                        <th class="align-middle">BANK DD</th>
                                        <th class="align-middle">ONLINE PAYMENT</th>
                                        <th class="align-middle">BANK TRANSFER</th>
                                        <th class="align-middle">DD</th>
                                        <th class="align-middle">TOTAL</th>
                                    </tr>
                                </thead>
                                <?php
                                // echo "<pre>";
                                // print_r($res);
                                $cash_total = 0;
                                $bank_dd_total = 0;
                                $online_payment_total = 0;
                                $bank_transfer_total = 0;
                                $dd_total = 0;
                                $overall = 0;
                                foreach ($res as $key => $value) {
                                    echo "<tr class='text-right'>";
                                    echo "<td class='text-center'>" . date('d-m-Y', strtotime($key)) . "</td>";
                                    $cash = (array_key_exists('1', $value)) ? $value['1'] : 0;
                                    echo "<td>" . number_format($cash, 2) . "</td>";
                                    $bank_dd = (array_key_exists('2', $value)) ? $value['2'] : 0;
                                    echo "<td>" . number_format($bank_dd, 2) . "</td>";
                                    $online_payment = (array_key_exists('3', $value)) ? $value['3'] : 0;
                                    echo "<td>" . number_format($online_payment, 2) . "</td>";
                                    $bank_transfer = (array_key_exists('4', $value)) ? $value['4'] : 0;
                                    echo "<td>" . number_format($bank_transfer, 2) . "</td>";
                                    $dd = (array_key_exists('5', $value)) ? $value['5'] : 0;
                                    echo "<td>" . number_format($dd, 2) . "</td>";
                                    $total = $cash + $bank_dd + $online_payment + $bank_transfer + $dd;
                                    echo "<td>" . number_format($total, 2) . "</td>";
                                    echo "</tr>";

                                    $cash_total = $cash_total + $cash;
                                    $bank_dd_total = $bank_dd_total + $bank_dd;
                                    $online_payment_total = $online_payment_total + $online_payment;
                                    $bank_transfer_total = $bank_transfer_total + $bank_transfer;
                                    $dd_total = $dd_total + $dd;
                                    $overall = $overall + $total;
                                }
                                echo "<tr class='text-right'>";
                                echo "<th>OVERALL</th>";
                                echo "<th>" . number_format($cash_total, 2) . "</th>";
                                echo "<th>" . number_format($bank_dd_total, 2) . "</th>";
                                echo "<th>" . number_format($online_payment_total, 2) . "</th>";
                                echo "<th>" . number_format($bank_transfer_total, 2) . "</th>";
                                echo "<th>" . number_format($dd_total, 2) . "</th>";
                                echo "<th>" . number_format($overall, 2) . "</th>";
                                echo "</tr>";
                                ?>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->


            </div> <!-- end col -->
        </div>
        <!-- end row-->



    </div>
</div>
<!-- End Page-content -->