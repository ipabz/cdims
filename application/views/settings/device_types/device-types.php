<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<div class="default-font">
    <div class="default-font" align="right">
        <button class="mbutton" onclick="settings.new_device_type('<?=site_url('settings/new_device_type')?>')()">
            <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
            New device type...
        </button>
    </div>
    <hr />
    <div>
    <?php $x = 1;
        foreach($device_types->result() as $row) {
            $unique_id = sha1(uniqid());
            
        ?>
        <div id="dt-<?=$unique_id?>" style="">
            <a title="Delete" href="#" style="text-decoration: none; float: right; margin-right: 20px; margin-top: 3px;" onclick="settings.delete_device_type('<?=$row->device_type_id?>', '#dt-<?=$unique_id?>')"><img align="absmiddle" src="<?=base_url()?>images/cross.png" /></a>
            <a title="Delete" href="#" style="text-decoration: none; float: right; margin-right: 10px; margin-top: 3px;" onclick="settings.edit_device_type_form('<?=$row->device_type_id?>')"><img align="absmiddle" src="<?=base_url()?>images/page_white_edit.png" /></a>
            <div style="padding: 3px;" class="highlight" align="left">
                <?=nbs(5).ucwords($row->device_type)?>
            </div>
        </div>
        <?php ++$x;
        }
    ?>
    </div>
</div>