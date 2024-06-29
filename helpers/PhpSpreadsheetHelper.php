<?php
namespace app\TDEs;
use app\core\TDE;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhpSpreadsheetHelper extends TDE
{
    protected Spreadsheet $spreadsheet;

    /* Spreadsheet ATTRIBUTES */
    protected $sheet;
    protected $style;
    protected $numberFormat;
    protected $columnDimmension;
    /* Spreadsheet ATTRIBUTES */

    protected string $fileDir;
    protected string $templateFileLink;
    protected array $isGenerateRowNumber = [];
    protected bool $rowNumberColumnIndex;

    protected array $data;
        protected array $fields;
        protected array $mapItems = [];
    protected array $dataColumns;
    protected array $isHeaderGroup = [];
    protected array $isStartHeaderGroup = [];
    protected array $headerGroupName = [];
    protected array $headerGroupCounter = [];
    protected array $headerGroups;

    protected int $startColumnIndex;
    protected int $startRowIndex;
    protected array $nowColumnIndex = [];
    protected int $nowRowIndex;
    public array $columns;
    public array $rowNumber = [];

    protected string $fileLink;
    /*
    FULL DOCUMENTATION : https://phpspreadsheet.readthedocs.io/en/latest/
    */
    public function __construct(array $params = [])
    {
        parent::__construct();
        $this->prepare("PhpSpreadsheetHelper");

        $this->fileDir = $params["fileDir"] ?? "";
        $this->templateFileLink = $params["templateFileLink"] ?? "";

        $this->startColumnIndex = $params["startColumnIndex"] ?? 0;
        $this->startRowIndex = $params["startRowIndex"] ?? 1;

        $this->isGenerateRowNumber[0] =  $params["generateRowNumber"] ?? false;
        $this->rowNumber[0] = 0;
        $this->rowNumberColumnIndex = $this->startColumnIndex;

        if(isset($params["generateRowNumber"]))
        {
            if(is_int($params["generateRowNumber"]))
                $this->rowNumberColumnIndex = $params["generateRowNumber"];
        }

        if(isset($params["data"]))
            $this->setData($params["data"]);

        $this->init();
    }

    #region init
        protected function init()
        {
            if($this->getStatusCode() != 100) return null;

            $this->nowColumnIndex[0] = $this->startColumnIndex;
            if(isset($this->rowNumberColumnIndex))$this->nowColumnIndex[0] = $this->rowNumberColumnIndex + 1;
            $this->nowRowIndex = $this->startRowIndex;

            if($this->templateFileLink)
            {
                $this->templateSpreadsheet();
            }
            else
            {
                $this->newSpreadsheet();
            }
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function newSpreadsheet()
        {
            if($this->getStatusCode() != 100) return null;
            $this->spreadsheet = new Spreadsheet();
            $this->sheet = $this->spreadsheet->getActiveSheet();
        }
        public function setTemplate(string $templateFileLink)
        {
            if($this->getStatusCode() != 100) return null;
            $this->templateFileLink = $templateFileLink;
            $this->templateSpreadsheet();
        }
            protected function templateSpreadsheet()
            {
                if($this->getStatusCode() != 100) return null;
                $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->templateFileLink);
                $this->sheet = $this->spreadsheet->getActiveSheet();
            }
        public function setFileDir(string $fileDir)
        {
            if($this->getStatusCode() != 100) return null;
            $this->fileDir = $fileDir;
        }
        public function setIsGenerateRowNumber(int $columnIndex = NULL)
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            $this->isGenerateRowNumber[$dataIndex] =  true;
            $this->rowNumber[$dataIndex] = 0;
            $this->rowNumberColumnIndex = $columnIndex ?? $this->startColumnIndex;
            $this->nowColumnIndex[$dataIndex] = $this->rowNumberColumnIndex + 1;
        }
        public function setData(array $data)
        {
            if($this->getStatusCode() != 100) return null;
            $this->data = $data;
            $this->setFields();
        }
            protected function setFields()
            {
                if($this->getStatusCode() != 100) return null;
                $this->fields = array_keys($this->data[0]);
            }
        public function setNowColumnIndex(int $columnIndex)
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            $this->nowColumnIndex[$dataIndex] = $columnIndex;
        }
        public function setNowRowIndex(int $rowIndex)
        {
            if($this->getStatusCode() != 100) return null;
            $this->nowRowIndex = $rowIndex;
        }
        public function setNextNowRowIndex()
        {
            if($this->getStatusCode() != 100) return null;
            $this->nowRowIndex++;
        }
        public function setNextNowColumnIndex()
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            $this->nowColumnIndex[$dataIndex]++;
        }
        public function setMapItems(string $key = "Items")
        {
            if($this->getStatusCode() != 100) return null;

            $this->mapItems[] = $key;

            $dataIndex = $this->getDataIndex();

            $this->isGenerateRowNumber[$dataIndex] =  false;
            $this->rowNumber[$dataIndex] = 0;
            $this->nowColumnIndex[$dataIndex] = $this->startColumnIndex + $dataIndex;
            $this->dataColumns[$dataIndex] = [];

            return $this;
        }
    #endregion setting variable

    #region getting / returning variable
        protected function getRowNumber($dataIndex = 0)
        {
            if($this->getStatusCode() != 100) return null;

            $this->rowNumber[$dataIndex]++;
            return $this->rowNumber[$dataIndex];
        }
        public function getNowColumnIndex($dataIndex = 0)
        {
            if($this->getStatusCode() != 100) return null;

            return $this->nowColumnIndex[$dataIndex];
        }
        public function getNowRowIndex()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->nowRowIndex;
        }
        public function getFileLink()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->fileLink;
        }
        public function getNumToAlpha($num)
        {
            if($this->getStatusCode() != 100) return null;
            return $this->numToAlpha($num);
        }
        protected function getDataIndex()
        {
            if($this->getStatusCode() != 100) return null;
            return count($this->mapItems);
        }
    #endregion  getting / returning variable

    #region parsing method
        //spreadsheet
        public function createSheet(string $sheetName = "")
        {
            if($this->getStatusCode() != 100) return null;

            $this->spreadsheet->createSheet();

            $sheetCount = $this->spreadsheet->getSheetCount();
            $sheetIndex = $sheetCount - 1;
            $this->spreadsheet->setActiveSheetIndex($sheetIndex);
            $this->sheet = $this->spreadsheet->getActiveSheet();

            if($sheetName)$this->setSheetName($sheetName);
            //echo $sheetIndex;
            return $this;
        }
        public function setSheetName(string $sheetName)
        {
            if($this->getStatusCode() != 100) return null;
            $this->sheet->setTitle($sheetName);
            return $this;
        }
        public function setActiveSheetIndex(int $index)
        {
            if($this->getStatusCode() != 100) return null;
            $this->spreadsheet->setActiveSheetIndex($index);
            return $this;
        }

        //sheet
        public function setCellValue($cell, $value)
        {
            if($this->getStatusCode() != 100) return null;
            $this->sheet->setCellValue($cell, $value);
        }
        public function setCellValueExplicit($cell, $value, $dataType)
        {
            if($this->getStatusCode() != 100) return null;
            $this->sheet->setCellValueExplicit($cell, $value, $dataType);
        }
        public function mergeCells(string $cellRange)
        {
            if($this->getStatusCode() != 100) return null;
            $this->sheet->mergeCells($cellRange);
        }
        public function getColumnDimension(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;
            $this->columnDimmension = $this->sheet->getColumnDimension($columnName);
            return $this->columnDimmension;
        }
            public function setAutoSize(bool $bool)
            {
                if($this->getStatusCode() != 100) return null;
                $this->columnDimmension->setAutoSize($bool);
            }
        public function getStyle($cell)
        {
            if($this->getStatusCode() != 100) return null;
            $this->style = $this->sheet->getStyle($cell);
            return $this->style;
        }
            public function getNumberFormat()
            {
                if($this->getStatusCode() != 100) return null;
                $this->numberFormat = $this->style->getNumberFormat();
                return $this->numberFormat;
            }
                public function setFormatCode($format)
                {
                    if($this->getStatusCode() != 100) return null;
                    $this->numberFormat->setFormatCode($format);
                }
            public function applyFromArray(array $fontStyle)
            {
                if($this->getStatusCode() != 100) return null;
                $this->style->applyFromArray($fontStyle);
            }
    #endregion parsing method

    #region data process
        protected function numToAlpha($num)
        {
            if($this->getStatusCode() != 100) return null;
            $numeric = $num % 26;
            $letter = chr(65 + $numeric);
            $num2 = intval($num / 26);
            if ($num2 > 0) {
                return $this->numToAlpha($num2 - 1) . $letter;
            } else {
                return $letter;
            }
        }
        protected function alphaToNum($a)
        {
            if($this->getStatusCode() != 100) return null;
            $a = strtoupper($a);
            $num = 0;
            $strarray = array_reverse(str_split($a));
            for($i = 0 ; $i < strlen($a) ; $i++)
            {
                $num += (ord($strarray[$i])-64) * pow(26,$i);
            }
            $num = $num - 1;
            return $num;
        }
        public function generateHeader(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            $columnIndex = $params["columnIndex"] ?? $this->nowColumnIndex[$dataIndex];
            $rowIndex = $params["rowIndex"] ?? $this->nowRowIndex;
            $titleText = $params["titleText"] ?? "Report";
            $mergeCellCount = $params["mergeCellCount"] ?? 0;
            $infos = $params["infos"] ?? [];

            $cell = $this->numToAlpha($columnIndex).$rowIndex;
            $titleStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ["rgb" => "FF0000"]
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ];
            if($mergeCellCount)
            {
                $toCell = $this->numToAlpha($columnIndex+$mergeCellCount).$rowIndex;
                $this->mergeCells("{$cell}:{$toCell}");
            }

            $this->setCellValue($cell, $titleText);
            $this->getStyle($cell)->applyFromArray($titleStyle);

            $this->nowRowIndex = $rowIndex + 1;
            if(count($infos))
            {
                foreach($infos AS $index => $value)
                {
                    $cellDesc = $this->numToAlpha($this->startColumnIndex).$this->nowRowIndex;
                    $cellInfo = $this->numToAlpha($this->startColumnIndex + 1).$this->nowRowIndex;

                    if($mergeCellCount)
                    {
                        $toCell = $this->numToAlpha($columnIndex+$mergeCellCount).$this->nowRowIndex;
                        $this->mergeCells("{$cellInfo}:{$toCell}");
                    }

                    if($index == "_callerOrigin" && $value == true)
                    {
                        $this->setCellValue($cellDesc, "Origin");
                        $this->setCellValue($cellInfo, $_SERVER["HTTP_REFERER"]);
                    }
                    else if($index == "_createdByUserId" && $value)
                    {
                        $model = new \app\ModelAlls\UranusUser();
                        $model->addParameters(["Id" => $value]);
                        $records = $model->F5();
                        $user = $records[0];

                        $this->setCellValue($cellDesc, "Created by");
                        $this->setCellValue($cellInfo, "({$user->EmployeeId}) {$user->Name}");
                    }
                    else if($index == "_createdByEmployeeId" && $value)
                    {
                        $model = new \app\ModelAlls\UranusEmployee_Detail();
                        $model->addParameters(["Id" => $value]);
                        $records = $model->F5();
                        $employee = $records[0];

                        $this->setCellValue($cellDesc, "Created by");
                        $this->setCellValue($cellInfo, "({$value}) {$employee->Name}");
                    }
                    else if($index == "_createdDateTime" && $value == true)
                    {
                        $this->setCellValue($cellDesc, "Created at");
                        $this->setCellValue($cellInfo, date("Y-m-d H:i:s"));
                    }


                    else
                    {
                        $this->setCellValue($cellDesc, $index);
                        $this->setCellValue($cellInfo, $value);
                    }
                    $this->nowRowIndex++;
                }
            }
            $this->nowRowIndex++;

            return $this;
        }
        public function generateFooter(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;
            $type = $params["type"] ?? "signature";
            $params["startColumn"] = $params["startColumn"] ?? 1;

            $this->nowRowIndex = $this->nowRowIndex + 2;
            if($type == "signature")$this->generateFooterSignature($params);

            return $this;
        }
            protected function generateFooterSignature(array $params = [])
            {
                if($this->getStatusCode() != 100) return null;

                $signatures = $params["signatures"] ?? [];
                $signatureRow = $params["signatureRow"] ?? 5;

                $nowRowIndex = $this->nowRowIndex;

                foreach($signatures AS $index => $signature)
                {
                    $title = "";
                    $name = "";
                    if(is_array($signature))
                    {
                        $title = $signature[0];
                        $name = $signature[1] ?? "";
                    }
                    else
                    {
                        $title = $signature;
                    }

                    $nameIsShow = $params["nameIsShow"] ?? ($name ? true : false);
                    if($nameIsShow && !$name) $name = $title;

                    $cellTitle = $this->numToAlpha($params["startColumn"] + $index).$nowRowIndex;
                    $cellName = $this->numToAlpha($params["startColumn"] + $index).($nowRowIndex + $signatureRow + 1);

                    $this->setCellValue($cellTitle, $title);
                    if($signatureRow > 1)
                    {
                        $cellSignatureStart = $this->numToAlpha($params["startColumn"] + $index).($nowRowIndex + 1);
                        $cellSignatureEnd = $this->numToAlpha($params["startColumn"] + $index).($nowRowIndex + $signatureRow);
                        $this->mergeCells("{$cellSignatureStart}:{$cellSignatureEnd}");
                        $this->getStyle("{$cellSignatureStart}:{$cellSignatureEnd}")->applyFromArray($this->getSignatureStyle());
                    }
                    if($nameIsShow && $name)$this->setCellValue($cellName, $name);


                    $this->getStyle($cellTitle)->applyFromArray($this->getSignatureStyle());
                    $this->getStyle($cellName)->applyFromArray($this->getSignatureStyle());
                }
                $this->nowRowIndex = $this->nowRowIndex + 1 + $signatureRow + 1;
            }
        public function map($fieldsAndColumnName, array $params = NULL)
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            if(is_string($fieldsAndColumnName))
            {
                $fields = $fieldsAndColumnName;
                $columnName = $fieldsAndColumnName;
            }
            else if(is_array($fieldsAndColumnName) && count($fieldsAndColumnName) == 2)
            {
                $fields = $fieldsAndColumnName[0];
                $columnName = $fieldsAndColumnName[1];
            }

            $columnIndex = $params["columnIndex"] ?? $this->nowColumnIndex[$dataIndex];
            unset($params["columnIndex"]);

            $this->dataColumns[$dataIndex][$columnIndex] = [
                "fields" => $fields,
                "columnName" => $columnName,
                "params" => $params,
                "headerGroup" => $this->headerGroupName[$dataIndex] ?? ""
            ];

            if(isset($this->isHeaderGroup[$dataIndex]) && isset($this->headerGroupName[$dataIndex]))
            {
                if(!isset($this->headerGroups[$dataIndex][$this->headerGroupCounter[$dataIndex]]))
                {
                    $this->headerGroups[$dataIndex][$this->headerGroupCounter[$dataIndex]] = [
                        "name" => $this->headerGroupName[$dataIndex],
                        "startIndex" => $columnIndex,
                        "endIndex" => 0,
                        "columns" => [],
                    ];
                }
                $this->headerGroups[$dataIndex][$this->headerGroupCounter[$dataIndex]]["endIndex"] = $columnIndex;
                $this->headerGroups[$dataIndex][$this->headerGroupCounter[$dataIndex]]["columns"][] = $fields;
            }

            $this->nowColumnIndex[$dataIndex] = $columnIndex;
            $this->nowColumnIndex[$dataIndex]++;

            return $this;
        }
        public function startHeaderGroup(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            if(isset($this->isStartHeaderGroup[$dataIndex]))$this->endHeaderGroup();

            if(!isset($this->isHeaderGroup[$dataIndex]) || !$this->isHeaderGroup[$dataIndex])
            {
                $this->isHeaderGroup[$dataIndex] = true;
                $this->headerGroups[$dataIndex] = [];
                $this->headerGroupCounter[$dataIndex] = 0;
            }

            $this->isStartHeaderGroup[$dataIndex] = true;
            $this->headerGroupName[$dataIndex] = $columnName;

            return $this;
        }
        public function endHeaderGroup()
        {
            if($this->getStatusCode() != 100) return null;

            $dataIndex = $this->getDataIndex();

            $this->isStartHeaderGroup[$dataIndex] = false;
            $this->headerGroupName[$dataIndex] = "";
            $this->headerGroupCounter[$dataIndex]++;

            return $this;
        }

        public function renderData(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $data = $params["data"] ?? $this->data;
            $dataIndex = $params["dataIndex"] ?? 0;

            #region generate header column
                if(isset($this->isHeaderGroup[$dataIndex]) && $this->isHeaderGroup[$dataIndex])
                {
                    if($this->isStartHeaderGroup[$dataIndex])$this->endHeaderGroup();
                    foreach($this->headerGroups[$dataIndex] AS $index => $headerGroup)
                    {
                        $headerName = $headerGroup["name"];
                        $headerStartIndex = $headerGroup["startIndex"];
                        $headerEndIndex = $headerGroup["endIndex"];

                        $startCell = $this->numToAlpha($headerStartIndex).$this->nowRowIndex;
                        $endCell = $this->numToAlpha($headerEndIndex).$this->nowRowIndex;
                        $this->mergeCells("{$startCell}:{$endCell}");
                        $this->setCellValue($startCell, $headerName);
                        $this->getStyle($startCell)->applyFromArray($this->getHeaderStyle());
                    }

                    $this->nowRowIndex++;
                }
                if($this->isGenerateRowNumber[$dataIndex])
                {
                    if(isset($this->isHeaderGroup[$dataIndex]) && $this->isHeaderGroup[$dataIndex])
                    {
                        $startCell = $this->numToAlpha($this->rowNumberColumnIndex).($this->nowRowIndex-1);
                        $endCell = $this->numToAlpha($this->rowNumberColumnIndex).$this->nowRowIndex;
                        $this->mergeCells("{$startCell}:{$endCell}");

                        $cell = $this->numToAlpha($this->rowNumberColumnIndex).($this->nowRowIndex-1);
                    }
                    else
                        $cell = $this->numToAlpha($this->rowNumberColumnIndex).$this->nowRowIndex;

                    $this->setCellValue($cell, "No");
                    $this->getStyle($cell)->applyFromArray($this->getHeaderStyle());
                }
                foreach($this->dataColumns[$dataIndex] AS $columnIndex => $dataColumn)
                {
                    if(isset($this->isHeaderGroup[$dataIndex]) && $this->isHeaderGroup[$dataIndex] && !$dataColumn["headerGroup"])
                    {
                        $startCell = $this->numToAlpha($columnIndex).($this->nowRowIndex-1);
                        $endCell = $this->numToAlpha($columnIndex).$this->nowRowIndex;
                        $this->mergeCells("{$startCell}:{$endCell}");

                        $cell = $this->numToAlpha($columnIndex).($this->nowRowIndex-1);
                    }
                    else
                        $cell = $this->numToAlpha($columnIndex).$this->nowRowIndex;

                    $columnName = $dataColumn["columnName"];
                    $this->setCellValue($cell, $columnName);
                    $this->getStyle($cell)->applyFromArray($this->getHeaderStyle());
                }
                $this->nowRowIndex++;
            #endregion generate header column

            $isAggregate = false;
            $aggregateColumns = [];
            $sums = [];
            $counts = [];
            $countas = [];
            //looping each data
            foreach($data AS $index => $row)
            {
                if($this->isGenerateRowNumber[$dataIndex])
                {
                    $cell = $this->numToAlpha($this->rowNumberColumnIndex).$this->nowRowIndex;
                    $this->setCellValue($cell, $this->getRowNumber($dataIndex));
                }
                foreach($this->dataColumns[$dataIndex] AS $columnIndex => $dataColumn)
                {
                    $cell = $this->numToAlpha($columnIndex).$this->nowRowIndex;
                    $fields = $dataColumn["fields"];
                    $params = $dataColumn["params"];

                    if(is_array($fields))
                    {
                        $glue = $params["glue"] ?? " ";
                        $values = [];
                        foreach($fields AS $index => $field)
                        {
                            if($row[$field])$values[] = $row[$field];
                        }
                        $value = implode($glue, $values);
                    }
                    else
                    {
                        $value = $row[$fields];
                    }

                    #region params
                        if(isset($params["replace"]))
                        {
                            $search = $params["replace"][0];
                            $replace = $params["replace"][1];

                            $value = str_replace($search, $replace, $value);
                        }
                    #endregion params

                    #region formatCell
                        if(isset($params["formatCell"]))
                        {
                            $formatCell = $params["formatCell"];
                            if($formatCell == "numeric")
                            {
                                $value = (int)$value;
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "dec1")
                            {
                                $value = round(floatval($value),1);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.0');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "dec2" || $formatCell == "dec")
                            {
                                $value = round(floatval($value),2);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "dec3")
                            {
                                $value = round(floatval($value),3);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.000');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "dec4")
                            {
                                $value = round(floatval($value),4);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.0000');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "percentage")
                            {
                                $value = round(floatval($value),2);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00 %');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "currency")
                            {
                                $value = round(floatval($value),2);
                                $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
                                $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            }
                            if($formatCell == "date")
                            {
                                $this->setCellValueExplicit($cell, substr($value,0,10), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            }
                            if($formatCell == "time")
                            {
                                $this->setCellValueExplicit($cell, substr($value,0,8), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            }
                            if($formatCell == "dateTime")
                            {
                                $this->setCellValueExplicit($cell, substr($value,0,19), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            }
                        }
                        else
                        {
                            $this->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        }
                    #endregion formatCell

                    #region aggreagate
                        if(isset($params["aggregate"]))
                        {
                            $isAggregate = true;
                            $aggregateColumns[$columnIndex] = $params["aggregate"];

                            if($params["aggregate"] == "sum")
                            {
                                if(!isset($sums[$columnIndex]))$sums[$columnIndex] = 0;
                                $sums[$columnIndex] += $value;
                            }
                            if($params["aggregate"] == "count")
                            {
                                if(!isset($counts[$columnIndex]))$counts[$columnIndex] = 0;
                                $counts[$columnIndex]++;
                            }
                            if($params["aggregate"] == "counta")
                            {
                                if(!isset($countas[$columnIndex]))$countas[$columnIndex] = 0;
                                if($value)$countas[$columnIndex]++;
                            }
                        }
                    #endregion aggregate
                }

                $this->nowRowIndex++;

                if($this->getDataIndex() > $dataIndex)
                {
                    $nextDataIndex = $dataIndex + 1;
                    $key = $this->mapItems[($nextDataIndex - 1)];
                    //dd($this->mapItems);
                    $nextData = $row[$key];
                    if(count($nextData))
                    {
                        $this->renderData([
                            "data" => $nextData
                            ,"dataIndex" => $nextDataIndex
                        ]);
                        $this->nowRowIndex++;
                    }
                }
            }
            if($isAggregate)
            {
                $footerStyle = ['font' => ['bold' => true]];
                foreach($aggregateColumns AS $columnIndex => $aggregate)
                {
                    $cell= $this->numToAlpha($columnIndex).$this->nowRowIndex;
                    if($aggregate == "sum")
                    {
                        $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
                        $this->setCellValueExplicit($cell, $sums[$columnIndex], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                        $this->getStyle($cell)->applyFromArray($footerStyle);
                    }
                    if($aggregate == "count")
                    {
                        $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
                        $this->setCellValueExplicit($cell, $counts[$columnIndex], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                        $this->getStyle($cell)->applyFromArray($footerStyle);
                    }
                    if($aggregate == "counta")
                    {
                        $style = $this->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
                        $this->setCellValueExplicit($cell, $countas[$columnIndex], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                        $this->getStyle($cell)->applyFromArray($footerStyle);
                    }
                }
            }
            //looping each data
            if(!$dataIndex) return $this;
        }
        public function getHeaderStyle()
        {
            return [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ];
        }
        public function getSignatureStyle()
        {
            return [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        //'color' => array('argb' => 'FFFF0000')
                    ]
                ]
            ];
        }
        public function autoSize()
        {
            if($this->getStatusCode() != 100) return null;

            for($dataIndex = 0 ; $dataIndex <= count($this->mapItems) ; $dataIndex++)
            {
                for($columnIndex = 0 ; $columnIndex <= $this->nowColumnIndex[$dataIndex] ; $columnIndex++)
                {
                    $this->sheet->getColumnDimension("{$this->numToAlpha($columnIndex)}")->setAutoSize(true);
                }
            }
            return $this;
        }
        public function end()
        {
            if($this->getStatusCode() != 100) return null;

            $cacheDir = "/".APP_NAME."/cache";
            $PhpSpreadsheetHelperDir = "/PhpSpreadsheetHelper";

            $tempDir = dirname(__DIR__,2).$cacheDir;
            if(!is_dir($tempDir))mkdir($tempDir);//GENERATE Archives FOLDER

            $tempDir .= $PhpSpreadsheetHelperDir;
            if(!is_dir($tempDir))mkdir($tempDir);//GENERATE Archives/PhpSpreadsheetHelper FOLDER

            $fileLink = "/".TDE_ROOT.$cacheDir;
            $fileLink .= $PhpSpreadsheetHelperDir;

            $fileDirArray = explode("/", $this->fileDir);
            foreach($fileDirArray AS $folder)
            {
                $tempDir .= "/".$folder;
                $fileLink .= "/".$folder;
                if(!is_dir($tempDir))mkdir($tempDir);
            }


            $now = \DateTime::createFromFormat('U.u', microtime(true));
            $now->setTimeZone(new \DateTimeZone('Asia/Jakarta'));
            $fileName = "{$now->format("Ymd_His_u")}.xlsx";
            $fileSave = "{$tempDir}/{$fileName}";
            $fileLink .= "/{$fileName}";

            $writer = new Xlsx($this->spreadsheet);
            $writer->save($fileSave);

            $this->fileLink = $fileLink;

            return $this;
        }
    #endregion data process
}
