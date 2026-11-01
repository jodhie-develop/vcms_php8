<?php require_once __DIR__ . "/_lib/bootstrap.php"; ?><div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo e($file_foto) ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><a href="leadsupdate.php?kdb=<?php echo e(u($kdb)) ?>" target="_parent"><?php echo e($nama) ?> <?php echo e($middle_name)  ?><?php echo e($family_name)  ?></a><br>
                (<a href="leadsupdate.php?kdb=<?php echo e(u($kdb)) ?>" target="_parent"><?php echo e($nama_cabang)  ?></a>) <br>
              </h3> 
              <span class="profile-username text-center"></span>
              <p class="text-muted text-center"><?php echo e($dob) ?></p>
 <p class="text-muted text-center"><?php echo e($org_school) ?> <?php echo e($grade)?></p>
                  
       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Leads</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><strong><em class="fa fa-book margin-r-5"></em> Address</strong>
              <p class="text-muted">
                <?php echo e($address)  ?><?php echo e($city) ?>
              </p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Phone Number</strong>
              <p class="text-muted"><?php echo e($hp) ?></p>
              <strong><em class="fa fa-map-marker margin-r-5"></em> E-Mail</strong>
              <p class="text-muted"><?php echo e($e_mail)  ?></p>
      
              <hr>
              <strong><em class="fa fa-book margin-r-5"></em> Parent &nbsp;Info</strong>
              <p class="text-muted">
                <strong>Father :</strong> 
              </p>
               <p class="text-muted">
                <strong>Mother :</strong> 
              </p>

<hr>
              <strong><em class="fa fa-map-marker margin-r-5"></em> Marketing Info</strong>
              <p class="text-muted"><?php echo e($event_type)   ?><?php echo e($event_type_dtl)   ?></p><br>
			  <p class="text-muted"><?php echo e($media_src)   ?><?php echo e($media_src_dtl)   ?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>