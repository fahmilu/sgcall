<?php

defined('BASEPATH') or exit('No direct script access.');

/**
 * @author Yugo
 * @property Testimonials_m $testimonials_m
 * @property Form_validation $form_validation
 */
final class Testimonials extends Public_Controller {

    private $write_rules = array(
        array(
            'field' => 'name',
            'label' => 'lang:lbl_name',
            'rules' => 'strip_tags|trim|required|max_length[30]'
        ),
        array(
            'field' => 'email',
            'label' => 'lang:lbl_email',
            'rules' => 'required|valid_email|max_length[100]'
        ),
        array(
            'field' => 'website',
            'label' => 'lang:lbl_website',
            'rules' => 'prep_url|max_length[50]'
        ),
        array(
            'field' => 'company',
            'label' => 'lang:lbl_website',
            'rules' => 'strip_tags|max_length[50]'
        ),
        array(
            'field' => 'message',
            'label' => 'lang:lbl_message',
            'rules' => 'required|strip_tags'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('testimonials');
        $this->load->model('testimonials_m');
        $this->load->helper('html');

        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }
    }

    /**
     * Show active testimonials 
     */
    public function index() {
        $this->db->start_cache();
        $this->testimonials_m->where('status', true);
        $this->db->stop_cache();

        // pagination
        $total = $this->testimonials_m->count_by(array());
        $pagination = create_pagination('testimonials/index', $total, 5, 3);

        $testimonials = $this->testimonials_m
            ->order_by('created_on', 'ASC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('testimonials'))
            ->set('testimonials', $testimonials)
            ->set('total', $total)
            ->set('pagination', $pagination)
            ->build('index');
    }

    /**
     * Write a new testimonial from user/member 
     */
    public function write() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);

        if ($this->form_validation->run()) {
            $data = array_merge($this->input->post(), array(
                'status' => false,
                'created_on' => now(),
                'ip_address' => $this->input->ip_address()
                )
            );
            $created = $this->testimonials_m->insert($data);
            if ($created) {
                $this->session->set_flashdata('success', lang('msg_testimonial_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_testimonial_uncreated'));
            }
            redirect(current_url());
        }
        else {
            $this->template->title(lang('lbl_write'))
                ->build('write');
        }
    }

}

/* EOF testimonials.php */