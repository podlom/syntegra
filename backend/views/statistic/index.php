<h1><?=$title?></h1>
<?php
//var_dump($data);die();
if(!empty($data)){
    foreach ($data as $v){
        if(is_array($v)) {
            foreach ($v as $v1) {
                echo $v1['title'] . " : " . $v1['value'].", ";
            }
            echo "<br>";
        }
    }
}