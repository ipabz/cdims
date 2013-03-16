<div style="border: 1px solid #ccc; float: right; border-radius: 3px; margin-top: 25px; box-shadow: 0px 1px 2px #ccc;">
	<?=form_open('search');?>
	<span style="padding: 5px; border-right: 1px solid #ccc;"><img src="<?=base_url()?>images/zoom.png" /></span>
    <input onFocus="this.select()" value="Search" style="border: none; background-color: #fff; padding: 5px;" size="50" type="text" name="keyword" id="keyword" />
    <?=form_close();?>
</div>