<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testimonial Plugin
 *
 */
class Plugin_event extends Plugin {

    private $table = 'event';

    /**
     *
     * {{event:count}}
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
     * {{event:get limit="2" order_by="created_on" order_dir="desc" teaser="1" words="30"}}
     *  {{name}}, {{message}}
     * {{/event:get}}
     */
    public function get() {
        $event = $this->db->select('*')
          ->where('status', 1)
          // ->where('date >= ', strtotime('today'))
          ->limit((int) $this->attribute('limit', 6))
          ->order_by($this->attribute('order_by', 'date', 'ASC'))
          ->order_by($this->attribute('order_by', 'time', 'ASC'))
          ->get($this->table)
          ->result();

        $month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $month2 = [ '01'=>'Jan',
                    '02'=>'Feb',
                    '03'=>'Mar',
                    '04'=>'Apr',
                    '05'=>'Mei',
                    '06'=>'Jun',
                    '07'=>'Jul',
                    '08'=>'Agu',
                    '09'=>'Sept',
                    '10'=>'Okt',
                    '11'=>'Nov',
                    '12'=>'Des'];
        foreach ($event as $p) {
            $p->url = base_url() . UPLOAD_PATH . 'event/'. $p->photo;
            // $p->date = strftime('%d '.$month[$p->month-1].' %Y', $p->date);
            if($p->date < strtotime('today')){
              $p->class = 'archived';
            }else{
              $p->class = 'active';
            }
            if($p->dateend){
                if($p->dateend != $p->date){
                    $p->date = strftime('%d '.$month2[$p->month].' %Y', $p->date).' - '.strftime('%d '.$month2[date('m', $p->dateend)].' %Y', $p->dateend);
                }else{
                    $p->date = strftime('%d '.$month[$p->month-1].' %Y', $p->date);
                }
            }else{
                $p->date = strftime('%d '.$month[$p->month-1].' %Y', $p->date); 
            }
        }
        return $event;
    }

    public function get_tags()
    {
        $tags = $this->db->select('*')
          ->order_by($this->attribute('order_by', 'id', 'ASC'))
          ->get($this->table.'_tags')
          ->result();

        foreach ($tags as $tag) {
            $tag->url = site_url('event/tag/'.url_title($tag->tag));
            $tag->tag = strtoupper($tag->tag);
        }

        return $tags;
    }
}

/* End of file example.php */