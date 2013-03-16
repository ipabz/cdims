<script>
$(function() {
		$('.generate-report').button();
		$('.print').button();
		$('.pdf').button();
		
		$('.pdf').click(function(e) {
			
			e.preventDefault();
			
			var header = '<html><head><title>Report - Printable Version</title>';
			header += '<style>';
			header += 'body {margin: 0px 10px 0px 10px;font-family:Geneva, Arial, Helvetica, sans-serif;background: #fff;}';
			header += '.mttable {border: 1px solid #ccc;}';
			header += '.mt-header {background: #EFEFEF;}.mt-header th {border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}';
			header += '.mtable td {border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}';
			header += '</style></head><body><br />';
			
			var html = header + $('.to-print').html() + '<br /></body></html>';
			
			
			var url = BASE_URL + 'report/to_pdf';
			var data = 'title=' + $('.choosen-location').html()+'&location='+$('#s-l').val()+'&devicetype='+$('#devicetype').val()+'&spn='+$('#s-n').val() + '&spv=' + $('#s-v').val(); 
			
			$.post(url, data, function(response) { 
				window.open(BASE_URL + 'my-pdf.pdf');
			});
			
		});
		
		$('.print').click(function(e) {
			
			e.preventDefault();
			
			
			var header = '<html><head><title>Report - Printable Version</title>';
			header += '<style>';
			header += 'body {margin: 0px 10px 0px 10px;font-family:Geneva, Arial, Helvetica, sans-serif;background: #fff;}';
			header += '.mttable {border: 1px solid #ccc;}';
			header += '.mt-header {background: #EFEFEF;}.mt-header th {border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}';
			header += '.mtable td {border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}';
			header += '</style></head><body><br />';
			
			var html = header + $('.to-print').html() + '<br /></body></html>';
			
			var w = window.open("" , "Printable");
			w.document.write(html);
			w.document.close();
			
			w.print();
			
			
		});
	
		$('.mtable').hover(function() {
				
				var id = $(this).attr('id');
				
				$('.d-'+id).show();
			
		}, function() {  var id = $(this).attr('id'); $('.d-'+id).hide(); });
		
		
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
    	Tabular Report
    </h2>
    
    <div>
        <div class="boxC">
    	<div class="login-header">
    		<b>Option(s)	</b>
        </div>
            <?=form_open('report/tabular')?>
            <div align="left" style="padding: 20px;">
            	<div style="padding: 5px;">
                Location 
                <?php
                print form_dropdown('location', $locations, set_value('location'), 'id="s-l"').nbs(3);
                ?>
                </div>
                <div style="padding: 5px;">
                Device type
                <?php
                print form_dropdown('device-type', $device_types, set_value('device-type'), 'onchange="report.get_specsname(\''.site_url('report/specs_name').'\', this.value)" id="devicetype"').nbs(3);
                ?>
                </div>
                <div style="padding: 5px;">
                Specification name
                <span id="spec-n">
                <?php
				
				$disabled = "";
				
				if (count($spec_names) <= 1) {
					$disabled = 'disabled="disabled"';
				}
				
                print form_dropdown('specification-name', $spec_names, set_value('specification-name'), $disabled.' id="s-n"  onchange="report.get_specvalues(\''.site_url('report/spec_values').'\', this.value)"').nbs(3);
                ?>
                </span>
                </div>
                <div style="padding: 5px;">
                Specification value
                <span id="spec-v">
                <?php
				
				$disabled = "";
				
				if (count($spec_values) <= 1) {
					$disabled = 'disabled="disabled"';
				}
				
                print form_dropdown('specification-value', $spec_values, set_value('specification-value'), $disabled.' id="s-v"').nbs(3);
                ?>
                </span>
                </div>
            </div>
            <hr />
            <div align="right">
                <input type="submit" name="generate-report" class="generate-report" value="Generate Report" />&nbsp;&nbsp;
                <br />&nbsp;
            </div>
            <?=form_close()?>
        </div>
    </div>
    <br /><br />
    
    <?php
	if ($report_query != NULL) {
	?>
    <div align="right" >
    	<a href="" class="print">
            <img src="<?=base_url();?>images/printer.png" align="absmiddle" />
            Print
        </a>
		<a href="" class="pdf">
            <img src="<?=base_url();?>images/page_white_acrobat.png" align="absmiddle" />
            Export to PDF
        </a>
    </div>
    <br />
	<div class="to-print">
	
	<div style="font-size:26px; text-align:center; font-weight:bold;" class="choosen-location">
		<?php
		if ($this->input->post('location')) {
			$location_info = $this->report_handler->get_location_details($this->input->post('location'));
		
			print ucwords($location_info->location);
		} else {
			print 'Cisco and IT Laboratory';
		}
		?>
	</div>
	<div style="text-align:center; font-size: 18px; font-weight: bold;">
		Inventory Report
	</div>
	<div style="text-align:center; font-size: 16px; font-weight: bold;">
		<?=date('F d, Y')?>
	</div>
	<br />
	<br />
	
	<div>
		<fieldset>
			<legend><b>Summary</b></legend>
			<?php
			$d_t = '';
			$b_d = '';
			$count_bd = 0;
			$count_dt = 0;
			$first = TRUE;
			$tt = 0;
			$brand_array = array();
			$brand_counter = array();
			
			foreach($report_query->result() as $row) {
				if ($d_t != $row->device_type) {
					$tt++;
					$temp = $this->device_handler->get_device_brand_or_model($row->device_id);
					
					/*
					if (! in_array($temp, $brand_array)) {
						
						print '<br /><div style="margin-bottom: 5px; padding-left: 80px;"><u>'.$temp.'</u></div>';
						
						$b_d = $temp;
						$brand_array[] = $temp;
						$brand_counter[$temp] = 1;
						$count_bd++;
						
					} else {
						
						$count_bd++;
						$brand_counter[$temp]++;
											
					}*/
					
					if ($d_t != '' && $first) {
						print '<div style="padding-left: 30px;">-> '.$count_dt.' set(s) of '.strtolower($d_t).'</div>';
						$first = FALSE;
					}
					
					print '<br /><div style="margin-bottom: 5px;"><b><u>'.$row->device_type.'</u></b></div>';
					
					if ($d_t != '') {
						print '<div style="padding-left: 30px;">-> '.$count_dt.' set(s) of '.strtolower($d_t).'</div>';
					}
					
					$d_t = $row->device_type;
					
					
					$count_bd = 0;
					$count_dt = 0;
					$count_dt++;
					
				} else {
				
					$temp = $this->device_handler->get_device_brand_or_model($row->device_id);
					
					
					if (! in_array($temp, $brand_array)) {
						
						//print '<br /><div style="margin-bottom: 5px; padding-left: 80px;"><u>'.$temp.'</u></div>';
						
						$b_d = $temp;
						$brand_array[] = $temp;
						$brand_counter[$temp] = 1;
						$count_bd++;
						
					} else {
						
						$count_bd++;
						$brand_counter[$temp]++;
											
					}
					
					if ($d_t != '' && $first) {
						//print '<div style="padding-left: 30px;">-> '.$count_dt.' set(s) of '.strtolower($d_t).'</div>';
						//$first = FALSE;
					}
					
					$count_dt++;
				
				}
			}
			
			if ($tt == 1) {
				print '<div style="padding-left: 30px;">-> '.$count_dt.' set(s) of '.strtolower($d_t).'</div>';
			}
			?>
		</fieldset>
	</div>
	
	<br />
	<br />
	
    <table width="100%" border="0" class="mttable" cellpadding="3" cellspacing="0">
    	<tr class="mt-header">
        	<th width="4%" height="30">
            	#
            </th>
        	
            <th>
            	Device Type
            </th>
            <th>
            	Brand or Model
            </th>
            <th>
            	Location
            </th>
            <th width="15%">
            	Computer Table
            </th>
            <th width="15%">
            	Workstation
            </th>
            <th width="10%">
                    
                </th>
        </tr>
        <?php
		$counter = 1;
		foreach($report_query->result() as $row) {
		?>
        <tr class="mtable" id="<?=$counter?>">
        	<td><?=$counter?></td>

            <td align="center"><?=$row->device_type?></td>
            <td align="center">
            <?php
			print $this->device_handler->get_device_brand_or_model($row->device_id);
			?>
            </td>
            <td align="center">
            <?php
			$loc = $this->device_handler->device_location($row->device_id);

			if ($loc->num_rows() > 0) {
				print @$loc->row()->location;
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
					print anchor('', 'Device Details', 'class="d-'.$counter.'" style="text-decoration: none; display: none;" onclick="return device.details(\''.site_url('device/device_details').'\', \''.$row->device_id.'\')"');
					?>
                </td>
        </tr>
        <?php
			$counter++;
		}
		?>
    </table>
		<br />
		<div align="right"><b>Prepared By:</b> 
		<?php
		print ucwords($this->session->userdata('first_name').' '.$this->session->userdata('last_name'));
		?>
		</div>
	</div>
    <?php
	}
	?>
</div>