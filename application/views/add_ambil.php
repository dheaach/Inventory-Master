<form action="mutasi/ambilproses/<?=$wor?>" method="post">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tanggal
		</label>
		<div class="col-sm-9">
			<input type="date" class="form-control" name="cc_tgl" value="<?php echo $tgl ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Barang
		</label>
		<div class="col-sm-9">
			<select name="cc_barang" class="form-control" id="cc_barang">
				<option hidden="hidden">Pilih Barang</option>
			<?php 
					$list = $this->mdmutasi->galonop();
					foreach($list as $iddiv=>$nmdiv){
						$sel = "";
						if(isset($def)){
							if($def == $iddiv){
								$sel = "selected";
							}
						}
						echo "
						<option value='$iddiv'>$nmdiv</option>
						";
					}
			?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Harga
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<span class="input-group-addon">Rp.</span>
				<input type="number" name="cc_harga" id="harga" class="form-control">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Jumlah Item Diambil
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
			<input type="text" name="cc_ket" class="form-control" autocomplete="off">
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#cc_barang').change(function() {
      var id = $(this).val();
      $.ajax({
        type : 'POST',
        url : '<?php echo base_url('mutasi/cek_harga') ?>',
        Cache : false,
        dataType: "json",
        data : 'cc_barang='+id,
        success : function(resp) {
            $('#harga').val(resp.harga); 
        }
      });
      // alert(id);
    });


    
  });
</script>