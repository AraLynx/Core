<?php
namespace app\core;

class ModelFact extends Model
{
    public function __construct(array $params)
    {
        $params["suffixName"] = "FACT";

        parent::__construct($params);

        $this->initFact();
    }

    #region init
        protected function initFact(){

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
