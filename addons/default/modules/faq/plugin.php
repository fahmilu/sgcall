<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Events Plugin
 *
 * Create a list of events
 */
class Plugin_Faq extends Plugin
{

    private $table = 'faqs';


    public function __construct()
    {
        $this->load->model(array('faq_m', 'faqs_categories_m'));
    }

    public function count() {
        $dt =  $this->db->where('published', 'yes')
          ->count_all_results($this->table);

        if($dt == 0){
            return 'style="display:none;"';
        }else{
            return 'style="display:block;"';
        }

    }

    public function get() {
        // $cat_id = $this->attribute('cat_id');

        $faq = $this->db->select('*')
          // ->where('category_id', $cat_id)
          ->order_by($this->attribute('order_by', 'order', 'ASC'))
          ->get($this->table)
          ->result();

          // foreach ($faq as $f) {
          //     if(AUTO_LANGUAGE == 'en'){
          //       if($f->question_en) $f->question = $f->question_en;
          //       if($f->answer_en) $f->answer = $f->answer_en;
          //     }
          // }

        return $faq;
    }
}

/* End of file plugin.php */
