<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper m-5">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <h5 class="card-header text-white bg-primary">Fee Reports</h5>
                            <div class="card-body">
                                <ul>
                                    <li><?php echo anchor('admin/academic_report', 'Academic Report'); ?> </li>
                                    <li><?php echo anchor('admin/daybook_report', 'Day Book Report'); ?> </li>
                                    <li><?php echo anchor('admin/dateTransactions', 'Day & Mode of Payment wise Transaction Details'); ?></li>
                                    <!-- <li><?php echo anchor('admin/dcb_report', 'DCB Report'); ?> </li> -->
                                    <li><?php echo anchor('admin/feebalance_report', 'Fee Balance Report'); ?> </li>
                                    <li><?php echo anchor('admin/corpusoverall_report', 'Corpus Overall Report'); ?> </li>
                                    <li><?php echo anchor('admin/corpusbalance_report', 'Corpus Balance Report'); ?> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End of Main Content -->