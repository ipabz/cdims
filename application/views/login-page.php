<div class="mheader">
	<img src="<?=base_url()?>images/logo_2.png" />
</div>
<br /><br /><br /><br />
<div class="login-container">
    <?php print form_open('login/do_login', 'class="login-form"'); ?>
    <div class="login-header">
    	<div class="login-header-content">
    		Please enter your login details.
        </div>
    </div>
    <br />
    <div class="notification"></div>
    <table border="0" width="80%" align="center">
        <tr>
            <td rowspan="4">
                <img src="<?=base_url()?>images/login.png" />
            </td>
            <td>
            	<div>
                	ID Number:
                </div>
                <input class="wide my-textfield text-center" type="text" name="id-number" value="<?php print set_value('id-number'); ?>" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr>
            
            <td>
            	<div>
                	Password:
                </div>
                <input class="wide my-textfield text-center" type="password" name="password" />
            </td>
        </tr>
        <tr>
            <td align="left">
                <br /><br />
                <img class="loading" src="<?php print base_url(); ?>images/ajax-loader.gif" style="margin-right: 3%; display: none" />
                <input class="my-button login mbutton" type="submit" name="login" value="Log In" />
            </td>
        </tr>
    </table>
    <br />
    <br />
    <div align="left">
        <a style="display: none;" href="#">I cannot access my account</a>
    </div>
    <?php print form_close(); ?>
</div>
<br /><br /><br /><br />