<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<div class="default-font">
    <div class="default-font" align="right">
        <button class="mbutton" onclick="settings.new_location_form()">
            <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
            New location...
        </button>
    </div>
    <hr />
    <table width="100%" class="mttable" cellpadding="3" cellspacing="0">
        <tr class="mt-header">
            <th height="30">
                Location Name
            </th>
            <th width="15%">
                # Table(s)
            </th>
            <th width="15%">
                # Workstations per Table
            </th>
            <th width="15%">
                # Workstations
            </th>
            <th>
                Action
            </th>
        </tr>
        <?php
        foreach ($locations->result() as $row) {
            $unique_id = uniqid();
            ?>
            <tr class="highlight mtable" id="<?=$unique_id?>">
                <td>
                    <?= $row->location ?>
                </td>
                <td align="center">
                    <?= $row->num_table ?>
                </td>
                <td align="center">
                    <?= $row->num_workstation ?>
                </td>
                <td align="center">
                    <?= $this->settings_handler->num_workstation_in($row->location_id) ?>
                </td>
                <td align="center">
                    [&nbsp;<a style="text-decoration: none;" onclick="return settings.edit_location_form('<?=site_url('settings/edit_location_form/'.$row->location_id)?>','<?=$row->location_id?>')" href="<?=site_url('settings/edit_location_form/'.$row->location_id)?>"><img align="absmiddle" src="<?=base_url()?>images/page_white_edit.png" title="Edit" alt="Edit" />&nbsp;Edit</a>&nbsp;]&nbsp;
                    [&nbsp;<a style="text-decoration: none;" onclick="return settings.delete_location('<?=site_url('settings/delete_location/'.$row->location_id)?>', '#<?=$unique_id?>')" href="<?=site_url('settings/delete_location/'.$row->location_id)?>"><img align="absmiddle" src="<?=base_url()?>images/cross.png" title="Edit" alt="Edit" />&nbsp;Delete</a>&nbsp;]
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>