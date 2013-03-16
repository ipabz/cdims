<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<script type="text/javascript">
$(function() {
    $('.checkbox').click(function(){
        var checked = $(this).attr('checked');
        
        if (checked) {
            $('.check').attr('checked', true);
        } else {
            $('.check').attr('checked', false);
        }
    });
    
    $(".delete-sel").click(function() {
        
        $('.checkbox').attr('checked', false);
        
        if($('#confirm').length < 1){
            $('<div>').attr('id','confirm').attr('title','Confirm').html('<div id="confirm-content"></div>').dialog({
                width:500, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        
                        $('.check:input').each(function(index) {

                            var checked = $(this).attr('checked');

                            if (checked) {

                                var id = '#' + $(this).val();

                                $(id).css('background-color', 'red');
                                $(id).css('color', 'white');
                                $(id).slideUp('slow');
                                
                                
                                var url = BASE_URL + 'settings/delete_predefined_device/'+$(this).val();
                                
                                $.get(url, function(html) {
                                    
                                });

                            }

                        });
                        
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                }
            }).show();
        }else{
                    
            $("#confirm").dialog({
                width:500, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        
                        $('.check:input').each(function(index) {

                            var checked = $(this).attr('checked');

                            if (checked) {

                                var id = '#' + $(this).val();

                                $(id).css('background-color', 'red');
                                $(id).css('color', 'white');
                                $(id).slideUp('slow');

                            }

                        });
                        
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                    
                }
            });

        }
        
        $("#confirm").html('Are you sure of deleting the selected device(s)?');
    });
    
});
</script>
<div class="default-font" align="right">
    <button class="mbutton" onclick="settings.new_predefined_device('<?=site_url('settings/new_predefined_device')?>')">
        <img src="<?=base_url()?>images/add.png" align="absmiddle" />
        New Device...
    </button>
    <button class="delete-sel mbutton">
        <img src="<?=base_url()?>images/action_stop.gif" align="absmiddle" />
        Delete selected device
    </button>
</div>
<hr />
<div class="pre-dev default-font">
    <table width="100%" border="0" class="mttable" cellpadding="3" cellspacing="0">
        <tr class="mt-header">
            <th width="2%" height="30">
                <input class="checkbox" type="checkbox" name="check-box" value="check-box" />
            </th>
            <th width="20%">
                Device type
            </th>
            <th width="25%">
                Action
            </th>
        </tr>
        <?php
        foreach ($devices->result() as $row) {
        ?>
        <tr class="mtable highlight" id="<?=$row->predefined_device_id?>">
            <td align="center">
                <input type="checkbox" name="check" value="<?=$row->predefined_device_id?>" class="check" />
            </td>
            <td align="center">
            <?=$row->device_type?>  
            </td>
            <td align="center">
                [&nbsp;<a style="text-decoration: none;" href="<?=site_url('settings/edit_pre_device_form/'.$row->predefined_device_id)?>" onclick="settings.edit_device_form('<?=site_url('settings/edit_pre_device_form/'.$row->predefined_device_id)?>')"><img align="absmiddle" src="<?=base_url()?>images/page_white_edit.png" title="Edit" alt="Edit" />&nbsp;Edit</a>&nbsp;]&nbsp;
                [&nbsp;<a style="text-decoration: none;" href="<?=site_url('settings/delete_predefined_device/'.$row->predefined_device_id)?>" onclick="return settings.delete_pre_device('<?=site_url('settings/delete_predefined_device/'.$row->predefined_device_id)?>', '#<?=$row->predefined_device_id?>')"><img align="absmiddle" src="<?=base_url()?>images/cross.png" title="Edit" alt="Edit" />&nbsp;Delete</a>&nbsp;]
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>