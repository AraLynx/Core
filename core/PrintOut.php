<?php
namespace app\core;

class PrintOut
{
    protected Application $app;

    protected array $cbpProfile;
    protected string $headerHtml;
    protected string $footerHtml;
    protected int $companyId;
    protected int $brandId;
    protected int $branchId;
    protected int $posId;

    protected int $page;

    public function __construct(array $params = [])
    {
        $this->app = Application::$app;

        $this->brandId = $params["brandId"] ?? $params["cbpProfile"]["BrandId"] ?? 0;
        $this->companyId = $params["companyId"] ?? $params["cbpProfile"]["CompanyId"] ?? 0;
        $this->branchId = $params["branchId"] ?? $params["cbpProfile"]["BranchId"] ?? 0;
        $this->posId = $params["posId"] ?? $params["cbpProfile"]["POSId"] ?? 0;

        $this->brandName = $params["brandName"] ?? $params["cbpProfile"]["BrandName"] ?? "";
        $this->companyName = $params["companyName"] ?? $params["cbpProfile"]["CompanyName"] ?? "TRI MANDIRI GROUP";
        $this->companyAlias = $params["companyAlias"] ?? $params["cbpProfile"]["CompanyAlias"] ?? "TMS";
        $this->branchName = $params["branchName"] ?? $params["cbpProfile"]["BranchName"] ?? "";
        $this->posName = $params["posName"] ?? $params["cbpProfile"]["POSName"] ?? "";

        $this->addressName = $params["addressName"] ?? $params["cbpProfile"]["AddressName"] ?? "";
        $this->addressLine1 = $params["branchAddressLine1"] ?? $params["cbpProfile"]["AddressLine1"] ?? "";
        $this->addressLine2 = $params["branchAddressLine2"] ?? $params["cbpProfile"]["AddressLine2"] ?? "";
        $this->addressKelurahan = $params["branchAddressKelurahan"] ?? $params["cbpProfile"]["AddressKelurahan"] ?? "";
        $this->addressKecamatan = $params["branchAddressKecamatan"] ?? $params["cbpProfile"]["AddressKecamatan"] ?? "";
        $this->addressKabupaten = $params["branchAddressKabupaten"] ?? $params["cbpProfile"]["AddressKabupaten"] ?? "";
        $this->addressPropinsi = $params["branchAddressPropinsi"] ?? $params["cbpProfile"]["AddressPropinsi"] ?? "";
        $this->addressKodePos = $params["branchAddressKodePos"] ?? $params["cbpProfile"]["AddressKodePos"] ?? "";
        $this->telp = $params["branchTelp"] ?? $params["cbpProfile"]["Telp"] ?? "";
        $this->fax = $params["branchFax"] ?? $params["cbpProfile"]["Fax"] ?? "";
        $this->NPWP = $params["branchNPWP"] ?? $params["cbpProfile"]["NPWP"] ?? "";
        $this->PKP = $params["branchPKP"] ?? $params["cbpProfile"]["PKP"] ?? "";

        $this->documentTitle = $params["documentTitle"] ?? "Dokumen";
        $this->documentDate = (isset($params["documentDate"]) ? \DateTime::createFromFormat('Y-m-d H:i:s', $params["documentDate"])->format('j F Y') : date("j F Y"));
        $this->documentNumber = $params["documentNumber"] ?? "";
        $this->documentAdditionalInfo = $params["documentAdditionalInfo"] ?? "";

        $this->isDotMatrix = $params["isDotMatrix"] ?? false;

        $this->paperSize = $params["paperSize"] ?? "A4";
        $this->itemMaxCount = $params["itemMaxCount"] ?? 15;
        $this->itemCountForHeader = $params["itemCountForHeader"] ?? 1;
        $this->itemCountForFooter = $params["itemCountForFooter"] ?? 1;

        $this->smallPaperSize = $params["smallPaperSize"] ?? $this->paperSize;
        $this->itemMaxCountForSmallPaperSize = $params["itemMaxCountForSmallPaperSize"] ?? 0;

        $this->items = $params["items"] ?? [];

        $this->footerFootNote = $params["footerFootNote"] ?? "";
        $this->footerSignatures = $params["footerSignatures"] ?? [];

        $this->headerHtml = "";
        $this->footerHtml = "";
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    public function methode1()
    {
        if($this->getStatusCode() != 100) return null;

        //DO SOMETHING
    }

#region init
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getHeader(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $this->generateHeader($params);

        return $this->headerHtml;
    }
    public function getFooter(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $this->generateFooter($params);

        return $this->footerHtml;
    }
    public function getPrepareView()
    {
        if($this->getStatusCode() != 100) return null;

        if(count($this->items) > $this->itemMaxCountForSmallPaperSize)
            $paperSize = $this->paperSize;
        else
            $paperSize = $this->smallPaperSize;

        $return = "<style>@page { size: '{$paperSize}'}</style>";
        $return .= "<script>
                $(document).ready(function(){
                    $('body').addClass('{$paperSize}');
                });
            </script>";
        if($this->isDotMatrix)
        {
            $return .= "<script>
                    $(document).ready(function(){
                        $('body').addClass('dotmatrix');
                    });
                </script>";
        }
        return $return;
    }
#endregion  getting / returning variable

#region data process
    #region generateHeader
        protected function generateHeader(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $page = $params["page"] ?? 0;
            $logo = $params["logo"] ?? [];
            $address = $params["address"] ?? [];
            $documentType = $params["documentType"] ?? [];

            $address["page"] = $page;
            $documentType["page"] = $page;

            $isHr = $params["isHr"] ?? true;

            $this->headerHtml = "<div class='print_header'>";
                $this->generateLogo($logo);
                $this->headerHtml .= "<div class='d-flex justify-content-between'>";
                    $this->generateAddress($address);
                    $this->generateDocumentType($documentType);
                $this->headerHtml .= "</div>";
                if($isHr)$this->headerHtml .= "<hr/>";
            $this->headerHtml .="</div>";
        }
            protected function generateLogo(array $params = [])
            {
                if($this->getStatusCode() != 100) return null;

                $isShow = $params["isShow"] ?? true;
                $type = $params["type"] ?? "old";
                $isShowBrand = $params["isShowBrand"] ?? ($type == "brand" ? false : true);

                if($isShow)
                {
                    $this->headerHtml .= "<div class='d-flex justify-content-between'>";
                        $this->headerHtml .= "<div class='logo_left'>";
                            if($type == "old")
                            {
                                $this->headerHtml .= "<img class='logo_image' src='/".COMMON_IMAGE."company/old_{$this->companyId}.png'/>";
                            }
                            else if($type == "new")
                            {
                                $this->headerHtml .= "<img class='logo_image' src='/".COMMON_IMAGE."company/new_{$this->companyId}.png'/>";
                            }
                        $this->headerHtml .="</div>";

                        $this->headerHtml .= "<div class='logo_right'>";
                            if($isShowBrand)
                            {
                                $this->headerHtml .= "<img class='logo_image' src='/".COMMON_IMAGE."brand/{$this->brandId}.png'/>";
                            }
                        $this->headerHtml .="</div>";
                    $this->headerHtml .= "</div>";
                }
            }
            protected function generateAddress(array $params = [])
            {
                if($this->getStatusCode() != 100) return null;

                $page = $params["page"];

                $this->headerHtml .= "<div class='header_address'>";
                    $this->headerHtml .= "<div class='company_name h5'>PT {$this->companyName}</div>";
                    $this->headerHtml .= "<div class='branch_name fw-bold'>{$this->branchName}</div>";
                    if(!$page)
                    {
                        $this->headerHtml .= "<div class='branch_address'>";
                            $this->headerHtml .= "{$this->addressLine1}";
                            if($this->addressLine2)$this->headerHtml .= "<br/>{$this->addressLine2}";
                            $this->headerHtml .= "<br/>{$this->addressKelurahan}, {$this->addressKecamatan}";
                            if($this->addressKodePos)$this->headerHtml .= ", {$this->addressKodePos}";
                        $this->headerHtml .= "</div>";
                        $this->headerHtml .= "<div class='branch_telpfax'>";
                            $this->headerHtml .= "Telp. {$this->telp}";
                            if($this->fax)$this->headerHtml .= "| Fax. {$this->fax}";
                        $this->headerHtml .= "</div>";
                    }
                    else
                    {

                    }
                $this->headerHtml .="</div>";
            }
            protected function generateDocumentType(array $params)
            {
                if($this->getStatusCode() != 100) return null;

                $page = $params["page"];

                $this->headerHtml .= "<div class='header_documentType text-end'>";
                    $this->headerHtml .= "<div class='document_title'><p class='text-center h5'>{$this->documentTitle}</p></div>";
                    if(!$page)
                    {
                        $this->headerHtml .= "<div class='document_date'>Tanggal {$this->documentDate}</div>";
                        if($this->documentNumber)$this->headerHtml .= "<div class='document_number'><p class='fw-bold'>{$this->documentNumber}</p></div>";
                        if($this->documentAdditionalInfo)$this->headerHtml .= "<div class='document_additionalInfo'>{$this->documentAdditionalInfo}</div>";
                    }
                    else
                    {
                        if($this->documentNumber)$this->headerHtml .= "<div class='document_number'><p class='fw-bold'>{$this->documentNumber}</p></div>";
                    }
                $this->headerHtml .="</div>";
            }
    #endregion generateHeader

    public function generateItems(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $return = [];

        $this->page = 0;
        $itemMaxCount = $this->itemMaxCount - $this->itemCountForHeader;
        $return[$this->page] = [];

        $itemCount = count($this->items);
        $itemCounter = 0;

        $maxItemIfOnePage = $this->itemMaxCount - $this->itemCountForHeader - $this->itemCountForFooter;

        if($itemCount <= $maxItemIfOnePage)
        {
            $return[$this->page] = $this->items;
        }
        else
        {
            $lastPageIsCreated = false;
            foreach($this->items AS $item)
            {
                //echo "item {$itemCounter} ";
                $itemCountInPage = count($return[$this->page]);
                //echo "> item in page {$itemCountInPage}, max item in page {$this->page} is {$itemMaxCount}";
                if($itemCountInPage + 1 > $itemMaxCount)
                {
                    $this->page++;
                    $return[$this->page] = [];

                    $itemAlreadySlottedIn = $itemCounter;
                    $itemWaiting = $itemCount - $itemAlreadySlottedIn;

                    if($itemWaiting <= $this->itemMaxCount - $this->itemCountForFooter)
                    {
                        $itemMaxCount = $this->itemMaxCount -  $this->itemCountForFooter;
                        $lastPageIsCreated = true;
                    }
                    else
                        $itemMaxCount = $this->itemMaxCount;

                    //echo "> item wont fit, create new page {$this->page} with max of {$itemMaxCount}";
                }

                $return[$this->page][] = $item;
                //echo "> insert into page {$this->page}";

                $itemCounter++;
                //echo "<br/>";
            }
            if(!$lastPageIsCreated)
            {
                //crete last page if not already created
                $this->page++;
                $return[$this->page] = [];
            }
        }
        return $return;
    }

    #region generateFooter
        protected function generateFooter(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $page = $params["page"] ?? 0;

            $isSignature = false;
            if(count($this->footerSignatures))$isSignature = true;

            $this->footerHtml = "<div class='print_footer'>";
                if($isSignature)$this->generateSignature($page);
                $this->footerHtml .= "<hr/>";
                $this->footerHtml .= "<div class='footer_lastrow'>";
                    $this->footerHtml .= "<div class='row'>";
                        $this->generateFootNote();
                        $this->generatePagination($page);
                    $this->footerHtml .="</div>";
                $this->footerHtml .="</div>";
            $this->footerHtml .="</div>";
        }
            protected function generateSignature(int $page)
            {
                if($this->getStatusCode() != 100) return null;

                if($page == $this->page && count($this->footerSignatures))
                {
                    $this->footerHtml .= "<div class='footer_signature'>";
                        $this->footerHtml .= "<div class='row'>";
                        foreach($this->footerSignatures AS $signature)
                        {
                            $brCount = $signature["brCount"] ?? 5;
                            $this->footerHtml .= "<div class='col'><p class='text-center'>";
                                if(isset($signature["title"]))$this->footerHtml .= $signature["title"];
                                for($brCounter = 0 ; $brCounter < $brCount ; $brCounter++)
                                {
                                    $this->footerHtml .= "<br/>";
                                }
                                if(isset($signature["name"]))$this->footerHtml .= "<br/>{$signature["name"]}";
                                if(isset($signature["position"]))$this->footerHtml .= "<br/><span style='font-size:0.85em;'>{$signature["position"]}</span>";
                                if(isset($signature["dateTime"]))$this->footerHtml .= "<br/><span style='font-size:0.85em;'>{$signature["dateTime"]}</span>";
                            $this->footerHtml .="</p></div>";
                        }
                        $this->footerHtml .="</div>";
                    $this->footerHtml .="</div>";
                }
            }
            protected function generateFootNote()
            {
                if($this->getStatusCode() != 100) return null;

                $this->footerHtml .= "<div class='col footer_footnote'>";
                    if($this->footerFootNote)$this->footerHtml .= "<div>{$this->footerFootNote}</div>";
                $this->footerHtml .="</div>";
            }
            protected function generatePagination(int $page)
            {
                if($this->getStatusCode() != 100) return null;

                $this->footerHtml .= "<div class='col-2 footer_pagination'>";
                    $this->footerHtml .= "<div class='text-end'>halaman ".($page+1)." dari ".($this->page+1)."</div>";
                $this->footerHtml .="</div>";
            }
    #endregion generateFooter
#endregion data process
}
