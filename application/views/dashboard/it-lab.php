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
	
	
.table_one {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-100px;
	color: #000;
}

.table_two {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-20px;
	color: #000;
}

.table_three {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:100px;
	color: #000;
}

.table_four {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:300px;
	color: #000;
}

.table_five {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:900px;
	color: #000;
}

.table_six {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:1100px;
	color: #000;
}

.table_seven {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:1200px;
	color: #000;
}

.table_eight {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-1500px;
	color: #000;
}

.table_nine {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-1400px;
	color: #000;
}

.table_ten {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-1200px;
	color: #000;
}

.table_eleven {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-600px;
	color: #000;
}

.table_twelve {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-300px;
	color: #000;
}

.table_thirteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:150px;
	margin-left:-200px;
	color: #000;
}

.table_fourteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:120px;
	margin-left:-1300px;
	color: #000;
}

.table_fifthteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:120px;
	margin-left:-1200px;
	color: #000;
}

.table_sixthteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:130px;
	margin-left:-900px;
	color: #000;
}

.table_seventhteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:120px;
	margin-left:-900px;
	color: #000;
}

.table_eightteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:120px;
	margin-left:-1000px;
	color: #000;
}

.table_ninthteen {
	display:none;
	background: #ccc;
	min-height:130px;
	padding:40px 30px 10px 30px;
	border: 5px solid #fff;
	box-shadow: 0px 0px 50px #000;
	border-radius: 5px;
	width:350px;
	margin-top:120px;
	margin-left:-1300px;
	color: #000;
}
</style>

<div id="page">
<img src="<?=base_url()?>images/panoIT.jpg" alt="CiscoLab" width="3000" height="510" border="0" usemap="#Map" class="advancedpanorama" />
<map name="Map" id="Map">
  <area shape="rect" coords="1503,123,1546,153" href="#" id="table_one" alt="table1" />
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
	?>
    </div>
  <area shape="rect" coords="1552,135,1604,162" href="#" id="table_two" alt="table2" />
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
	?>
    </div>
  <area shape="rect" coords="1577,171,1741,232" href="#" id="table_three" alt="table3" />
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
	?>
    </div>
  <area shape="rect" coords="1798,159,2098,407" href="#" id="table_four" alt="table4" />
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
  <area shape="rect" coords="2425,107,2736,379" href="#" id="table_five" alt="table5" />
  <div class="table_five">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 5</div>
    <?php
		foreach($table_five->result() as $row) {
		?>
        <div name="<?=$table_five_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="2768,114,2888,207" href="#" id="table_six" alt="table6" />
  <div class="table_six">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 6</div>
    <?php
		foreach($table_six->result() as $row) {
		?>
        <div name="<?=$table_six_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="2835,90,2926,114" href="#" id="table_seven" alt="table7" />
  <div class="table_seven">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 7</div>
    <?php
		foreach($table_seven->result() as $row) {
		?>
        <div name="<?=$table_seven_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="41,96,101,139" href="#" id="table_eight" alt="table8" />
  <div class="table_eight">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 8</div>
    <?php
		foreach($table_eight->result() as $row) {
		?>
        <div name="<?=$table_eight_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="109,113,237,192" href="#" id="table_nine" alt="table9" />
  <div class="table_nine">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 9</div>
    <?php
		foreach($table_nine->result() as $row) {
		?>
        <div name="<?=$table_nine_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="285,142,501,389" href="#" id="table_ten" alt="table10" />
  <div class="table_ten">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 10</div>
    <?php
		foreach($table_ten->result() as $row) {
		?>
        <div name="<?=$table_ten_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="928,184,1226,377" href="#" id="table_eleven" alt="table11" />
  <div class="table_eleven">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 11</div>
    <?php
		foreach($table_eleven->result() as $row) {
		?>
        <div name="<?=$table_eleven_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="1255,136,1356,233" href="#" id="table_twelve" alt="table12" />
  <div class="table_twelve">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 12</div>
    <?php
		foreach($table_twelve->result() as $row) {
		?>
        <div name="<?=$table_twelve_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="1357,122,1443,173" href="#" id="table_thirteen" alt="table13" />
  <div class="table_thirteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 13</div>
    <?php
		foreach($table_thirteen->result() as $row) {
		?>
        <div name="<?=$table_thirteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="254,100,312,138" href="#" id="table_fourteen" alt="table14" />
  <div class="table_fourteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 14</div>
    <?php
		foreach($table_fourteen->result() as $row) {
		?>
        <div name="<?=$table_fourteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="350,111,408,141" href="#" id="table_fifthteen" alt="table15" />
  <div class="table_fifthteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 15</div>
    <?php
		foreach($table_fifthteen->result() as $row) {
		?>
        <div name="<?=$table_fifthteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="555,129,641,212" href="#" id="table_sixthteen" alt="table16" />
  <div class="table_sixthteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 16</div>
    <?php
		foreach($table_sixthteen->result() as $row) {
		?>
        <div name="<?=$table_sixthteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="645,98,715,159" href="#" id="table_seventhteen" alt="table17" />
  <div class="table_seventhteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 17</div>
    <?php
		foreach($table_seventhteen->result() as $row) {
		?>
        <div name="<?=$table_seventhteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="463,96,533,139" href="#" id="table_eightteen" alt="table18" />
  <div class="table_eightteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 18</div>
    <?php
		foreach($table_eightteen->result() as $row) {
		?>
        <div name="<?=$table_eightteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
  <area shape="rect" coords="411,89,445,135" href="#" id="table_ninthteen" alt="table19" />
  <div class="table_ninthteen">
  	<div style="margin-bottom: 15px; background: #fff; color: #000;">Table 19</div>
    <?php
		foreach($table_ninthteen->result() as $row) {
		?>
        <div name="<?=$table_ninthteen_id?>" id="<?=$row->name?>" style="margin: 3px; background: #fff; float: left; padding: 5px; cursor: pointer" class="w-details">
        	<div>
            	<img src="<?=base_url()?>images/pc.png" />
            </div>
        	PC <?=$row->name?>
        </div>
        <?php
		}
	?>
    </div>
</map>
</div>
<script>

	$("#table_one").tooltip({ effect: 'slide'});
	$("#table_two").tooltip({ effect: 'slide'});
	$("#table_three").tooltip({ effect: 'slide'});
	$("#table_four").tooltip({ effect: 'slide'});
	$("#table_five").tooltip({ effect: 'slide'});
	$("#table_six").tooltip({ effect: 'slide'});
	$("#table_seven").tooltip({ effect: 'slide'});
	$("#table_eight").tooltip({ effect: 'slide'});
	$("#table_nine").tooltip({ effect: 'slide'});
	$("#table_ten").tooltip({ effect: 'slide'});
	$("#table_eleven").tooltip({ effect: 'slide'});
	$("#table_twelve").tooltip({ effect: 'slide'});
	$("#table_thirteen").tooltip({ effect: 'slide'});
	$("#table_fourteen").tooltip({ effect: 'slide'});
	$("#table_fifthteen").tooltip({ effect: 'slide'});
	$("#table_sixthteen").tooltip({ effect: 'slide'});
	$("#table_seventhteen").tooltip({ effect: 'slide'});
	$("#table_eightteen").tooltip({ effect: 'slide'});
	$("#table_ninthteen").tooltip({ effect: 'slide'});

</script>