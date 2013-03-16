<div style="padding-top: 6px;" align="center">
    <input type="text" name="device-type" value="" class="text-center device-type" />
    <span style="border: 1px solid #ccc; padding: 3px;">
        <label><input type="checkbox" name="inner-device" class="inner-device" /> Inner Device</label>
        &nbsp;|&nbsp;
        <label><input type="checkbox" name="with-devices" class="with-devices" /> With Inner Device(s)</label>
    </span>
    &nbsp;
    <button class="mbutton" onclick="settings.add_device_type('<?=site_url('settings/add_device_type')?>')">
        <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
        Add
    </button>
</div>