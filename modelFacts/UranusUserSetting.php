<?php
namespace app\modelFacts;
use app\core\ModelFact;
use app\core\Record;
use app\core\Application;

class UranusUserSetting extends ModelFact
{
    public function __construct(array $params = [])
    {
        $params["dbName"] = "uranus";
        $params["dataName"] = "UserSetting";

        parent::__construct($params);
    }

    public function getUserSettings()
    {
        $app = Application::$app;

        $userSettings = [];
        foreach($this->records AS $record)
        {
            $userSettings[$record->SettingName] = $record->SettingValue;
        }

        //AMBIL DEFAULT VALUE DARI PARAM
        $setingNames = $app->getDefaultSettingNames();
        foreach($setingNames AS $setingName)
        {
            $userSettings[$setingName] = $userSettings[$setingName] ?? $app->getDefaultSettingValue($setingName);
        }

        return $userSettings;
    }
}

class UranusUserSettingRecord extends Record
{
    public function __construct(array $params, array $record)
    {
        parent::__construct($params, $record);

        $this->initialize();
    }

#region init
    protected function initialize()
    {
        if($this->getStatusCode() != 100) return null;

        //$this->generateSomething();
    }
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getSomething(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(isset($params))$this->generateSomething($params);
        return $this->something;
    }
#endregion  getting / returning variable

#region data process
    protected function generateSomething(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $something = $this->field1;
        $something .= $this->field2;
        $this->something = $something;
    }
#endregion data process
}
