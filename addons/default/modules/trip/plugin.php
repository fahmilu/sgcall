<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_Trip extends Plugin {

    private $table = 'trip';

    /**
     *
     * {{trip:count}}
     */
    public function count() {
        $dt =  $this->db->where('status', 1)
          ->count_all_results($this->table);

        if($dt == 0){
            return 'style="display:none;"';
        }else{
            return true;
        }

    }

    /**
     *
     * {{trip:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $trip = $this->db->select('*')
          ->where('status', 1)
          ->limit((int) $this->attribute('limit', 3))
          ->order_by($this->attribute('order_by', 'id', 'ASC'))
          ->get($this->table)
          ->result();

        $month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
         

        foreach ($trip as $t) {
            $t->url = base_url() . UPLOAD_PATH . 'trip/'. $t->photo;
            if($t->datestart == $t->dateend){
                $t->date = strftime('%d '. $month[strftime('%m', $t->datestart)] .' %Y', $t->datestart);
            }else{
                $t->date = strftime('%d '. $month[strftime('%m', $t->datestart)] .' %Y', $t->datestart).' - '.strftime('%d '. $month[strftime('%m', $t->dateend)] .' %Y', $t->dateend);

            }
        }

        // print_r($trip);
        // exit();
        return $trip;
    }

}

/* End of file example.php */