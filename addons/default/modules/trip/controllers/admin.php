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
            'field' => 'title',
            'label' => 'lang:lbl_title',
            'rules' => 'strip_tags|trim|required|max_length[100]'
        ),
        array(
            'field' => 'photo',
            'label' => 'lang:lbl_photo',
            'rules' => 'trim'
        ),
        array(
            'field' => 'datestart',
            'label' => 'lang:lbl_date',
            'rules' => 'required'
        ),
        array(
            'field' => 'dateend',
            'label' => 'lang:lbl_date',
            'rules' => 'trim'
        ),
        array(
            'field' => 'label',
            'label' => 'lang:lbl_label',
            'rules' => 'required'
        ),
        array(
            'field' => 'status',
            'label' => 'lang:lbl_status',
            'rules' => 'numeric|required'
        ),
        array(
            'field' => 'description',
            'label' => 'lang:lbl_description',
            'rules' => 'required|max_length[250]'
        ),
        array(
            'field' => 'link',
            'label' => 'lang:lbl_link',
            'rules' => 'required|strip_tags'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->load->language('trip');
        $this->load->model('trip_m');
        $this->load->library('user_agent');
    }

    /**
     * Show active trip 
     */
    public function index() {
        $this->db->start_cache();
        // $this->trip_m->where('status', true);
        $this->db->stop_cache();

        $total = $this->trip_m->count_by(array());
        $pagination = create_pagination('admin/trip/index', $total);

        $trip = $this->trip_m            
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'],  $pagination['offset'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('trip'))
            ->set('trip', $trip)
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
            $config['upload_path'] = UPLOAD_PATH . 'trip/';
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
            	'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'label' => $this->input->post('label'),
            	'link' => $this->input->post('link'),
                'datestart' => strtotime($this->input->post('datestart')),
                'dateend' => strtotime($this->input->post('dateend')),
            	'status' => $this->input->post('status'),
                'created_on' => now(),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->trip_m->insert($data);
            if ($created) {
            	if ($this->input->post('status') == 'live')
	                $this->session->set_flashdata('success', lang('msg_trip_created'));
	            else
	                $this->session->set_flashdata('success', lang('msg_trip_created_pending'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_trip_uncreated'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/trip') : redirect('admin/trip/edit/' . $created);
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
        empty($id) AND redirect('admin/trip');
        
        $this->load->library('upload');
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->write_rules);
        $messages = array();
		$data = $this->trip_m->get($id);

        $hero_filename = '';

        if (!empty($_FILES['photo']['name'])){
            // Setup upload config
            $config = $this->upload_cfg;
            $config['upload_path'] = UPLOAD_PATH . 'trip/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            // $config['max_size']  = '100';
            $this->upload->initialize($config);

            // check directory exists
            $this->check_dir($config['upload_path']);

            if ($this->upload->do_upload('photo')){
                $file = $this->upload->data();
                $hero_filename = $file['file_name'];
                unlink( UPLOAD_PATH . 'trip/'.$this->input->post('curimg'));
            }else{
                $messages['error'] = $this->upload->display_errors();
            }
        }else{
            $hero_filename = $this->input->post('curimg');
        }


        if ($this->form_validation->run() && $hero_filename != '') {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'label' => $this->input->post('label'),
                'link' => $this->input->post('link'),
                'datestart' => strtotime($this->input->post('datestart')),
                'dateend' => strtotime($this->input->post('dateend')),
                'status' => $this->input->post('status'),
            );

            if ($hero_filename)
                $data['photo'] = $hero_filename;
            elseif ($this->input->post('curimg'))
                $data['photo'] = $this->input->post('curimg');

            $created = $this->trip_m->update($id, $data);
            if ($created) {
                $this->session->set_flashdata('success', lang('msg_trip_created'));
            }
            else {
                $this->session->set_flashdata('error', lang('msg_trip_uncreated'));
            }
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/trip') : redirect('admin/trip/edit/' . $id);
        }

		foreach($this->write_rules as $field)
		{
			if (isset($_POST[$field['field']]))
				$data->$field['field'] = set_value($field['field']);
		}

        // print_r($data);

        // foreach ($data as $dt) {
            // print_r($dt);
            if($data->datestart){
                $data->datestart = date('M d, Y', $data->datestart);
            }
            if($data->dateend){
                $data->dateend = date('M d, Y', $data->dateend);
            }
        // }

		$this->template
			->title(lang('lbl_write'))
            ->set('data', $data)
			->set('messages', $messages)
			->build('admin/form');
    }


    /**
     * Show pending trip 
     */
    public function pending() {
        $this->db->start_cache();
        $this->trip_m->where('status', false);
        $this->db->stop_cache();

        $total = $this->trip_m->count_by(array());
        $pagination = create_pagination('admin/trip/pending', $total);

        $trip = $this->trip_m->where('status', false)
            ->order_by('created_on', 'DESC')
            ->limit($pagination['limit'])
            ->get_all();
        $this->db->flush_cache();

        $this->template->title(lang('lbl_pending'))
            ->set('trip', $trip)
            ->set('pagination', $pagination)
            ->build('admin/pending');
    }

    /**
     * Approve pending trip
     * @param int $id 
     */
    public function approve($id = '') {
        empty($id) AND redirect('admin/trip');
        $approved = $this->trip_m->update($id, array('status' => true));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_trip_approved'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Un-approve approved trip
     * @param int $id 
     */
    public function unapprove($id = '') {
        empty($id) AND redirect('admin/trip');
        $approved = $this->trip_m->update($id, array('status' => false));
        if ($approved) {
            $this->session->set_flashdata('success', lang('msg_trip_unapproved'));
        }
        redirect($this->agent->referrer());
    }

    public function delete($id = '') {
        empty($id) AND redirect('admin/trip');

        $data = $this->trip_m->get($id);
        if(is_file(UPLOAD_PATH . 'trip/'.$data->photo)){
            unlink(UPLOAD_PATH . 'trip/'.$data->photo);
        }
        
        $deleted = $this->trip_m->delete($id);
        if ($deleted) {
            $this->session->set_flashdata('success', lang('msg_trip_deleted'));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Preview trip message to modal
     * @param int $id 
     */
    public function preview($id = '') {
        $this->template->set('trip', $this->trip_m->get($id))
            ->set_layout('modal', 'admin')
            ->build('admin/preview');
    }

    /**
     * Multiple delete, approve and un-approve trip
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
                        $deleted[] = $this->trip_m->delete($id);
                    }
                }

                if (!empty($deleted) AND !in_array(false, $deleted)) {
                    $this->session->set_flashdata('success', lang('msg_trip_deleted'));
                }
                break;

            case 'approve' :
                if (!empty($action_to)) {
                    $approved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->trip_m->update($id, array('status' => true));
                    }
                }

                if (!empty($approved) AND !in_array(false, $approved)) {
                    $this->session->set_flashdata('success', lang('msg_trip_approved'));
                }
                break;

            case 'unapprove' :
                if (!empty($action_to)) {
                    $unapproved = array();
                    foreach ($action_to as $id) {
                        $approved[] = $this->trip_m->update($id, array('status' => false));
                    }
                }

                if (!empty($unapproved) AND !in_array(false, $unapproved)) {
                    $this->session->set_flashdata('success', lang('msg_trip_unapproved'));
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