var Dialog = {
    identifier: '',
    buttons: null,
    loading: '<img src="'+BASE_URL+'images/ajax-loader.gif" /> &nbsp;Please wait a moment...',
    reload: true,
    show_dialog: function(container_id,title,msg,d_width,d_height,d_modal) {
        
        this.identifier = '#' + container_id;
        
        if($('#'+container_id).length < 1){
            $('<div>').attr('id',container_id).attr('title',title).html('<div id="'+container_id+'-content"></div>').dialog({
                width:d_width, 
                height:d_height,
                modal: d_modal,
                buttons: this.buttons
            }).show();
        }else{
            $("#"+container_id).dialog({
                title: title,
                width:d_width, 
                height:d_height,
                modal: d_modal,
                buttons: this.buttons
            });
				
        }
        
        $('#'+container_id).html(msg);
        
    },
    close: function() {
        
        $(this.identifier).html('');
        $(this.identifier).dialog('close');
        
    }
} 

var form = {
    getData: function(identifier) {
        
        var data = '';
        
        $(identifier).each(function(index) {
            if (data == '') { 
                data = $(this).attr('name') + '=' + $(this).val();
            } else {
                data += '&' + $(this).attr('name') + '=' + $(this).val();
            }
        });
        
        return data;
    },
    check_box: function(id) {
        
        var checked = $(id+':checkbox').attr('checked');
        
        if (checked) {
            $(id+':checkbox').attr('checked', true);
        } else {
            $(id+':checkbox').attr('checked', false);
        }
        
    }
};

var dashboard = {
	cisco_show_panorama: function() {
		
		$('#dialog').dialog({
				width: 1000,
				height: 630,
				modal: true,
				title: 'Cisco Laboratory'
			});
		
		$('#dialog').css('background', '#414141');
		
		var url = BASE_URL + "dashboard/cisco_lab";
		$("#dialog").html('');
		$.get(url, function(html) {
			$("#dialog").html(html);
		});
		
		return false;
		
	},
	it_show_panorama: function() {
		
		$('#dialog').dialog({
				width: 1000,
				height: 630,
				modal: true,
				title: 'IT Laboratory'
			});
		
		$('#dialog').css('background', '#414141');
		
		var url = BASE_URL + "dashboard/it_lab";
		$("#dialog").html('');
		$.get(url, function(html) {
			$("#dialog").html(html);
		});
		
		return false;
		
	},
	
	workstation_details: function() {
		
	}
};

var report = {
	get_specsname: function(url,device_type) {
		
		var data = "device-type="+device_type;
		
		$.post(url, data, function(html) {
			$("#spec-n").html(html);
		});
		
	},
	get_specvalues: function(url,name) {
		
		var device_type = $("#devicetype").val();
		
		var data = "spec-name="+name+"&device-type="+device_type;
		
		$.post(url,data,function(html) {
			
			$("#spec-v").html(html);
			
		});
		
	}
};

var device = {
	details: function(url,device_id) {
		
		var data = "device_id="+device_id;
		
		$.post(url, data, function(html) {
			
			Dialog.buttons = {
				"Close"	: function() {
					Dialog.close();	
				}
			};
			 
			Dialog.show_dialog('device-details', 'Details', html, 800, 600, true);
			
		});
		
		return false;
		
	},
	
	edit_device: function(url,device_id) {
		
		var data = "device_id="+device_id;
		
		$.post(url, data, function(html) {
			
			Dialog.buttons = {
				"Save": function() {
                                        var url = BASE_URL + 'device/edit_device_save';
                                        device.edit_device_save(url);
                                    
						
				},
				"Cancel"	: function() {
					$('#edit-device').dialog('close');
				}
				
			};
			 
			Dialog.show_dialog('edit-device', 'Edit', html, 800, 600, true);
			
		});
		
		return false;
		
	},
        
        edit_device_save: function(url) {
            
            var device_name = $('.device-name').val();
            var device_id = $('.device-id').val();
            var status = $('.status').val();
			
            var specs = '';
            var name='',value='';
            var devices = '';
            
            $('.specs-inputs').each(function(index) {
            
                name = $(this).attr('name');
                value = $(this).val();
            
                specs += name + '::::' + value + '----';
            
            });
            
            $('.device-inputs').each(function(index) {
            
                name = $(this).attr('name');
                value = $(this).attr('id');
            
                devices += name + '::::' + value + ',';
            
            });
            
            var data = 'device-id=' +device_id+ '&device-name='+device_name+'&specs='+specs+'&devices='+devices+'&status='+status;
            //alert(data);
            $.post(url, data, function(html) {
                if (html != '') {
                    alert(html);
                } else {
					
                    $('#edit-device').dialog('close');
					window.location = BASE_URL + 'device/devices';
                }
            });
            
        },
		
		delete_device: function(url,tid) {
			
			Dialog.buttons = {
					'Yes': function() {
						
						$.get(url, function() {
								Dialog.close();
								settings.remove_item(tid);
							});
						
						
					},
					'No': function() {
						Dialog.close();
					}
				};
			
			Dialog.show_dialog('confirm-delete', 'Confirm', 'Are you sure of deleting this device?', 400, 180, true);
			
		}
};

