<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * FAQ admin controller
 *
 * @author      Stephen Cozart
 * @link		http://www.stephencozart.com
 * @package 	PyroCMS
 * @subpackage  FAQ Module
 * @category	controller
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation rules for creating a new faq
	 *
	 * @var array
	 * @access private
	 */
	private $validation_rules = array();

    public $upload_cfg = array();

	public $section = 'faqs';

	public function __construct()
	{
		// First call the parent's constructor
		parent::__construct();

		// Load all the required classes
		$this->load->model(array('faq_m', 'faqs_categories_m'));
		$this->lang->load('faq');

		$this->load->library('form_validation');
        $this->load->library('upload');

		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'question',
				'label' => lang('faq_question_label'),
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'answer',
				'label' => lang('faq_answer_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'published',
				'label'	=> lang('faq_published_label'),
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'category_id',
				'label'	=> lang('faq_category_label'),
				'rules'	=> 'trim|required'
			)

		);
		$this->template->publish_options = array(
			'yes' => lang('faq_published_yes'),
			'no' => lang('faq_published_no')
		);

		$no_category[''] = lang('faq_category_option');

		$categories = $this->faqs_categories_m->category_options();

		$this->template->category_options = $no_category + $categories;
		$this->template->category_options_without_no = $categories;

		$this->template
			->append_metadata( $this->load->view('fragments/wysiwyg', array(), TRUE) )
			->append_js('module::faq.js');

		//if the request is ajax set layout to false
		$this->_is_ajax() and $this->template->set_layout(FALSE);

        /**
         * Set upload library configuration
         */
        $this->upload_cfg['upload_path'] = UPLOAD_PATH . '/faq' ;
        $this->upload_cfg['allowed_types'] = 'jpg|gif|png|jpeg'; //|ogg|flv|mpg|mpeg|mp4|mov|3gp';
        $this->upload_cfg['max_size'] = '30000';
        $this->upload_cfg['remove_spaces'] = true;
        $this->upload_cfg['overwrite'] = FALSE;

        $this->_path = UPLOAD_PATH . '/faq';//$this->upload_cfg['upload_path'].'/';
        $this->check_dir($this->_path);
	}

	/**
	 * List all faq's
	 *
	 * @author Stephen Cozart
	 * @access public
	 * @return void
	 */
	public function index()
	{
		if(isset($_SERVER['HTTP_REFERER'])){
			if(!preg_match("/faq/",$_SERVER['HTTP_REFERER'])){
				$this->session->unset_userdata('category');
			}
		}
		//Get the records and assign to template
		if ($this->session->userdata('category')) {
			$this->template->faq = $this->faq_m->get_all_faqs_by_category($this->session->userdata('category'));
			
		} else {
			$this->template->faq = $this->faq_m->get_all_faqs();
		}
		

        // $this->template->categories = $this->faqs_categories_m->get_all();

		//build output
		$this->template->build('admin/index');
	}

	/**
	 * Create a new faq
	 *
	 * @author Stephen Cozart
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		//validate the form
		if($this->form_validation->run())
		{
			//prep data array
			$data = array(
						'question' => $this->input->post('question'),
						'answer' => $this->input->post('answer'),
						'published' => $this->input->post('published'),
						'category_id' => $this->input->post('category_id')
				    );

			//insert data
			if($id = $this->faq_m->create_faq($data))
			{	
				$this->session->unset_userdata('category');
                $this->load->library('upload');
                $this->upload->initialize($this->upload_cfg);

                if ($this->upload->do_upload('image')) {
                    $file = $this->upload->data();
                    $filename = $file['file_name'];
                    $image_data['image'] = $filename;
                    $this->faq_m->update($id, $image_data, true);
                }

				//success message
				$message = lang('faq_create_success');
				$status = 'success';
			}
			else
			{
				//failure message
				$message= lang('faq_create_error');
				$status = 'error';
			}

			//form validated so either the record saved or there was a db error
			if($this->_is_ajax())
			{
				//lets only return a json encoded array
				$json = array('message' => $message,
					      'status' => $status
					      );
				echo json_encode($json);
				return TRUE;
			}

			//not ajax lets redirect
			else
			{
				$this->session->set_flashdata($status, $message);
				redirect('admin/faq');
			}
		}

		//form didn't validate and post is set so we should return our validation errors in json
		if($this->_is_ajax() && $_POST)
		{
			echo json_encode(
							array(
								'status' => 'error',
								'message' => validation_errors()
							)
						);
		}

		//just show the form view
		else
		{
			// Load the view
			$this->template->build('admin/create');
		}
	}

	/**
	 * Delete an single or many faq's
	 *
	 * @author Stephen Cozart
	 * @access public
	 * @return void
	 */
	public function delete()
	{
		$ids = $this->input->post('action_to');

		if(!empty($ids))
		{
			//counter
			$i = 0;

			$count = count($ids);

			//loop through each id and try to delete
			foreach($ids as $id)
			{
				//delete success
				if($this->faq_m->delete($id))
				{
					$i++;
				}
			}
			$this->session->set_flashdata('success', sprintf(lang('faq_delete_success'), $i, $count));
		}
		else
		{
			//oops no ids.. ids required here.
			$this->session->set_flashdata('notice', lang('faq_action_empty'));
		}
		//no need to keep hanging around here,  redirect back to faq list
		redirect('admin/faq');
	}

	/**
	 * Edit an existing faq
	 *
	 * @author Stephen Cozart
	 * @param id the ID to edit
	 * @access public
	 * @return void
	 */
	public function edit($id = FALSE)
	{
		$id_rule = array(
						'field' => 'faq_id',
						'label' => lang('faq_id_label'),
						'rules' => 'required|is_numeric|trim'
					);

		//push the special id rule into the validation rules
		array_push($this->validation_rules, $id_rule);

		$this->form_validation->set_rules($this->validation_rules);

		//form valid lets do something with the data
		if($this->form_validation->run())
		{
			//prep the data
			$data = array(
						'question' => $this->input->post('question'),
						'answer' => $this->input->post('answer'),
				      	'published' => $this->input->post('published'),
				      	'category_id' => $this->input->post('category_id')
				      );
			//update data
			if($this->faq_m->update($this->input->post('faq_id'), $data, TRUE))
			{
                $this->load->library('upload');
                $this->upload->initialize($this->upload_cfg);

                if ($this->upload->do_upload('image')) {
                    $file = $this->upload->data();
                    $filename = $file['file_name'];
                    $image_data['image'] = $filename;
                    $this->faq_m->update($this->input->post('faq_id'), $image_data, true);
                }

                $message = lang('faq_update_success');
								$status = 'success';
			}
			else
			{
				$message = lang('faq_update_error');
				$status = 'error';
			}

			if($this->_is_ajax())
			{
				$json = array('message' => $message,
					      'status' => $status
					      );
				echo json_encode($json);
				return TRUE;
			}
			else
			{
				$this->session->set_flashdata($status, $message);
				redirect('admin/faq');
			}
		}

		//id is set lets gooo.
		if($id)
		{
			//get the faq we want to edit and assign to template variable
			$this->template->faq = $this->faq_m->get($id);
		}
		else
		{
			//oops no id can't do nothing without that!
			redirect('admin/faq');
		}

		//form didn't validate and post is set so we should return our validation errors in json
		if($this->_is_ajax() && $_POST)
		{
			echo json_encode(
							array(
								'status' => 'error',
								'message' => validation_errors()
							)
						);
		}

		//just build the output
		else
		{
			$this->template->build('admin/edit');
		}
	}

	/**
	 * Helper method to allow one form to controll multiple actions
	 *
	 * @access public
	 * @return void
	 */
	public function action()
	{
		if($this->input->post('btnAction') == 'delete')
		{
			$this->delete();
		}
	}

	/**
	 * Ajax helper to update the sort/display order
	 *
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function update_order()
	{
		$data = $this->input->post('order');
		if(is_array($data))
		{
			$order = 1;
			foreach($data as $id)
			{
				$this->faq_m->update_order($id, $order);
				$order++;
			}
		}
	}

	protected function _is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? TRUE : FALSE;
	}

    /**
     * Check attachment dir, and create accordingly
     *
     * @param string Directory to check
     * @return array
     */
    function check_dir($dir)
    {
        // check directory
        $fileOK = array();
        $fdir = explode('/', $dir);
        $ddir = '';
        for ($i = 0; $i < count($fdir); $i++) {
            $ddir .= $fdir[$i] . '/';
            if (!is_dir($ddir)) {
                if (!@mkdir($ddir, 0777)) {
                    $fileOK[] = 'not_ok';
                } else {
                    $fileOK[] = 'ok';
                }
            } else {
                $fileOK[] = 'ok';
            }
        }
        return $fileOK;

    }

    function filterbycategory(){
    	if($this->input->post('category') != 0){
    		$this->session->set_userdata('category', $this->input->post('category'));
    	}else{
    		$this->session->unset_userdata('category');
    	}

    	redirect('admin/faq','refresh');
    }
}
