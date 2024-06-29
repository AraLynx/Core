<?php
unset($_SESSION[APP_NAME]);
$quotes = [
    "Every new day begins with new possibilities<br/>-Ronald Reagan-"
    ,"With the new day comes new strength and new toughts<br/>-Eleanor Roosevelt-"
    ,"Today is a new day. Even if you were wrong yesterday, you can get it right today<br/>-Dwight Howard-"
    ,"Every day that I wake up has to be a good day!<br/>-Bret Michaels-"
    ,"On a good day everybody can beat everybody.<br/>-Chris Hughton-"
    ,"Anyone can have a good day, but you have to be able to perform on a bad day.<br/>-Jurgen Klopp-"
];
?>

<main id="_401" class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center row">
        <div class="col-md-4">
            <img src="/<?php echo IMAGE_ROOT;?>newDay/itsanewday2.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-8 mt-5">
            <p class="fs-3">
                <span class="text-success"><?php echo $quotes[rand(0,(count($quotes) - 1))];?></span>
            </p>
            <p class="lead mt-5">
                We have detected that this is your first visit for today.
                <br/>Please re-login to your account to update your <span class="text-danger">credential</span>.
            </p>
            <p class="mt-5 fst-italic">
                You will be automatically redirect to the login page shortly.
                <br/><span id="redirectCounter">Please allow up to 5 seconds</span> ...
            </p>
            <p class="mt-4 small">Don't want to wait ?<br/><a role="button" class="text-primary" onClick="location.reload();">Click here</a> to go back to Login now</p>
        </div>
    </div>
</main>
<script>
    let redirectCounter = 5;
    $(document).ready(function(){
        setInterval(function(){
            redirectCounter--;
            if(redirectCounter > 1)
                $("#redirectCounter").html("Please allow up to "+redirectCounter+" seconds");
            else if(redirectCounter == 1)
                $("#redirectCounter").html("Please allow up to "+redirectCounter+" second");
            else if(redirectCounter == 0){
                $("#redirectCounter").html("...Redirecting...");
                location.reload();
            }
        }, 1000);
    });
</script>
