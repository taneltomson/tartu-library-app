<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('database_model');
        $this->load->library('table');
        $this->load->helper('url_helper');
    }

    public function view_schools()
    {
        $data['schools'] = $this->database_model->get_schools();
        $data['title'] = 'Koolid';

        $i = 0;
        foreach ($data['schools'] as $school) {
            $data['schools'][$i]['edit'] = '<a href="'.site_url("Muuda/Kool/".$school['id']).'">Muuda</a>';
            $data['schools'][$i]['name'] = '<a href="'.site_url("Klassid/".$school['id']).'">'.$school['name'].'</a>';
            $i++;
        }

        $template = array(
            'table_open' => '<table border="1" cellpadding="4">',
            'table_close' => '
                <tr><td colspan="5"><a href="'.site_url('Lisa/Kool').'">Lisa uus kool</a></td></tr>
                <tr><td colspan="5"><a href="'.site_url('Kustuta/Kool').'">Kustuta kool</a></td></tr>
                </table>'
        );

        $this->table->set_template($template);
        $this->table->set_heading("Id", "Kooli nimi", "Telefon", "E-Mail", "Muuda");

        $data['table'] = $this->table->generate($data['schools']);

        $this->load->view('templates/header', $data);
        $this->load->view('view/view_schools', $data);
        $this->load->view('templates/footer');
    }

    public function view_classes($school_id)
    {
        $data['classes'] = $this->database_model->get_classes($school_id);
        $data['title'] = 'Klassid';
        $i = 0;
        foreach ($data['classes'] as $class) {
            $data['classes'][$i]['name'] = '<a href="'.site_url("Nimekiri/".$class['id']).'">'.$class['name'].'</a>';
            $data['classes'][$i]['school_id'] = $this->database_model->get_school_name($class['school_id']);
            $data['classes'][$i]['edit'] = '<a href="'.site_url("Muuda/Klass/".$class['id']).'">Muuda</a>';
            $i++;
        }

        $template = array(
            'table_open' => '<table border="1" cellpadding="4">',
            'table_close' => '<tr><td colspan="4"><a href="'.site_url('Lisa/Klass/'.$school_id).'">Lisa uus klass</a> </td></tr>
                <tr><td colspan="5"><a href="'.site_url('Kustuta/Klass/'.$school_id).'">Kustuta klass</a></td></tr>
                </table>'
        );

        $this->table->set_template($template);
        $this->table->set_heading("Id", "Kooli nimi", "Klassi nimi", "Muuda");

        $data['table'] = $this->table->generate($data['classes']);

        $this->load->view('templates/header', $data);
        $this->load->view('view/view_classes', $data);
        $this->load->view('templates/footer');
    }

    public function view_books()
    {
        $data['books'] = $this->database_model->get_books();
        $data['title'] = 'Raamatud';
        $i = 0;
        foreach ($data['books'] as $book) {
            $data['books'][$i]['edit'] = '<a href="'.site_url("Muuda/Raamat/".$book['id']).'">Muuda</a>';
            $i++;
        }

        $template = array(
            'table_open' => '<table border="1" cellpadding="4">',
            'table_close' => '<tr><td colspan="5"><a href="'.site_url('Lisa/Raamat').'">Lisa uus raamat</a> </td></tr>
                <tr><td colspan="5"><a href="'.site_url('Kustuta/Raamat').'">Kustuta raamat</a></td></tr>
                </table>'
        );

        $this->table->set_template($template);
        $this->table->set_heading("Id", "Raamatu nimi", "Autor", "Aasta", "Muuda");

        $data['table'] = $this->table->generate($data['books']);

        $this->load->view('templates/header', $data);
        $this->load->view('view/view_books', $data);
        $this->load->view('templates/footer');
    }

    public function view_reading_list($class_id)
    {
        $data['list'] = $this->database_model->get_reading_list_from_class($class_id);
        $data['title'] = 'Lugemis Nimekiri';

        $i = 0;
        foreach ($data['list'] as $book) {
            $data['list'][$i]['class_id'] = $this->database_model->get_class_by_id($class_id)['name'];
            $data['list'][$i]['book_id'] = $this->database_model->get_book_by_id($book['book_id'])['title'];
            $i++;
        }

        $template = array(
            'table_open' => '<table border="1" cellpadding="4">',
            'table_close' => '<tr><td colspan="5"><a href="'.site_url('Lisa/Nimekiri/'.$class_id).'">Lisa nimekirja raamat</a> </td></tr>
                <tr><td colspan="5"><a href="'.site_url('Kustuta/Nimekiri/'.$class_id).'">Kustuta Nimekirjast</a></td></tr>
                </table>'
        );

        $this->table->set_template($template);
        $this->table->set_heading("Id", "Klass", "Raamatu Nimi");

        $data['table'] = $this->table->generate($data['list']);

        $this->load->view('templates/header', $data);
        $this->load->view('view/reading_list', $data);
        $this->load->view('templates/footer');
    }
}