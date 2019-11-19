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
class Registration extends Public_Controller
{
    protected $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
        // Load all the required classes
        $this->load->model('registration_m');
    }
    public function index()
    {
        // var_dump($this->config);
        // echo date("d/m/Y");
        redirect('','refresh');
    }

    public function submit()
    {

        $post = array(
            'name'              => $this->input->post('name'),
            'gender'            => $this->input->post('gender'),
            'email'             => $this->input->post('email'),
            'birtday'           => $this->input->post('birtday'),
            'province'          => $this->input->post('province'),
            'visited_sg'        => $this->input->post('visited_sg'),
            'visited_sg_count'  => $this->input->post('visited_sg_count'),
            'created_at'        => date('Y-m-d h:i:s'),
            'updated_at'        => date('Y-m-d h:i:s'),
        );

        if ($this->registration_m->create($post)) {
            $this->session->set_flashdata('registration-success', 'Terima Kasih, Data anda sudah kami terima');

            redirect('daftar','refresh');
        }
    }

}
