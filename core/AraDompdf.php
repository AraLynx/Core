<?php
namespace app\core;
use Dompdf\Dompdf;

class AraDompdf extends Dompdf
{
    public string $dir = "";
    public string $fileName = "temporary.pdf";

    public function __construct()
    {
        parent::__construct();
        $this->setPaper("A4", 'portrait');

        $dir = __DIR__."/../cache";
        if(!is_dir($dir))mkdir($dir);

        $dir .= "/pdf";
        if(!is_dir($dir))mkdir($dir);

        $this->dir = $dir;
    }

#region init
#endregion init

#region set status
    public function araSetDir($folder)
    {
        $folders = explode("/",$folder);
        $dir = $this->dir;
        foreach($folders AS $folder)
        {
            $dir .= "/".$folder;
            if(!is_dir($dir))mkdir($dir);
        }
        $this->dir = $dir;
    }
    public function araSetFileName($fileName)
    {
        $this->fileName = $fileName.".pdf";
    }
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
    public function araLoadHTML($html)
    {
        $this->load_html($html);
    }
    public function araGeneratePDF()
    {
        $fullLink = $this->dir."/".$this->fileName;

        $this->render();
        $pdf = $this->output();

        file_put_contents($fullLink, $pdf);
    }
#endregion data process
}
