<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_About extends Plugin {

    private $table = 'about';

    /**
     *
     * {{about:count}}
     */
    public function count() {
        return $this->db->where('status', true)
          ->count_all_results($this->table);
    }

    /**
     *
     * {{about:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $about = $this->db->select('*')
          ->where('id', 1)
          // ->limit((int) $this->attribute('limit', 1))
          ->order_by($this->attribute('order_by', 'id', 'ASC'), $this->attribute('order_dir', 'RANDOM', 'DESC'))
          ->get($this->table)
          ->result();

        return $about;
    }

}

/* End of file example.php */