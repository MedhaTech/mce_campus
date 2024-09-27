  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper m-5">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <!-- Main content -->
          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="card">
                              <div class="card-header" style="background-color:#2f4050;">
                              <h3 class="card-title text-white">
                                <?= $page_title; ?>
                              </h3>
                              </div>
                              <div class="card-body">
                                  <ul>
                                      <li><?php echo anchor('admin/corpusoverall_report', 'Corpus Overall Report'); ?> </li>
                                      <li><?php echo anchor('admin/corpusbalance_report', 'Corpus Balance Report'); ?> </li>
                                      <!-- <li><?php echo anchor('admin/department_quota_report', 'Academic Year Wise Report'); ?> </li> -->
                                  </ul>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>
  <!-- End of Main Content -->