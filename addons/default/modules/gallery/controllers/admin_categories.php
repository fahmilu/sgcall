<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * gallery categories admin controller
 *
 * @author      Stephen Cozart
 * @link		http://www.stephencozart.com
 * @package 	PyroCMS
 * @subpackage  gallery Module
 * @category	controller
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 */
class Admin_categories extends Admin_Controller {

    /**
     * Validation rules for creating a new gallery
     *
     * @var array
     * @access private
     */
    private $validation_rules = array();

	public $section = "categories";

    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Load all the required classes
		$this->load->model('gallery_categories_m');
		$this->load->library('form_validation');
		$this->lang->load('gallery');

        // Set the validation rules
        $this->validation_rules = array(
                array(
                        'field' => 'title',
                        'label' => lang('gallery_category_label'),
                        'rules' => 'trim|max_length[250]|required'
                ),
                array(
                        'field' => 'published',
                        'label' => lang('gallery_published_label'),
                        'rules' => 'trim|required'
                )
        );

        $this->template->publish_options = array(
											'yes' => lang('gallery_published_yes'),
											'no' => lang('gallery_published_no')
										);
		$this->template
			->append_metadata( $this->load->view('fragments/wysiwyg', array(), TRUE) )
            ->append_js('module::gallery.js');

        $this->_is_ajax() and $this->template->set_layout(FALSE);
    }

    /**
     * index method
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $this->template->categories = $this->gallery_categories_m->get_all();
        $this->template->build('admin/categories/index');
    }

    public function create()
    {
        //set validation rules
        $this->form_validation->set_rules($this->validation_rules);

        //validate the form
        if($this->form_validation->run())
        {
            //prepare data
            $data = array(
						'title' => $this->input->post('title'),
                        'slug' => strtolower(url_title($this->input->post('title'))),
						'published' => $this->input->post('published')
                    );
            //insert the data
            if($this->gallery_categories_m->create_category($data))
            {
                //insert ok
                $message = lang('gallery_category_create_success');
                $status = 'success';
            }
            else
            {
                //insert error
                $message = lang('gallery_category_create_error');
                $status = 'error';
            }

            //what kind of request?
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
                redirect('admin/gallery/category');
            }
        }

        if($this->_is_ajax() && $_POST)
        {
			echo json_encode(
							array(
								'status' => 'error',
								'message' => validation_errors()
							)
						);
        }
        else
        {
            $this->template->build('admin/categories/create');
        }
    }

    /**
    * Edit an existing gallery category
    *
    * @author Stephen Cozart
    * @param id the ID to edit
    * @access public
    * @return void
    */
    public function edit($id = FALSE)
    {
            $id_rule = array(
                            'field' => 'category_id',
                            'label' => lang('gallery_id_label'),
                            'rules' => 'required|is_numeric|trim'
                        );

            array_push($this->validation_rules, $id_rule);

            $this->form_validation->set_rules($this->validation_rules);

            //form valid lets do something with the data
            if($this->form_validation->run())
            {
				//prep the data
				$data = array(
						'title' => $this->input->post('title'),
                        'slug' => strtolower(url_title($this->input->post('title'))),
						'published' => $this->input->post('published')
					);
				//update data
				if($this->gallery_categories_m->update($this->input->post('category_id'), $data, TRUE))
				{
						$message = lang('gallery_category_update_success');
						$status = 'success';
				}
				else
				{
						$message = lang('gallery_category_update_error');
						$status = 'error';
				}

				//what kind of request?
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
					redirect('admin/gallery/category');
				}
            }

            //id is set lets gooo.
            if($id)
            {
                //get the gallery we want to edit
                $this->template->category = $this->gallery_categories_m->get($id);
            }
            else
            {
				//oops no id can't do nuthin without that!
				redirect('admin/gallery/category');
            }

            if($this->_is_ajax() && $_POST)
            {
				echo json_encode(
								array(
									'status' => 'error',
									'message' => validation_errors()
								)
							);
            }
            else
            {
                $this->template->build('admin/categories/edit');
            }
    }

    /**
    * Delete existing gallery category(s)
    *
    * @author   Stephen Cozart
    * @param    none
    * @access   public
    * @return   void
    */
    public function delete()
    {
        $this->load->model('gallery_m');
        $ids = $this->input->post('action_to');

        if($ids)
        {
            $i = 0;
            $count = count($ids);
            foreach($ids as $id)
            {
                //reset the category_id of any gallery associated with this category
                if($this->gallery_m->clear_category($id))
                {
                    if($this->gallery_categories_m->delete($id))
                    {
                        $i++;
                    }
                }
            }
            $this->session->set_flashdata('success', sprintf(lang('gallery_category_delete_success'), $i, $count));
        }
        else
        {
            //oops no ids.. ids required here.  GTFO.
			$this->session->set_flashdata('notice', lang('gallery_action_empty'));
        }
        redirect('admin/gallery/category');
    }

    /**
     * Action helper method
     *
     */
    public function action()
    {
        if($this->input->post('btnAction') == 'delete')
        {
            $this->delete();
        }
    }

    protected function _is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? TRUE : FALSE;
    }
}
/* End of file admin_categories.php */
/* Location: ./addons/modules/gallery/controllers/admin_categories.php */
