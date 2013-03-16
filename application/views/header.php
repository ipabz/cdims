<script type="text/javascript">
$(function() {
		
		var data = {
				timestamp: 0
			};
		
		var handler = function(datas, clib) {
			clib.data.timestamp = datas.timestamp
			alert(datas.message + " ---- " + datas.timestamp + " -- " + datas.prev_timestamp);
			//data.timestamp = datas.timestamp;
		};
		
		var notification = new comet_lib('<?=site_url('dashboard/get_updates')?>', data, 'POST', 'json', handler);
		//notification.connect(notification);
		
	});
</script>
<?php
//$this->memcached_library->set('sample', 'this');
?>
<div class="header">
    <?php
    $account_type = $this->session->userdata('account_type');
    ?>
        
    <div class="h_containers">    
        <div class="title">&nbsp;</div>
    </div>
    
    <div class="menu">
        <ul id="MenuBar1" class="MenuBarHorizontal">
            <li><a href="<?=site_url('dashboard')?>">Home</a></li>
            <li><a href="<?=site_url('device/devices')?>">Device</a></li>
            <?php if ($account_type == 1 OR $account_type == 2) { ?>
            <li><a class="MenuBarItemSubmenu" href="#report">Transaction</a>
                <ul class="subcontainer">
                    <li><a class="add-new-transaction" href="<?=site_url("transaction/add_new")?>" class="fontweight-normal">Add New...</a></li>
                    <li><a href="<?= site_url("transaction/transaction_list") ?>" class="fontweight-normal">List</a></li>
                </ul>
            </li>
            <?php } ?>
            <li><a class="MenuBarItemSubmenu" href="#report">Report</a>
                <ul class="subcontainer">
                    <li><a href="<?=site_url('report/tabular')?>" class="fontweight-normal">Tabular</a></li>
                    <li><a href="<?=site_url('report/graphical')?>" class="fontweight-normal">Graphical</a></li>
                </ul>
            </li>
            <?php if ($account_type == 1 OR $account_type == 2) { ?>
            <li><a class="MenuBarItemSubmenu" href="#settings">Settings</a>
                <ul class="subcontainer">
                    <li><a href="<?=site_url('settings/device_types')?>" class="fontweight-normal device-types">Device Types</a></li>
                    <li><a href="<?=site_url('settings/predefined_devices')?>" class="fontweight-normal predefined-devices">Predefined Devices</a></li>
                    <li><a href="<?= site_url('settings/locations') ?>" class="fontweight-normal locations">Locations</a></li>
                </ul>
            </li>
            <?php } ?>
            <li><a class="MenuBarItemSubmenu" href="#manage-account">Account</a>
                <ul class="subcontainer">
                    <?php if ($account_type == 1) { ?>
                    <li><a href="<?=site_url('account/manage_account')?>" class="fontweight-normal manage-account">Manage Account</a></li>
                    <?php } else if ($account_type == 2 OR $account_type == 3) { ?>
                    <li><a onclick="return account.edit_account_form('<?=site_url('account/edit_account_form/'.$this->session->userdata('id_number'))?>', false)" href="<?=site_url('account/edit_account_form/'.$this->session->userdata('id_number'))?>" class="fontweight-normal">Edit Account</a></li>
                    <?php } ?>
                    <li><a href="<?= site_url('account/logout') ?>" class="fontweight-normal">Logout</a></li>
                </ul>
            </li>
        </ul>
        <script type="text/javascript">
            <!--
            var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../../SpryAssets/SpryMenuBarRightHover.gif"});
            //-->
        </script>
    </div>
    
    <div class="title" style=" position:absolute; top: 10px; left: 118px;">
		<img src="<?=base_url()?>images/logo-2.png" align="top" />
    	<!---<img align="top" src="<?=''//base_url()?>images/logo_2.png" style="margin-left: 0px;" />-->
		Computing Devices Inventory Management System
		
    </div>
</div>