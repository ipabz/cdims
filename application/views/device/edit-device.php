<input type="hidden" class="device-id" value="<?=$details['device']->device_id?>" />
<div  class="default-font">
    <div style="margin-top: 5px; padding: 1px 0px 1px 0px; display: none;">
    Device Name: <input type="text" name="device-name" class="device-name" value="<?=$details['device']->name?>" />
    </div>
    <div style="padding: 1px 0px 1px 0px;">
    Device Type: <?=$details['device']->device_type?>
    </div>
    <div style="padding: 1px 0px 1px 0px;">
    Location: 
    <?php
	$loc = $this->device_handler->device_location($details['device']->device_id);

	if ($loc->num_rows() > 0) {
		print $loc->row()->location;
	}
	?>
    </div>
    <div style="padding: 1px 0px 1px 0px;">
    Computer Table: 
    <?php
	print @$this->device_handler->device_table($loc->row()->computer_table_id)->name;
	?>
    </div>
    <div style="padding: 1px 0px 1px 0px;">
    Workstation: 
     <?php
        if ($loc->num_rows() > 0) {
            print $loc->row()->name;
        }
        ?>
    </div>
    <div style="padding: 1px 0px 1px 0px;">
    Status: 
     <?php
        print form_dropdown('status', $statuses, $details['device']->device_status, 'class="status"');
        ?>
    </div>
    <div style="background: #ffc; padding: 10px 5px 10px 5px; border-top: 1px #999 solid; margin-top: 10px;">

        <fieldset style="background: #fff;">
            <legend><b>Specifications</b></legend>
            <?php
			
			$x=0;
			
            foreach($details['specs_query']->result() as $row) { $x++;
            ?>
            <div <?=(($x%2 == 0) ? 'class="alt_1"' : 'class="alt_2"')?> align="left" style="padding-top: 3px; padding-bottom: 3px;">
            <?php
            //print '<b>'.$row->name.'</b>: '.$row->value;
			print '<b>'.$row->name.'</b>: ';
			print form_dropdown($row->name, $this->transaction_handler->possible_values($row->name, $details['device']->device_type_id), $row->value, 'id="' . $row->specification_id . '" class="specs-inputs"');
            ?>
            &nbsp;<a onclick="return transaction.add_value('#<?= $row->specification_id ?>')" href="#"><img src="<?= base_url() ?>images/add.png" alt="add value" title="Add Value" /></a>
            </div>
            <?php
            }
            ?>
        </fieldset>
        <br />
        <?php
		if ($details['devices_inside_query']->num_rows() > 0) {
		?>
        <fieldset style="background: #fff;">
            <legend><b>Device(s) Inside</b></legend>
            <?php
            foreach($details['devices_inside_query']->result() as $row) { $x++;
                $unique_id = sha1($row->device_id);
            ?>
            <div <?=(($x%2 == 0) ? 'class="alt_1"' : 'class="alt_2"')?> align="left" style="padding-top: 3px; padding-bottom: 3px;">
                
                <?php 
            print '<b>'.$row->device_type.'</b>: ';
            ?>
                <span class="d-here-<?= $unique_id ?> device-inputs" name="">
                <?php
            print $row->name;
            ?>
                </span>&nbsp;&nbsp;
                <button onclick="transaction.choose_device('<?= site_url('transaction/predevices_of_type') ?>', '<?= ucwords(@$row->device_type) ?>', '<?= $row->device_type_id ?>', 'd-here-<?= $unique_id ?>')">
                    <img src="<?= base_url() ?>images/magnifier.png" align="absmiddle" />
                    Choose...
                </button>
            </div>
            <?php
            }
            ?>
        </fieldset>
        <?php } ?>
    </div>

</div>