<script>
$(function() {
		$(".trans1").tooltip();
	});
</script>
<?php
    $account_type = $this->session->userdata('account_type');
?>
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
	<br style="clear: both" />
	<div>
    	<?php
		$this->load->view('search/search-form');
		?>
    </div>
	<h2>
    	<img src="<?=base_url();?>images/home.png" align="absmiddle" />
    	Home
    </h2>
    
    <br />
    <div class="slider-wrapper theme-default">

            <div class="ribbon"></div>

    <div id="slider" class="nivoSlider">

                <a href="<?=site_url('report/graphical')?>"><img src="<?=base_url()?>images/panoIT_small.png" width="800" alt="" title="IT Laboratory" /></a>

                <img title="Cisco Laboratory" src="<?=base_url()?>images/panoCisco_small.png" alt="" width="800" />
            </div>
	</div>
    <script type="text/javascript">

    $(window).load(function() {

        $('#slider').nivoSlider();

    });

    </script>
     <br />
    <div class="boxC">
    	<div class="login-header">
    		<b>Latest Transaction(s)</b>
        </div>
        <br />
        <table align="center" borer="0" width="96%" class="mttable" cellpadding="3" cellspacing="0">
           
            <tr class="mt-header">
                <th width="10%">
                    Transaction Type
                </th>
                <th width="10%">
                    Device
                </th>
                <th>
                	Brand or Model
                </th>
                <th width="40%">
                    Person Incharge
                    <div style="border-top: #ccc solid 2px; margin-top: 3px; padding-top: 5px;">
                    	<div style="width: 49%; float: left; border-right: 2px solid #ccc;">Device</div>
                        <div style="width: 49%; float: right">System</div>
                    </div>
                </th>
                
                <th>
                    Date
                </th>
                <th>
                    Action
                </th>
            </tr>

			<?php
			foreach($trans_query->result() as $row) {
			?>
            <tr class="mtable trans1" title="<?=$row->more_info?>">
            	<td align="center">
                <?php
				print $row->transaction_type;
				?>
                </td>
                <td>
                <?php
				print $this->transaction_handler->get_device_type($row->device_type_id)->device_type;
				?>
                </td>
                <td align="center">
                <?php
				print $this->device_handler->get_device_brand_or_model($row->device_id);
				?>
                </td>
                <td>
                    <div>
                        <div style="width: 49%; float: left; border-right: 3px solid #fff;">
                        <?php
						print ucwords($row->firstname.' '.$row->lastname);
						?>
                        </div>
                        <div style="width: 49%; float: right">
                        <?php
						print ucwords($row->afn.' '.$row->aln);
						?>
                        </div>
                    </div>
                </td>
                <td align="center">
                <?php
				print date('M d, Y H:i', strtotime($row->transaction_date));;
				?>
                </td>
                <td align="center">
                	<?php
					print anchor('', 'Device Details', 'style="text-decoration: none;" onclick="return device.details(\''.site_url('device/device_details').'\', \''.$row->device_id.'\')"');
					?>
                </td>
            </tr>
            <?php
			}
			?>
           
        </table>
        <div align="right" style="padding: 2%;">
        	<a style="text-decoration: none;" href="<?=site_url('transaction/transaction_list')?>">View More</a>
        </div>
    </div>

    

    
    <br />&nbsp;
    <div class="boxC">
    	<div class="login-header">
    		<b>Defective Device(s)	</b>
        </div>
        <br />
         <table id="sortable_table" align="center" class="tablesorter mttable" borer="0" width="96%" cellpadding="3" cellspacing="0">
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
							print '[ '.anchor('', 'Details', 'style="text-decoration: none;" onclick="return device.details(\''.site_url('device/device_details').'\', \''.$row->device_id.'\')"').' ]'.nbs(3);
                            print '[ '.anchor('', 'Edit', 'style="text-decoration: none;" onclick="return device.edit_device(\''.site_url('device/edit_device').'\', \''.$row->device_id.'\')"').' ]'.nbs(3);
							if ($account_type == 1 OR $account_type == 2) {
                            	//print '[ '.anchor('device/delete_device/'.$row->device_id, 'Delete', 'alt="container-'.$row->device_id.'" class="delete-device"').' ]';
							}
                            ?>
                        </td>
                    </tr>
        <?php
    }
}
?></table>
		<div align="right" style="padding: 2%;">
        	<a style="text-decoration: none;" href="<?=site_url('device/defective_devices_lists/defective')?>">View More</a>
        </div>
    </div>
    
    
    <br />
    <br />&nbsp;
   

    
</div>