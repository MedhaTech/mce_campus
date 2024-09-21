<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">

            <div class="card m-2 shadow card-info">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        PERSONAL DETAILS
                    </h3>
                    <div class="card-tools">
                        <!-- <?php echo anchor('student/personaldetails', '<i class="fas fa-edit"></i> Edit ', 'class="btn btn-dark btn-sm"'); ?> -->
                    </div>
                </div>

                <div class="card-body">
                      <?php echo form_open_multipart($action, 'class="user"'); ?>
                      <div class="row">
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Student Name</label>
                                  <input type="text" class="form-control" placeholder="Enter Student Name"
                                      id="student_name"
                                      value="<?php echo (set_value('student_name')) ? set_value('student_name') : $student_name; ?>"
                                      name="student_name">
                                  <span class="text-danger"><?php echo form_error('student_name'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="label">Mobile<span class="text-danger">*</span></label>
                                  <input type="number" class="form-control" placeholder="Enter Mobile Number" id="mobile"
                                      value="<?php echo (set_value('mobile')) ? set_value('mobile') : $mobile; ?>"
                                      name="mobile">
                                  <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="label">Emial<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" placeholder="Enter Email Id" id="email"
                                      value="<?php echo (set_value('email')) ? set_value('email') : $email; ?>"
                                      name="email">
                                  <span class="text-danger"><?php echo form_error('email'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="label">AAdhar Number<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" placeholder="Enter Aadhaar Number" id="aadhaar"
                                      value="<?php echo (set_value('aadhaar')) ? set_value('aadhaar') : $aadhaar; ?>"
                                      name="aadhaar">
                                  <span class="text-danger"><?php echo form_error('aadhaar'); ?></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Date of Birth</label>
                                  <input type="date" class="form-control" placeholder="Enter DOB"
                                      id="date_of_birth"
                                      value="<?php echo (set_value('date_of_birth')) ? set_value('date_of_birth') : $date_of_birth; ?>"
                                      name="date_of_birth">
                                  <span class="text-danger"><?php echo form_error('date_of_birth'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="label">Gender<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" placeholder="Enter Gender" id="gender"
                                      value="<?php echo (set_value('gender')) ? set_value('gender') : $gender; ?>"
                                      name="gender">
                                  <span class="text-danger"><?php echo form_error('gender'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Sports</label>
                                  <?php $sports_options = array(" "=>"Select Sports","State Level"=>"State Level","National Level"=>"National Level","International Level"=>"International Level","Not Applicable"=>"Not Applicable");
                                        echo form_dropdown('sports', $sports_options, (set_value('sports')) ? set_value('sports') : $sports , 'class="form-control" id="sports"'); 
                                  ?>
                                  <span class="text-danger"><?php echo form_error('sports'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Blood Group</label>
                                  <?php $blood_groups = array(" "=>"Select Blood Group","O-"=>"O-","O+"=>"O+","A-"=>"A-","A+"=>"A+","B-"=>"B-","B+"=>"B+","AB-"=>"AB-","AB+"=>"AB+");
                                        echo form_dropdown('blood_group', $blood_groups, (set_value('blood_group')) ? set_value('blood_group') : $blood_group, 'class="form-control" id="blood_group"'); 
                                  ?>
                                  <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Place of Birth</label>
                                  <input type="text" class="form-control" placeholder="Enter Birth Place"
                                      id="place_of_birth"
                                      value="<?php echo (set_value('place_of_birth')) ? set_value('place_of_birth') : $place_of_birth; ?>"
                                      name="place_of_birth">
                                  <span class="text-danger"><?php echo form_error('place_of_birth'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Country of Birth</label>
                                  <select name="country_of_birth" id="country_of_birth" class="form-control input-lg select2">
                                        <option>Select Country</option>
                                        <?php foreach ($countries as $country): ?>
                                            <?php
                                                $selected = ($country->name == $country_of_birth) ? 'selected' : '';
                                            ?>
                                            <option data-id="<?= $country->id ?>" value="<?= $country->name ?>" <?= $selected ?>><?= $country->name ?></option>
                                        <?php endforeach; ?>
                                 </select>
                                    <span class="text-danger"><?php echo form_error('country_of_birth'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Nationality</label>
                                  <select name="nationality" id="nationality" class="form-control input-lg select2">
                                        <option>Select Nationality</option>
                                        <?php foreach ($countries as $country): ?>
                                            <?php
                                                $selected = ($country->name == $nationality) ? 'selected' : '';
                                            ?>
                                            <option data-id="<?= $country->id ?>" value="<?= $country->name ?>" <?= $selected ?>><?= $country->name ?></option>
                                        <?php endforeach; ?>
                                 </select>
                                    <span class="text-danger"><?php echo form_error('nationality'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Religion</label>
                                  <?php 
                                     echo form_dropdown('religion', $religion_option, (set_value('religion')) ? set_value('religion') : $religion, 'class="form-control form-control" id="religion"'); 
                                 ?>
                                  <span class="text-danger"><?php echo form_error('religion'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Caste</label>
                                  <?php 
                                     echo form_dropdown('caste', $caste_option, (set_value('caste')) ? set_value('caste') : $caste, 'class="form-control form-control" id="caste"'); 
                                 ?>
                                  <span class="text-danger"><?php echo form_error('caste'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Mother Tongue</label>
                                  <input type="text" class="form-control" placeholder="Enter Mother Tongue"
                                      id="mother_tongue"
                                      value="<?php echo (set_value('mother_tongue')) ? set_value('mother_tongue') : $mother_tongue; ?>"
                                      name="mother_tongue">
                                  <span class="text-danger"><?php echo form_error('mother_tongue'); ?></span>
                              </div>
                          </div>
                          <!-- <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Father Name</label>
                                  <input type="text" class="form-control" placeholder="Enter Father Name"
                                      id="father_name"
                                      value="<?php echo (set_value('father_name')) ? set_value('father_name') : $father_name; ?>"
                                      name="father_name">
                                  <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                              </div>
                          </div> -->
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Current Address</label>
                                  <textarea class="form-control" placeholder="Enter Current Address"
                                     id="current_address" name="current_address"><?php echo (set_value('current_address')) ? set_value('current_address') : $current_address; ?></textarea>
                                  <span class="text-danger"><?php echo form_error('current_address'); ?></span>
                              </div>
                          </div>
                          <div class="col-md-3 col-sm-12">
                              <div class="form-group">
                                  <label class="form-label">Present Address</label>
                                  <textarea class="form-control" placeholder="Enter Present Address"
                                     id="present_address" name="present_address"><?php echo (set_value('present_address')) ? set_value('present_address') : $present_address; ?></textarea>
                                  <span class="text-danger"><?php echo form_error('present_address'); ?></span>
                              </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                  </div>
                  <div class="card-footer">
                      <div class="row">
                          <div class="col-md-6">
                              <?php echo anchor('student/profile', 'BACK', 'class="btn btn-danger btn-square" '); ?>
                          </div>
                          <div class="col-md-6 text-right">
                              <button type="submit" class="btn btn-info btn-square" name="Update" id="Update"> SAVE
                              </button>
                              <?php //// echo anchor('student/parentdetails', 'NEXT', 'class="btn btn-danger btn-square float-right" '); ?>
                          </div>
                      </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>

            </div>
            <!-- /.col -->
        </div>
    </section>
</div>