<?php
//dd($approvalApprovalTypes);
require_once dirname(__DIR__,2).'/configs/attendaceLegends.php';

#region FORM GET DATA
$formParams = array(
    "page" => "profile",
    "group" => "profile",
    "id" => "GetData",
    "isHidden" => true,
);
$form = new \app\pages\Form($formParams);
$form->begin();
$form->end();
$form->render();
#endregion
?>
<script>
    let approvalGetApprovalsSelectOptions = <?php echo json_encode($approvalApprovalTypes);?>;
    let approvalGetApprovalsSelectOptionsApplications = approvalGetApprovalsSelectOptions.Applications;
    let approvalGetApprovalsSelectOptionsPages = approvalGetApprovalsSelectOptions.Pages;
    let approvalGetApprovalsSelectOptionsApprovalTypes = approvalGetApprovalsSelectOptions.ApprovalTypes;
    let approvalGetApprovalsSelectOptionsApprovalTypeSteps = approvalGetApprovalsSelectOptions.ApprovalTypeSteps;
</script>
<main id="profile" class="d-lg-flex w-100">
    <div id="profile_menu" class="tde-box me-lg-3 mb-lg-0 mb-3" style="min-width:240px">
        <nav class="p-2">
            <div class="d-lg-block d-none">
                <div id="profile_menu_user" class="row" role="button" onClick="profileShowSubContent('account');">
                    <div id="profile_menu_user_avatar" class="col-4 my-auto px-0 d-flex justify-content-end">
                    </div>
                    <div id="profile_menu_user_username_position" class="col">
                        <p id="" class="">
                            <span class="fw-bold" id="profile_menu_user_employeeName">..LOADING..</span> (<span id="profile_menu_user_employeeId">0000</span>)
                            <br/><small class="text-muted fst-italic">aka <span id="profile_menu_user_username">..LOADING..</span></small>
                            <br/><span id="profile_menu_user_employee_position">..LOADING..</span>
                        </p>
                    </div>
                </div>
                <hr class="text-secondary"/>
            </div>

            <ul class="d-flex justify-content-between flex-lg-column list-unstyled mb-0 mb-lg-3">
                <li class="py-2 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('account');">
                        <i class="fa-regular fa-fw fa-user" title="MY ACCOUNT"></i>
                        <div class="d-lg-block d-none ms-lg-2">MY ACCOUNT</div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative d-none">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('notification');">
                        <i class="fa-regular fa-fw fa-bell" title="NOTIFICATION"></i>
                        <div class="d-lg-block d-none mx-lg-2">NOTIFICATION</div>
                        <div class="badge rounded-pill bg-danger workerNotification"></div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('chat');">
                        <i class="fa-regular fa-fw fa-comment" title="CHAT"></i>
                        <div class="d-lg-block d-none mx-lg-2">CHAT</div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('message');">
                        <i class="fa-regular fa-fw fa-envelope" title="MESSAGE"></i>
                        <div class="d-lg-block d-none mx-lg-2">MESSAGE</div>
                        <div class="badge rounded-pill bg-danger unreadEmailCounter"></div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('approval');">
                        <i class="fa-regular fa-fw fa-thumbs-up" title="APPROVAL"></i>
                        <div class="d-lg-block d-none mx-lg-2">APPROVAL</div>
                        <div class="badge rounded-pill bg-danger approvalWMAPCounter"></div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('attendance');">
                        <i class="fa-solid fa-fw fa-calendar-check" title="ATTENDANCE"></i>
                        <div class="d-lg-block d-none mx-lg-2">ATTENDANCE</div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('employee');">
                        <i class="fa-solid fa-fw fa-users" title="EMPLOYEES"></i>
                        <div class="d-lg-block d-none mx-lg-2">EMPLOYEES</div>
                    </div>
                </li>
                <li class="py-2 p-lg-0 position-relative">
                    <div class="d-flex align-items-center" role="button" onClick="profileShowSubContent('news_feed');">
                        <i class="fa-solid fa-fw fa-circle-info" title=" NEWS FEED"></i>
                        <div class="d-lg-block d-none mx-lg-2"> NEWS FEED</div>
                    </div>
                </li>

                <hr class="text-secondary d-lg-block d-none"/>

                <?php
                if(APP_NAME != "Gaia")
                { ?>
                    <li class="py-2 p-lg-0">
                        <a class="d-flex align-items-center text-reset text-decoration-none" role="button" href="/<?php echo TDE_ROOT;?>/Gaia/">
                            <img src="/<?php echo COMMON_IMAGE;?>/Logo_GAIA_16.png" class=""/>
                            <div class="d-lg-block d-none ms-lg-2">GAIA</div>
                        </a>
                    </li>
                <?php }
                if(APP_NAME != "Selene")
                { ?>
                    <li class="py-2 p-lg-0">
                        <a class="d-flex align-items-center text-reset text-decoration-none" role="button" href="/<?php echo TDE_ROOT;?>/Selene/">
                            <img src="/<?php echo COMMON_IMAGE;?>/Logo_SELENE_16.png" class=""/>
                            <div class="d-lg-block d-none ms-lg-2">SELENE</div>
                        </a>
                    </li>
                <?php }
                if(APP_NAME != "Plutus")
                { ?>
                    <li class="py-2 p-lg-0">
                        <a class="d-flex align-items-center text-reset text-decoration-none" role="button" href="/<?php echo TDE_ROOT;?>/Plutus/">
                            <img src="/<?php echo COMMON_IMAGE;?>/Logo_PLUTUS_16.png" class=""/>
                            <div class="d-lg-block d-none ms-lg-2">PLUTUS</div>
                        </a>
                    </li>
                <?php }
                if(APP_NAME == "Plutus" && count($_OTHER_BRANCHES))
                { ?>
                    <li class="py-2 p-lg-0">
                        <a class="d-flex align-items-center text-reset text-decoration-none" role="button" onClick="TDE.defaultKendoWindowSwitchBranch.center().open();">
                        <i class="fa-solid fa-fw fa-repeat"></i>
                            <div class="d-lg-block d-none ms-lg-2">SWITCH BRANCH</div>
                        </a>
                    </li>
                <?php }
                ?>

                <hr class="text-secondary d-lg-block d-none"/>

                <li class="py-2 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="defaultLogoutConfirmationMessage();">
                        <i class="fa-solid fa-fw fa-arrow-right-from-bracket" title="LOGOUT"></i>
                        <div class="d-lg-block d-none ms-lg-2">LOGOUT</div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div id="profile_content" class="tde-box-3 overflow-auto flex-fill">
        <div id="profile_account" class="profile_content d-none">
            <?php require_once __DIR__."/profile_account.php";?>
        </div>

        <div id="profile_notification" class="profile_content d-none">
            <?php //require_once __DIR__."/profile_notification.php";?>
        </div>

        <div id="profile_chat" class="profile_content d-none">
            <?php require_once __DIR__."/profile_chat.php";?>
        </div>

        <div id="profile_message" class="profile_content d-none">
            <?php require_once __DIR__."/profile_message.php";?>
        </div>

        <div id="profile_approval" class="profile_content d-none">
            <?php require_once __DIR__."/profile_approval.php";?>
        </div>

        <div id="profile_attendance" class="profile_content d-none">
            <?php require_once __DIR__."/profile_attendance.php";?>
        </div>

            <div id="profile_teamAttendance" class="profile_content d-none">
                <?php require_once __DIR__."/profile_teamAttendance.php";?>
            </div>

        <div id="profile_employee" class="profile_content d-none">
            <?php require_once __DIR__."/profile_employee.php";?>
        </div>

        <div id="profile_news" class="profile_content d-none">
            <?php require_once __DIR__."/profile_news.php";?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        profileGetData();
        profileShowSubContent('<?php echo $subContent;?>');
    });
</script>
