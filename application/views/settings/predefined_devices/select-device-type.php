<div>
    <?php
    foreach($device_types->result() as $row) {
    ?>
    <div onclick="settings.select_device('<?=$row->device_type_id?>', '<?=$row->device_type?>')" style="padding-left: 10px;" align="left" class="highlight" id="<?=$row->device_type_id?>"><?=ucwords($row->device_type)?></div>
    <?php
    }
    ?>
</div>