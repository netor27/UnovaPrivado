<?php

define("EMAIL_ADVICE_ERRORS", "neto.r27@gmail.com");
define("EMAIL_FROM", "Unova@unova.mx");
define("HEADER", '<html>
        <head>
        <title>Bienvenido a Unova</title>
        </head>
        <body style="color:midnightblue">
        <table cellpadding="0" cellspacing="0" width="98%">
        <tbody><tr>
            <td width="100%" align="center">
                <table width="700" cellpadding="0" cellspacing="0" bgcolor="#f1f1ee" style="font-family:\'Trebuchet MS\', Helvetica, sans-serif;font-size:14px;line-height:150%">
                    <colgroup>
                        <col width="30">
                        <col width="640">
                        <col width="30">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:10px 0">
                                <a href="' . getDomainName() . '">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Unova_Logo_400x102.png" width="219" height="50" border="0" title="Unova" alt="Unova">
                                </a>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:20px 15px" bgcolor="#ffffff">
                                <p></p>
                                <p></p>');

define("FOOTER", '<p></p>
                                <p></p></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="padding:10px 35px;color:#999999;font-size:11px;line-height:16px">
                                Encu&eacute;ntranos en:&nbsp;
                                <a href="http://www.facebook.com/pages/Unova/266525193421804" style="text-decoration:none;border:0" title="Facebook" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Facebook.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Facebook">
                                </a>&nbsp;
                                <a href="http://twitter.com/UnovaEdu" style="text-decoration:none;border:0" title="Twitter" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Twitter.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Twitter">
                                </a>&nbsp;
                                <a href="https://plus.google.com/u/0/118207331473943619520/posts" style="text-decoration:none;border:0" title="Google+" target="_blank">
                                    <img src="http://c342380.r80.cf1.rackcdn.com/Google+.png" style="border:0" width="16" height="16" alt="Encuentra a Unova en Google+">
                                </a>&nbsp;
                                <br>
                                <br>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody></table>
            </td>
        </tr>
    </tbody>
    </table>
    </body></html>
    ');
?>