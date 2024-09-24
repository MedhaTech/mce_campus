<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">

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
                                <?= $admissionDetails->mobile; ?>
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
                                <label class="form-label">Aadhaar Number</label><br>
                                <?= $admissionDetails->aadhaar; ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Department</label><br>
                                <?= $this->admin_model->get_dept_by_id($admissionDetails->dept_id)["department_name"]; ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Quota</label><br>
                                <?= $admissionDetails->quota; ?>
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
                <div class="card-body">
                    <?php // print_r($fees); 
                    ?>
                    <div class="row">
                        <!-- <div class="col-2">
                              <div class="form-group">
                                  <label class="form-label">Total College Fee + Corpus Fund - Concession Fee (Rs.)</label>
                                  <h4><?php echo number_format($fees->total_college_fee, 2) . ' + ' . number_format($fees->corpus_fund, 2) . ' - ' . number_format($studentDetails->concession_fee, 2); ?>
                                  </h4>
                              </div>
                          </div> -->
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">College Fee</label>
                                <h4><?php echo number_format($fees->total_college_fee, 2); ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Corpus Fund</label>
                                <h4><?php echo number_format($fees->corpus_fund, 2); ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Concession Fee</label>
                                <h4><?php echo number_format($fees->consession_amount, 2); ?>
                                </h4>
                            </div>
                        </div>
                        <!-- <div class="col-2">
                              <div class="form-group">
                                  <label class="form-label">Total College Fee + Corpus Fund - Concession Fee
                                      (Rs.)</label>
                                  <h4><?php echo number_format($fees->total_college_fee, 0) . ' + ' . number_format($fees->corpus_fund, 0) . ' - ' . number_format($studentDetails->concession_fee, 0); ?>
                                  </h4>
                              </div>
                          </div> -->
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Total Fee (Rs.)</label>
                                <h4 class="text-primary"><?php echo number_format($fees->final_fee, 2); ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Paid Fee (Rs.)</label>
                                <h4 class="text-success"><?php echo number_format($paid_amount, 2); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Balance Fee (Rs.)</label>
                                <h4 class="text-danger">
                                    <?php $balance_amount = $fees->final_fee - $paid_amount;
                                    echo number_format($balance_amount, 2); ?>
                                </h4>
                                <!-- <?php echo anchor('', 'Pay Balance Fee', 'class="btn btn-danger btn-sm"'); ?> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        


        </div>


    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="student_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title text-bold" id="exampleModalLabel">
                    <?= $enquiryDetails->student_name; ?> Details</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="insert_form">



                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Total College Fee</label>
                                <input type="text" class="form-control" id="total_college_fee"
                                    name="total_college_fee" placeholder="Total College fee" readonly value="<?php echo $fees->total_college_fee; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Corpus Fund</label>
                                <input type="text" class="form-control" id="corpus_fund" name="corpus_fund"
                                    placeholder="Corpus Fund" readonly value="<?php echo $fees->corpus_fund; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Total Fee</label>
                                <input type="text" class="form-control" id="total_tution_fee"
                                    name="total_tution_fee" placeholder="Total Fee" readonly value="<?php echo $fees->final_fee; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Concession Type</label>
                                <?php $concession_type_options = array("" => "Select", "Sports Quota" => "Sports Quota", "Management Quota" => "Management Quota");
                                echo form_dropdown('concession_type', $concession_type_options, '', 'class="form-control input-xs" id="concession_type"'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Concession Amount (if any)</label>
                                <input type="text" class="form-control" id="concession_fee"
                                    name="concession_fee" placeholder="Enter Concession Fee" value="<?php echo $fees->consession_amount; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Final Fee</label>
                                <input type="text" class="form-control" id="final_amount" name="final_amount"
                                    placeholder="Payable Fee" readonly value="<?php echo $fees->final_fee; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks"
                                    placeholder="Enter remarks" value="">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-sm tx-13"
                                data-dismiss="modal">Close</button>
                        </div>
                        <div class="col text-right">
                            <input type="submit" name="insert" id="insert" value="Update Concession"
                                class="btn btn-danger btn-sm" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';

        $("#cash_details").hide();
        $("#cheque_dd_details").hide();
        $("#online_payment_details").hide();

        $('input[type=radio][name=mode_of_payment]').change(function() {
            if (this.value == "Cash") {
                $("#cash_details").show();
                $("#cheque_dd_details").hide();
                $("#online_payment_details").hide();
            }
            if (this.value == "ChequeDD") {
                $("#cash_details").hide();
                $("#cheque_dd_details").show();
                $("#online_payment_details").hide();
            }
            if (this.value == "OnlinePayment") {
                $("#cash_details").hide();
                $("#cheque_dd_details").hide();
                $("#online_payment_details").show();
            }

            $('#cash_amount').keypress(function(e) {
                var a = [];
                var k = e.which;
                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0)) {
                    e.preventDefault();
                    $(".error").css("display", "inline");
                } else {
                    $(".error").css("display", "none");
                }

                setTimeout(function() {
                    $('.error').fadeOut('slow');
                }, 2000);

            });

            $('#cheque_dd_amount').keypress(function(e) {
                var a = [];
                var k = e.which;
                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0)) {
                    e.preventDefault();
                    $(".error").css("display", "inline");
                } else {
                    $(".error").css("display", "none");
                }

                setTimeout(function() {
                    $('.error').fadeOut('slow');
                }, 2000);

            });

            $('#transaction_amount').keypress(function(e) {
                var a = [];
                var k = e.which;
                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0)) {
                    e.preventDefault();
                    $(".error").css("display", "inline");
                } else {
                    $(".error").css("display", "none");
                }

                setTimeout(function() {
                    $('.error').fadeOut('slow');
                }, 2000);

            });
        });



        $("#edit_concession").click(function() {
            event.preventDefault();
            $('#student_modal').modal('show');
        });


        $("#concession_fee").change(function() {
            event.preventDefault();
            var final_amount = finalAmount();
            $('#final_amount').val(finalAmount);
            var final_amount = collegeAmount();
            $('#final_amount').val(final_amount);
        });

        $("#corpus_fee").change(function() {
            event.preventDefault();
            var final_amount = finalAmount();
            $('#final_amount').val(finalAmount);
        });

        function finalAmount() {
            var total_college_fee = $("#total_college_fee").val();
            var corpus_fund = $("#corpus_fund").val();
            var total_tution_fee = $("#total_tution_fee").val();
            var concession_fee = $("#concession_fee").val();

            var final_amount = parseInt(total_tution_fee) + parseInt(concession_fee);
            return final_amount;
        }

        function collegeAmount() {
            var total_tution_fee = $("#total_tution_fee").val();
            var concession_fee = $("#concession_fee").val();

            var total_college_fee = parseInt(total_tution_fee) - parseInt(concession_fee);

            return total_college_fee;
        }
        $("#insert").click(function() {
            event.preventDefault();
            var id = '<?php echo $encryptId; ?>';


            var corpus = $("#corpus_fee").val();
            var remarks = $("#remarks").val();
            var total_tution_fee = $("#total_tution_fee").val();
            var total_college_fee = $("#total_college_fee").val();

            var concession_type = $("#concession_type").val();
            var concession_fee = $("#concession_fee").val();
            var final_amount = $('#final_amount').val();

            $.ajax({
                'type': 'POST',
                'url': base_url + 'admin/updateConcession',
                'data': {

                    "id": id,
                    "total_college_fee": total_college_fee,
                    "total_tution_fee": total_tution_fee,

                    "concession_type": concession_type,
                    "concession_fee": concession_fee,
                    "remarks": remarks,
                    "final_amount": final_amount
                },
                'dataType': 'text',
                'cache': false,
                'beforeSend': function() {
                    $('#insert').val("Inserting...");
                    $("#insert").attr("disabled", true);
                },
                'success': function(data) {
                    $('#insert').val("Inserted");
                    $('#student_modal').modal('hide');
                    var url = base_url + 'admin/paymentDetail/' + id
                    window.location.replace(url);
                }
            });

        });

    });
