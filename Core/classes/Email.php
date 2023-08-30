<?php
class Email
{
    private $log;
    private $email;
    public $mail;
    private $username_email;
    private $password_email;
    private $host_email;
    private $email_to;
    private $nomeApp;
    public $dati;
    public $errore;

    public function __construct($mail, $log)
    {
        $this->log = $log;
        $this->mail = $mail;
        # Parametri provider email -> Amazon aws
        $this->username_email = "AKIAXTGJSCBTW7GGJBOB";
        $this->password_email = "BKrz8q3zvzLstJG3mbZeIhyas1SvhB9I9kG6Mb6J4owI";
        $this->host_email = "email-smtp.eu-west-2.amazonaws.com";
        $this->email_to = "noreply@raiseup.it";
        $this->nomeApp = "Yunes CRM";
    }

    public function inviaPreventivo(string $email, string $cliente,  string $allegato, string $oggetto): bool
    {
        try {

            $toBody = <<<HTML
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

                <head>
                    <!--[if gte mso 9]>
                        <xml>
                            <o:OfficeDocumentSettings>
                                <o:AllowPNG/>
                                <o:PixelsPerInch>96</o:PixelsPerInch>
                            </o:OfficeDocumentSettings>
                        </xml>
                        <![endif]-->
                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                    <meta content="width=device-width" name="viewport" />
                    <!--[if !mso]>
                        <!-->
                    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
                    <!-- 
                        <![endif]-->
                    <title></title>
                    <!--[if !mso]>
                        <!-->
                    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
                    <!-- 
                        <![endif]-->
                    <style type="text/css">
                    body {
                        margin: 0;
                        padding: 0;
                    }

                    table,
                    td,
                    tr {
                        vertical-align: top;
                        border-collapse: collapse;
                    }

                    * {
                        line-height: inherit;
                    }

                    a[x-apple-data-detectors=true] {
                        color: inherit !important;
                        text-decoration: none !important;
                    }

                    .ie-browser table {
                        table-layout: fixed;
                    }

                    [owa] .img-container div,
                    [owa] .img-container button {
                        display: block !important;
                    }

                    [owa] .fullwidth button {
                        width: 100% !important;
                    }

                    [owa] .block-grid .col {
                        display: table-cell;
                        float: none !important;
                        vertical-align: top;
                    }

                    .ie-browser .block-grid,
                    .ie-browser .num12,
                    [owa] .num12,
                    [owa] .block-grid {
                        width: 650px !important;
                    }

                    .ie-browser .mixed-two-up .num4,
                    [owa] .mixed-two-up .num4 {
                        width: 216px !important;
                    }

                    .ie-browser .mixed-two-up .num8,
                    [owa] .mixed-two-up .num8 {
                        width: 432px !important;
                    }

                    .ie-browser .block-grid.two-up .col,
                    [owa] .block-grid.two-up .col {
                        width: 324px !important;
                    }

                    .ie-browser .block-grid.three-up .col,
                    [owa] .block-grid.three-up .col {
                        width: 324px !important;
                    }

                    .ie-browser .block-grid.four-up .col [owa] .block-grid.four-up .col {
                        width: 162px !important;
                    }

                    .ie-browser .block-grid.five-up .col [owa] .block-grid.five-up .col {
                        width: 130px !important;
                    }

                    .ie-browser .block-grid.six-up .col,
                    [owa] .block-grid.six-up .col {
                        width: 108px !important;
                    }

                    .ie-browser .block-grid.seven-up .col,
                    [owa] .block-grid.seven-up .col {
                        width: 92px !important;
                    }

                    .ie-browser .block-grid.eight-up .col,
                    [owa] .block-grid.eight-up .col {
                        width: 81px !important;
                    }

                    .ie-browser .block-grid.nine-up .col,
                    [owa] .block-grid.nine-up .col {
                        width: 72px !important;
                    }

                    .ie-browser .block-grid.ten-up .col,
                    [owa] .block-grid.ten-up .col {
                        width: 60px !important;
                    }

                    .ie-browser .block-grid.eleven-up .col,
                    [owa] .block-grid.eleven-up .col {
                        width: 54px !important;
                    }

                    .ie-browser .block-grid.twelve-up .col,
                    [owa] .block-grid.twelve-up .col {
                        width: 50px !important;
                    }
                    </style>
                    <style id="media-query" type="text/css">
                    @media only screen and(min-width: 670px) {
                        .block-grid {
                        width: 650px !important;
                        }

                        .block-grid .col {
                        vertical-align: top;
                        }

                        .block-grid .col.num12 {
                        width: 650px !important;
                        }

                        .block-grid.mixed-two-up .col.num3 {
                        width: 162px !important;
                        }

                        .block-grid.mixed-two-up .col.num4 {
                        width: 216px !important;
                        }

                        .block-grid.mixed-two-up .col.num8 {
                        width: 432px !important;
                        }

                        .block-grid.mixed-two-up .col.num9 {
                        width: 486px !important;
                        }

                        .block-grid.two-up .col {
                        width: 325px !important;
                        }

                        .block-grid.three-up .col {
                        width: 216px !important;
                        }

                        .block-grid.four-up .col {
                        width: 162px !important;
                        }

                        .block-grid.five-up .col {
                        width: 130px !important;
                        }

                        .block-grid.six-up .col {
                        width: 108px !important;
                        }

                        .block-grid.seven-up .col {
                        width: 92px !important;
                        }

                        .block-grid.eight-up .col {
                        width: 81px !important;
                        }

                        .block-grid.nine-up .col {
                        width: 72px !important;
                        }

                        .block-grid.ten-up .col {
                        width: 65px !important;
                        }

                        .block-grid.eleven-up .col {
                        width: 59px !important;
                        }

                        .block-grid.twelve-up .col {
                        width: 54px !important;
                        }
                    }

                    @media(max-width: 670px) {

                        .block-grid,
                        .col {
                        min-width: 320px !important;
                        max-width: 100% !important;
                        display: block !important;
                        }

                        .block-grid {
                        width: 100% !important;
                        }

                        .col {
                        width: 100% !important;
                        }

                        .col>div {
                        margin: 0 auto;
                        }

                        img.fullwidth,
                        img.fullwidthOnMobile {
                        max-width: 100% !important;
                        }

                        .no-stack .col {
                        min-width: 0 !important;
                        display: table-cell !important;
                        }

                        .no-stack.two-up .col {
                        width: 50% !important;
                        }

                        .no-stack .col.num4 {
                        width: 33% !important;
                        }

                        .no-stack .col.num8 {
                        width: 66% !important;
                        }

                        .no-stack .col.num4 {
                        width: 33% !important;
                        }

                        .no-stack .col.num3 {
                        width: 25% !important;
                        }

                        .no-stack .col.num6 {
                        width: 50% !important;
                        }

                        .no-stack .col.num9 {
                        width: 75% !important;
                        }

                        .video-block {
                        max-width: none !important;
                        }

                        .mobile_hide {
                        min-height: 0px;
                        max-height: 0px;
                        max-width: 0px;
                        display: none;
                        overflow: hidden;
                        font-size: 0px;
                        }

                        .desktop_hide {
                        display: block !important;
                        max-height: none !important;
                        }
                    }
                    </style>
                </head>

                <body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #e5e5e5;">
                    <style id="media-query-bodytag" type="text/css">
                    @media (max-width: 670px) {
                        .block-grid {
                        min-width: 320px !important;
                        max-width: 100% !important;
                        width: 100% !important;
                        display: block !important;
                        }

                        .col {
                        min-width: 320px !important;
                        max-width: 100% !important;
                        width: 100% !important;
                        display: block !important;
                        }

                        .col>div {
                        margin: 0 auto;
                        }

                        img.fullwidth {
                        max-width: 100% !important;
                        height: auto !important;
                        }

                        img.fullwidthOnMobile {
                        max-width: 100% !important;
                        height: auto !important;
                        }

                        .no-stack .col {
                        min-width: 0 !important;
                        display: table-cell !important;
                        }

                        .no-stack.two-up .col {
                        width: 50% !important;
                        }

                        .no-stack.mixed-two-up .col.num4 {
                        width: 33% !important;
                        }

                        .no-stack.mixed-two-up .col.num8 {
                        width: 66% !important;
                        }

                        .no-stack.three-up .col.num4 {
                        width: 33% !important
                        }

                        .no-stack.four-up .col.num3 {
                        width: 25% !important
                        }
                    }
                    </style>
                    <!--[if IE]>
                        <div class="ie-browser">
                            <![endif]-->
                    <table bgcolor="#F5F5F5" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e5e5e5; width: 100%;" valign="top" width="100%">
                    <tbody>
                        <tr style="vertical-align: top;" valign="top">
                        <td style="word-break: break-word; vertical-align: top; border-collapse: collapse;" valign="top">
                            <!--[if (mso)|(IE)]>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td align="center" style="background-color:#F5F5F5">
                                                        <![endif]-->
                            <div style="background-color:transparent;">
                            <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                <!--[if (mso)|(IE)]>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                                                                    <tr class="layout-full-width" style="background-color:transparent">
                                                                                        <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        <td align="center" width="650" style="background-color:transparent;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                <tr>
                                                                                                    <td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;">
                                                                                                        <![endif]-->
                                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;;">
                                    <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]>
                                                                                                                <!-->
                                    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                        <!-- 
                                                                                                                    <![endif]-->
                                        <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                        <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                            <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="10" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; border-top: 0px solid transparent; height: 10px;" valign="top" width="100%">
                                                <tbody>
                                                    <tr style="vertical-align: top;" valign="top">
                                                    <td height="10" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse;" valign="top">
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <!--[if (!mso)&(!IE)]>
                                                                                                                    <!-->
                                    </div>
                                    <!-- 
                                                                                                                <![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <![endif]-->
                                </div>
                            </div>
                            </div>
                            <div style="background-color:transparent;">
                            <div class="block-grid two-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;margin: 0 auto;;background-color: transparent;">
                                <!--[if (mso)|(IE)]>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                                                                    <tr class="layout-full-width" style="background-color:#FFFFFF">
                                                                                        <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        <td align="center" width="325" style="background-color:#FFFFFF;width:325px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                <tr>
                                                                                                    <td style="padding-right: 0px; padding-left: 25px; padding-top:25px; padding-bottom:25px;">
                                                                                                        <![endif]-->
                                <div class="col num12" style="min-width: 320px; max-width: 325px; display: table-cell; vertical-align: top;;">
                                    <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]>
                                                                                                                <!-->
                                    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:25px; padding-right: 0px; padding-left: 25px;">
                                        <!-- 
                                                                                                                    <![endif]-->
                                        <div align="center" class="img-container left fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]>
                                                                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                            <tr style="line-height:0px">
                                                                                                                                <td style="padding-right: 0px;padding-left: 0px;" align="left">
                                                                                                                                    <![endif]-->
                                        <img alt="Logo_Yunes" border="0" class="left fixedwidth" src="https://crm.yunes.it/Assets/images/yunes/marchiologotipo_blue.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; border: 0; height: auto; float: none; width: 100%; max-width: 195px; display: block;" title="Image" width="195" />
                                        <!--[if mso]>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                        <![endif]-->
                                        </div>
                                        <!--[if (!mso)&(!IE)]>
                                                                                                                    <!-->
                                    </div>
                                    <!-- 
                                                                                                                <![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        </td>
                                                                                        <td align="center" width="325" style="background-color:#FFFFFF;width:325px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                <tr>
                                                                                                    <td style="padding-right: 25px; padding-left: 0px; padding-top:25px; padding-bottom:25px;">
                                                                                                        <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <![endif]-->
                                </div>
                            </div>
                            </div>
                            <div style="background-color:transparent;">
                            <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;border-radius: 26px;box-shadow: 0px 4px 20px rgb(0 0 0 / 10%);">
                                <div style="border-collapse: collapse;display: table;min-width: 500px;margin: 0 auto;background-color:#FFFFFF; border-radius: 26px;">
                                <!--[if (mso)|(IE)]>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                                                                    <tr class="layout-full-width" style="background-color:#FFFFFF">
                                                                                        <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                        <td align="center" width="650" style="background-color:#FFFFFF;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                <tr>
                                                                                                    <td style="padding-right: 25px; padding-left: 25px; padding-top:5px; padding-bottom:60px;">
                                                                                                        <![endif]-->
                                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;;">
                                    <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]>
                                                                                                                <!-->
                                    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:60px; padding-right: 25px; padding-left: 25px;">
                                        <!-- 
                                                                                                                    <![endif]-->
                                        <!--[if mso]>
                                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                        <tr>
                                                                                                                            <td style="padding-right: 10px; padding-left: 15px; padding-top: 20px; padding-bottom: 0px; font-family: Arial, sans-serif">
                                                                                                                                <![endif]-->
                                        <div style="color: #212529;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%;padding-top:60px;padding-right:10px;padding-bottom:0px;padding-left:15px;">

                                        </div>
                                        <!--[if mso]>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                    <![endif]-->
                                        <!--[if mso]>
                                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                        <tr>
                                                                                                                            <td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif">
                                                                                                                                <![endif]-->
                                        <div style="color:#555555;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div style="font-size: 12px; line-height: 14px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #555555;">
                                            <p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;">
                                            <span style="font-size: 18px; color: #0A1F31">
                                          
                                            <span style="font-size: 24px; font-weight: bolder;">$oggetto</span>
                                                <br>
                                                <br>
                                                <br>
                                                <small>
                                                <i>Per qualsiasi domanda il nostro supporto é <br> a tua completa disposizione ai seguenti recapiti: <br>
                                                <br>Via email: support@swissvoip.eu<br>
                                                    Via telefono: +390287176355    
                                                 </i>
                                                </small>
                                            </span>
                                            </p>
                                        </div>
                                        </div>
                                        <!--[if mso]>
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    <![endif]-->
                                        <div align="center" class="button-container" style="padding-top:20px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <!--[if mso]>
                                                                                                                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                                                                                                                            <tr>
                                                                                                                                                                                <td style="padding-top: 20px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px" align="center">
                                                                                                                                                                                    <v:roundrect
                                                                                                                                                                                        xmlns:v="urn:schemas-microsoft-com:vml"
                                                                                                                                                                                        xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:39pt; width:163.5pt; v-text-anchor:middle;" arcsize="29%" stroke="false" fillcolor="#45b860">
                                                                                                                                                                                        <w:anchorlock/>
                                                                                                                                                                                        <v:textbox inset="0,0,0,0">
                                                                                                                                                                                            <center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px">
                                                                                                                                                                                                <![endif]-->
                                        <a href="https://crm.yunes.it/" style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #212529;background-color: #39d7d0;border-color: #39d7d0;; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; width: auto; width: auto; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;" target="_blank">
                                            <span style="padding-left:40px;padding-right:40px;font-size:16px;display:inline-block;">
                                            <span style="font-size: 16px; line-height: 32px;">
                                                <strong>ACCEDI</strong>
                                            </span>
                                            </span>
                                        </a>
                                        <!--[if mso]>
                                                                                                                                                                                            </center>
                                                                                                                                                                                        </v:textbox>
                                                                                                                                                                                    </v:roundrect>
                                                                                                                                                                                </td>
                                                                                                                                                                            </tr>
                                                                                                                                                                        </table>
                                                                                                                                                                        <![endif]-->
                                        </div>
                                        <!--[if (!mso)&(!IE)]>
                                                                                                                                                                    <!-->
                                    </div>
                                    <!-- 
                                                                                                                                                                <![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                            <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                    <![endif]-->
                                </div>
                            </div>
                            </div>
                            <div style="background-color:transparent;">
                            <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                <!--[if (mso)|(IE)]>
                                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;">
                                                                                                                        <tr>
                                                                                                                            <td align="center">
                                                                                                                                <table cellpadding="0" cellspacing="0" border="0" style="width:650px">
                                                                                                                                    <tr class="layout-full-width" style="background-color:transparent">
                                                                                                                                        <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                                                                        <td align="center" width="650" style="background-color:transparent;width:650px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top">
                                                                                                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                                                <tr>
                                                                                                                                                    <td style="padding-right: 0px; padding-left: 0px; padding-top:20px; padding-bottom:60px;">
                                                                                                                                                        <![endif]-->
                                <div class="col num12" style="min-width: 320px; max-width: 650px; display: table-cell; vertical-align: top;">
                                    <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]>
                                                                                                                                                                <!-->
                                    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:60px; padding-right: 0px; padding-left: 0px;">
                                        <!-- 
                                                                                                                                                                    <![endif]-->
                                        <table cellpadding="0" cellspacing="0" class="social_icons" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%">
                                        <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                            <td style="word-break: break-word; vertical-align: top; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
                                                <table activate="activate" align="center" alignment="alignment" cellpadding="0" cellspacing="0" class="social_table" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: undefined; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;" to="to" valign="top">
                                                <tbody>
                                                    <tr align="center" style="vertical-align: top; display: inline-block; text-align: center;" valign="top">
                                                    <td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 8px; padding-left: 8px; border-collapse: collapse;" valign="top">
                                                        <a href="https://www.facebook.com/yunes_crm-106056588905146/" target="_blank">
                                                        <img alt="Facebook" height="32" src="https://crm.yunes.it/Assets/images/social/facebook.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; height: auto; float: none; border: none; display: block;" title="Facebook" width="32" />
                                                        </a>
                                                    </td>
                                                    <td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 8px; padding-left: 8px; border-collapse: collapse;" valign="top">
                                                        <a href="https://www.instagram.com/yunes_crm/" target="_blank">
                                                        <img alt="Instagram" height="32" src="https://crm.yunes.it/Assets/images/social/instagram.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; clear: both; height: auto; float: none; border: none; display: block;" title="Facebook" width="32" />
                                                        </a>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <!--[if mso]>
                                                                                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                                                                        <tr>
                                                                                                                                                                            <td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif">
                                                                                                                                                                                <![endif]-->
                                        <!-- <div style="color:#555555;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div style="font-size: 12px; line-height: 18px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #555555;"><p style="font-size: 14px; line-height: 21px; text-align: center; margin: 0;"> VIA CANTONALE 19, 6805 MEZZOVICO-VIRA SVIZZERA</p></div></div> -->
                                        <!--[if mso]>
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    <![endif]-->
                                        <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
                                        <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                            <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; border-collapse: collapse;" valign="top">
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 60%; border-top: 1px dotted #C4C4C4; height: 0px;" valign="top" width="60%">
                                                <tbody>
                                                    <tr style="vertical-align: top;" valign="top">
                                                    <td height="0" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse;" valign="top">
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <!--[if mso]>
                                                                                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                                                                                                        <tr>
                                                                                                                                                                            <td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif">
                                                                                                                                                                                <![endif]-->
                                        <div style="color:#4F4F4F;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div style="font-size: 12px; line-height: 14px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #4F4F4F;">
                                            <p style="font-size: 12px; line-height: 16px; text-align: center; margin: 0;">
                                            <span style="font-size: 14px;">
                                                <a href="https://yunes.it/index#sectionFaq" rel="noopener" style="text-decoration: none; color: #39d7d0;" target="_blank">
                                                <strong>Help &amp; FAQ's</strong>
                                                </a>
                                                <!-- <span style="background-color: transparent; line-height: 16px; font-size: 14px;">- CHE-182.147.868</span> -->
                                            </span>
                                            </p>
                                        </div>
                                        </div>
                                        <!--[if mso]>
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    <![endif]-->
                                        <!--[if (!mso)&(!IE)]>
                                                                                                                                                                    <!-->
                                    </div>
                                    <!-- 
                                                                                                                                                                <![endif]-->
                                    </div>
                                </div>
                                <!--[if (mso)|(IE)]>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                            <![endif]-->
                                <!--[if (mso)|(IE)]>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </table>
                                                                                                                            </td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                    <![endif]-->
                                </div>
                            </div>
                            </div>
                            <!--[if (mso)|(IE)]>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <![endif]-->
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    <!--[if (IE)]>
                                                                        </div>
                                                                        <![endif]-->
                </body>

                </html>
            HTML;


            $mail = $this->mail;
            $mail->ClearAllRecipients();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = $this->host_email;
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = $this->username_email;
            $mail->Password = $this->password_email;
            $mail->setFrom($this->email_to, $this->nomeApp);
            $mail->AddAddress($email);
            $mail->Subject = "CRM Yunes";
            $mail->CharSet = 'UTF-8';
            // $mail->addAttachment($pdf);
            $mail->addStringAttachment(file_get_contents($allegato), 'preventivo.pdf');
            $mail->Body = $toBody;
            if (!$mail->send()) {
                throw new Exception($mail->ErrorInfo);
            }
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            return true;
        } catch (Exception $ex) {

            return false;
        }
    }

    public function emailDev(string $ip): bool
    {
        try {

            $devEmail = "salvatore@tekmind.it";

            $toBody = <<<HTML
            <html>
            <head>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover">
            <style>
            body{
                text-rendering: optimizeLegibility;
            }
            </style>
            </head>
            <body>
            <h3>ATTENZIONE!</h3>
            <p>Possibile attacco Brute Force su login!</p>
            <p>Il seguente {$ip} sta facendo frequenti tentativi di accesso</p>
            <br>
            <br>
            <b><small>nome app</small></b>
            </body>
            </html>
            HTML;

            $mail = $this->mail;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'TLS';
            $mail->Host = $this->host_email;
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = $this->username_email;
            $mail->Password = $this->password_email;
            $mail->setFrom('noreply@raiseup.it', 'RaiseUP');
            $mail->AddAddress($devEmail);
            $mail->Subject = "ATTENZIONE - ";
            $mail->Body = $toBody;
            if (!$mail->send()) {
                throw new Exception($mail->ErrorInfo);
            }
            return true;
        } catch (Exception $ex) {

            return false;
        }
    }

    public function emailErrore(string $oggetto, string $messaggio, string $file, string $line): bool
    {
        try {

            $devEmail = "salvatore@tekmind.it";

            $toBody = <<<HTML
            <html>
            <head>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover">
            <style>
            body{
                text-rendering: optimizeLegibility;
            }
            </style>
            </head>
            <body>
            <p><strong>Errore:</strong> $messaggio</p>      
            <p><strong>File: </strong>$file</p>  
            <p><strong>Riga:</strong> $line</p>  
            </body>
            </html>
            HTML;

            $mail = $this->mail;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'TLS';
            $mail->Host = $this->host_email;
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = $this->username_email;
            $mail->Password = $this->password_email;
            $mail->setFrom('noreply@raiseup.it', 'RaiseUP');
            $mail->AddAddress($devEmail);
            $mail->Subject = $oggetto;
            $mail->Body = $toBody;
            if (!$mail->send()) {
                throw new Exception($mail->ErrorInfo);
            }
            return true;
        } catch (Exception $ex) {

            return false;
        }
    }
}
