<?php
	date_default_timezone_set('asia/jakarta');
	header("Content-type: application/vnd-ms-excel");	 
	header("Content-Disposition: attachment; filename=SGCallDataRegistration-".date('dmY-Gis', time()).".xls");
?>
<style type="text/css">
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}	
	table th{
		background-color: #e2e2e2;
	}
</style>
<table>
	<thead>
		<tr>
			<th>No.</th>
			<th style="width: 150px;">Name</th>
			<th style="width: 150px;">Gender</th>
			<th style="width: 150px;">Email</th>
			<th style="width: 150px;">Birtday</th>
			<th style="width: 150px;">Province</th>
			<th style="width: 150px;">Have ever been to Singapore?</th>
			<th style="width: 150px;">How many time have been to Singapore?</th>
			<th><?php echo lang('created_updated'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach( $items as $item ): ?>
		<tr>
			<td><?= $no; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->gender; ?></td>
			<td><?php echo $item->email; ?></td>
			<td><?php echo $item->birtday; ?></td>
			<td><?php echo $item->province; ?></td>
			<td><?php echo $item->visited_sg; ?></td>
			<td><?php echo $item->visited_sg_count; ?></td>
			<td><i class="fa fa-calendar"></i><?= date('d/m/Y',strtotime($item->created_at)) ?></td>
		</tr>
		<?php $no++; endforeach; ?>
	</tbody>
</table>