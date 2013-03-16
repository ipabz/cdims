<div class="default-font">
    <table align="center" width="320" cellpadding="3">
        <tr>
            <td>ID number</td>
            <td class="id-num-container">
                <input onkeyup="account.account_exists(this.value, '<?=site_url('account/validate_id_number')?>')" type="text" name="id-number" class="id-number" value="" />
            </td>
        </tr>
        <tr>
            <td>First name</td>
            <td>
                <input type="text" name="first-name" class="first-name" value="" />
            </td>
        </tr>
        <tr>
            <td>Last name</td>
            <td>
                <input type="text" name="last-name" class="last-name" value="" />
            </td>
        </tr>
        <tr>
            <td>Contact number</td>
            <td>
                <input type="text" name="contact-number" class="contact-number" value="" />
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <select class="account-status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Account type</td>
            <td>
            <?php
            print form_dropdown('account-type', $account_types, '', 'class="account-type"');
            ?>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <input type="password" name="password" class="pass-word" value="" />
            </td>
        </tr>
    </table>
    <hr />
    <div align="center">
        <button disabled="disabled" class="my-button save-new" onclick="account.save_new_account('<?=site_url('account/save_new_account')?>')">
            <img src="<?= base_url() ?>images/action_save.gif" align="absmiddle" />
            Save
        </button>
        &nbsp;
        <button class="my-button" onclick="account.cancel_new_account()">
            <img src="<?= base_url() ?>images/action_stop.gif" align="absmiddle" />
            Cancel
        </button>
    </div>
</div>