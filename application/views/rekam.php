<table align="left">
	<tr>
		<td>Nama Pelanggan</td>
		<td style="padding:0 1em;">:</td>
		<td><strong><?=$row['nama_p']?></strong></td>
	</tr>
</table>
<div class="clearfix"></div>


<table class="data table">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th style="text-align:center">Pinjam <span class="label label-success"><span class="fa fa-plus"></span></span></th>
			<th style="text-align:center">Kembali <span class="label label-danger"><span class="fa fa-minus"></span></span></th>
			<th style="text-align:center">Operasional <span class="label label-info">OP</span></span></th>
			<th>Keterangan</th>
			<th>Mutasi</th>
			<th style="text-align:center">Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$mutasi = 0;
	foreach($item_mutasi as $tgl=>$data){
		$tgll = date("Y-m-d H:i:s",$tgl);
		$kirim = "";
		$id_terjual = "";
		if(isset($data['pinjam'])){
			$kirim = $data['pinjam'];
			$mutasi += $kirim;
			$id_terjual = 0;
		}
		$terima = "";
		if(isset($data['kembali'])){
			$terima = $data['kembali'];
			$mutasi -= $terima;
			$id_terjual = 0;
		}
		$ambil = "";
		if(isset($data['ambil'])){
			$ambil = $data['ambil'];
			$id_terjual = $data['id_terjual'];
		}
		$ket = isset($data['ket']) ? $data['ket'] : "";
		if($id_terjual > 0) {
			$sql = query("SELECT * FROM cc_terjual JOIN cc_master ON cc_master.id = cc_terjual.id_master WHERE cc_terjual.id = '$id_terjual'")->result();
			foreach ($sql as $key) {
				$nama = "( ".$key->nama." )";
				$nama_master = $key->nama;
			}
		}else{
			$nama = "";
		}
		
		echo "
		<tr>
			<td>".indo_date($tgll,"half")."</td>
			<td style=text-align:center>$kirim</td>
			<td style=text-align:center>$terima</td>
			<td style=text-align:center>$ambil $nama</td>
			<td><em>$ket</em></td>
			";
		?>
			<?php if(isset($data['ambil'])) {
				echo "<td>-</td>";
			?>
				<td align="center">
					<button class='btn btn-warning btn-sm' data-fancybox data-src='mutasi/edit_detail/<?=$id_terjual?>/<?php echo $idmaster ?>'><i class='fa fa-edit'></i></button>&nbsp;
					
					<a href="<?php echo base_url('').'mutasi/hapus_detail/'.$id_terjual.'/'.$idmaster ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
				</td>
			<?php }else{
				echo "<td>$mutasi</td>";
				echo "<td> </td>";
			} ?>
		</tr>
	<?php } ?>
		<tr>
			<td colspan=5 align="right"><strong>Jumlah Pinjaman Saat Ini</strong></td>
			<td><strong><?=$mutasi?> pcs</strong></td>
		</tr>
	</tbody>
</table>
