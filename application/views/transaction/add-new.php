<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<script type="text/javascript">
    
	function per_to_dev() {
		$('#person-incharge-label2').removeClass('selected');
        $('#person-incharge-label2').addClass('opt');
        $('#device-label2').removeClass('finish');
        $('#device-label2').addClass('selected');
		
		$(".person-incharge-container").hide();
		$(".dev-search-container").slideDown("fast");
	}
	
	function dev_to_per() {
		
		var ok = false;
		
		$(".check").each(function(index, element) {
            if ($(this).attr('checked')) {
				ok = true;
			}
        });
		
		if (! ok) {
			alert("Please choose at least one device.");
			return;
		}
		
		$('#device-label2').removeClass('opt');
		$('#device-label2').removeClass('selected');
		$('#device-label2').addClass('finish');
		$('#person-incharge-label2').removeClass('opt');
		$('#person-incharge-label2').addClass('selected');
		
		$(".dev-search-container").hide();
		$(".person-incharge-container").slideDown("fast");
		
	}
	
	function dev_to_loca() {
		$('#device-label2').removeClass('selected');
        $('#device-label2').addClass('opt');
        $('#location-label2').removeClass('finish');
        $('#location-label2').addClass('selected');
		
		$(".dev-search-container").hide();
		$(".location-search-container").slideDown("fast");
		
	}
	
	function loca_to_dev() {
		$('#location-label2').removeClass('opt');
		$('#location-label2').removeClass('selected');
		$('#location-label2').addClass('finish');
		$('#device-label2').removeClass('opt');
		$('#device-label2').addClass('selected');
	}
	
    function existing_select_specs(val) {
        
        if (val != '') {
            $(".search-field").attr('disabled', false);
            $(".search-button").attr('disabled', false);
        } else {
            $(".search-field").attr('disabled', true);
            $(".search-button").attr('disabled', true);
        }
        
    }
    
    function existing_select_device_type(val) {
    
        if (val != '') {
            $(".specs-select").attr('disabled', false);
            
            var data = 'device-type=' + val;
        
            var url = "<?=site_url('transaction/search_get_specs')?>";

            $.post(url, data, function(html) {
                $('.specs-cont').html(html);
            });
        } else {
            $(".specs-select").attr('disabled', true);
            $(".search-field").attr('disabled', true);
            $(".search-button").attr('disabled', true);
        }
    
    }
    
    function back_to_location() {
        
        $(".person-incharge-container").slideUp('fast');
        $(".location-container").slideDown('fast');
        
        $('#person-incharge-label').removeClass('selected');
        $('#person-incharge-label').addClass('opt');
        $('#location-label').removeClass('finish');
        $('#location-label').addClass('selected');
        
    }
    
    function back_to_new_device() {
        
		var option = $('.stock-in-opt:checked').val();
		
        $(".location-container").hide('fast');
		
		if (option == 'new') {
			$(".new-device-container").slideDown('fast');
		} else {
        	$(".existing-device-container").slideDown('fast');
		}
        
        $('#location-label').removeClass('selected');
        $('#location-label').addClass('opt');
        $('#device-label').removeClass('finish');
        $('#device-label').addClass('selected');
        
    }
    
    function location_continue() {
        
        var location = $('.location-select').val();
        var table = $('.computer-table-select').val();
        var workstation = $('.workstation-select').val();
        
        if (location != '' && table != '' && workstation != '') {
            
            $(".location-container").slideUp('fast');
            $(".person-incharge-container").slideDown('fast');
            
            $('#location-label').removeClass('opt');
            $('#location-label').removeClass('selected');
            $('#location-label').addClass('finish');
            $('#person-incharge-label').removeClass('opt');
            $('#person-incharge-label').addClass('selected');
            
        } else {
            alert('All fields must not be empty!');
        }
        
    }
    
    function back_to_stock_options() {
        $('.device-options').html('');
        $('.device-type-opt').val('');
        $('.stock-in-opt').attr('checked', false);
        $(".new-device-container").slideUp('fast');
            
        $(".stock-in-options").slideDown("fast");
        
        $('#device-label').removeClass('selected');
        $('#device-label').addClass('opt');
        $('#transaction-type-label').removeClass('finish');
        $('#transaction-type-label').addClass('selected');
        
        $('.location-select').val('');
        $('.computer-tables-option').html('');
        $('.workstations-option').html('');
        $(".firstname").val('');
        $(".lastname").val('');
        $(".contact-number").val('');
        $(".id-number").val('');
        //$('.device-name').val('');
		
		//hide existing options
		$('.existing-device-container').slideUp('fast');
    }
    
    function new_device_continue() {
        
        var value = '';
        var specs_inputs_empty = false;
        var dev_inputs_empty = false;
        
        var device_name = $('.device-name').val();
        
        if (device_name == '') {
            alert('Oops!!! You forgot to fill up the device name.');
            return;
        }
        
        $('.specs-inputs').each(function(index) {
            
            value = $(this).val();
            
            if (value == '') {
                specs_inputs_empty = true;
            }
            
        });
        
        if (specs_inputs_empty) {
            alert('Please provide values for the specifications!');
            return;
        }
        
        $('.device-inputs').each(function(index) {
            
            value = $(this).attr('id');
            
            if (value == '') {
                dev_inputs_empty = true;
            }
            
        });
        
        if (dev_inputs_empty) {
            alert('Please provide values for the devices inside this device!');
            return;
        }
        
        $(".new-device-container").slideUp('fast');
        $(".location-container").slideDown('fast');
        
        $('#device-label').removeClass('opt');
        $('#device-label').removeClass('selected');
        $('#device-label').addClass('finish');
        $('#location-label').removeClass('opt');
        $('#location-label').addClass('selected');
        
    }
	
	function new_device_continue_existing(device_id) {
        
		/*
        var value = '';
        var specs_inputs_empty = false;
        var dev_inputs_empty = false;
        
        var device_name = $('.device-name').val();
        
        if (device_name == '') {
            alert('Oops!!! You forgot to fill up the device name.');
            return;
        }
        
        $('.specs-inputs').each(function(index) {
            
            value = $(this).val();
            
            if (value == '') {
                specs_inputs_empty = true;
            }
            
        });
        
        if (specs_inputs_empty) {
            alert('Please provide values for the specifications!');
            return;
        }
        
        $('.device-inputs').each(function(index) {
            
            value = $(this).attr('id');
            
            if (value == '') {
                dev_inputs_empty = true;
            }
            
        });
        
        if (dev_inputs_empty) {
            alert('Please provide values for the devices inside this device!');
            return;
        }
        
        $(".new-device-container").slideUp('fast');*/
        $(".location-container").slideDown('fast');
        
		
        $('#device-label').removeClass('opt');
        $('#device-label').removeClass('selected');
        $('#device-label').addClass('finish');
        $('#location-label').removeClass('opt');
        $('#location-label').addClass('selected');
		
		//hide existing options
		$('.existing-device-container').slideUp('fast');
		$('.existing-device-id').val(device_id);
        
    }
    
    $(function() {
        $(".hide").hide();
        $(".continue").attr('disabled', true);
        
        $(".select-transaction-type").change(function() {
            var val = $(this).val();
            
            if (val == 1) {
                $(".stock-in-options").slideDown("fast");
				$("#breadcrumb-stockin").slideDown("slow");
				$("#breadcrumb-stockout").hide();
				$(".stock-out").hide();
				$(".pi").show();
            } else if (val == 2) {
                $(".stock-in-options").slideUp("fast");
				$("#breadcrumb-stockin").hide();
				$("#breadcrumb-stockout").slideDown("slow");
				$(".location-search-container").show("fast");
				
				$('#transaction-type-label2').removeClass('opt');
				$('#transaction-type-label2').removeClass('selected');
				$('#transaction-type-label2').addClass('finish');
				$('#location-label2').removeClass('opt');
				$('#location-label2').addClass('selected');
				
				$(".stock-in").hide();
				$(".po").show();
				$(".stock-in-opt").attr('checked', false);
				
            } else {
                $(".stock-in-options").slideUp("fast");
				$(".stock-out").hide();
				$(".stock-in").hide();
				
				$('#location-label2').addClass('opt');
				$('#location-label2').removeClass('selected');
				$('#transaction-type-label2').removeClass('finish');
				$('#transaction-type-label2').addClass('selected');
				
				$(".stock-in-opt").attr('checked', false);
				
				$('#device-label').addClass('opt');
				$('#device-label').removeClass('selected');
				$('#transaction-type-label').removeClass('finish');
				$('#transaction-type-label').addClass('selected');
				
            }
        });
        
        $(".stock-in-opt").click(function() {
            var val = $(this).val();
            
            if (val == 'existing') {
                $(".new-device").slideUp("fast");
                $(".existing-search").slideDown('fast');
                
                $('.existing-device-container').fadeIn('fast');
                
                $('#transaction-type-label').removeClass('opt');
                $('#transaction-type-label').removeClass('selected');
                $('#transaction-type-label').addClass('finish');
                $('#device-label').removeClass('opt');
                $('#device-label').addClass('selected');
                
            } else if (val == 'new') {
                $(".new-device").slideDown("fast");
                $(".existing-search").slideUp('fast');
                //$(".select-transaction-type").val('');
                $('.new-device-container').show('fast');
                
                $('#transaction-type-label').removeClass('opt');
                $('#transaction-type-label').removeClass('selected');
                $('#transaction-type-label').addClass('finish');
                $('#device-label').removeClass('opt');
                $('#device-label').addClass('selected');
            }
            
            $(".stock-in-options").slideUp("fast");
        });
        
        var options = [
<?php
foreach ($person_incharge as $id_num => $details) {

    print '\'' . $id_num . '\',';
}
?>
        ];
        
        $(".id-number").autocomplete({
            source: options,
            select: function(event, ui) {
                
                var url = '<?= site_url('transaction/get_person_incharge'); ?>/' + ui.item.value;
                
                $.getJSON(url, function(data) {
                    $(".firstname").val(data.firstname);
                    $(".lastname").val(data.lastname);
                    $(".contact-number").val(data.contact_number);
                });
                
            }
        });
        
        
       
    });
