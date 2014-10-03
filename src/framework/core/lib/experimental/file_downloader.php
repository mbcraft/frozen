<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
require ('../framework/lib/init.php');

function cURLcheckBasicFunctions()
{
  if( !function_exists("curl_init") &&
      !function_exists("curl_setopt") &&
      !function_exists("curl_exec") &&
      !function_exists("curl_close") ) return false;
  else return true;
}

/*
 * Returns string status information.
 * Can be changed to int or bool return types.
 */
function cURLdownload($url, $file)
{
  if( !cURLcheckBasicFunctions() ) return "UNAVAILABLE: cURL Basic Functions";
  $ch = curl_init();
  if($ch)
  {
    $fp = fopen($file, "w");
    if($fp)
    {
      if( !curl_setopt($ch, CURLOPT_URL, $url) )
      {
        fclose($fp); // to match fopen()
        curl_close($ch); // to match curl_init()
        return "FAIL: curl_setopt(CURLOPT_URL)";
      }
      if( !curl_setopt($ch, CURLOPT_FILE, $fp) ) return "FAIL: curl_setopt(CURLOPT_FILE)";
      if( !curl_setopt($ch, CURLOPT_HEADER, 0) ) return "FAIL: curl_setopt(CURLOPT_HEADER)";
      if( !curl_exec($ch) ) return "FAIL: curl_exec()";
      curl_close($ch);
      fclose($fp);
      return "SUCCESS: $file [$url]";
    }
    else return "FAIL: fopen()";
  }
  else return "FAIL: curl_init()";
}
?>


<html>
    <head>
        <title>Php setup utilities</title>
    </head>
    <body>

        <?php
        if (!isset($_POST["command"]))
        {
        ?>
        <form name="form_download" action="/setup/utils.php" method="POST">
        <table>
            <tr>
                <td>
                    Choose file to download : <input type="text" size="40" name="location" />
                </td>
            </tr>
            <tr>
                <td>
                    Choose name for save : <input type="filename" size="40" name="filename" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="command" value="DOWNLOAD" />
                    <input type="submit" name="Download" value="Download" />
                </td>
            </tr>
        </table>

        </form>


            <?php
        }
        else
        {
            if ($_POST["command"]=="DOWNLOAD")
            {
                cURLdownload($_POST["location"], SITE_ROOT_PATH."/setup/download/".$_POST["filename"]);
            }
        }
        ?>
    </body>
</html>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>