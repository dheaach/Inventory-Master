<?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
<?php endif; ?>
<table class="data table">
	<thead>
		<tr>
			<th>#</th>
			<th>Uraian</th>
			<th>Total Biaya</th>
			<th>Tanggal</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5">
				<div class="btn btn-block btn-primary new-button" data-target="cc_keluar">
					<span class="fa fa-plus fa-fw"></span> New Data
				</div>
			</td>
		</tr>
		<tr class="new-form" id="cc_keluar" style="display:none;">
		<form name="f2" method="post" action="mutasi/tambah">
			<td></td>
			<td><input type="text" class="form-control" name="cc_ket" placeholder="Keterangan" required></td>
			<td><input type="number" class="form-control" name="cc_tot" placeholder="Total Biaya" required><i style="color:red;">*harus diisi dengan angka</i></td>
			<td><input type="date" name="cc_tgl" value="<?=$date?>" class="form-control"></td>
			<td>
				<button type="submit" class="btn btn-success" title="Save"><span class="fa fa-check"></span></button>
		</form>
				<a href="mutasi/pengeluaran"><button class="btn btn-danger close-button" data-target="cc_keluar" title="Cancel"><span class="fa fa-times"></span></button></a>
			</td>
		
		</tr>
	<?php
	$no = 1;
	foreach($list as $row){
	?>
		<tr>
			<td><?=$no?></td>
			<td><?php echo $row['keterangan']?></td>
			<td><?php echo 'Rp. '.number_format($row['total'],0,",","."); ?></td>
			<td><?php echo $row['tanggal']?></td>
			<td>
				<a href="#" class="btn btn-warning edit-button btn-sm" data-toggle="modal" data-target="#modal_edit<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a>
				<span href="mutasi/hapus/<?=$row['id']?>" class="btn btn-danger btn-sm delete-button"><span class="fa fa-trash"></span></span>
			</td>
		</tr>
	<?php
		$no++;
	}
	?>
	</tbody>
</table>

<script>
$("#cc_keluar .btn-success").on("click",function(){
	cc_keluar();
});	
$("#cc_keluar input").on("keypress",function(e){
	if(e.which == 2){
		cc_keluar();
	}
});	

</script>
<?php
foreach($list as $row){
?>
	<div class="modal fade" id="modal_edit<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #A6C9FC; color: white;font-size: 15px;">
                
                <label class="control-label" >Edit</label>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'mutasi/edit'?>">
                <div class="modal-body">
                    <input name="id" class="form-control" type="hidden" value="<?php echo $row['id']; ?>">
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >Keterangan</label>
                        <div class="col-sm-8">
                            <input name="ket" class="form-control" type="text" value="<?php echo $row['keterangan'];?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3" >Total Biaya</label>
                        <div class="col-sm-8">
                            <input name="tot" class="form-control" type="number" value="<?php echo $row['total'];?>" required>
                            <i style="color:red;">*harus diisi dengan angka</i>
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

