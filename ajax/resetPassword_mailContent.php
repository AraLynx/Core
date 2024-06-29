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
                Congratulation, you have successfully reset your login password.
                <br/>Your new temporary password is
            </div>
            <br/><br/>
            <table>
                <tr>
                    <td class="center">
                        <h3><?php echo $newPassword;?></h3>
                    </td>
                </tr>
            </table>
            <br/><br/><br/>
            <div>
                <a class="pointer" href="https://vibi.trimandirigroup.com:816/<?php echo TDE_ROOT;?>/<?php echo $ajax->get["a"];?>/profile">Click here</a> to login,
                and <span class="retro_red">don't forget to change your password</span> again.
            </div>
            <br/><br/><br/><br/><br/>
            <div class="dark_grey">
                TDE System Auto Email, <?php echo date("Y");?>
            </div>
        </td>
        <td></td>
    </tr>
</table>
