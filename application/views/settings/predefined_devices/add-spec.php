<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<div class="default-font">
    <table border="0" width="100%" class="default-font">
        <tr>
            <td>
                <div>
                    Specification name
                </div>
                <input type="text" name="spec-name" class="spec-name wide" value="" />
            </td>
        </tr>
        <tr>
            <td>
                <br />
                <div>
                    Specification value
                </div>
                <input type="text" name="spec-value" class="spec-value wide" value="" />
            </td>
        </tr>
    </table>
    <br />
    <div align="center">
        <button class="my-button mbutton" onclick="settings.add_pre_spec('<?=base_url()?>','<?=sha1(uniqid(time().  rand(-100000, 100000)))?>')">
            <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
            Add
        </button>
        &nbsp;
        <button class="my-button mbutton" onclick="settings.cancel_add_pre_spec()">
            <img src="<?= base_url() ?>images/action_stop.gif" align="absmiddle" />
            Cancel
        </button>
    </div>
</div>