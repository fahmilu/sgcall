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

    private $write_rules = array(
        array(
            'field' => 'content',
            'label' => 'lang:lbl_city',
            'rules' => 'trim|required'
        ),
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('about');
        $this->load->model('about_m');
        $this->load->library('user_agent');
    }

    /**
     * Show active about 
     */
    public function index() {
        $id = 1;
        empty($id) AND redirect('admin/about');
        
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
        $data = $this->about_m->get($id);

        foreach($this->write_rules as $field)
        {
            if (isset($_POST[$field['field']]))
                $data->$field['field'] = set_value($field['field']);
        }

        $this->template
            ->append_metadata( $this->load->view('fragments/wysiwyg', array(), TRUE) )
            ->title(lang('lbl_write'))
            ->set('data', $data)
            ->set('messages', $messages)
            ->build('admin/form');
    }


    public function save() {
        $id = 1;
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
        $data = $this->about_m->get($id);


        if ($this->form_validation->run()) {
            $data = array(
                'content' => $this->input->post('content'),
            );

            // print_r($data);
            // exit();
            $created = $this->about_m->update($id, $data);
            if ($created) {
                $this->session->set_flashdata('success', lang('msg_about_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_about_uncreated'));
            }
            redirect('admin/about');
        }
    }

    public function edit($id) {
        empty($id) AND redirect('admin/about');
        
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
		$data = $this->about_m->get($id);

        $hero_filename = '';

        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'about/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
                unlink( UPLOAD_PATH . 'about/'.$this->input->post('curimg'));
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $hero_filename = $this->input->post('curimg');
        }


        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
                'name' => $this->input->post('name'),
                'role' => $this->input->post('role'),
                'status' => $this->input->post('status'),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->about_m->update($id, $data);
            if ($created) {
                $this->session->set_flashdata('success', lang('msg_about_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_about_uncreated'));
            }
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/about') : redirect('admin/about/edit/' . $id);
        }

		foreach($this->write_rules as $field)
		{
			if (isset($_POST[$field['field']]))
				$data->$field['field'] = set_value($field['field']);
		}

		$this->template
            ->append_metadata( $this->load->view('fragments/wysiwyg', array(), TRUE) )
			->title(lang('lbl_write'))
            ->set('data', $data)
			->set('messages', $messages)
			->build('admin/form');
    }


    /**
     * Show pending about 
     */
    public function pending() {
        $this->db->start_cache();
        $this->about_m->where('status', false);
        $this->db->stop_cache();

        $total = $this->about_m->count_by(array());
        $pagination = create_pagination('admin/about/pending', $total);

        $about = $this->about_m->where('status', false)
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('lbl_pending'))
            ->set('about', $about)
            ->set('pagination', $pagination)
            ->build('admin/pending');
    }

    /**
     * Approve pending about
     * @param int $id 
     */
    public function approve($id = '') {
        empty($id) AND redirect('admin/about');
        $approved = $this->about_m->update($id, array('status' => true));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_about_approved'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Un-approve approved about
     * @param int $id 
     */
    public function unapprove($id = '') {
        empty($id) AND redirect('admin/about');
        $approved = $this->about_m->update($id, array('status' => false));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_about_unapproved'));
        }
        redirect($this->agent->referrer());
    }

    public function delete($id = '') {
        empty($id) AND redirect('admin/about');

        $data = $this->about_m->get($id);
        if(is_file(UPLOAD_PATH . 'about/'.$data->photo)){
            unlink(UPLOAD_PATH . 'about/'.$data->photo);
        }
        
        $deleted = $this->about_m->delete($id);
        if ($deleted) {
            $this->session->set_flashdata('success', lang('msg_about_deleted'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Preview about message to modal
     * @param int $id 
     */
    public function preview($id = '') {
        $this->template->set('about', $this->about_m->get($id))
            ->set_layout('modal', 'admin')
            ->build('admin/preview');
    }

    /**
     * Multiple delete, approve and un-approve about
     */
    public function actions() {
        $button = $_POST['btnAction'];
        $action_to = $_POST['action_to'];
        switch ($button) {

            case 'delete' :
                // multiple delete if not empty
                if (!empty($_POST['action_to'])) {
                    $deleted[] = array();
                    foreach ($_POST['action_to'] as $id) {
                        $deleted[] = $this->about_m->delete($id);
                    }
                }

                if (!empty($deleted) AND !in_array(false, $deleted)) {
                    $this->session->set_flashdata('success', lang('msg_about_deleted'));
                }
                break;

            case 'approve' :
                if (!empty($action_to)) {
                    $approved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->about_m->update($id, array('status' => true));
                    }
                }

                if (!empty($approved) AND !in_array(false, $approved)) {
                    $this->session->set_flashdata('success', lang('msg_about_approved'));
                }
                break;

            case 'unapprove' :
                if (!empty($action_to)) {
                    $unapproved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->about_m->update($id, array('status' => false));
                    }
                }

                if (!empty($unapproved) AND !in_array(false, $unapproved)) {
                    $this->session->set_flashdata('success', lang('msg_about_unapproved'));
                }
                break;
        }

        // redirect to previous page
        redirect($this->agent->referrer());
    }

    function check_dir($dir)
    {
        // check directory
        $fileOK = array();
        $fdir = explode('/', $dir);
        $ddir = '';
        for($i=0; $i<count($fdir); $i++)
        {
            $ddir .= $fdir[$i] . '/';
            if (!is_dir($ddir))
            {
                if (!@mkdir($ddir, 0777)) {
                    $fileOK[] = 'not_ok';
                }
                else
                {
                    $fileOK[] = 'ok';
                }
            }
            else
            {
                $fileOK[] = 'ok';
            }
        }
        return $fileOK;

    }
}

/* EOF admin.php */