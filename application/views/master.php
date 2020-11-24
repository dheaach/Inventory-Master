<span data-tgl="<?=$date?>"></span>
<?php if ($this->session->flashdata('success')){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
<?php }else if($this->session->flashdata('danger')){?>
			<div class="alert alert-danger" role="alert">
                <?php echo $this->session->flashdata('danger'); ?>
            </div>
<?php } ?>
<table class="data table">
	<thead>
	
		<tr>
			<th>#</th>
			<th>Nama Barang</th>
			<th>Harga</th>
			<th>Stok</th>
			<th>Action</th>
		</tr>
		<tr>
			<td colspan="5">
				<div class="btn btn-block btn-primary new-button" data-target="cc_master">
					<span class="fa fa-plus fa-fw"></span> New Data
				</div>
			</td>
		</tr>
		<tr class="new-form" id="cc_master" style="display:none;">
			<form name="f2" method="post" action="master/add">
			<td></td>
			<input type="hidden" name="cc_id" value="<?php echo $idku ?>">
			<td><input type="text" class="form-control" name="cc_nama" placeholder="Nama Barang"></td>
			
			<td>
				<div class="input-group">
					<span class="input-group-addon">Rp.</span>
					<input type="number" class="form-control" name="cc_harga" placeholder="Harga">
				</div>
				<i style="color:red;">*harus diisi dengan angka</i>
			</td>
			<td>
				<div class="input-group">
					<input type="number" class="form-control" name="cc_stok" placeholder="Stok">
					<span class="input-group-addon">pcs</span>
				</div>
					<i style="color:red;">*harus diisi dengan angka</i>
			</td>
			<td>
				<button class="btn btn-success" title="Save"><span class="fa fa-check"></span></button>
			</form>
			<a href="master/cc">
				<button class="btn btn-danger close-button" title="Cancel"><span class="fa fa-times"></span></button>
			</a>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
		foreach($query->result_array() as $row){
		?>
		<tr>
			<td><?=$no?></td>
			<td><?=$row['nama']?></td>
			
			<td><?=$row['harga']?></td>
			<td><?=$row['stok']?></td>
			<td>
				
				<button class="btn btn-warning edit-button btn-sm" data-fancybox data-src="master/edit/master/<?=$row['id']?>" ><i class="fa fa-edit"></i></button>
				<span a href="#" data-toggle="modal" data-target="#modal_hapus<?php echo $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fa fa-trash"></i></a></span>
				
			</td>
		</tr>
		<?php
			$no++;
		}
		?>
	</tbody>
</table>
<!-- ============ MODAL HAPUS BARANG =============== -->
<?php
		foreach($query->result_array() as $row){
		?>

            <div class="modal fade" id="modal_hapus<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url().'master/delete2'?>">
                <div class="modal-body">
                    <p>Anda yakin mau menghapus barang <b><?php echo $row['nama']?></b></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-danger">Hapus</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    <?php }
    ?>
    <!--END MODAL HAPUS BARANG-->

<script>
$("#cc_master .btn-success").on("click",function(){
	cc_master();
});	
$("#cc_master input").on("keypress",function(e){
	if(e.which == 13){
		cc_master();
	}
});	

</script>