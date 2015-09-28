<?php
define("Add",9);
define("Delete",0);
$link = mysqli_connect("localhost","root","786","asterisk");
function follow($file,$link)
{
    $size = 0;
    while (true) {
         clearstatcache();
        $currentSize = filesize($file);
        if ($size == $currentSize) {

            usleep(100);
            continue;
        }

        $fh = fopen($file, "r");
        fseek($fh, $size);

        while ($d = fgets($fh)) {
          if (strpos($d,"DTMF end passthrough")){
			$parse = explode("' on SIP/",$d);
			$Digit = substr($parse[0],strlen($parse[0])-1,1);
			$User = $parse[1];
  echo "\n". substr($parse[0],1,10);
			if (substr($parse[0],1,10) == date('Y-m-y')){
				if ($Digit == Add){
					$result = mysqli_query($link,"INSERT INTO userque (digit,user,act) values (" . $Digit . ",'" . $User . "','1')");
                    echo "\n"."INSERT INTO userque (digit,user,act) values (" . $Digit . ",'" . $User . "','1')";
			}elseif ($Digit == Delete){
				$result = mysqli_query($link,"INSERT INTO userque (digit,user,act) values (" . $Digit 
. ",'" . $User . "','0')");
			}
                    }
          }
        }
        fclose($fh);
        $size = $currentSize;
    }
}
follow("/var/log/asterisk/messages",$link);

