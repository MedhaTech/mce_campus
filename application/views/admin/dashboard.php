<div class="page-content">
<div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-flex align-items-center justify-content-between">
                                        <!-- <h4 class="mb-0 font-size-18">Welcome</h4> -->
        
                                        
                                        
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title -->
        
                            <div class="row">
                                <div class="col-xl-7">
                                    
                                </div> <!-- end col -->
                            
                                <div class="col-xl-5">
                                   
        
                                    <div class="card">
                                        <div class="card-body">
                            
                                      
                                            
                                     
                                            <div class="form-group">
                                                <label>Student Profile Search</label>
                                                <?php echo form_open_multipart('admin/profileDetails/' , 'class="user"'); ?>
                                                <div class="input-group">
                                                    <input type="text"   id="usn" name="usn" value="<?php echo (set_value('usn')) ? set_value('usn') : $usn; ?>" class="form-control" placeholder="Enter USN" aria-label="Enter USN">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-dark waves-effect waves-light" type="submit">Search</button>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                            
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
        
                                   
                                </div> <!-- end col -->
                            </div>
                            <!-- end row-->
        

                        
                    </div>
</div>
<!-- End Page-content -->