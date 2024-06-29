<?php
namespace app\core;

class ModelDim extends Model
{
    protected bool $record_isGenerateSelectValueAndText;
    public array $selectValuesAndTexts;
    public function __construct(array $params)
    {
        $params["suffixName"] = "DIM";

        $this->record_isGenerateSelectValueAndText = $params["isGenerateSelectValueAndText"] ?? true;

        $params["recordParams"]["isGenerateSelectValueAndText"] = $this->record_isGenerateSelectValueAndText;
        parent::__construct($params);

        $this->initDim();
    }

    #region init
        protected function initDim()
        {
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
        public function getSelectValuesAndTexts()
        {
            if($this->getStatusCode() != 100) return null;

            if(!isset($selectValuesAndTexts)) $this->generateSelectValuesAndTexts();

            return $this->selectValuesAndTexts;

        }
    #endregion  getting / returning variable

    #region data process
        protected function generateSelectValuesAndTexts(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            foreach($this->records AS $index => $record)
            {
                $this->selectValuesAndTexts[] = $record->selectValueAndText;
            }
        }
    #endregion data process

}
