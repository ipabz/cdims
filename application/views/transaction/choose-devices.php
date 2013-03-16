<?php
    foreach($devices->result() as $row) {
        ?>
<div onclick="transaction.select_the_device('<?=site_url('')?>', '<?=$row->predefined_device_id?>', '<?=ucwords($row->name)?>', '<?=$src?>')" class="highlight" style="padding: 3px; border-bottom: 1px dashed #ccc;">
    <img src="<?=base_url()?>images/arrow_right.png" align="absmiddle" />
    <?=nbs(1).ucwords($row->name);?>
</div>
        <?php
    }
    
    if ($devices->num_rows() == 0) {
        print 'There are no devices of this type.';
    }
    
?>