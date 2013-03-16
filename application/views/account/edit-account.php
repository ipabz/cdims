<div class="default-font">
    <table align="center" width="320" cellpadding="3">
        <tr>
            <td>ID number</td>
            <td>
                <input disabled="disabled" style="border: none; background-color: #fff; color: #000;" type="text" name="id-number" class="id-number" value="<?= $account->account_id ?>" />
            </td>
        </tr>
        <tr>
            <td>First name</td>
            <td>
                <input type="text" name="first-name" class="first-name" value="<?= $account->firstname ?>" />
            </td>
        </tr>
        <tr>
            <td>Last name</td>
            <td>
                <input type="text" name="last-name" class="last-name" value="<?= $account->lastname ?>" />
            </td>
        </tr>
        <tr>
            <td>Contact number</td>
            <td>
                <input type="text" name="contact-number" class="contact-number" value="<?= $account->contact_number ?>" />
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <?php
                $attr = '';

                if ($this->session->userdata('account_type') != 1) {
                    $attr = ' disabled="disabled"';
                }

                $status = array(
                    '1' => 'Active',
                    '0' => 'Inactive'
                );

                print form_dropdown('account-status', $status, $account->account_status, 'class="account-status"'.$attr);
                ?>
            </td>
        </tr>
        <tr>
            <td>Account type</td>
            <td>
                <?php
                print form_dropdown('account-type', $account_types, $account->account_type_id, 'class="account-type"' . $attr);
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
        <button class="my-button" onclick="account.update_account('<?= site_url('account/update_account') ?>', false)">
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