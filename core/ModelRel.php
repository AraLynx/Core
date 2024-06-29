<?php
namespace app\core;

class ModelRel extends Model
{
    public function __construct(array $params)
    {
        $params["suffixName"] = "REL";

        parent::__construct($params);

        $this->initRel();
    }

    #region init
        protected function initRel(){

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
