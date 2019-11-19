<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * This is a stories module for PyroCMS
 *
 * @author         Jerel Unruh - PyroCMS Dev Team
 * @website        http://unruhdesigns.com
 * @package     PyroCMS
 * @subpackage     Sample Module
 */
class Event extends Public_Controller
{
    protected $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
        // Load all the required classes
        $this->load->model('event_m');
    }
    public function index($page=0)
    {
        $tag_session = '';
        if(isset($_SERVER['HTTP_REFERER'])){
            if(!preg_match("/event/",$_SERVER['HTTP_REFERER'])){
                $this->session->unset_userdata('tag');
                $this->session->set_userdata('month', 'year');
                $this->session->set_userdata('year', 'all');
            }else{
                if($this->session->userdata('tag')){
                    $tag_session = $this->session->userdata('tag');
                }
            }
        }

        if($tag_session != ''){
            $this->db->like('tags', $tag_session, 'BOTH');
        }
        
        if($this->session->userdata('month') != 'year'){
            $this->db->where('month', $this->session->userdata('month'));
        }   

        if($this->session->userdata('year') != 'all'){
            $this->db->where('year', $this->session->userdata('year'));
        }

        $total_rows = $this->db->where('status', 1)->get('event')->num_rows();

        // echo $total_rows;

        // exit();
        $this->load->library('pagination');
        $config['base_url'] = site_url('event/page');
        $config['total_rows'] = $total_rows;
        $perpage = $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        // $config['num_links'] = 3;
        // $config['full_tag_open'] = '<li>';
        // $config['full_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<div>';
        $config['first_tag_close'] = '</div>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<div>';
        $config['last_tag_close'] = '</div>';
        // $config['next_link'] = '<div class="btn next"></div>';
        // $config['next_tag_open'] = '<div>';
        // $config['next_tag_close'] = '</div>';
        // $config['prev_link'] = '<div class="btn prev"></div>';
        // $config['prev_tag_open'] = '<div>';
        // $config['prev_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<li><a class="cur">';
        $config['cur_tag_close'] = '</a></li>';
        
        $this->pagination->initialize($config);
        
        $pagination = $this->pagination->create_links();

        $tags = $this->db->select('*')
          ->order_by('id', 'ASC')
          ->get('event_tags')
          ->result();

        foreach ($tags as $tag) {
            $tag->url = site_url('event/tag/'.url_title($tag->tag));
            if($this->session->userdata('tag') == $tag->tag){
                $tag->class = 'active';
            }
            $tag->tag = strtoupper($tag->tag);
        }
        
        $year = $this->db->select('year')
            ->where('status', 1)
            // ->where('date >= ', strtotime('today'))
            ->group_by('year')
            ->order_by('date', 'ASC')
            ->get('event')
            ->result_array();

        $datelist = array();
        
        foreach ($year as $y) {
            // $datelist[$y['year']] = 'test';
            $month = $this->db->select('month, year')
                ->where('status', 1)
                ->where('year', $y['year'])
                // ->where('date >= ', strtotime('today'))
                ->group_by('month')
                ->order_by('date', 'ASC')
                ->get('event')
                ->result_array();     

                $datelist[$y['year']] = $month;
        }

        if($tag_session != ''){
            $this->db->like('tags', $tag_session, 'BOTH');
        }
        
        if($this->session->userdata('month') != 'year'){
            $this->db->where('month', $this->session->userdata('month'));
        }        

        if($this->session->userdata('year') != 'all'){
            $this->db->where('year', $this->session->userdata('year'));
        }

        $result = 
            $this->db->select('*')
            ->where('status', 1)
            // ->where('year', $this->session->userdata('year'))
            // ->where('date >= ', strtotime('today'))
            ->order_by('date', 'ASC')
            ->order_by('time', 'ASC')
            ->limit($perpage,$page)
            ->get('event');

        // print_r($result
        $monthlist = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $monthlist2 = [ '01'=>'Jan',
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

        foreach ($result->result() as $p) {
            $p->url = base_url() . UPLOAD_PATH . 'event/'. $p->photo;
            // $p->date = strftime('%d '.$month[$p->month-1].' %Y', $p->date);
            if($p->date < strtotime('today')){
              $p->class = 'archived';
            }else{
              $p->class = 'active';
            }
            if($p->dateend){
                if($p->dateend != $p->date){
                    $p->date = strftime('%d '.$monthlist2[$p->month].' %Y', $p->date).' - '.strftime('%d '.$monthlist2[date('m', $p->dateend)].' %Y', $p->dateend);
                }else{
                    $p->date = strftime('%d '.$monthlist[$p->month-1].' %Y', $p->date);
                }
            }else{
                $p->date = strftime('%d '.$monthlist[$p->month-1].' %Y', $p->date); 
            }
        }

        // print_r($result);

        // exit();
        $this->template
            ->title('Event')
            ->set('result', $result)
            ->set('pagination', $pagination)
            ->set('monthlist', $monthlist)
            ->set('tags', $tags)
            ->set('datelist', $datelist)
            ->build('index');
        // $this->load->view('data', $data);       
    }

    function tag($tag){
        $array = array(
            'tag' => str_replace('-', ' ', $tag)
        );
        // echo $tag;
        // exit();
        if($tag != 'all'){
            $this->session->set_userdata($array);
        }else{
            $this->session->unset_userdata('tag');
        }

        redirect('event','refresh');
    }

    function bymonth($month, $year){
        $this->session->set_userdata('month', $month);
        $this->session->set_userdata('year', $year);

        redirect('event','refresh');
    }

}
