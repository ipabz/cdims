<script type="text/javascript">
$(function() {
	
	$('.hide').hide();
	
	$('.device-type').change(function() {
		
		var url = '<?=site_url('settings/getdevice_type')?>/' + $(this).val();
		
		$.get(url, function(data) { 
				if (data == 1) {
					$('.devices--inside').attr('style', 'visibility: visible');
					
				} else {
					$('.devices--inside').attr('style', 'visibility: hidden');
					
				}
			});
			
		url = '<?=site_url('settings/gdt')?>/' + $(this).val();
		
		$.get(url, function(data) { 
				if (data == 0) {
					$('.dn').hide();
					
					$('.device-name').val(new Date());
					
				} else {
					$('.dn').show('fast');
					$('.device-name').val('');
				}
			});
			
	});	
});
</script>
<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<table border="0" width="100%" class="default-font">
	
    <tr>
        <td align="left">
            Device type
        </td>
        <td>
            <?php
            print form_dropdown('device-type', $device_types, '', 'class="device-type"');
            ?>
        </td>
    </tr>

    <tr class="dn hide">
        <td align="left">
            Device name
        </td>
        <td>
            <input type="text" name="device-name" class="device-name wide" value="" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><hr /></td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <button class="mbutton" onclick="settings.add_pre_specification_form('.specs','<?= site_url('settings/add_spec') ?>')">
                <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
                Add Specification
            </button>
        </td>
    </tr>
</table>
<div class="specs default-font">
    <fieldset style="height: 150px; overflow: auto;">
        <legend>Specifications</legend>
        <div style="height: 140px; overflow: auto;">
            <table width="100%" border="0" class="specification-list">

            </table>
        </div>
    </fieldset>
    
    <div class="devices--inside" style="visibility: hidden">
        <div align="right" style="padding-top: 10px;">
            <hr />
            <button class="mbutton" onclick="settings.select_device_form('<?= site_url('settings/select_device') ?>')">
                <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
                Select device...
            </button>
        </div>
        <fieldset style="height: 150px; overflow: auto;">
            <legend>Device(s) Inside</legend>
            <div style="height: 140px; overflow: auto;">
                <table width="100%" border="0" class="device-list">
    
                </table>
            </div>
        </fieldset>
    </div>
    <br />
    <div align="center">
        <button class="my-button mbutton" onclick="settings.save_new_pre_device()">
            <img src="<?= base_url() ?>images/action_save.gif" align="absmiddle" />
            Save
        </button>
        &nbsp;
        <button class="my-button mbutton" onclick="settings.cancel_add_new_device()">
            <img src="<?= base_url() ?>images/action_stop.gif" align="absmiddle" />
            Cancel
        </button>
    </div>
</div>