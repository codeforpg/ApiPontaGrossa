<?PHP

function array_any(Array $array){
    $key = array_rand($array);
    return $array[$key];
}