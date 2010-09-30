<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="this is the installation of Xenlus." />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

        <title>Xenlus | Installation</title>

        <link href="/theme/default/style.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
        <div align="center">
            <table width="700" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2" class="header" valign="top">
                        <div class="heading1">Xenlus - Installation</div>
                        <div class="heading2">Just Another Web CMS</div>
                    </td>
                </tr>
                <tr>
                    <td width="180" class="menu" valign="top">
                        <div class="h1">Installation</div>
                        <a><strong>Check</strong></a>
                        <a>Set-up config.php</a>
                        <a>Create tables</a>
                        <a>Set-up admin user</a>
                        <a>Finished</a>
                        <br /><br />
                    </td>
                    <td width="520" class="menu" style="border-left:1px solid #f5f5f5;" valign="top">
                        <h1>Checking files</h1>
                        <?php
                        include("../core/config.php");
                        if (isset($user)):
                            echo "<h3>Installation already executed, please remove the installation directory.</h3>";
                        else:

                            if ($_GET['error'] == "1") {
                                echo'<font style="border: 1px solid #C00; background-color:#FF6; color:#F00; font-size:14px;"><b>The config file needs to be writable</b></font>';
                                echo "<br />
							<br />";
                            }
                        ?>
                            <p>Thank you for downloading Xenlus, You can now start with the installation</p>
                            <p>This installation will take about 1-3 minutes</p>
                            <hr />
                            <p>Please check if the points below are configured correctly</p>
                        <?php
                            $filename1 = "../core/config.php";
                            $fp = fopen($filename1, "r");
                            $old_con = fread($fp, filesize($filename1));
                            fclose($fp);
                            if (is_writable($filename1)) {
                                echo "<p style='color: green;'><strong>$filename1 is writable</strong></p>";
                            } else {
                                echo "<p style='color: red;'><strong>$filename1 is not writable</strong></p>";
                            }
                        ?>
                            <form action="setup-config.php">
                                <input type="submit" class="button" value="Next" />
                            </form>
                        <?php
                            endif;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="footer">
                        <div class="heading2">Powered by <a href="http://www.xenlus.com/">Xenlus</a><br /> &copy; 2009 Xenlus Group</div><br />
                    </td>
                </tr>
            </table>
            <br />

        </div>

    </body>
</html>