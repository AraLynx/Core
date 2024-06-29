<?php
namespace app\core;

class Response
{
    public function __construct()
    {

    }

    #region init
    #endregion init

    #region set status
        public function setStatusCode(int $code)
        {
            http_response_code($code);
        }
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
    #endregion data process


}
