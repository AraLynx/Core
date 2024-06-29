<?php
namespace app\TDEs;
use app\core\TDE;

class TDETemplate extends TDE
{
    public function __construct()
    {
        parent::__construct();
        $this->prepare("TDETemplate");
    }

    public function someFunction()
    {
        if($this->getStatusCode() != 100) return null;

        //do something
    }

#region init
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
#endregion data process
}
