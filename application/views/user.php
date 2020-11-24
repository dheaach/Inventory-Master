
<?php if ($this->session->flashdata('success')){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
<?php }else if($this->session->flashdata('danger')){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $this->session->flashdata('danger'); ?>
                </div>  
<?php }?>
  
                <table class="data table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tr>
                    <td colspan="8">
                      <div class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal_add_new">
                        <span class="fa fa-plus fa-fw"></span> New Data
                      </div>
                    </td>
                  </tr>
                  <tr align="center">
                    
                    <?php 
                    $no = 1;
                    foreach ($query as $hah): ?> 
                    <tr>
                      <td>
                        <?php echo $no;?>
                      </td>
                      <td>
                        <?php echo $hah->username; ?>
                      </td>
                      <td>
                        <?php echo $hah->name; ?>
                      </td>
                      <td>
                        <?php echo $hah->email; ?>
                      </td>
                     <td><a href="#" class="btn btn-warning btn-sm"data-toggle="modal" data-target="#modal_edit<?php echo $hah->id; ?>"><i class="fa fa-edit"></i></a>
                      <?php 
                        if($hah->id == 1){?>
                          <button href="#" class="btn btn-danger btn-sm delete-button" disabled><span class="fa fa-trash "></span></button>
                        <?php }else{?>
                          <span href="add_user/hapus/<?=$hah->id?>" class="btn btn-danger btn-sm delete-button"><span class="fa fa-trash"></span></span>
                       <?php }
                      ?>
                        
                    </td>
                    </tr>
                    <?php 
                      $no++;
                      endforeach;
                    ?> 
                  </tr>
                </table>
           
<!-- ============ MODAL ADD BARANG =============== -->
<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="color:black">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalScrollableTitle">Add User</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form class="form-horizontal" method="post" action="<?php echo base_url().'add_user/registration'?>" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-xs-3" >Username</label>
                <div class="col-xs-8">
                    <input name="username" class="form-control" type="text" autocomplete="off" required>
                </div>
            </div>

           <div class="form-group">
                <label class="control-label col-xs-3" >Name</label>
                    <div class="col-xs-8">
                        <input name="nama" class="form-control" type="text" autocomplete="off" required>
                    </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3" >Email</label>
                    <div class="col-xs-8">
                        <input name="email" class="form-control" type="email" autocomplete="off" required>
                    </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3" >Password</label>
                    <div class="col-xs-8">
                        <input name="password" class="form-control" type="password" autocomplete="off" required>
                    </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>
    <!--END MODAL ADD BARANG-->
    <!-- ============ MODAL EDIT BARANG =============== -->
<?php 
    foreach($query as $hah):
            $id=$hah->id;
            $username=$hah->username;
            $nama=$hah->name;
            $email=$hah->email;
            $password=$hah->password;
        ?>

    <div class="modal fade" id="modal_edit<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="color:black">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalScrollableTitle">Edit User</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form class="form-horizontal" method="post" action="<?php echo base_url().'add_user/update'?>" enctype="multipart/form-data">

          <div class="form-group">
                <label class="control-label col-xs-3" >Username</label>
                    <div class="col-xs-8">
                        <input name="id" value="<?php echo $id; ?>" class="form-control" type="hidden">
                        <input name="user" value="<?php echo $username; ?>" class="form-control" type="text" required>
                    </div>
            </div>
           <div class="form-group">
                <label class="control-label col-xs-3" >Name</label>
                    <div class="col-xs-8">
                        <input name="nama" value="<?php echo $nama; ?>" class="form-control" type="text" autocomplete="off" required>
                    </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-3" >Email</label>
                    <div class="col-xs-8">
                        <input name="email" value="<?php echo $email; ?>" class="form-control" type="email" autocomplete="off" required>
                    </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

<?php endforeach; ?>