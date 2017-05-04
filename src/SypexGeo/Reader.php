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

    public function __construct($db) {
        $this->db = $db;
    } 

    public function getGeo($ip)
    {
        try {
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
                $data['country']['iso'] = 'LO';
                $data['country']['en'] = 'Local network';
                $data['country']['ru'] = 'Локальная сеть';
                $data['region']['en'] = 'Local Network';
                $data['region']['ru'] = 'Локальная сеть';
                $data['city']['en'] = 'Local Network';
                $data['city']['ru'] = 'Локальная сеть';
            } elseif((ip2long($ip) >= 2130706432 && ip2long($ip) <= 2147483647)) {
                $data['country']['iso'] = 'LO';
                $data['country']['en'] = 'Localhost';
                $data['country']['ru'] = 'Локальный хост';
                $data['region']['en'] = 'Loopback';
                $data['region']['ru'] = 'Петля обратной связи';
                $data['city']['en'] = 'Loopback';
                $data['city']['ru'] = 'Петля обратной связи';
            } else {
                $data['country']['iso'] = ($geo['country']['iso'] == null) ? 'UN' : $geo['country']['iso'];
                $data['country']['en'] = ($geo['country']['name_en'] == null) ? 'Unknown' : $geo['country']['name_en'];
                $data['country']['ru'] = ($geo['country']['name_ru'] == null) ? 'Неизвестно' : $geo['country']['name_ru'];
                $data['region']['en'] = ($geo['region']['name_en'] == null) ? 'Unknown' : $geo['region']['name_en'];
                $data['region']['ru'] = ($geo['region']['name_ru'] == null) ? 'Unknown' : $geo['region']['name_ru'];
                $data['city']['en'] = ($geo['city']['name_en'] == null) ? 'Unknown' : $geo['city']['name_en'];
                $data['city']['ru'] = ($geo['city']['name_ru'] == null) ? 'Unknown' : $geo['city']['name_ru'];
            }   
        } catch (\Exception $e) {
            $data = $e->getMessage();
        }
        return $data;
    }
}