</script>
<script>
    $(document).ready(function() {


        // Function to update final fee based on selected checkboxes
        function updateFinalFee() {
            var sum = 0;
            var corpusFundChecked = false;

            // Iterate over each checkbox that needs to be considered
            $('input[type="checkbox"]').each(function() {
                if ($(this).prop('checked')) {
                    var inputId = $(this).attr('id').replace('_checkbox', '');
                    var inputValue = parseFloat($('#' + inputId).val());

                    if ($(this).attr('id') === 'corpus_fund_checkbox') {
                        // If corpus_fund_checkbox is checked, uncheck all others
                        corpusFundChecked = true;
                        sum = inputValue; // Set sum to only the corpus fund value
                    } else {
                        // Add value to sum only if it's not corpus_fund_checkbox
                        sum += inputValue;
                    }
                }
            });

            // Update the final_fee input with the calculated sum
            $('#final_fee').val(sum.toFixed(2));

            // If corpus_fund_checkbox is checked, uncheck all other checkboxes
            if (corpusFundChecked) {
                $('input[type="checkbox"]').each(function() {
                    if ($(this).attr('id') !== 'corpus_fund_checkbox' && $(this).prop('checked')) {
                        $(this).prop('checked', false);
                    }
                });
            }
        }
        $('#selectAllCheckbox').change(function() {
            // Check if the master checkbox is checked
            var isChecked = $(this).is(':checked');

            // Select or deselect all checkboxes that are not disabled and not with the ID 'corpus_fund_checkbox'
            $('input[type="checkbox"]:not(:disabled):not(#corpus_fund_checkbox)').prop('checked', isChecked);
        });
        // Attach change event listener to relevant checkboxes
        $('input[type="checkbox"]').change(function() {
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

                // Find the corresponding text field value based on feeValue
                var textFieldValue = $('#' + feeValue).val();

                // Prepare data for submission
                selectedFees.push({
                    name: $(this).attr('id'),
                    value: feeValue,
                    textFieldValue: textFieldValue
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