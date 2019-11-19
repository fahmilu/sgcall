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
            'field' => 'name',
            'label' => 'lang:lbl_name',
            'rules' => 'strip_tags|trim|required|max_length[30]'
        ),
        array(
            'field' => 'photo',
            'label' => 'lang:lbl_photo',
            'rules' => 'trim'
        ),
        array(
            'field' => 'status',
            'label' => 'lang:lbl_status',
            'rules' => 'numeric|required'
        ),
        array(
            'field' => 'message',
            'label' => 'lang:lbl_message',
            'rules' => 'required|strip_tags'
        ),
        array(
            'field' => 'occupation',
            'label' => 'loccupation',
            'rules' => 'required|strip_tags'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('testimonials');
        $this->load->model('testimonials_m');
        $this->load->library('user_agent');

        $this->template->append_js('module::testimonials.js');
    }

    /**
     * Show active testimonials 
     */
    public function index() {
        $this->db->start_cache();
        // $this->testimonials_m->where('status', true);
        $this->db->stop_cache();

        $total = $this->testimonials_m->count_by(array());
        $pagination = create_pagination('admin/testimonials/index', $total);

        $testimonials = $this->testimonials_m
            ->order_by('order', 'ASC')
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('testimonials'))
            ->set('testimonials', $testimonials)
            ->set('pagination', $pagination)
            ->build('admin/index');
    }

    public function create() {
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
        // hero image processing
        $hero_filename = '';
        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'testimonial/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $this->form_validation->set_rules('photo', 'Photo', 'required');
        }

        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
            	'name' => $this->input->post('name'),
                'message' => $this->input->post('message'),
            	'occupation' => $this->input->post('occupation'),
            	'status' => $this->input->post('status'),
                'created_on' => now(),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->testimonials_m->insert($data);
            if ($created) {
            	if ($this->input->post('status') == 'live')
	                $this->session->set_flashdata('success', lang('msg_testimonial_created'));
	            else
	                $this->session->set_flashdata('success', lang('msg_testimonial_created_pending'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_testimonial_uncreated'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/testimonials') : redirect('admin/testimonials/edit/' . $created);
        }

        $data = new StdClass();
		foreach($this->write_rules as $field)
		{
			//if (isset($_POST[$field['field']]))
			$data->$field['field'] = set_value($field['field']);
		}

		$this->template
			->title(lang('lbl_write'))
            ->set('data', $data)
			->set('messages', $messages)
			->build('admin/form');
    }

    public function edit($id) {
        empty($id) AND redirect('admin/testimonials');
        
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
		$data = $this->testimonials_m->get($id);

        $hero_filename = '';

        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'testimonial/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
                unlink( UPLOAD_PATH . 'testimonial/'.$this->input->post('curimg'));
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $hero_filename = $this->input->post('curimg');
        }


        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
                'name' => $this->input->post('name'),
                'message' => $this->input->post('message'),
                'occupation' => $this->input->post('occupation'),
                'status' => $this->input->post('status'),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->testimonials_m->update($id, $data);
            if ($created) {
                $this->session->set_flashdata('success', lang('msg_testimonial_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_testimonial_uncreated'));
            }
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/testimonials') : redirect('admin/testimonials/edit/' . $id);
        }

		foreach($this->write_rules as $field)
		{
			if (isset($_POST[$field['field']]))
				$data->$field['field'] = set_value($field['field']);
		}

		$this->template
			->title(lang('lbl_write'))
            ->set('data', $data)
			->set('messages', $messages)
			->build('admin/form');
    }


    /**
     * Show pending testimonials 
     */
    public function pending() {
        $this->db->start_cache();
        $this->testimonials_m->where('status', false);
        $this->db->stop_cache();

        $total = $this->testimonials_m->count_by(array());
        $pagination = create_pagination('admin/testimonials/pending', $total);

        $testimonials = $this->testimonials_m->where('status', false)
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('lbl_pending'))
            ->set('testimonials', $testimonials)
            ->set('pagination', $pagination)
            ->build('admin/pending');
    }

    /**
     * Approve pending testimonial
     * @param int $id 
     */
    public function approve($id = '') {
        empty($id) AND redirect('admin/testimonials');
        $approved = $this->testimonials_m->update($id, array('status' => true));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_testimonials_approved'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Un-approve approved testimonial
     * @param int $id 
     */
    public function unapprove($id = '') {
        empty($id) AND redirect('admin/testimonials');
        $approved = $this->testimonials_m->update($id, array('status' => false));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_testimonials_unapproved'));
        }
        redirect($this->agent->referrer());
    }

    public function delete($id = '') {
        empty($id) AND redirect('admin/testimonials');

        $data = $this->testimonials_m->get($id);
        if(is_file(UPLOAD_PATH . 'testimonial/'.$data->photo)){
            unlink(UPLOAD_PATH . 'testimonial/'.$data->photo);
        }
        
        $deleted = $this->testimonials_m->delete($id);
        if ($deleted) {
            $this->session->set_flashdata('success', lang('msg_testimonials_deleted'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Preview testimonial message to modal
     * @param int $id 
     */
    public function preview($id = '') {
        $this->template->set('testimonial', $this->testimonials_m->get($id))
            ->set_layout('modal', 'admin')
            ->build('admin/preview');
    }

    /**
     * Multiple delete, approve and un-approve testimonials
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
                        $deleted[] = $this->testimonials_m->delete($id);
                    }
                }

                if (!empty($deleted) AND !in_array(false, $deleted)) {
                    $this->session->set_flashdata('success', lang('msg_testimonials_deleted'));
                }
                break;

            case 'approve' :
                if (!empty($action_to)) {
                    $approved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->testimonials_m->update($id, array('status' => true));
                    }
                }

                if (!empty($approved) AND !in_array(false, $approved)) {
                    $this->session->set_flashdata('success', lang('msg_testimonials_approved'));
                }
                break;

            case 'unapprove' :
                if (!empty($action_to)) {
                    $unapproved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->testimonials_m->update($id, array('status' => false));
                    }
                }

                if (!empty($unapproved) AND !in_array(false, $unapproved)) {
                    $this->session->set_flashdata('success', lang('msg_testimonials_unapproved'));
                }
                break;
        }

        // redirect to previous page
        redirect($this->agent->referrer());
    }

    public function update_order()
    {
        $data = $this->input->post('order');
        if(is_array($data))
        {
            $order = 1;
            foreach($data as $id)
            {
                $this->testimonials_m->update_order($id, $order);
                $order++;
            }
        }
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