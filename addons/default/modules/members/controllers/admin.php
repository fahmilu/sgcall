<?php

defined('BASEPATH') or exit('No direct script access.');

final class Admin extends Admin_Controller {

	protected $section = 'list';

    protected $upload_cfg = array(
        'max_size'          => '10000',
        'remove_spaces'     => TRUE,
        'overwrite'         => FALSE,
        'encrypt_name'      => FALSE,
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('members');
        $this->load->model('members_m');
        $this->load->library('user_agent');
    }

    /**
     * Show active members 
     */
    public function index() {
        // $this->db->start_cache();
        // // $this->members_m->where('status', true);
        // $this->db->stop_cache();

        // $total = $this->members_m->count_by(array());
        // $pagination = create_pagination('admin/members/index', $total);

        // $members = $this->members_m
        //     ->order_by('created_on', 'ASC')
        //     ->limit($pagination['limit'])
        //     ->get_all();
        // $this->db->flush_cache();

        // $this->template->title(lang('members'))
        //     ->set('members', $members)
        //     ->set('pagination', $pagination)
        //     ->build('admin/index');
        redirect('admin/members/all','refresh');
    }

    public function all() {


        $total = $this->members_m->count_by(1);
        // $total = 100;
        $pagination = create_pagination('admin/members/all', $total);

        $members = $this->members_m->get(1, $pagination['limit'], $pagination['offset']);

        $this->template->title(lang('lbl_all'))
            ->set('active_section', lang('lbl_all'))
            ->set('members', $members)
            ->set('pagination', $pagination)
            ->build('admin/index');
    }

    public function queue() {
        $this->template->title(lang('lbl_queue'))
            ->set('active_section', lang('lbl_queue'))
            // ->set('pagination', $pagination)
            ->build('admin/index');
    }

    public function finish() {
        $this->template->title(lang('lbl_finish'))
            ->set('active_section', lang('lbl_finish'))
            // ->set('members', $members)
            // ->set('pagination', $pagination)
            ->build('admin/index');
    }

}

/* EOF admin.php */