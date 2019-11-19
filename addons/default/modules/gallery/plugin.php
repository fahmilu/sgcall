<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_Gallery extends Plugin {

    private $table = 'gallery';

    /**
     *
     * {{gallery:count}}
     */
    public function count() {
        $dt =  $this->db->where('published', 'yes')
          ->count_all_results($this->table);

        if($dt == 0){
            return 'style="display:none;"';
        }else{
            return true;
        }

    }

    /**
     *
     * {{gallery:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/testimonial:get}}
     */
    public function get() {
        $gallery = $this->db->select('*')
          ->where('published', 'yes')
          // ->limit((int) $this->attribute('limit', 3))
          ->order_by($this->attribute('order_by', 'position', 'ASC'))
          ->get($this->table)
          ->result();

         

        foreach ($gallery as $t) {
            $t->img_url = base_url() . UPLOAD_PATH . 'gallery/'. $t->filename;
        }

        // print_r($gallery);
        // exit();
        return $gallery;
    }

}

/* End of file example.php */