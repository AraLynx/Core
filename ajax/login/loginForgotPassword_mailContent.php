<?php
?>
<br/>
<br/>
<br/>
<br/>
<table>
    <tr>
        <td></td>
        <td width="400px">
            <h3>Hi <?php echo $User->Name;?>,</h3>
            <br/><br/><br/>
            <div>
                We're sorry to hear that you're having trouble with logging in to <?php echo APP_NAME;?>.
                We've received a message that you've forgotten your password.
                If this wasn't you, you can get straight back into your account or reset your password now.
            </div>
            <br/><br/>
            <table>
                <tr>
                    <td class="center">
                        <h6><a class="pointer" href="https://vibi.trimandirigroup.com:816/<?php echo TDE_ROOT;?>/<?php echo APP_NAME;?>/">Log in as<br/><?php echo $User->Username;?></a></h6>
                    </td>
                    <td class="center">
                    <h6><a class="pointer" href="https://vibi.trimandirigroup.com:816/<?php echo TDE_ROOT;?>/Chronos/ajax/resetPassword.php?a=<?php echo APP_NAME;?>&t=<?php echo $token;?>">Reset your<br/>password</a></h6>
                    </td>
                </tr>
            </table>
            <br/><br/><br/>
            <div class="retro_orange bold">
                If you didn't request a login link or password reset, you can ignore this message and learn more about why you might have received it.
            </div>
            <br/><br/><br/><br/><br/>
            <div class="dark_grey">
                TDE System Auto Email, <?php echo date("Y");?>
            </div>
        </td>
        <td></td>
    </tr>
</table>
