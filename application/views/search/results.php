<?php
    $account_type = $this->session->userdata('account_type');
?>
<div class="container">
	<h2><?=$title?></h2>
    
    <?=form_open('search');?>
        <div style="border: 1px solid #ccc; float: left; border-radius: 3px; margin-top: 5px; box-shadow: 0px 1px 2px #ccc;">
	<span style="padding: 5px; border-right: 1px solid #ccc;"><img src="<?=base_url()?>images/zoom.png" /></span>
    <input onFocus="this.select()" value="<?=(($this->input->post('keyword')) ? $this->input->post('keyword') : 'Search')?>" style="border: none; background-color: #fff; padding: 5px;" size="70" type="text" name="keyword" id="keyword" />
    
    
</div>
    <?=form_close();?>
    <br style="clear: both;" />
    <br />
    <hr />
    
    <div>
    <?php
		if ($devices != NULL) {
	?>
    	<div align="right">
        	<?php
			print '<div><i>'. '<b>' . $offset . '</b> &nbsp;to&nbsp; <b>' . $to . '</b> &nbsp;of&nbsp; <b>' . $total . '</b></i></div>';
			?>
        </div>
        <br />
    	<table id="sortable_table" class="tablesorter mttable" borer="0" width="100%" cellpadding="3" cellspacing="0">
            
            <tr class="mt-header">
                <th width="15%" height="30">
                    Type
                </th>
                <th>
                	Brand or Model
                </th>
                <th>
                    Status
                </th>
                <th>
                    Location
                </th>
                <th>
                    Table
                </th>
                <th>
                    Workstation
                </th>
                <th width="15%">
                    Action
                </th>
            </tr>
            
            
            
            <?php
			if ($devices != NULL) {
            foreach ($devices->result() as $row) {
                if (TRUE) {
                    ?>
                    <tr class="mtable container-<?=$row->device_id?>">
                        
                        <td align="center">
                            <?= $this->transaction_handler->get_device_type($row->device_type_id)->device_type ?>
                        </td>
                        <td align="center">
                        <?php
						print $this->device_handler->get_device_brand_or_model($row->device_id);
						?>
                        </td>
                        <td align="center">
                            <?= $row->device_status ?>
                        </td>
                        <td align="center">
                            <?php
                            $loc = $this->device_handler->device_location($row->device_id);

                            if ($loc->num_rows() > 0) {
                                print $loc->row()->location;
                            }
                            ?>
                        </td>
                        <td align="center">
                            <?php
                            print @$this->device_handler->device_table($loc->row()->computer_table_id)->name;
                            ?>
                        </td>
                        <td align="center">
        <?php
        if ($loc->num_rows() > 0) {
            print $loc->row()->name;
        }
        ?>
                        </td>
                        <td align="center">
                            <?php
							print '[ '.anchor('', 'Details', 'onclick="return device.details(\''.site_url('device/device_details').'\', \''.$row->device_id.'\')"').' ]'.nbs(3);
                            print '[ '.anchor('', 'Edit', 'onclick="return device.edit_device(\''.site_url('device/edit_device').'\', \''.$row->device_id.'\')"').' ]'.nbs(3);
							if ($account_type == 1 OR $account_type == 2) {
                            	//print '[ '.anchor('device/delete_device/'.$row->device_id, 'Delete', 'alt="container-'.$row->device_id.'" class="delete-device"').' ]';
							}
                            ?>
                        </td>
                    </tr>
        <?php
    }
}
			}
?>
        </table>
        
        
        <br /><br />
        <div align="center">
            <?php
            print $this->pagination->create_links();
            ?>
        </div>
        
        <?php
		} else {
		?>
        <fieldset>
        	No result(s) found.
        </fieldset>
        <?php	
		}
		?>
    </div>
    
</div>