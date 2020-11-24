<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('laporan/barang') ?>" class="active">Gudang</a></li>
      <li><a href="<?php echo base_url('laporan/langganan') ?>">Pelanggan</a></li>
    </ul>
</div>			
	<div class="row">
		<div class="col-md-12">
			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	    </div>
	</div>
	    <br>
	    <?php 
			if($bulin == date('m')) {	
				if($bulin = date('m')) {
					$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
				}
			}else{
				$bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			}
		?>

	    <p> Bulan : <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
	    <table class="table table-bordered">	
	    	<thead>	
	    		<thead>
	    			<tr class="active">
						<td style="text-align: center;" width="5%"><strong>No.</strong></td>
						<td style="text-align: center;"><strong>Nama Item</strong></td>
						<td style="text-align: center;"><strong>Stok</strong></td>
						<td style="text-align: center;"><strong>Detail</strong></td>
					</tr>
	    	</thead>
	    	<tbody>	
	    		<?php $no=1; foreach ($benda as $key) { ?>
	    			<tr>
	    				<td style="text-align: center;"><?php echo $no++ ?></td>
	    				<td><?php echo $key->nama ?></td>
	    				<td style="text-align: center;"><?php echo $key->stok ?></td>
	    				<form method="POST" action="laporan/cari">
	    				<input type="hidden" name="bulan" value="<?php echo $bulin ?>">
	    				<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
	    				<input type="hidden" name="nama_barang" value="<?php echo $key->id ?>">
	    				<td style="text-align: center;" width="10%"><button type="submit" class="btn btn-sm btn-primary">Detail</button></td>
	    				</form>
	    			</tr>
	    		<?php } ?>
	    	</tbody>
	    </table>	
</div>