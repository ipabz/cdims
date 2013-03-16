<link rel="stylesheet" type="text/css" href="<?php print base_url();?>css/jquery.panorama.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print base_url();?>css/jquery.fancybox-1.3.1.css" media="screen" />
<script type="text/javascript" src="<?php print base_url();?>js/jquery.panorama.js"></script>

<script type="text/javascript" src="<?php print base_url();?>js/cvi_text_lib.js"></script>
<script type="text/javascript" src="<?php print base_url();?>js/jquery.advanced-panorama.js"></script>
<script type="text/javascript" src="<?php print base_url();?>js/jquery.flipv.js"></script>
<script type="text/javascript" src="<?php print base_url();?>js/jquery.fancybox-1.3.1.pack.js"></script>

<script src="<?php echo base_url();?>js/jquery.tooltip.js"></script>
        

<script type="text/javascript">
	$(document).ready(function(){
		$("img.advancedpanorama").panorama({
	          auto_start: 0,
			start_position: 1527
	         });
			 
		$('area').hover(function() {
				$('img.advancedpanorama').trigger('click');
			});	 
			 
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
	  $('.thickbox').fancybox();
	  $('.thickbox').tooltip({ effect: 'slide'});
	  
	  
	  	$('.w-details').click(function() {
				
				var workstation = $(this).attr('id');
				var table_id = $(this).attr('name');
				
				
				var url = '<?=site_url('dashboard/workstation_devices')?>';
				var data = 'workstation='+workstation+'&table-id='+table_id;
				
				$.post(url, data, function(html) {
						
						var msg = html;
						Dialog.buttons = null;
						Dialog.show_dialog('pc-' + workstation,'PC ' + workstation, msg, 500, 300, true);
						
					});
				
			});
	  
	  
	});
	
</script>

<style type="text/css">
	#page {
		text-align: center;
		color: white;
	}
	#page a {
		color: white;
	}
	#page .panorama-viewport {
		border: 20px solid #414141;
		margin-left: auto;
		margin-right: auto;
	}
	
</style>

<style>
.table_four {
	display:none;
	background: #ccc;
	min-height:163px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-350px;
	color: #000;
}

.table_three {
	display:none;
	background: #ccc;
	min-height:163px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:280px;
	margin-left:-90px;
	color: #000;
}

.table_two {
	display:none;
	background: #ccc;
	min-height:163px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:230px;
	margin-left:200px;
	color: #000;
}

.table_one {
	display:none;
	background: #ccc;
	min-height:163px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:190px;
	margin-left:550px;
	color: #000;
}
</style>


<div id="page">
<img src="<?=base_url()?>images/panCisco.jpg" alt="CiscoLab" width="3000" height="510" border="0" usemap="#Map" class="advancedpanorama" />
<map name="Map" id="Map">
  <area shape="rect" coords="1149,107,1405,237" id="table_four" href="#" alt="table4" />
  	<div class="table_four">
		<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 4</div>
    <?php
		foreach($table_four->result() as $row) {
		?>
        <div name="<?=$table_four_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
    <area shape="rect" coords="1461,118,1638,435" href="#" alt="table3" id="table_three" />
    <div class="table_three">
		<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 3</div>
    <?php
		foreach($table_three->result() as $row) {
		?>
        <div name="<?=$table_three_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>	<div style="clear: both">&nbsp;</div>
    </div>
    <area shape="rect" coords="1680,104,2034,239" href="#" id="table_two" alt="table2" />
    <div class="table_two">
		<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 2</div>
    <?php
		foreach($table_two->result() as $row) {
		?>
        <div name="<?=$table_two_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>	<div style="clear: both">&nbsp;</div>
    </div>
    <area shape="rect" coords="2129,111,2344,177" href="#" id="table_one" alt="table1" />
    <div class="table_one">
		<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 1</div>
    <?php
		foreach($table_one->result() as $row) {
		?>
        <div name="<?=$table_one_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>	<div style="clear: both">&nbsp;</div>
    </div>
</map>
</div>

<script>

	$("#table_four").tooltip({ effect: 'slide'});
	$("#table_three").tooltip({ effect: 'slide'});
	$("#table_two").tooltip({ effect: 'slide'});
	$("#table_one").tooltip({ effect: 'slide'});

</script>