var transaction = {
    select_category: function(value,loading_container,url) {
        
        $(loading_container).html(Dialog.loading);
        
        var data = 'device-type='+value;
        
        $.post(url, data, function(html) {
            $(".device-options").hide();
            $(".device-options").html(html);
            $(".device-options").slideDown('fast');
            $(loading_container).html('');
        });
        
    },
    
    add_value: function(input_id) {
        
        var html = '<input type="text" name="value" class="value wide text-center" />';
        
        Dialog.buttons = {
            "Add": function() {
                
                var val = $('.value').val();
                
                if (val == '') {
                    alert('Please provide a value.');
                    return;
                }
                
                var opt = '<option value="'+val+'">'+val+'</option>';
                $(input_id).append(opt);
                
                $(input_id).val(val);
               
                Dialog.close();
            },
            "Cancel": function() {
                Dialog.close();
            }
        };
        
        Dialog.show_dialog('add-value', 'Add Value', html, 400, 180, true);
        
        return false;
        
    },
    
    choose_device: function(url,device_type,device_type_id,src) {
        
        Dialog.buttons = null;
        Dialog.show_dialog('choose-device', 'Choose a '+device_type, Dialog.loading, 500, 300, true);
        
        var data = 'device-type='+device_type_id+'&src='+src;
        
        $.post(url, data, function(html) {
            $('#choose-device').html(html);
        });
        
    },
    
    select_the_device: function(url,device_id,device_name,src) {

        $("."+src).html(device_name);
        $("."+src).attr('id', device_id);
        Dialog.close();
        
    },
    
    add_device_type: function(url) {
        
        $.post(url, function(html) {
            
            Dialog.buttons = null;
            
            Dialog.show_dialog('add-device-type', 'Select device', html, 400, 300);
            
        });
        
    },
    
    computer_table_option: function (url,value,src) {
        
        var data = 'location-id='+value;
        
        $('.loading-here').html(Dialog.loading);
        
        $.post(url, data, function(html) {
            $('.loading-here').html('');
            $('.computer-tables-option').html(html);
            $('.workstations-option').html('');
        });
		
		if (value == '') {
			$('.loc-next-dev').attr('disabled', true);
		} else {
			//$('.loc-next-dev').attr('disabled', false);
		}
        
    },
    
    workstation_option: function (url,value,src) {
        
        var data = 'computer-table='+value;
        
        $('.loading-here2').html(Dialog.loading);
        
        $.post(url, data, function(html) {
            $('.loading-here2').html('');
            $('.workstations-option').html(html);
			$(".computer-table-select").val(value);
        });
		
		if (value == '') {
			$('.loc-next-dev').attr('disabled', true);
		} else {
			$('.loc-next-dev').attr('disabled', false);
		}
        
    },
	
	change_w: function(val) {
		$('.workstation-select').val(val);
	},
    
    add_transaction: function(url) { 
        
        var transaction_type = $('.select-transaction-type').val();
        var option = $('.stock-in-opt:checked').val();
        
        if (option == 'new') {
            
            //new device
            var device_type = $('.device-type-opt').val();
            var specs = '';
            var name='',value='';
            var devices = '';
            
            var device_name = $('.device-name').val();
            
            $('.specs-inputs').each(function(index) {
            
                name = $(this).attr('name');
                value = $(this).val();
            
                specs += name + '::::' + value + '----';
            
            });
            
            $('.device-inputs').each(function(index) {
            
                name = $(this).attr('name');
                value = $(this).attr('id');
            
                devices += name + '::::' + value + ',';
            
            });
            
            //location
            var location = $('.location-select').val();
            var table = $('.computer-table-select').val();
            var workstation = $('.workstation-select').val();
            
            //person incharge
            var fname = $(".firstname").val();
            var lname = $(".lastname").val();
            var contact_number = $(".contact-number").val();
            var id_number = $(".id-number").val();
            
            if (fname == '' || lname == '' || contact_number == '' || id_number == '') {
                
                alert('All fields must have a value!!!');
                return;
                
            }
			
			var more_info = $(".more-info").val();
            
            var data = 'device-type='+device_type+'&specs='+specs+'&devices='+devices+'&location='+location+'&table='+table+'&workstation='+workstation+'&fname='+fname+'&lname='+lname+'&contact-number='+contact_number+'&id-number='+id_number+'&option='+option+'&device-name='+device_name+'&transaction-type='+transaction_type+"&more_info="+more_info;
            
            $('.loading-here').show('fast');
            $('.add-trans').attr('disabled', true);
            
            $.post(url, data, function(html) {
                
				if (html == 'error') {
					alert('Unable to continue. Devices must be unique in every workstation.');
					$('.add-trans').attr('disabled', false);
					
				} else {
				
					Dialog.buttons = {
						"Ok": function() {
							Dialog.close();
							$('.dialog-container').dialog('close');
						}
					};
					
					Dialog.show_dialog('add-transaction-success', 'success', 'Transaction successful!', 300, 180, true);
				
				}
                
            });
           
           /*
           $.ajax({
               type: "POST",
               url: url,
               data: data,
               sucess: function(html) {
                   alert(html);
               },
               error: function(e) {
                   alert(e.responseText);
               }
           }); */
           
        } else {
			
			//location
            var location = $('.location-select').val();
            var table = $('.computer-table-select').val();
            var workstation = $('.workstation-select').val();
            
            //person incharge
            var fname = $(".firstname").val();
            var lname = $(".lastname").val();
            var contact_number = $(".contact-number").val();
            var id_number = $(".id-number").val();
			
			if (fname == '' || lname == '' || contact_number == '' || id_number == '') {
                
                alert('All fields must have a value!!!');
                return;
                
            }
			
			var more_info = $(".more-info").val();
			var device_id = $('.existing-device-id').val();
			
			var data = 'transaction-type='+transaction_type+'&more_info='+more_info+'&device-id='+device_id+'&location='+location+'&table='+table+'&workstation='+workstation+'&fname='+fname+'&lname='+lname+'&contact-number='+contact_number+'&id-number='+id_number;
			
			var url2 = BASE_URL + 'transaction/add_new_transaction_existing';			
			
			$.post(url2, data, function(html) {
                
				if (html == 'error') {
					alert('Unable to continue. Devices must be unique in every workstation.');
					$('.add-trans').attr('disabled', false);
					
				} else {
				
					Dialog.buttons = {
						"Ok": function() {
							Dialog.close();
							$('.dialog-container').dialog('close');
						}
					};
					
					Dialog.show_dialog('add-transaction-success', 'success', 'Transaction successful!', 300, 180, true);
				
				}
                
            });
			
		}
        
    },
    
    search_device: function(url,dst) {
        
        var device_type = $(".device-type-sel").val();
        var spec = $(".specs-select").val();
        var keyword = $(".search-field").val();
        
        if (keyword == '') {
            return;
        }
        
        $(".specs-select").attr('disabled', true);
        $(".search-field").attr('disabled', true);
        $(".search-button").attr('disabled', true);
        $(".device-type-sel").attr('disabled', true);
        
        $('.loading-here').html(Dialog.loading);
        var data = 'device-type='+device_type+'&spec='+spec+'&keyword='+keyword;
        
        $.post(url, data, function(html) {
            $(".specs-select").attr('disabled', false);
            $(".search-field").attr('disabled', false);
            $(".search-button").attr('disabled', false);
            $(".device-type-sel").attr('disabled', false);

            $('.loading-here').html('');
        
            $(dst).html(html);
        });
        
    },
	
	devices_in: function(url) {
		
		var location = $('.location-s').val();
		var table = $('.computer-table-select').val();
		var workstation = $('.workstation-select').val();
		table = document.getElementById('ts').value;
		var data = "location="+location+"&table="+table+"&workstation="+workstation;
		
		$(".location-search-container").slideUp('fast');
		$(".dev-search-container").html("Searching... &nbsp;&nbsp;" + Dialog.loading);
		
		$.post(url, data, function(html) {
			$(".dev-search-container").show();
			$(".dev-search-container").html(html);
		});
		
	},
	
	add_transaction_so: function(url) {
		
		var transaction_type = $('.select-transaction-type').val();
		
		 //person incharge
		var fname = $(".firstname").val();
		var lname = $(".lastname").val();
		var contact_number = $(".contact-number").val();
		var id_number = $(".id-number").val();
		
		if (fname == '' || lname == '' || contact_number == '' || id_number == '') {
			
			alert('All fields must have a value!!!');
			return;
			
		}
		
		var devices = "";
		
		$(".check").each(function(index, element) {
        	
			if ($(this).attr('checked')) {
			
				if (devices == "") {
					devices = element.value;
				} else {
					devices += "::::" + element.value;	
				}
			
			}
        });
		
		var more_info = $(".more-info").val();
	
		var data = "transaction-type="+transaction_type+"&fname="+fname+"&lname="+lname+"&contact_number="+contact_number+"&id_number="+id_number+"&devices="+devices+"&more_info="+more_info;
		
		$.post(url, data, function(html) {
			
			Dialog.buttons = {
				"Ok": function() {
					Dialog.close();
					$('.dialog-container').dialog('close');
				}
			};
			
			Dialog.show_dialog('add-transaction-success', 'success', 'Transaction successful!', 300, 180, true);
			
		});
		
	}
};

