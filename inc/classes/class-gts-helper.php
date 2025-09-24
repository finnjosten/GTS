<?php
/**
 * GTS helper Class
 *
 */

class Wux_Helper {
    
    /** 	
     * Get array of day and month attributes
     * 
     * @param int $timestamp
     * 
     * @return array
     */
    static function get_post_date_array($timestamp) { 

        $date_time = array();

        setlocale(LC_TIME, 'NL_nl');
        
        $date_time['day_num'] = date('d', $timestamp);
        $date_time['day'] = date('D', $timestamp);
        $date_time['month_num'] = date('m', $timestamp);
        $date_time['month'] = date('M', $timestamp);
        $date_time['month_full'] = date('F', $timestamp);

        return $date_time;

    }

    static function hexToToRgb($hex, $returnArray = false) {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $array = [
            'r' => $r,
            'g' => $g,
            'b' => $b,
        ];

        if ($returnArray) {
            return $array;
        }

        return implode(', ', $array);
    }

}