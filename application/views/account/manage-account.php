<div class="default-font" align="right">
    <button onclick="account.new_account_form('<?=site_url('account/new_account_form')?>')">
        <img src="<?= base_url() ?>images/add.png" align="absmiddle" />
        New account...
    </button>
</div>
<hr />
<table borer="0" width="100%" cellspacing="0" cellpadding="3" style="font-size: 14px;" class="mttable">
    <tr class="mt-header">
        <th height="35">
            ID Number
        </th>
        <th width="20%">
            First Name
        </th>

        <th>
            Last Name
        </th>
        <th>
            Contact Number
        </th>
        <th>
            Account Type
        </th>
        <th>
            Status
        </th>
        <th>
            Action
        </th>
    </tr>

    <?php
    foreach ($accounts->result() as $row) {
        ?>
        <tr class="mtable">
            <td align="center">
                <?=$row->account_id ?>
            </td>
            <td>
                <?= ucwords($row->firstname) ?>
            </td>
            <td>
                <?= ucwords($row->lastname) ?>
            </td>
            <td align="center">
                <?= $row->contact_number ?>
            </td>
            <td align="center">
                <?= $row->account_type ?>
            </td>
            <td align="center">
                <?php
                if ($row->account_status == '1') {
                    print 'Active';
                } else {
                    print 'Inactive';
                }
                ?>
            </td>
            <td>
                [&nbsp;<a onclick="return account.edit_account_form('<?=site_url('account/edit_account_form/'.$row->account_id)?>', true)" style="text-decoration: none;" class="transaction-details" href="edit-account"><img align="absmiddle" src="<?=base_url()?>images/page_white_edit.png" title="Edit" alt="Edit" />&nbsp;Edit</a>&nbsp;]&nbsp;
            </td>
        </tr>
    <?php
}
?>


</table>