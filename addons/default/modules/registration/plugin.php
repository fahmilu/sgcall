<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_Registration extends Plugin {

    private $table = 'registration';

    /**
     *
     * {{registration:count}}
     */
    public function count() {
        return  $this->db->where('status', 1)->count_all_results($this->table);
    }

    /**
     *
     * {{registration:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $registration = $this->db->select('*')
          ->where('status', 1)
          ->limit((int) $this->attribute('limit', 4))
          ->order_by('id', 'desc')
          ->get($this->table)
          ->result();
         $themes = $this->bcalib->getThemes(); 
        foreach ($registration as $r) {
            $r->image_url = base_url() . UPLOAD_PATH . 'gallery/'. $r->image;
            $r->theme = $themes[$r->img_theme];
        }

        return $registration;
    }

}

/* End of file example.php */