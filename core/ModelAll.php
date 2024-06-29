<?php
namespace app\core;

class ModelAll extends Model
{
    public function __construct(array $params)
    {
        $params["suffixName"] = "ALL";
        $params["isGenerateDim"] = false;

        parent::__construct($params);

        $this->initAll();
    }

    #region init
        protected function initAll(){

        }
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
