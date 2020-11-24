
<?php if ($this->session->flashdata('success')){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
<?php }else if($this->session->flashdata('danger')){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $this->session->flashdata('danger'); ?>
                </div>
<?php } ?>

            <div class="form-group row" >
            	<form action="master/search" method="post">
            	<div class="col-sm-8" align="right">
                    
                </div>	
                <div class="input-group no-print" style="float:left">
                        <input type="text" class="form-control" name="search" placeholder="Cari Pelanggan">
                </div>
               <div class="input-group no-print">
                    <button type="submit" class="btn btn-info" style="text-align: center;border-top-right-radius: 5px;border-bottom-right-radius: 5px"><i class="fa fa-search"></i></button>
                </form>
                    <a href="master/pelanggan"><button type="button" class="btn btn-info"><i class="fa fa-refresh"></i></button></a>
                </div>
            </div>


<table class="data table">
	<thead>
		<tr>
			<th>#</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>No.HP</th>
			<th>Total Pinjaman</th>
			<th>Keterangan</th>
			<th>Action</th>
		</tr>
		<tr>
			<td colspan="7">
				<div class="btn btn-block btn-primary new-button" data-target="cc_pelanggan">
					<span class="fa fa-plus fa-fw"></span> New Data
				</div>
			</td>
		</tr>
		<tr class="new-form" id="cc_pelanggan" style="display:none;">
			<form name="f2" method="post" action="master/tambah">
			<td></td>
			<td><input type="text" class="form-control" name="cc_nama" placeholder="Nama Pelanggan"></td>
			<td><textarea class="form-control" name="cc_alamat" placeholder="Alamat Lengkap"></textarea></td>
			<td><input type="number" class="form-control" name="cc_no" placeholder="No Handphone"></td>
			<td><input type="text" class="form-control" name="cc_tot" value="0" readonly></td>
			<td><textarea class="form-control" name="cc_ket" placeholder="Keterangan"></textarea></td>
			<!--<td>
				<select class="form-control" name="cc_ket">
					<option>--Select--</option>
					<option value="pinjaman awal">Pinjaman Awal</option>
					<option value="pinjaman tambahan">Pinjaman Tambahan</option>
					<option value="pinjaman kembali">Pinjaman Kembali</option>
					<option value="pengambilan">Pengambilan</option>
				</select>
				<textarea class="form-control" name="cc_ket" placeholder="Keterangan"></textarea>
			</td>-->
			
			<td>
				<button type="submit" class="btn btn-success btn-sm" title="Save"><span class="fa fa-check"></span></button>
			</form>
				<a href="master/pelanggan">
				<button class="btn btn-danger close-button btn-sm" data-target="cc_pelanggan" title="Cancel"><span class="fa fa-times"></span></button></a>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach($query->result_array() as $row){
		?>
		<tr>
			<td><?php echo $no;?></td>
			<td><?=$row['nama_p']?></td>
			<td><?=$row['alamat']?></td>
			<td><?=$row['no_hp']?></td>
			<td><?=$row['total_pinjam']?></td>
			<td><?=$row['ket']?></td>
			<td>
				<a href="#" class="btn btn-warning edit-button btn-sm" data-toggle="modal" data-target="#modal_edit<?php echo $row['id_p'];?>"><i class="fa fa-edit"></i></a>
				<span a href="#" data-toggle="modal" data-target="#modal_hapus<?php echo $row['id_p']; ?>" class="btn btn-danger btn-sm tombol-hapus"><span class="fa fa-trash"></span></span>
			</td>
		</tr>
		<?php
		$no++;
		}
		?>
	</tbody>
</table>




<script>

$("#cc_pelanggan .btn-success").on("click",function(){
	cc_pelanggan();
});	
$("#cc_pelanggan input").on("keypress",function(e){
	if(e.which == 13){
		cc_pelanggan();
	}
});	

</script>
<?php
foreach($query->result_array() as $row){
?>
	<div class="modal fade" id="modal_edit<?php echo $row['id_p'];?>" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #A6C9FC; color: white;font-size: 15px;">
                
                <label class="control-label" >Edit</label>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'master/update'?>">
                <div class="modal-body">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $row['id_p']; ?>">
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >Nama</label>
                        <div class="col-sm-8">
                            <input name="nama" class="form-control" type="text" value="<?php echo $row['nama_p'];?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >Alamat</label>
                        <div class="col-sm-8">
                            <textarea name="alamat" class="form-control" value="<?php echo $row['alamat'];?>" required><?php echo $row['alamat'];?></textarea>
                        </div>					
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >No.HP</label>
                        <div class="col-sm-8">
                            <input name="no" class="form-control" type="number" value="<?php echo $row['no_hp'];?>" required>
                        </div>					
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >Keterangan</label>
                        <div class="col-sm-8">
                            <input name="ket" class="form-control" type="text" value="<?php echo $row['ket'];?>">
                        </div>					
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info">Update</button>
                </div>
            </form>
            </div>
            </div>
        </div>
<?php
}
?>
<?php
		foreach($query->result_array() as $row){
		?>

            <div class="modal fade" id="modal_hapus<?php echo $row['id_p'];?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">Hapus Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'master/hapus'?>">
                <div class="modal-body">
                    <p>Anda yakin mau menghapus <b><?php echo $row['nama_p']?></b></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="<?php echo $row['id_p'];?>">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-danger">Hapus</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    <?php }
    ?>