var account = {
    new_account_form: function(url) {
        
        $.get(url, function(html) {
            Dialog.buttons = null;
            Dialog.show_dialog('new-account-form', 'New account', html, 360, 340, true);
        });
        
    },
    cancel_new_account: function() {
        
        Dialog.close();
        
    },
    save_new_account: function(url) {
        
        var id_number = $('.id-number').val();
        var first_name = $('.first-name').val();
        var last_name = $('.last-name').val();
        var contact_number = $('.contact-number').val();
        var account_status = $('.account-status').val();
        var account_type = $('.account-type').val();
        var password = $('.pass-word').val();
        
        var data = 'id-number='+id_number+'&first-name='+first_name+'&last-name='+last_name+'&contact-number='+contact_number;
        data += '&account-status='+account_status+'&account-type='+account_type+'&password='+password;
        
        if (id_number == '' || first_name == '' || last_name == '' || contact_number == '' || account_type == '' || password == '') {
            alert('All fields must be filled up.');
            return;
        }
        
        $.post(url, data, function(html) {
            
            Dialog.close();
            
            Dialog.buttons = {
                "Ok": function() {
                    Dialog.close();
                    
                    $(".dialog-container").html(Dialog.loading);
        
                    url = BASE_URL + 'account/manage_account';
        
                    $.get(url, function(html) {
                        $(".dialog-container").html(html);
                    });
                    
                }
            };
            
            var msg = 'Account successfully save.';
            var title = 'Success';
            
            if (html == '-1') {
                msg = 'A Problem occured. Unable to save account.';
                title = 'Error!!!';
            }
            
            Dialog.show_dialog('success', title, msg, 450, 180, true);
            
        });
        
        
    },
    
    edit_account_form: function(url,reload_page) {
        
        Dialog.reload = reload_page;
        
        $.get(url, function(html) {
            Dialog.buttons = null;
            Dialog.show_dialog('edit-account-form', 'Edit account', html, 360, 340, true);
        });
        
        return false;
        
    },
    
    update_account: function(url) {
        
        var id_number = $('.id-number').val();
        var first_name = $('.first-name').val();
        var last_name = $('.last-name').val();
        var contact_number = $('.contact-number').val();
        var account_status = $('.account-status').val();
        var account_type = $('.account-type').val();
        var password = $('.pass-word').val();
       
        
        var data = 'id-number='+id_number+'&first-name='+first_name+'&last-name='+last_name+'&contact-number='+contact_number;
        data += '&account-status='+account_status+'&account-type='+account_type+'&password='+password;
        
        if (id_number == '' || first_name == '' || last_name == '' || contact_number == '' || account_type == '' || password == '') {
            alert('All fields must be filled up.');
            return;
        }
        
        $.post(url, data, function(html) {
            
            Dialog.close();
            
            Dialog.buttons = {
                "Ok": function() {
                    Dialog.close();
                    
                    if (Dialog.reload) {
                        $(".dialog-container").html(Dialog.loading);
                        
                        url = BASE_URL + 'account/manage_account';

                        $.get(url, function(html) {
                            $(".dialog-container").html(html);
                        });
                    }
                    
                }
            };
            
            var msg = 'Account successfully updated.';
            var title = 'Success';
            
            if (html == '-1') {
                msg = 'A Problem occured. Unable to update account.';
                title = 'Error!!!';
            }
            
            Dialog.show_dialog('success', title, msg, 450, 180, true);
            
        });
        
    },
    
    account_exists:function(id_number,url) {
        
        var data = 'id-number='+id_number;
        
        $.post(url, data, function(html) {
            if (html != '') {
                $('.id-notice').remove();
                $('.id-num-container').append(html);
                $('.save-new').attr('disabled', true);
            } else {
                $('.save-new').attr('disabled', false);
                $('.id-notice').remove();
            }
        });
        
    }
};

