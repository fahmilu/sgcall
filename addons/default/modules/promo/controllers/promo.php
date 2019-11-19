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
class Promo extends Public_Controller
{
    protected $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
        // Load all the required classes
        $this->load->model('promo_m');
    }
    public function index($page=0)
    {
        $this->load->library('pagination');
        
        $config['base_url'] = site_url('promo/page');
        $config['total_rows'] = $this->db->where('status', 1)->count_all_results('promo');
        $perpage = $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        // $config['num_links'] = 1;
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
        $result = $this->db->where('status', 1)->order_by('id', 'asc')->limit($perpage,$page)->get('promo');

        foreach ($result->result() as $r) {
            $r->img_url = base_url() . UPLOAD_PATH . 'promo/'. $r->photo;
        }

        $this->template
            ->title('Promo')
            ->set('result', $result)
            ->set('pagination', $pagination)
            ->build('index');
        // $this->load->view('data', $data);       
    }


}
