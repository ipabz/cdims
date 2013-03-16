<script type="text/javascript">
$(function() {
		
	$('.device-type-sel').change(function() {
			
			var device_type = $(this).val();
			
			if (device_type != '') {
				$('.dd').hide('fast');
				$('.'+device_type).show('fast');
			} else {
				$('.dd').show('fast');
			}
			
		});	
	
});
</script>
<?php
    $device_types[''] = '[ Device type ]';
?>

<div align="center" style="padding: 10px;">
	<span style="font-weight: normal;">Device type </span>
    <?= form_dropdown('device-type', $device_types, '', 'class="device-type-sel" style="padding: 2px;"') ?>
</div>
<div align="center" class="loading-here"></div>
<hr />
<br />
<input type="hidden" class="existing-device-id" />
<table width="100%" cellpadding="5">
	<tr style="background-color: #ffffcc; box-shadow: 0px 1px 2px #000;">
    	
    	<th>
        	Device Type
        </th>
        <th width="30%">
        	Action
        </th>
    </tr>
<?php
	$existing_devices_query = $this->transaction_handler->existing_devices();
	
	foreach($existing_devices_query->result() as $row) {
	?>
    <tr class="mtable <?=$row->device_type_id?> dd">
    	<td style="font-weight: normal;">
        	<?=$row->device_type?>
        </td>
        <td align="center">
        	<?='[ '.anchor('', 'Stock In', 'onclick="new_device_continue_existing(\''.$row->device_id.'\'); return false;" style="font-weight: normal;"'). ' ]'?>
            &nbsp;
            <?='[ '.anchor('', 'Details', 'style="font-weight: normal;" onclick="return device.details(\''.site_url('device/device_details').'\', \''.$row->device_id.'\')"').' ]';?>
        </td>
    </tr>
    <?php
	}
?>
</table>
<div align="center" style="background-color: #ffffcc; padding: 10px">
    <button class="mbutton" onclick="back_to_stock_options()">
        <img src="<?=base_url()?>images/arrow_left.png" align="absmiddle" />
        Back
    </button>
</div>