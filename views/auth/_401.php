<?php
unset($_SESSION[APP_NAME]);
?>

<div id="_401" class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center row">
        <div class="col-md-6">
            <img src="/<?php echo COMMON_IMAGE;?>404/security_breach.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-6 mt-5">
            <p class="fs-3">
                <span class="text-danger">Warning!</span> Security breach.
            </p>
            <p class="lead mt-2">
                We have detected that your login account just loged on other browser / device.
                <br/>If that's not your doing, we urge you to change your password <span class="text-danger">immediately</span>.
            </p>
            <br/><a role="button" class="btn btn-primary" onClick="location.reload();">back to Login</a>
        </div>
    </div>
</div>
