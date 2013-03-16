<script type="text/javascript">
$(function() {
	
	$(".trans1").tooltip();
    
    $(".void").click(function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        
        $('.'+id).attr('style', 'background-color: #ccc;');
    });
    
    $(".start-date").datepicker({
		changeYear: true,
		dateFormat: "yy-mm-dd",
		showAnim: "fold",
		changeMonth: true	
	});
    
    $(".hide").hide();
    
    $(".transaction-details").click(function (e) {
        e.preventDefault();
        
        $('.trans-details').dialog({
            title: "Transaction Details",
            width: 480,
            height: 400,
            modal: true,
            buttons: {
                "OK": function() {
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
    	<img src="<?=base_url();?>images/review.png" align="absmiddle" />
    	Transactions
    </h2>
    <div>
        
        <div>
                    <?=form_open('transaction/transaction_list')?>
                    
                    <?php
					print 'Transaction type '.form_dropdown('transaction-type', $transaction_types, set_value('transaction-type')).nbs(5);
					?>
                    
                    Start Date <input value="<?=set_value('start-date')?>" style="text-align: center" type="text" name="start-date" class="start-date" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    End Date <input value="<?=set_value('end-date')?>" style="text-align: center" type="text" name="end-date" class="start-date" />
                    &nbsp;<input type="submit" name="ok" value="Filter" />
                    <input form="mf" type="submit" name="clear" value="Clear" />
                    <?=form_close()?>
                    <?=form_open('transaction/transaction_list', 'id="mf"')?>
                    
                    <?=form_close()?>
        </div>
        <br />
        
        <table borer="0" width="100%" class="mttable" cellpadding="3" cellspacing="0">
           
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
			foreach($query->result() as $row) {
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
        <br /><br />
        <div align="center">
            <?php
            print $this->pagination->create_links();
            ?>
        </div>
    </div>
</div>