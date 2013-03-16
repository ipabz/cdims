<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<br />
<div>
<?php
	print 'Location ' . nbs(2) . form_dropdown('', $locations, '', 'class="location-s" onchange="transaction.computer_table_option(\'' . site_url('transaction/computer_tables') . '\', this.value, \'.c-table-option\')"');
?>
</div>
<table border="0" width="250" style="margin-top: 5px;">
	<tr class="computer-tables-option">
    </tr>
</table>
<table border="0" width="150" style="margin-top: 5px;">
	<tr class="workstations-option">
    </tr>
</table>
<br />
<hr />
<div align="center">
	<button disabled="disabled" class="loc-next-dev" onClick="transaction.devices_in('<?=site_url('transaction/devices_in_loc')?>'); loca_to_dev()">
    	<img src="<?= base_url() ?>images/arrow_right.png" align="absmiddle" />
        Next
    </button>
</div>