var settings = {
    new_predefined_device: function(url) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#new-pre-device').length < 1){
            $('<div>').attr('id','new-pre-device').attr('title','New Device').html('<div id="new-pre-device-content"></div>').dialog({
                width:500, 
                height:620,
                modal: true,
                close: function(event,ui) {
                    $('#new-pre-device').remove();
                }
            }).show();
        }else{
            $("#new-pre-device").dialog({
                width:500, 
                height:620,
                modal: true,
                close: function(event,ui) {
                    $('#new-pre-device').remove();
                }
            });
				
        }
        
        $("#new-pre-device").html(loading);
        
        $.get(url, function(html) {
            $("#new-pre-device").html(html);
        });
        
    },
    add_pre_specification_form: function(container,url) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#add-spec').length < 1){
            $('<div>').attr('id','add-spec').attr('title','Add Specification').html('<div id="nadd-spec-content"></div>').dialog({
                width:350, 
                height:230,
                modal: true
            }).show();
        }else{
            $("#add-spec").dialog({
                width:350, 
                height:230,
                modal: true
            });
				
        }
        
        $("#add-spec").html(loading); 
        
        $.get(url, function(html) {
            $("#add-spec").html(html);
        });
        
        
    },
    
    cancel_add_pre_spec: function() {
        
        $("#add-spec").dialog('close');
        
    },
    
    add_pre_spec: function(base_url,unique_id) {
        
        var spec_name = $.trim($('.spec-name').val());
        var spec_value = $.trim($('.spec-value').val());
        
        if (spec_name == '' || spec_value == '') {
            alert("All fields must not be empty!");
            return;
        }
        
        $("#add-spec").dialog('close');
        
        var html = '<tr class="highlight m-specs mtable" id="spec-'+unique_id+'" title="'+spec_name+'----'+spec_value+'">';
        html += '<td contenteditable="true">';
        html += spec_name;
        html += '</td>';
        html += '<td contenteditable="true">';
        html += spec_value;
        html += '</td>';
        html += '<td align="right">';
        html += '<a href="#" style="text-decoration: none" onclick="settings.remove_item(\'#spec-'+unique_id+'\')"><img align="absmiddle" src="'+base_url+'images/cross.png" /> Remove</a>';
        html += '</td>';
        html += '</tr>'; 
        
        $('.specification-list').prepend(html);
        
    },
    
    remove_item: function(id) {

        $(id).css('background-color', 'red');
        $(id).css('color', 'white');
        $(id).slideUp('fast', function() {
            $(id).remove();
        });
    },
    
    cancel_add_new_device: function() {
        $("#new-pre-device").dialog('close');
        $("#new-pre-device").remove();
    },
    
    save_new_pre_device: function() {
        
        var device_name = $('.device-name').val();
        var device_type = $('.device-type').val();
        
        var data = 'device-name='+device_name+'&device-type='+device_type;
        var temp = '';
        var specs = '';
        var devices_inside = '';
        
        $('tr.m-specs').each(function(index) {
            
            temp = $(this).attr('title');
            
            if (specs == '') {
                specs = temp;
            } else {
                specs += '<->' + temp;
            }
            
        });
        
        $('tr.d-types').each(function(index) {
            
            temp = $(this).attr('id');
            
            if (devices_inside == '') {
                devices_inside = temp;
            } else {
                devices_inside += ',' + temp;
            }
            
        });
        
        data += '&specs=' + specs +'&devices='+devices_inside;
        
        if (device_name == '' || device_type == '' || specs == '') {
            alert("Please provide a value for the Device name, Device type, and specifications!");
            return;
        }
       
        var url = BASE_URL + 'settings/add_device';
       
        $.post(url, data, function(html) { 
            
            if($('#success').length < 1){
                $('<div>').attr('id','success').attr('title','Success').html('<div id="success-content"></div>').dialog({
                    width:350, 
                    height:150,
                    modal: true,
                    buttons: {
                        "OK": function() {
                            $("#success").dialog('close');
                            url = BASE_URL + 'settings/predefined_devices';
        
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);

                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                        }
                    }
                }).show();
            }else{
                    
                $("#success").dialog({
                    width:350, 
                    height:150,
                    modal: true,
                    buttons: {
                        "OK": function() {
                            $("#success").dialog('close');
                            url = BASE_URL + 'settings/predefined_devices';
        
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);

                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                        }
                    }
                });

            }
                
            $("#success").html('Device successfully added.');
                
                
                
        });

        
        $("#new-pre-device").dialog('close');
        $("#new-pre-device").remove();
        
        
        
    },
    
    edit_device_form: function(url) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#edit-device').length < 1){
            $('<div>').attr('id','edit-device').attr('title','Edit Device').html('<div id="edit-device-content"></div>').dialog({
                width:500, 
                height:620,
                modal: true,
                close: function(event,ui) {
                    $('#edit-device').remove();
                }
            }).show();
        }else{
            $("#edit-device").dialog({
                width:500, 
                height:620,
                modal: true,
                close: function(event,ui) {
                    $('#edit-device').remove();
                }
            });
				
        }
        
        $("#edit-device").html(loading); 
        
        $.get(url, function(html) {
            
            if (html == '-1') {
                alert('Device does not exists!');
            } else {
                $("#edit-device").html(html);
            }
            
        });
        
    },
    
    cancel_edit_pre_device: function() {
        $("#edit-device").dialog('close');
        $("#edit-device").remove();
    },
    
    save_edited_pre_device: function(device_id) { 
        
        var device_name = $('.device-name').val();
        var device_type = $('.device-type').val();
        
        var data = 'device-name='+device_name+'&device-type='+device_type+'&device-id='+device_id;
        var temp = '';
        var specs = '';
        var devices_inside = '';
        
        $('tr.m-specs').each(function(index) {
            
            temp = $(this).attr('title');
            
            if (specs == '') {
                specs = temp;
            } else {
                specs += '<->' + temp;
            }
            
        });
        
        $('tr.d-types').each(function(index) {
            
            temp = $(this).attr('id');
            
            if (devices_inside == '') {
                devices_inside = temp;
            } else {
                devices_inside += ',' + temp;
            }
            
        });
        
        data += '&specs=' + specs + '&devices='+devices_inside;
        
        if (device_name == '' || device_type == '' || specs == '') {
            alert("Please provide a value for the Device name, Device type, and specifications!");
            return;
        }
       
       
        var url = BASE_URL + 'settings/edit_pre_device';
  
        $.post(url, data, function(html) { 
            
            if($('#success').length < 1){
                $('<div>').attr('id','success').attr('title','Success').html('<div id="success-content"></div>').dialog({
                    width:350, 
                    height:180,
                    modal: true,
                    buttons: {
                        "OK": function() {
                            $("#success").dialog('close');
                            url = BASE_URL + 'settings/predefined_devices';
        
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);

                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                        }
                    }
                }).show();
            }else{
                    
                $("#success").dialog({
                    width:350, 
                    height:180,
                    modal: true,
                    buttons: {
                        "OK": function() {
                            $("#success").dialog('close');
                            url = BASE_URL + 'settings/predefined_devices';
        
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);

                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                        }
                    }
                });

            }
                
            $("#success").html('Device successfully updated.');
                
                
                
        });

        
        $("#edit-device").dialog('close');
        $("#edit-device").remove();
        
    },
    
    delete_pre_device: function(url,id) {
        
        if($('#confirm').length < 1){
            $('<div>').attr('id','confirm').attr('title','Confirm').html('<div id="confirm-content"></div>').dialog({
                width:400, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slideUp('slow');
            
                        });
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                }
            }).show();
        }else{
                    
            $("#confirm").dialog({
                width:400, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slideUp('slow');
            
                        });
                        
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                    
                }
            });

        }
        
        
        $("#confirm").html('Are you sure of deleting this device?');
        
        
        
        return false;
        
    },
    
    delete_selected: function(device_id) {
        
        if($('#confirm').length < 1){
            $('<div>').attr('id','confirm').attr('title','Confirm').html('<div id="confirm-content"></div>').dialog({
                width:500, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slidUp('slow');
            
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
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slideUp('slow');
            
                        });
                        
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                    
                }
            });

        }
        
        
        $("#confirm").html('Are you sure of deleting the selected device(s)?');
        
        return false;
        
    },
    
    new_location_form: function() {
        
        if($('#new-location').length < 1){
            $('<div>').attr('id','new-location').attr('title','New Location').html('<div id="new-location-content"></div>').dialog({
                width:400, 
                height:250,
                modal: true,
                buttons: {
                    "Save": function() {
                        
                        var location_name = $(".location-name").val();
                        var num_computer_table = $('.num-computer-table').val();
                        var num_workstation = $('.num-workstation-per-table').val();
                        
                        if (location == '' || num_computer_table == '' || num_workstation == '') {
                            alert("Please provide values on all the fields.");
                            return;
                        }
                        
                        var data = 'location-name='+location_name+'&num-computer-table='+num_computer_table+'&num-workstation='+num_workstation;
                        
                        var url = BASE_URL + "settings/new_location";
                        
                        $.post(url, data, function(html) {
                            alert('Successfully added a new location.');
                            
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);
        
                            url = BASE_URL + 'settings/locations';
        
                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                            
                        });
                        
                        $("#new-location").dialog('close');
                        
                    },
                    "Cancel": function() {
                        $("#new-location").dialog('close');
                    }
                }
            }).show();
        }else{
                    
            $("#new-location").dialog({
                width:400, 
                height:250,
                modal: true,
                buttons: {
                    "Save": function() {
                        var location_name = $(".location-name").val();
                        var num_computer_table = $('.num-computer-table').val();
                        var num_workstation = $('.num-workstation-per-table').val();
                        
                        if (location == '' || num_computer_table == '' || num_workstation == '') {
                            alert("Please provide values on all the fields.");
                            return;
                        }
                        
                        var data = 'location-name='+location_name+'&num-computer-table='+num_computer_table+'&num-workstation='+num_workstation;
                        
                        var url = BASE_URL + "settings/new_location";
                        
                        $.post(url, data, function(html) {
                            alert('Successfully added a new location.');
                            
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);
        
                            url = BASE_URL + 'settings/locations';
        
                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                            
                        });
                        
                        $("#new-location").dialog('close');
                        
                    },
                    "Cancel": function() {
                        $("#new-location").dialog('close');
                    }
                    
                }
            });

        }
        
        var url = BASE_URL + 'settings/new_location_form';
                        
        $.get(url, function(html) {
            $("#new-location").html(html);
        });
        
    },
    
    edit_location_form: function(url,location_id) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#edit-location').length < 1){
            $('<div>').attr('id','edit-location').attr('title','Edit Location').html('<div id="edit-location-content"></div>').dialog({
                width:400, 
                height:250,
                modal: true,
                buttons: {
                    "Save": function() {
                        $('#edit-location').dialog('close');
                        
                        var location_name = $(".location-name").val();
                        var num_computer_table = $('.num-computer-table').val();
                        var num_workstation = $('.num-workstation-per-table').val();
                        
                        var data = 'location-name='+location_name+'&num-computer-table='+num_computer_table+'&num-workstation='+num_workstation;
                        
                        url = BASE_URL + 'settings/edit_location/'+location_id;
                        
                        $.post(url, data, function(html) {
                            alert('Location successfully updated.');
                            
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);
        
                            url = BASE_URL + 'settings/locations';
        
                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                            
                        });
                        
                    },
                    "Cancel": function() {
                        $('#edit-location').dialog('close');
                    }
                }
            }).show();
        }else{
            $("#edit-location").dialog({
                width:400, 
                height:250,
                modal: true,
                buttons: {
                    "Save": function() {
                        $('#edit-location').dialog('close');
                        
                        var location_name = $(".location-name").val();
                        var num_computer_table = $('.num-computer-table').val();
                        var num_workstation = $('.num-workstation-per-table').val();
                        
                        var data = 'location-name='+location_name+'&num-computer-table='+num_computer_table+'&num-workstation='+num_workstation;
                        
                        url = BASE_URL + 'settings/edit_location/'+location_id;
                        
                        $.post(url, data, function(html) {
                            alert('Location successfully updated.');
                            
                            var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                            $(".dialog-container").html(loading);
        
                            url = BASE_URL + 'settings/locations';
        
                            $.get(url, function(html) {
                                $(".dialog-container").html(html);
                            });
                            
                        });
                    },
                    "Cancel": function() {
                        $('#edit-location').dialog('close');
                    }
                }
            });
				
        }
        
        $("#edit-location").html(loading); 
        
        $.get(url, function(html) {
            
            if (html == '-1') {
                alert('Location does not exists!');
            } else {
                $("#edit-location").html(html);
            }
            
        });
        
        return false;
        
    },
    
    delete_location: function(url,id) {
        
        
        if($('#confirm').length < 1){
            $('<div>').attr('id','confirm').attr('title','Confirm').html('<div id="confirm-content"></div>').dialog({
                width:400, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slideUp('slow');
            
                        });
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                }
            }).show();
        }else{
                    
            $("#confirm").dialog({
                width:400, 
                height:180,
                modal: true,
                buttons: {
                    "Yes": function() {
                        $("#confirm").dialog('close');
                        $.get(url, function(html) {
            
                            $(id).css('background-color', 'red');
                            $(id).css('color', 'white');
                            $(id).slideUp('slow');
            
                        });
                        
                    },
                    "No": function() {
                        $("#confirm").dialog('close');
                    }
                    
                }
            });

        }
        
        
        $("#confirm").html('Are you sure of deleting this location?');
        
        
        
        return false;
        
    },
    
    select_device_form: function(url) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#select-device').length < 1){
            $('<div>').attr('id','select-device').attr('title','Select device').html('<div id="select-device-content"></div>').dialog({
                width:350, 
                height:300,
                modal: true
            }).show();
        }else{
                    
            $("#select-device").dialog({
                width:350, 
                height:300,
                modal: true
            });

        }
        
        $('#select-device').html(loading);
        
        $.get(url, function(html) {
            $('#select-device').html(html);
        });
        
    },
    
    select_device: function(device_type,device_name) {
        
        var unique_id = device_type;
        
        var html = '<tr class="d-types" id="'+device_type+'">';
        html += '<td>';
        html += device_name;
        html += '</td>';
        html += '<td align="right">';
        html += '<a href="#" style="text-decoration: none" onclick="settings.remove_item(\'#'+unique_id+'\')"><img align="absmiddle" src="'+BASE_URL+'images/cross.png" /> Remove</a>';
        html += '</td>';
        html += '</tr>';
        
        $('.device-list').prepend(html);
        
        $('#select-device').dialog('close');
        
    },
    
    new_device_type: function(url) {
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        
        if($('#new-device-type').length < 1){
            $('<div>').attr('id','new-device-type').attr('title','New Device Type').html('<div id="new-device-type-content"></div>').dialog({
                width:750, 
                height:110,
                modal: true
            }).show();
        }else{
                    
            $("#new-device-type").dialog({
                width:750, 
                height:110,
                modal: true
            });

        }
        
        $('#new-device-type').html(loading);
        
        $.get(url, function(html) {
            $('#new-device-type').html(html);
        });
        
    },
    
    add_device_type: function(url) {
        
        var device_type = $('.device-type').val();
		var inner = $('.inner-device').attr('checked') ? 1 : 0;
		var with_devices = $('.with-devices').attr('checked') ? 1 : 0;
        
		if (device_type == '') {
			alert('Please enter a device type.');
			$('.device-type').focus();
			return;	
		}
		
        var data = 'device-type='+device_type+'&inner='+inner+'&with-devices='+with_devices;
        
        $.post(url, data, function(html) {
            
            $('#new-device-type').dialog('close');
            
            Dialog.buttons = {
                "OK": function() {
                   
                    $('#add-device-type').dialog('close');
                   
                    var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                    $('.dialog-container').html(loading);
                    
                    url = BASE_URL + 'settings/device_types';
        
                    $.get(url, function(html) {
                        $('.dialog-container').html(html);
                    });
                   
                }
            };
            
            var msg = 'Successfully added a device type.';
            
            Dialog.show_dialog('add-device-type', 'Success', msg, 450, 180, true);
        });
        
    },
    
    delete_device_type: function(device_type_id,unique_id) {
        
        Dialog.buttons = {
            "Yes": function() {
                $('#confirm').dialog('close');
                
                var url = BASE_URL + 'settings/delete_device_type';
                var data = 'device-type='+device_type_id;
                
                $.post(url, data, function(html) {
                    settings.remove_item(unique_id);
                });
            },
            "No": function() {
                $('#confirm').dialog('close');
            }
        };
        
        Dialog.show_dialog('confirm', 'Confirm', 'Are you sure of deleting this device type?', 450, 180, true);
        
        return;        
    },
    
    edit_device_type_form: function(device_type_id) {
        
        var url = BASE_URL + 'settings/edit_device_type_form';
        var data = 'device-type='+device_type_id;
        
        $.post(url,data,function(html) {
            
            Dialog.buttons = null;
            
            Dialog.show_dialog('edit-device-type', 'Edit device type', html, 750, 110, true);
            
        });
        
    },
    
    edit_device_type: function(device_type_id) {
        
        var device_type = $('.device-type2').val();
        var inner = $('.inner-device').attr('checked') ? 1 : 0;
		var with_devices = $('.with-devices').attr('checked') ? 1 : 0;
        
		if (device_type == '') {
			alert('Please enter a device type.');
			$('.device-type').focus();
			return;	
		}
		
        var url = BASE_URL + 'settings/edit_device_type/'+device_type_id+'/'+device_type+'/'+inner+'/'+with_devices;  
        
        $.get(url, function(html) { 
            
            $('#edit-device-type').dialog('close');
            
            Dialog.buttons = {
                "Ok": function() {
                    
                    Dialog.close();
                    
                    var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
                    $('.dialog-container').html(loading);
                    
                    url = BASE_URL + 'settings/device_types';
        
                    $.get(url, function(html) {
                        $('.dialog-container').html(html);
                    });
                    
                }
            };
            
            Dialog.show_dialog('success', 'Success', 'Successfully updated.', 450, 180, true);
           
        });
        
    }
};

