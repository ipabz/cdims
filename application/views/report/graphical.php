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
	<img src="<?=base_url();?>images/banner.png" align="absmiddle" />
	Panoramic View
</h2>
<div id="panorama-container" style="background: #fff; border: 1px solid #ccc; display: none; width: 100px; height: 100px; position: fixed; top: 100px;"></div>
    
    <div align="center" style="border-radius: 5px; border: 10px solid #ccc; background: #f7f7f7; padding: 20px;">
        <span>
            <a onclick="return dashboard.cisco_show_panorama()" href="#dialog" name="modals">
            <img class="locations2 cisco" src="<?=base_url()?>images/cisco-lab.jpg" />
            </a>
        </span>
        
        <span>
            <a onclick="return dashboard.it_show_panorama()" href="#dialog" name="modals">
            <img class="locations2" src="<?=base_url()?>images/it-lab.jpg" />
            </a>
        </span>
        
        <br style="clear: both;" />
    </div>
    
     <br /><br /><br /><br />
    
    
    
    <div id="boxes">
    
    	<div id="dialog" class="window">
           
        </div>

    	<div id="mask"></div>
        
    </div>
    
    </div>