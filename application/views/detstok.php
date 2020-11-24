<div class="clearfix"></div>

<table class="data table">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Nama User</th>
			<th>Jumlah <span class="label label-success"><span class="fa fa-plus"></span></span></th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($row as $r): ?>
		<tr>
			<td><?=$r['tgl']?></td>
			<td><?=$r['username']?></td>
			<td><?=$r['jml']?></td>
			<td><?=$r['ket']?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan=3 align="right"><strong>Jumlah Stok Saat Ini :</strong></td>
			<?php foreach($ri as $u): ?>
			<td><strong><?=$u['stok']?> pcs</strong></td>
			<?php endforeach; ?>
		</tr>
	</tbody>
</table>

