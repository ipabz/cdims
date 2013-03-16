<div style="padding-top: 6px;" align="center">
    <input type="text" name="device-type" value="<?=$device_type->device_type?>" class="text-center device-type2" />
    <span style="border: 1px solid #ccc; padding: 3px;">
        <label><input type="checkbox" name="inner-device" class="inner-device" <?=(($device_type->inner_device) ? 'checked="checked"' : '')?> /> Inner Device</label>
        &nbsp;|&nbsp;
        <label><input type="checkbox" name="with-devices" class="with-devices" <?=(($device_type->with_devices) ? 'checked="checked"' : '')?> /> With Inner Device(s)</label>
    </span>
    &nbsp;
    <button onclick="settings.edit_device_type('<?=$device_type->device_type_id?>')">
        <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
        Save
    </button>
</div>