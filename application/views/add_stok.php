<form action="mutasi/plusproses/<?=$row['id']?>" method="post">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tanggal
		</label>
		<div class="col-sm-9">
			<input type="hidden" class="form-control" name="cc_id" value="<?=$row['id']?>">
            <input type="hidden" class="form-control" name="cc_user" value="<?php echo $this->session->userdata('user_id');?>">
			<input type="date" class="form-control" name="cc_tgl" value="<?=$tgl?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Stok Awal
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" name="cc_stok" class="form-control" value="<?= $row['stok']?>" readonly>
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tambah Stok
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" name="cc_jml" class="form-control">
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Keterangan
		</label>
		<div class="col-sm-9">
			<input type="text" name="cc_ket" class="form-control" value="Restok Gudang" readonly>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>	
		</div>
	</div>
</form>

