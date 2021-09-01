<?php
//sanitize string
function escape($string)
{
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
//generate random strings (for unique codes)
function random_strings($length_of_string) 
{ 
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
}
//pagination
function render($style = 3)
{
	return DB::getInstance()->render($style);
}
//Time past
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
//error parser for exception handling
function error_parser($value ='')
{
    return (!is_array(json_decode($value))) ? $value : json_decode($value);
}
//token call
function crsf_token($value='')
{
    return '<input type="hidden" id="token" name="token" value="'.Token::generate().'" />';
}
function show_errors($value='error', $type= 1)
{ 
    if (Session::exists($value)):
        $a = error_parser(Session::get($value));
        if(is_array($a)):
            foreach ($a as $key => $v) {
                echo Alert::message($v, $type);
            }
        else:
            echo Alert::message($a, $type);
        endif;
        Session::flash($value);
    endif;
}
function show_status($value='status')
{
    if (Session::exists($value)) echo Session::flash($value,'','info', 1);
}
?>