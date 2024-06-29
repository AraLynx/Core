<?php
namespace app\controllers;
use app\core\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setIsLayoutChronos(true);
        $this->setIsContentChronos(true);
        $this->setLayout('auth');
    }

    public function unauthorized()//Unauthorized
    {
        $this->setPageTitle('Security breach');
        return $this->render('_401');
    }

    public function notFound()//Not Found
    {
        $this->setPageTitle('Ooops!');
        return $this->render('_404');
    }

    public function newDay()
    {
        $this->setPageTitle('New Day, New Life...');
        return $this->render('newDay');
    }

    public function login()
    {
        $this->setJS(['login']);
        $this->setCSS(['login']);
        $this->setPageTitle('Login');

        return $this->render('login');
    }

    public function loginBranch()
    {
        $this->setJS(['loginBranch']);
        $this->setCSS(['login']);
        $this->setPageTitle('Login Branch');

        $userId = $_SESSION[APP_NAME]["login"]["userId"];
        $branches = $this->loginBranchGetCompanyBranches($userId);

        $params = [
            "user" => $this->loginBranchGetUser($userId),
            "branches" => $branches,
        ];
        //dd($params);
        if(count($branches))return $this->render('loginBranch', $params);
        else return $this->render('loginBranchNoAccess', $params);
    }
        protected function loginBranchGetCompanyBranches(int $userId)
        {
            $SP = new \app\core\StoredProcedure(APP_NAME, "SP_Sys_Auth_getCompanyBranches");
            $SP->addParameters(["UserId" => $userId]);
            $rows = $SP->f5();
            $branches = [];
            foreach($rows AS $index => $row)
            {
                //$companyId = $row["CompanyId"];
                //$companyName = $row["CompanyName"];
                $companyAlias = $row["CompanyAlias"];

                $branchId = $row["BranchId"];
                $branchName = $row["BranchName"];

                $branches[] = ["Value" => $branchId, "Text" => "{$companyAlias} - {$branchName}"];
            }
            return $branches;
        }
        protected function loginBranchGetUser(int $userId)
        {
            $model = new \app\modelAlls\UranusUser();
            $model->addParameters(["Id" => $userId]);
            $users = $model->f5();

            return $users[0];
        }
}
