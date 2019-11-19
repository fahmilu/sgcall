<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Yugo
 * @property CI_DB_Active_record $db
 */
class Module_Members extends Module {

    public $version = '1.0';

    public function info() {
        return array(
            'name' => array(
                'id' => 'Member',
                'en' => 'Members'
            ),
            'description' => array(
                'id' => 'Menampilkan user yang sudah registrasi.',
                'en' => 'Showing registrated users.'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'data',
            'sections' => array(
                'All Data' => array(
                    'name' => 'lbl_all',
                    'uri' => 'admin/members/all',
                ),
                'Queue Data' => array(
                    'name' => 'lbl_queue',
                    'uri' => 'admin/members/queue',
                ),
                'Finish Data' => array(
                    'name' => 'lbl_finish',
                    'uri' => 'admin/members/finish',
                ),
            )
        );
    }

    public function install() {
        return true;
    }

    public function uninstall() {
        return true;
    }

    public function upgrade($old_version) {
        return TRUE;
    }

    public function help() {
        return $this->load->view('help', null, true);
    }

}

/* End of file details.php */