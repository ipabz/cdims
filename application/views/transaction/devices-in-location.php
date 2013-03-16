<script type="text/javascript">
	function check_uncheck() {
		var checked = $(".check-option").attr('checked');	
		
		if (checked) {
			$('.check').attr('checked', true);
		} else  {
			$('.check').attr('checked', false);
		}
	}
</script>
<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<fieldset style="background: #fff;">
	<legend>Devices</legend>
<?php
	if ($query == NULL) {
		print '<div align="center">No device(s) in this location.</div>';
	}
?>

<?php
	if ($query != NULL ) {
		
?>
<table width="100%" style="background: #fff;" cellpadding="3">
	<tr style="background: #CCC">
    	<th><input type="checkbox" class="check-option" onchange="check_uncheck()" /></th>
    	
        <th>
        	Device Type
        </th>
    </tr>
<?php
	foreach(@$query->result() as $row) {
		?>
        <tr class="mtable">
        	<td width="2%">
            	<input type="checkbox" class="check" value="<?=$row->device_id?>" />
            </td>
        	
            <td align="center">
            <?php
				print $row->device_type;
			?>
            </td>
        </tr>
        <?php
	}
?>
</table>
<?php
	}
?>
<br />
<hr />
<div align="center">
	<button class="mbutton" onclick="dev_to_loca()">
        <img src="<?= base_url() ?>images/arrow_left.png" align="absmiddle" />
        Back
    </button>
    &nbsp;
    <button class="add-trans mbutton" onclick="dev_to_per()">
        <img src="<?= base_url() ?>images/arrow_right.png" align="absmiddle" />
        Continue
    </button>
</div>
</fieldset>