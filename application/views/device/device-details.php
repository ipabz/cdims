<script type="text/javascript">
$(function() {
	$(".trans1").tooltip();	
});
</script>
<div  class="default-font">
    <div style="margin-top: 5px; padding: 1px 0px 1px 0px; display: none;">
    Device Name: <b><?=$details['device']->name?></b>
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
        print $details['device']->device_status;
        ?>
    </div>
    <br /><br />
        <div class="boxC">
            <div class="login-header">
                <b>Specification(s)	</b>
            </div>
            <div style="padding: 5px;">
            <?php
			
			$x = 0;
			
            foreach($details['specs_query']->result() as $row) { $x++;
            ?>
            <div <?=(($x%2 == 0) ? 'class="alt_1"' : 'class="alt_2"')?> align="left" style="padding-top: 3px; padding-bottom: 3px;">
            <?php
            print '<b>'.$row->name.'</b>: '.$row->value;
            ?>
            </div>
            <?php
            }
            ?>
            </div>
        </div>
        <br />
        <?php
		if ($details['devices_inside_query']->num_rows() > 0) {
		?>
        <div class="boxC">
            <div class="login-header">
                <b>Device(s) inside	</b>
            </div>
            <div style="padding: 5px;">
            <?php
            foreach($details['devices_inside_query']->result() as $row) {  $x++;
            ?>
            <div <?=(($x%2 == 0) ? 'class="alt_1"' : 'class="alt_2"')?> align="left" style="padding-top: 3px; padding-bottom: 3px;">
            <?php
            print '<b>'.$row->device_type.'</b>: '.$row->name;
            ?>
            </div>
            <?php
            }
            ?>
            </div>
        </div>
        <?php } ?>
 
    <br />
    <div class="boxC">
    	<div class="login-header">
    		<b>Transaction(s)	</b>
        </div>
        <br />
        <table align="center" width="96%" cellpadding="3" cellspacing="0" class="mttable">
        	<tr class="mt-header">
            	<th width="15%" height="30">Type</th>
                <th>
                	Person Incharge
                    <div style="border-top: #ccc solid 2px; margin-top: 3px; padding-top: 5px;">
                    	<div style="width: 49%; float: left; border-right: 2px solid #ccc;">Device</div>
                        <div style="width: 49%; float: right">System</div>
                    </div>
                </th>
                <th>
                	Date
                </th>
            </tr>
        <?php
        foreach($details['transaction_query']->result() as $row) {
		?>
        	<tr class="mtable trans1" title="<?=$row->more_info?>">
            	<td align="left">
                <?php
				print $row->transaction_type
				?>
                </td>
                <td>
                <div>
                    <div style="width: 49%; float: left; border-right: 2px solid #fff;"><?=ucwords($row->personincharge)?></div>
                    <div style="width: 49%; float: right"><?=ucwords($row->system_incharge)?></div>
                </div>
                </td>
                <td width="22%" align="center">
                <?php
				print date('M d, Y', strtotime($row->transaction_date));
				?>
                </td>
            </tr>
        <?php
		}
        ?>
        </table>
        <br />
    </div>
</div>