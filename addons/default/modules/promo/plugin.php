<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_Promo extends Plugin {

    private $table = 'promo';

    /**
     *
     * {{promo:count}}
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
     * {{promo:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $promo = $this->db->select('*')
          ->where('status', 1)
          ->limit((int) $this->attribute('limit', 3))
          ->order_by($this->attribute('order_by', 'id', 'asc'))
          ->get($this->table)
          ->result();

        foreach ($promo as $testi) {
            $testi->url = base_url() . UPLOAD_PATH . 'promo/'. $testi->photo;
        }
        return $promo;
    }

}

/* End of file example.php */