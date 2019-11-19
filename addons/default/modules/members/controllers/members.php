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
class Members extends Public_Controller
{
    protected $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci =& get_instance();
        // Load all the required classes
        // $this->load->model('registration_m');
        $this->load->helper('user');
        // var_dump($this->config);
        // echo date("d/m/Y");
        // redirect('','refresh');
        if(!is_logged_in()){
            redirect('login','refresh');
        }
    }
    public function index()
    {
        // $this->load->helper('user');
        // var_dump($this->config);
        // echo date("d/m/Y");
        // redirect('','refresh');
        redirect('profile');
    }

    public function view()
    {
        
        if($this->current_user->group_id != 2){
            redirect('admin','refresh');
        }

        $user = $this->current_user;

        $quest = $this->sobat->quest($user->id);

        $this->template->title('Profile')
            ->set('user', $user)
            ->set('quest', $quest)
            ->build('profile');       
    }

    public function submit()
    {
        $user_id = $this->input->post('user_id');
        $quest_id = $this->input->post('quest_id');

        if($this->sobat->submissionByUser($user_id, $quest_id) < $this->sobat->checkQuestMaxSubmission($quest_id)){
            $id_user_quest = 0;
            if($this->sobat->unapprovedSubmissionByUser($user_id, $quest_id) > 0){
                $id_user_quest = $this->sobat->getUnapprovedSubmissionID($user_id, $quest_id);
            }

            if($this->input->post('type') == 1){
                $config['upload_path'] = UPLOAD_PATH . 'quest';
                $config['allowed_types'] = 'jpg|gif|png|jpeg';
                $config['max_size']  = '150';
                $config['max_width']  = '5000';
                $config['max_height']  = '5000';
                
                $path = $config['upload_path'].'/';
                $this->check_dir($path);

                $this->load->library('upload', $config);
                
                if ( !$this->upload->do_upload('image')){
                    $error = array('error' => $this->upload->display_errors());
                    print_r($this->upload->display_errors());
                }
                else{
                    // print_r($this->upload->data());
                    $image = $this->upload->data()['file_name'];
                    // exit();
                    if($id_user_quest == 0){
                        $this->sobat->insertQuestPoint($user_id, $quest_id, "", $image, $this->input->post('point'), 0);
                    }else{
                        $this->sobat->updateQuestPoint($id_user_quest, "", $image, $this->input->post('point'));
                    }
                    $this->session->set_flashdata('success', 'success');
                    redirect('profile','refresh');
                }
            }else{
                $url = $this->input->post('url');
                if($id_user_quest == 0){
                    $this->sobat->insertQuestPoint($user_id, $quest_id, $url, "", $this->input->post('point'), 0);
                }else{
                    $this->sobat->updateQuestPoint($id_user_quest, $url, "", $this->input->post('point'));
                }
                $this->session->set_flashdata('success', 'success');
                redirect('profile','refresh');                
            }
        }else{
            $this->session->set_flashdata('warning', 'already full');
            redirect('profile','refresh');             
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
