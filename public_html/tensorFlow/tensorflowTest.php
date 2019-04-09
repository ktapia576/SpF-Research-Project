<?php
$handle = popen("sh people_test.sh", "r");
//echo "'$handle'; " . gettype($handle) . "\n";
$read = fread($handle, 2096);
echo "<BR>";
$row = explode("\n", trim($read));
for($i = 0; $i< count($row); $i++){
    $a = $row[$i];
    echo "$a"."<BR>";
}
pclose($handle);
?>