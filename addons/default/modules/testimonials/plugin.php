<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_Testimonials extends Plugin {

    private $table = 'testimonials';

    /**
     *
     * {{testimonials:count}}
     */
    public function count() {
        return $this->db->where('status', 1)
          ->count_all_results($this->table);
    }

    /**
     *
     * {{testimonials:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $testimonials = $this->db->select('*')
          ->where('status', 1)
          // ->limit((int) $this->attribute('limit', 1))
          ->order_by($this->attribute('order_by', 'order', 'ASC'), $this->attribute('order_dir', 'created_on', 'desc'))
          ->get($this->table)
          ->result();

        foreach ($testimonials as $testi) {
            // if(AUTO_LANGUAGE == 'en'){
            //     if($testi->message_en) $testi->message = $testi->message_en;
            // }
            $testi->url = base_url() . UPLOAD_PATH . 'testimonial/'. $testi->photo;
        }
        return $testimonials;
    }

}

/* End of file example.php */