<script>
$(function() {
		$('.mbutton').button();
	});
</script>
<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.41em 0 0.41em 0.45em; }
</style>
<script type="text/javascript">
(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button type='button'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

$(function() {
	$( ".combobox" ).combobox();	
});
</script>
<hr />
<div class="default-font">
    <div align="right">
        <!--
        <button onclick="settings.add_pre_specification_form('.specs','<?=''// site_url('settings/add_spec') ?>')">
            <img src="<?=''// base_url() ?>images/add.png" align="absmiddle" />
            Add Specification
        </button>
        -->
    </div>
    <fieldset>
        <legend>Specifications</legend>
        <table cellpadding="3" width="100%" border="0" class="specification-list">
            <?php
            foreach (@$inputs->result() as $row) {
                $unique_id = uniqid();
                ?>
                <tr class="mtable" id="spec-<?= $unique_id ?>">
                    <td><?= ucwords($row->name) ?></td>
                    <td>
                        <?php
                        if ($this->transaction_handler->no_choices(strtolower($row->name))) {
                            print form_input(array(
                                        'type' => 'text',
                                        'name' => $row->name,
                                        'class' => 'specs-inputs'
                                    ));
                        } else {
                            $id = uniqid(time());
                            print form_dropdown($row->name, $this->transaction_handler->possible_values($row->name, $device_type), '', 'id="' . $id . '" class="specs-inputs combobox"');
                            ?>
                            &nbsp;<a onclick="return transaction.add_value('#<?= $id ?>')" href="#"><img src="<?= base_url() ?>images/add.png" alt="add value" title="Add Value" /></a>
                            <?php
                        }
                        ?>
                    </td>
                    <td align="right">
                        <a href="#" style="text-decoration: none" onclick="settings.remove_item('#spec-<?= $unique_id ?>')"><img align="absmiddle" src="<?= base_url() ?>images/cross.png" /> Remove</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </fieldset>
    <hr />
    <!--
    <div align="right">
        <button onclick="settings.add_pre_specification_form('.specs','<?=''// site_url('settings/add_spec') ?>')">
            <img src="<?= ''//base_url() ?>images/add.png" align="absmiddle" />
            Select device...
        </button>
    </div>
    -->
    <?php
	//print_r($devices_inside);
	if (is_array($devices_inside) && count($devices_inside) >= 2) {
	?>
    <fieldset>
        <legend>Device(s) Inside</legend>
        <table cellpadding="3" width="100%" border="0" class="device-list">
            <?php
            foreach ($devices_inside as $row) {
                $dtype = $this->transaction_handler->get_device_type($row);
                $unique_id = sha1($row);

                if (@$dtype->device_type != '') {
                    ?>
                    <tr class="mtable" id="div-in-<?= $unique_id ?>">
                        <td>
                            <?= ucwords(@$dtype->device_type) ?>
                        </td>
                        <td>
                            <span class="d-here-<?= $unique_id ?> device-inputs" name="<?=$row?>"></span>&nbsp;&nbsp;
                            <button onclick="transaction.choose_device('<?= site_url('transaction/predevices_of_type') ?>', '<?= ucwords(@$dtype->device_type) ?>', '<?= $row ?>', 'd-here-<?= $unique_id ?>')">
                                <img src="<?= base_url() ?>images/magnifier.png" align="absmiddle" />
                                Choose...
                            </button>
                        </td>
                        <td align="right">
                            <a href="#" style="text-decoration: none" onclick="settings.remove_item('#div-in-<?= $unique_id ?>')"><img align="absmiddle" src="<?= base_url() ?>images/cross.png" /> Remove</a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </fieldset>
	<?php
	}
	?>
</div>
<br />
<div align="center" style="background-color: #ffffcc; padding: 10px">
    <button class="mbutton" onclick="back_to_stock_options()">
        <img src="<?=base_url()?>images/arrow_left.png" align="absmiddle" />
        Back
    </button>
    &nbsp;
    <button class="mbutton" onclick="new_device_continue()">
        <img src="<?=base_url()?>images/arrow_right.png" align="absmiddle" />
        Continue
    </button>
</div>