</script>

<div id="breadcrumb-stockin" align="left" class="default-font" style="background-color: #99ccff; border: 1px solid #ccc;">
    <div id="transaction-type-label" class="selected">Transaction Type</div>
    <div id="device-label" class="opt">Device</div>
    <div id="location-label" class="opt">Location</div>
    <div id="person-incharge-label" class="opt">Person Incharge</div>
    
    <br style="clear: both;" />
</div>

<div id="breadcrumb-stockout" align="left" class="default-font" style="background-color: #99ccff; border: 1px solid #ccc; display: none;">
	<div id="transaction-type-label2" class="selected">Transaction Type</div>
    <div id="location-label2" class="opt">Location</div>
    <div id="device-label2" class="opt">Device</div>
    <div id="person-incharge-label2" class="opt">Person Incharge</div>
    
    <br style="clear: both;" />
</div>

<br />
<div style="font-size: 14px;">
    <div align="left">
        Transaction Type: 
        <?php
        print form_dropdown('transaction-type', $transaction_types, '', 'class="select-transaction-type"');
        ?>
    </div>
    <div align="center" class="stock-in-options hide" style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc">
        Is device 
        <label>
            <input type="radio" class="stock-in-opt" name="stock-in" value="existing" />
            <u>Existing?</u>
        </label> or 
        <label>
            <input type="radio" class="stock-in-opt" name="stock-in" value="new" />
            <u>New...?</u>
        </label>
    </div>

    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="new-device-container hide default-font stock-in">
        <fieldset style="background-color: #fff;">
            <legend><b>New Device</b></legend>
            <div>
                <span class="hide">Device name <input name="device-name" class="device-name" value="<?=time()?>" /></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Device type:
                <?php
                print form_dropdown('device-category', $device_categories, '', 'onchange="transaction.select_category(this.value,\'.load-cont\', \'' . site_url('transaction/device_options') . '\')" class="device-type-opt"');
                ?>
                &nbsp;&nbsp;
                <span class="load-cont"></span>
            </div>
            <div class="device-options"></div>
            
        </fieldset>
    </div>


    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="location-container hide default-font stock-in">
        <fieldset style="background-color: #fff;">
            <legend>Location</legend>
            <table width="80%" align="center" class="c-table-option">
                <tr>
                    <td>
                        Location
                    </td>
                    <td>
                        <?php
                        print form_dropdown('location', $locations, '', 'class="location-select" onchange="transaction.computer_table_option(\'' . site_url('transaction/computer_tables') . '\', this.value, \'.c-table-option\')"');
                        ?>

                        &nbsp;<span class="loading-here"></span>
                    </td>
                </tr>
                <tr class="computer-tables-option">

                </tr>
                <tr class="workstations-option">

                </tr>
            </table>
        </fieldset>
        <br />
        <div align="center">
            <button class="mbutton" onclick="back_to_new_device()">
                <img src="<?= base_url() ?>images/arrow_left.png" align="absmiddle" />
                Back
            </button>
            &nbsp;
            <button class="mbutton" onclick="location_continue()">
                <img src="<?= base_url() ?>images/arrow_right.png" align="absmiddle" />
                Continue
            </button>
        </div>
    </div>


    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="person-incharge-container hide default-font stock-in">
        <fieldset style="background-color: #fff;">
            <legend><b>Person Incharge<b></legend>
            <table align="center" border="0" width="80%" cellpadding="5">
                <tr>
                    <td>
                        ID Number
                    </td>
                    <td>
                        <div>
                            <input type="text" name="id-number" value="" class="id-number" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        First Name
                    </td>
                    <td>
                        <input type="text" name="firstname" value="" class="firstname" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name
                    </td>
                    <td>
                        <input type="text" name="lastname" value="" class="lastname" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Contact Number
                    </td>
                    <td>
                        <input type="text" name="contact-number" value="" class="contact-number" />
                    </td>
                </tr>
            </table>
        </fieldset>
        <br />
        
        <fieldset style="background-color: #fff;">
        	<legend><b>Transaction Additional Info</b> <i>( Optional )</i></legend>
            <div>
            	<textarea class="more-info" style="width: 99%; height: 100px;"></textarea>
            </div>
        </fieldset>
        
        
        <br />
        <div align="center" class="stock-in pi">
            <button class="mbutton" onclick="back_to_location()">
                <img src="<?= base_url() ?>images/arrow_left.png" align="absmiddle" />
                Back
            </button>
            &nbsp;
            <button class="add-trans mbutton" onclick="transaction.add_transaction('<?=site_url('transaction/add_new_transaction')?>')">
                <img src="<?= base_url() ?>images/arrow_right.png" align="absmiddle" />
                Add Transaction
            </button>
            
            &nbsp;
            <span class="loading-here hide"><img src="<?=base_url()?>images/ajax-loader.gif" /></span>
        </div>
        
        <div align="center" class="stock-out po">
            <button class="mbutton" onclick="per_to_dev()">
                <img src="<?= base_url() ?>images/arrow_left.png" align="absmiddle" />
                Back
            </button>
            &nbsp;
            <button class="add-trans mbutton" onclick="transaction.add_transaction_so('<?=site_url('transaction/add_transaction_so')?>')">
                <img src="<?= base_url() ?>images/arrow_right.png" align="absmiddle" />
                Add Transaction
            </button>
            
            &nbsp;
            <span class="loading-here hide"><img src="<?=base_url()?>images/ajax-loader.gif" /></span>
        </div>
    </div>
    
    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="existing-device-container hide default-font stock-in">
        <fieldset style="background-color: #fff;">
            <legend><b>Existing Device</b></legend>
        <?php $this->load->view('transaction/search-form', array('device_types'=>$device_categories)); ?>
            <hr />
            <br />
            &nbsp;
        </fieldset>
    </div>
    
    
    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="location-search-container hide default-font stock-out">
        <fieldset style="background-color: #fff;">
            <legend><b>Where is the device?</b></legend>
        <?php $this->load->view('transaction/location-search', array('locations'=>$locations)); ?>
           
            &nbsp;
        </fieldset>
    </div>
    
    <div style="border-top: 1px solid #ccc; margin-top: 10px; padding: 8px; background-color: #ffc" class="dev-search-container hide default-font stock-out">
    
    </div>

</div>