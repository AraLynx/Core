<?php
//dd($_EMPLOYEE);
?>
<header id="header" class="sticky-top">
    <div id="navbar" class="navbar navbar-expand-lg bg-chronos bg-<?php echo strtolower(APP_NAME);?> navbar-dark">
        <nav class="container-xxl bd-gutter flex-wrap flex-lg-nowrap">
            <div class="bd-navbar-toggle ms-3">
                <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Toggle docs navigation">
                    <i class="fa-solid fa-bars text-white"></i>
                </button>
            </div>
            <a class="navbar-brand p-0 me-0 me-lg-2" href="/<?php echo APP_ROOT;?>">
                <img class="navbar-text" src="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_100White.png" alt="Logo"/>
            </a>
            <?php
            if(APP_NAME == "Hephaestus")
            {?>
                <div class="flex-grow-1"></div>
            <?php }
            else
            {?>
                <div class="d-flex d-lg-none">
                    <button class="navbar-toggler d-flex p-2 position-relative me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#profileBar" aria-controls="profileBar" aria-label="Toggle navigation">
                        <span id="navbarWorkerNotification" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger workerNotification"></span>
                        <i class="fa-regular fa-user text-white"></i>
                    </button>
                </div>
                <div id="profileBar" class="offcanvas offcanvas-lg offcanvas-end flex-grow-1 bg-dark" tabindex="-1" aria-labelledby="profileBarOffcanvasLabel" data-bs-scroll="true">
                    <div class="offcanvas-header px-4 pb-0">
                        <i class="fa-regular fa-user text-white"></i>
                        <h5 class="offcanvas-title text-white text-center" id="profileBarOffcanvasLabel">
                            My Page
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#profileBar"></button>
                    </div>

                    <div class="offcanvas-body p-4 pt-0 p-lg-0">
                        <ul class="navbar-nav flex-row flex-wrap bd-navbar-nav d-none d-lg-block">
                            <li class="nav-item col-6 col-lg-auto">
                                <div class="py-2 px-0 px-lg-2">
                                    <a class="nav-link active p-0" aria-current="true" href="/<?php echo APP_ROOT;?>">
                                        <?php
                                            echo APP_NAME;
                                            if(APP_NAME == "Plutus") echo " {$_BRANCH->BrandName}";
                                        ?>
                                    </a>
                                    <?php
                                    if(APP_NAME == "Plutus")
                                    {
                                        if(count($_OTHER_BRANCHES))
                                        {
                                            echo "<div class='navbar-text text-danger fw-bold branch-name pt-0 text-decoration-underline' role='button' title='Switch Branch' onClick='TDE.defaultKendoWindowSwitchBranch.center().open();'>";
                                                echo "{$_BRANCH->CompanyId}.{$_BRANCH->Id} - {$_BRANCH->CompanyAlias} {$_BRANCH->Name}";
                                            echo "</div>";
                                        }
                                        else
                                        {
                                            echo "<div class='navbar-text text-danger fw-bold branch-name pt-0'>";
                                                echo "{$_BRANCH->CompanyId}.{$_BRANCH->Id} - {$_BRANCH->CompanyAlias} {$_BRANCH->Name}";
                                            echo "</div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                        </ul>
                        <hr class="d-lg-none text-white">

                        <ul class="navbar-nav flex-row align-items-center flex-wrap ms-md-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link py-2 px-0 px-lg-2 position-relative" role="button" href="/<?php echo APP_ROOT;?>notification">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger workerNotification"></span>
                                <i class='fa-solid fa-bell text-white'></i>
                                <small class="d-lg-none ms-2 text-white">Notification</small>
                            </a>
                        </li>
                        <li class="nav-item col-12 col-lg-auto mb-lg-0 mb-3">
                            <a class="nav-link py-2 px-0 px-lg-2" role="button" href="/<?php echo APP_ROOT;?>profile">
                                <?php
                                    $params = [
                                        "page" => "default",
                                        "group" => "default",
                                        "id" => "navbar",
                                        "employee" => $_EMPLOYEE,
                                        "size" => 20
                                    ];
                                    $avatar = new \app\components\Avatar($params);
                                    $avatar->begin();
                                    $avatar->end();
                                    $avatar->render();
                                ?>
                                <small class="d-lg-none ms-2 text-white"><?php echo $_EMPLOYEE["Name"];?></small>
                            </a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto d-lg-none">
                            <a class="nav-link py-2 px-0 px-lg-2 position-relative" role="button" href="/<?php echo APP_ROOT;?>approval">
                                <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger unreadEmailCounter"></span>
                                <i class='fa-regular fa-fw fa-envelope'></i>
                                <small class="d-lg-none ms-2 text-white">Message</small>
                            </a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto d-lg-none">
                            <a class="nav-link py-2 px-0 px-lg-2 position-relative" role="button" href="/<?php echo APP_ROOT;?>approval">
                                <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger approvalWMAPCounter"></span>
                                <i class='fa-regular fa-fw fa-thumbs-up'></i>
                                <small class="d-lg-none ms-2 text-white">Approval</small>
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
            <?php }?>
        </nav>
    </div>

    <div id="breadcrumb" class="bg-secondary d-none d-lg-block">
        <nav aria-label="breadcrumb" class="container-xxl">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a role="button" onClick="TDE.sidebar.toggle();" title="Sidebar Menu"><i class="fa-solid fa-bars"></i></a></li>
                <li class="breadcrumb-item"><a href="/<?php echo APP_ROOT;?>">Home</a></li>
                <?php
                if(isset($breadcrumbs))
                {
                    foreach($breadcrumbs AS $index => $breadcrumb)
                    {
                        echo "<li class='breadcrumb-item'><a href='/".APP_ROOT."{$breadcrumb[1]}'>$breadcrumb[0]</a></li>";
                    }
                }
                ?>
            </ol>
        </nav>
    </div>
</header>