$(function() {
    
    //login
    $('.login-form').bind('submit', function() {
        
        $(":input").attr('disabled', true);
        $(".loading").show();
            
        var data = form.getData(':input');
        var url = BASE_URL + 'login/do_login'; 
           
        $.post(url, data, function(html) {
            $(":input").attr('disabled', false);
            $(".loading").hide();
               
            if (html == '1') {
                    
                window.location = BASE_URL + 'dashboard';
                    
            } else { 
                $('.notification').html(html);
            }
                    
            
        });
            
        return false;
    });
    
    $(".add-new-transaction").click(function(e) {
        e.preventDefault();
        
        $('.dialog-container').dialog({
            title: "New Transaction",
            width: 800,
            height: 620,
            modal: true
        });
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        $(".dialog-container").html(loading);
        
        var url = $(this).attr('href');
        
        $.get(url, function(html) {
            $(".dialog-container").html(html);
        });
        
    });
    
    $(".manage-account").click(function(e) {
        e.preventDefault();
        
        $('.dialog-container').dialog({
            title: "Manage Account",
            width: 800,
            height: 500,
            modal: true
        });
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        $(".dialog-container").html(loading);
        
        var url = $(this).attr('href');
        
        $.get(url, function(html) {
            $(".dialog-container").html(html);
        });
        
    });
    
    $(".predefined-devices").click(function(e) {
        e.preventDefault();
        
        $('.dialog-container').dialog({
            title: "Predefined Devices",
            width: 800,
            height: 550,
            modal: true
        });
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        $(".dialog-container").html(loading);
        
        var url = $(this).attr('href');
        
        $.get(url, function(html) {
            $(".dialog-container").html(html);
        });
        
    });
    
    $(".locations").click(function(e) {
        e.preventDefault();
        
        $('.dialog-container').dialog({
            title: "Locations",
            width: 800,
            height: 500,
            modal: true
        });
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        $(".dialog-container").html(loading);
        
        var url = $(this).attr('href');
        
        $.get(url, function(html) {
            $(".dialog-container").html(html);
        });
        
    });
    
    
    $(".device-types").click(function(e) {
        e.preventDefault();
        
        $('.dialog-container').dialog({
            title: "Device Types",
            width: 400,
            height: 450,
            modal: true
        });
        
        var loading = '<img src="'+BASE_URL+'images/ajax-loader.gif" /> Please wait a moment...';
        $(".dialog-container").html(loading);
        
        var url = $(this).attr('href');
        
        $.get(url, function(html) {
            $(".dialog-container").html(html);
        });
        
    });
	
	
	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});	
    
	$('.mbutton').button();
    
});