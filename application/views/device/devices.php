<?php
    $account_type = $this->session->userdata('account_type');
?>
<script type="text/javascript">
    $(function() {
		
		
		
		$('.delete-device').click(function(e) {
				
				e.preventDefault();
				device.delete_device($(this).attr('href'), '.' + $(this).attr('alt'));
				
			});
    
        $(".void").click(function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
        
            $('.'+id).attr('style', 'background-color: #ccc;');
        });
    
        $(".hide").hide();
    
        $(".transaction-details").click(function (e) {
            e.preventDefault();
        
            $('.trans-details').dialog({
                title: "Edit Device",
                width: 480,
                height: 350,
                modal: true,
                buttons: {
                    "Save": function() {
                        $(".trans-details").dialog('close');
                    },
                    "Cancel": function() {
                        $(".trans-details").dialog('close');
                    }
                }
            });
        });
    
    });   
</script>
<div class="container">
	<div style="float: right;">
		<b>
		Logined as [<?=$this->session->userdata('acc_type')?>]:
		</b>
		<u>
		<?php
		print ucwords($this->session->userdata('first_name').' '.$this->session->userdata('last_name'));
		?>
		</u>
	</div>
	<br style="clear: both;" />
<div>
    	<?php
		$this->load->view('search/search-form');
		?>
    </div>
    <h2>
    	<img src="<?=base_url();?>images/backup.png" align="absmiddle" />
    	Devices
    </h2>
    <div>
    	<div align="right">
        	<?php
			print '<div><i>'. '<b>' . $offset . '</b> &nbsp;to&nbsp; <b>' . $to . '</b> &nbsp;of&nbsp; <b>' . $total . '</b></i></div>';
			?>
        </div>
        
        <div style="display: none;">
                    <?= form_open('device/devices', 'name="dev_form" id="dev-form"') ?>
                    Location:
                    <?php
					print nbs(2).form_dropdown('location', $locations, set_value('location'), 'onchange="document.dev_form.submit();"');
					?>
                    &nbsp;&nbsp;
                    Computer Table:
                    <?php
					print nbs(2).form_dropdown('computer-table', $computer_tables, set_value('computer-table'), 'onchange="document.dev_form.submit();"');
					?>
                    &nbsp;&nbsp;
                    Workstation:
                    <?php
					print nbs(2).form_dropdown('workstation', $workstations, set_value('workstation'), 'onchange="document.dev_form.submit();"');
					?>
                    &nbsp;&nbsp;
                    Device Type:
                    <?php
					print nbs(2).form_dropdown('device-type', $device_types, set_value('device-type'), 'onchange="document.dev_form.submit();"');
					?>
                   
                    <?php
					$statuses = array(
						'' => 'All',
						'Active' => 'Active',
						'Inactive' => 'Inactive'
					);
					
					//print nbs(2).form_dropdown('status', $statuses, set_value('status'));
					?>
                    <?= form_close() ?>
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
            
            <tr class="table-filters">
            	<td align="center">
                <?php
				print form_dropdown('device-type', $device_types, set_value('device-type'), 'form="dev-form" onchange="document.dev_form.submit();"');
				?>
                </td>
                <td>
                
                </td>
                <td></td>
                <td align="center">
                <?php
				print form_dropdown('location', $locations, set_value('location'), 'form="dev-form" onchange="document.dev_form.submit();"');
				?>
                </td>
                <td align="center">
                <?php
				print form_dropdown('computer-table', $computer_tables, set_value('computer-table'), 'form="dev-form" onchange="document.dev_form.submit();"');
				?>
                </td>
                <td align="center">
                <?php
				print form_dropdown('workstation', $workstations, set_value('workstation'), 'form="dev-form" onchange="document.dev_form.submit();"');
				?>
                </td>
                <td></td>
            </tr>
            
            <?php
            foreach ($devices->result() as $row) {
                if ($row->parent_device == '') {
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
?>
        </table>
        <br /><br />
        <div align="center">
            <?php
            print $this->pagination->create_links();
            ?>
        </div>
    </div>
</div>