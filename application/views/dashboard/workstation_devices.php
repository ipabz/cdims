<table width="100%">
	<tr style="background-color: #ffffcc; box-shadow: 0px 1px 2px #000;">
    	<th>
        	Device Type
        </th>
        <th>
        	Action
        </th>
    </tr>
    <?php
	
	foreach($query->result() as $device) {
	?>
    
    <tr class="mtable"  style="font-weight: normal; font-size: 12px;">
    	<td style="font-weight: normal;">
        	<?=$device->device_type?>
        </td>
        <td align="center">
        	<?=anchor('', 'Details', 'style="font-weight: normal;" onclick="return device.details(\''.site_url('device/device_details').'\', \''.$device->device_id.'\')"')?>
        </td>
    </tr>
    
    <?php	
	}
	
	?>
</table>