<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    public static function sentMail($recipients, $subject, $html){
        $mail = new PHPMailer(true);
        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'eassignment.norton@gmail.com';         //SMTP username
            $mail->Password   = 'neuaulkrflwlcgto';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('eassignment.norton@gmail.com', 'Norton.e-assignment');
            $mail->addAddress($recipients);
            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {
                    $mail->ErrorInfo}";
        }
    }

    public static function verifyMailHtml($username, $message){
        $html = '
            <!doctype html>
                <html lang="en"
                    xmlns="http://www.w3.org/1999/xhtml"
                    xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">

                <title>Norton E-Assignment</title>

                <!--[if gte mso 9]>
                <xml>
                <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
                </xml>
                <![endif]-->

                </head>
                <body style="margin:0; padding:0; background:#eeeeee;">

                    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                       TES COMPANY
                    </div>

                    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                    </div>

                    <center>

                    <div style="width:100%; max-width:600px; background:#ffffff; padding:30px 20px; text-align:left; ">

                    <!--[if mso]>
                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" bgcolor="#ffffff">
                    <tr>
                    <td align="left" valign="top" style="padding:20px;">
                    <![endif]-->

                    <a href="https://beta.spm-edoc.com/">
                        <img src="https://www.norton-u.com/images/logo-banner-blue.png" width="200" height="50" style="display:block; margin-bottom:30px; object-fit: contain">
                    </a>

                    <h1 style="font-size:16px; line-height:22px; font-weight:normal; color:#333333;">
                        Hello ' . $username . '!
                    </h1>

                    <img src="http://placehold.it/50x1/ff0000/ff0000" width="50" height="1" style="display:block; margin-bottom:30px;">
                    <div>
                    
                       ' . $message . '
                    </div>
                    <p style="font-size:16px; line-height:24px; color:#666666; margin-bottom:30px;">
                    Thanks and Best Regards,
                    <br>
                    Norton E-Assignment Team
                    </p>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td bgcolor="#2a2185"
                                    style="padding: 12px 26px 12px 26px; border-radius:4px"
                                    align="center">
                                    <a href="https://beta.spm-edoc.com/"
                                    target="_blank"
                                    style=" font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; display: inline-block;">
                                        See Now
                                    </a>
                                </td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                        <tr>
                        <td width="100%" height="30">&nbsp;</td>
                        </tr>
                    </table>

                    <hr style="border:none; height:1px; color:#dddddd; background:#dddddd; width:100%; margin-bottom:20px;">

                    <p style="font-size:12px; line-height:18px; color:#999999; margin-bottom:10px;">
                        &copy; Copyright 2023
                        <a href="http://glennsmith.me"
                        style="font-size:12px; line-height:18px; color:#666666; font-weight:bold;">
                        Norton E-Assignment</a>, All Rights Reserved.
                    </p>

                    <!--[if mso | IE]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->

                    </div>

                    </center>

                </body>
            </html>

        ';

        return $html;
    }

}