<?php
 parse_str($_SERVER['QUERY_STRING'], $params);
$upload_path = '../../data/ielts_record_speaking';
$name = isset($params['name']) ? $params['name'] : 'output.wav';
$content = file_get_contents('php://input');
$fh = fopen($upload_path."/".$name, 'w') or die("can't open file");
fwrite($fh, $content);
fclose($fh);
?>