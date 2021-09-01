<?php 
/**
 * summary
 */
class Pager
{
    /**
     * summary
     */
    public static function render()
    {
    	$r = DB::getInstance()->render();
        return $r;
    }
}



?>