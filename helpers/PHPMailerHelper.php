<?php
namespace app\TDEs;
use app\core\TDE;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailerHelper extends TDE
{
    protected PHPMailer $mail;
    protected string $account;
    protected array $accounts = [
        "debug" => [
            "SMTPDebug" => SMTP::DEBUG_SERVER,
            "Host" => "mail.tmsgroup.co.id",
            "SMTPAuth" => true,
            "Username" => "no-reply@tmsgroup.co.id",
            "Password" => "Tms@supp0rt",
            "SMTPSecure" => PHPMailer::ENCRYPTION_SMTPS,
            "Port" => 465,
            "FromEmail" => "no-reply@tmsgroup.co.id",
            "FromName" => "TDE System",
            //"ReplyEmail" => "noreply@trimandirigroup.com",
            //"ReplyName" => "TDE System",
            "isHTML" => true,
        ],
        "noreply" => [
            "Host" => "mail.tmsgroup.co.id",
            "SMTPAuth" => true,
            "Username" => "no-reply@tmsgroup.co.id",
            "Password" => "Tms@supp0rt",
            "SMTPSecure" => PHPMailer::ENCRYPTION_SMTPS,
            "Port" => 465,
            "FromEmail" => "no-reply@tmsgroup.co.id",
            "FromName" => "TDE System",
            //"ReplyEmail" => "noreply@trimandirigroup.com",
            //"ReplyName" => "TDE System",
            "isHTML" => true,
        ]
    ];
    public function __construct(string $account = "noreply")
    {
        parent::__construct();
        $this->prepare("PHPMailerHelper");

        $this->mail = new PHPMailer(true);
        $this->account = $account;
        $this->init();
    }

#region init
    public function init()
    {
        if($this->getStatusCode() != 100) return null;

        $account = $this->accounts[$this->account];

        $this->mail->SMTPDebug = $account["SMTPDebug"] ?? false;
        $this->mail->isSMTP();
        $this->mail->Host = $account["Host"];
        $this->mail->SMTPAuth = $account["SMTPAuth"];
        $this->mail->Username = $account["Username"];
        $this->mail->Password = $account["Password"];
        $this->mail->SMTPSecure = $account["SMTPSecure"];
        $this->mail->Port = $account["Port"];

        $this->mail->setFrom($account["FromEmail"], $account["FromName"]);
        if(isset($account["ReplyEmail"]))$this->mail->addReplyTo($account["ReplyEmail"], $account["ReplyName"]);
        $this->mail->isHTML($account["isHTML"]);
    }
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getMail()
    {
        return $this->mail;
    }
#endregion  getting / returning variable

#region data process
#endregion data process
}
