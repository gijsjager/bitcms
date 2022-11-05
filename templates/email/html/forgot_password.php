<table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="100%" bgcolor="#4dbfbf">
    <tr>
        <td>
            <br>
            <img src="https://www.filepicker.io/api/file/Pv8CShvQHeBXdhYu9aQE" width="216" height="189" alt="robot picture">
        </td>
    </tr>
    <tr>
        <td class="headline">
            <?= __('Forgot your password?'); ?>
        </td>
    </tr>
    <tr>
        <td>

            <center>
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="60%">
                    <tr>
                        <td style="color:#187272;">
                            <br>
                            <?= __('That is oke. Mistakes can happen.<br/>We\'ve created a new password for you. You can change this within your account.'); ?><br>
                            <br>
                            <strong><?= __('Username') ?></strong>: <?= $user->username ?><br/>
                            <strong><?= __('Password') ?></strong>: <?= $password ?><br/>
                            <br>
                        </td>
                    </tr>
                </table>
            </center>

        </td>
    </tr>
    <tr>
        <td>
            <div><!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="<?= $this->Url->build(['prefix' => 'bitcms', 'controller' => 'Users', 'action' => 'login'], true) ?>" style="height:50px;v-text-anchor:middle;width:200px;" arcsize="8%" stroke="f" fillcolor="#178f8f">
                    <w:anchorlock/>
                    <center>
                <![endif]-->
                <a href="<?= $this->Url->build(['prefix' => 'bitcms', 'controller' => 'Users', 'action' => 'login'], true) ?>"
                   style="background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;"><?= __('Login to your account!'); ?></a>
                <!--[if mso]>
                </center>
                </v:roundrect>
                <![endif]--></div>
            <br>
            <br>
        </td>
    </tr>
</table>
