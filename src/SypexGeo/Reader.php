<?php
/**
 * SypexGeo Reader
 *
 * Released under the MIT license
 */
namespace SypexGeo;

use SypexGeo\SxGeo;

class Reader
{
    protected $db = null;
    protected $locale = null;

    public function __construct($db, $locale) {
        $this->db = $db;
        $locales = ['en', 'ru'];
        $this->locale = ((in_array($locale, $locales)) ? $locale : 'en');
    } 

    public function getGeo($ip)
    {
        // Create object
        // // First param - db-file (used SxGeo.dat)
        // // Second param - mode: 
        // //     SXGEO_FILE   (work with the base file, default mode); 
        // //     SXGEO_BATCH (batch processing, increases the speed when processing multiple IP at a time)
        // //     SXGEO_MEMORY (DB caching in memory, still increases batch processing speed, but requires more memory)
        $SxGeo = new SxGeo($this->db);
        //$SxGeo = new SxGeo($this->db, SXGEO_BATCH | SXGEO_MEMORY); // The most productive mode, if you need to process a lot of IP at a time
        $geo = $SxGeo->getCityFull($ip);
        if((ip2long($ip) >= 167772160 && ip2long($ip) <= 184549375)
            || (ip2long($ip) >= 2886729728 && ip2long($ip) <= 2887778303)
            || (ip2long($ip) >= 3232235520 && ip2long($ip) <= 3232301055)) { //networks classes A,B,C
            $data['country'] = 'LO';
            $data['city'] = 'Local Network';
        } elseif((ip2long($ip) >= 2130706432 && ip2long($ip) <= 2147483647)) {
            $data['country'] = 'LO';
            $data['city'] = 'Loopback';
        } else {
            $data['country'] = ($geo['country']['iso'] == null) ? 'UN' : $geo['country']['iso'];
            $data['city'] = ($geo['city']['name_'.$this->locale] == null) ? 'Unknown' : $geo['city']['name_'.$this->locale];
        }        
        return $data;
    }
}
