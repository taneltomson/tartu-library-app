<?php

class Database_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_school_name($id) {
        $query = $this->db->get_where('school', array('id'=>$id));
        return $query->row_array()['name'];
    }

    public function get_school($id) {
        $query = $this->db->get_where('school', array('id'=>$id));
        return $query->row_array();
    }

    public function get_class_by_id($id) {
        $query = $this->db->get_where('class', array('id'=>$id));
        return $query->row_array();
    }

    public function get_book($book_id) {
        $query = $this->db->get_where('book', array('id'=>$book_id));
        return $query->row_array();
    }

    public function get_from_reading_list($id) {
        $query = $this->db->get_where('reading_list', array('id'=>$id));
        return $query->row_array();
    }
    
    public function get_reading_list($class_id) {
        $query = $this->db->get_where('reading_list', array('class_id'=>$class_id));
        return $query->result_array();
    }

    public function get_list() {
        $query = $this->db->get('reading_list');
        return $query->result_array();
    }

    public function get_reading_list_from_class($class_id) {
        $query = $this->db->get_where('reading_list', array('class_id'=>$class_id));
        return $query->result_array();
    }

    public function get_reading_list_from_book($book_id) {
        $query = $this->db->get_where('reading_list', array('book_id'=>$book_id));
        return $query->result_array();
    }

    public function get_schools() {
        $query = $this->db->get('school');
        return $query->result_array();
    }

    public function get_classes($id=NULL) {
        if ($id) {
            $query = $this->db->get_where('class', array('school_id'=>$id));
        } else {
            $query = $this->db->get('class');
        }
        return $query->result_array();
    }

    public function get_users() {
        $query = $this->db->get('account');
        return $query->result_array();
    }

    public function get_user() {
        $this->load->helper('url');
        $query = $this->db->get_where('account', array('email'=>$this->input->post("email"), 'pass'=>$this->input->post("password")));
        return $query->row_array();
    }

    public function get_books() {
        $query = $this->db->get('book');
        return $query->result_array();
    }

    public function get_keywords($book_id=NULL, $keyword_id=NULL) {
        if ($book_id||$keyword_id) {
            $where = array();
            if ($book_id) {
                $where['book_id'] = $book_id;
            }
            if ($keyword_id) {
                $where['keyword_id'] = $keyword_id;
            }
            $query = $this->db->get_where('book_keyword', $where);
        } else {
            $query = $this->db->get('keyword');
        }
        return $query->result_array();
    }

    public function get_keyword($keyword_id) {
        $query = $this->db->get_where('keyword', array('id'=>$keyword_id));
        return $query->row_array();
    }

    public function get_book_keyword_entry($id) {
        $query = $this->db->get_where('book_keyword', array('id'=>$id));
        return $query->row_array();
    }

    public function get_authors($book_id=NULL, $author_id=NULL) {
        if ($book_id||$author_id) {
            $where = array();
            if ($book_id) {
                $where['book_id'] = $book_id;
            }
            if ($author_id) {
                $where['author_id'] = $author_id;
            }
            $query = $this->db->get_where('book_author', $where);
        } else {
            $query = $this->db->get('author');
        }
        return $query->result_array();
    }

    public function get_author($author_id) {
        $query = $this->db->get_where('author', array('id'=>$author_id));
        return $query->row_array();
    }

    public function get_book_author_entry($id) {
        $query = $this->db->get_where('book_author', array('id'=>$id));
        return $query->row_array();
    }

    public function get_genres($book_id=NULL, $genre_id=NULL) {
        if ($book_id||$genre_id) {
            $where = array();
            if ($book_id) {
                $where['book_id'] = $book_id;
            }
            if ($genre_id) {
                $where['genre_id'] = $genre_id;
            }
            $query = $this->db->get_where('book_genre', $where);
        } else {
            $query = $this->db->get('genre');
        }
        return $query->result_array();
    }

    public function get_genre($genre_id) {
        $query = $this->db->get_where('genre', array('id'=>$genre_id));
        return $query->row_array();
    }

    public function get_book_genre_entry($id) {
        $query = $this->db->get_where('book_genre', array('id'=>$id));
        return $query->row_array();
    }

    public function add_school() {
        $this->load->helper('url');

        $data = array(
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email')
        );

        return $this->db->insert('school', $data);
    }

    public function add_class() {
        $this->load->helper('url');

        $data = array(
            'school_id' => $this->input->post('school_id'),
            'name' => $this->input->post('name')
        );

        return $this->db->insert('class', $data);
    }

    public function add_book() {
        $this->load->helper('url');

        $data = array(
            'title' => $this->input->post('title'),
            'lang' => $this->input->post('lang'),
            'year' => $this->input->post('year')
        );

        return $this->db->insert('book', $data);
    }

    public function add_book_to_reading_list() {
        $this->load->helper('url');

        $data = array(
            'class_id' => $this->input->post('class_id'),
            'book_id' => $this->input->post('book_id')
        );

        return $this->db->insert('reading_list', $data);
    }

    public function add_user() {
        $this->load->helper('url');

        $is_admin = 1;
        if ($this->input->post('is_admin') == NULL) {
            $is_admin = 0;
        }

        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'pass' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'is_admin' => $is_admin
        );

        return $this->db->insert('account', $data);
    }

    public function add_keyword() {
        $this->load->helper('url');

        $data = array(
            'name' => $this->input->post('name')
        );

        return $this->db->insert('keyword', $data);
    }

    public function add_keyword_to_book($book_id) {
        $this->load->helper('url');

        $data = array(
            'book_id' => $book_id,
            'keyword_id' => $this->input->post('keyword_id')
        );

        return $this->db->insert('book_keyword', $data);
    }

    public function add_author() {
        $this->load->helper('url');

        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname')
        );

        return $this->db->insert('author', $data);
    }

    public function add_author_to_book($book_id) {
        $this->load->helper('url');

        $data = array(
            'book_id' => $book_id,
            'author_id' => $this->input->post('author_id')
        );

        return $this->db->insert('book_author', $data);
    }

    public function add_genre() {
        $this->load->helper('url');

        $data = array(
            'name' => strtolower($this->input->post('name'))
        );

        return $this->db->insert('genre', $data);
    }

    public function add_genre_to_book($book_id) {
        $this->load->helper('url');

        $data = array(
            'book_id' => $book_id,
            'genre_id' => $this->input->post('genre_id')
        );

        return $this->db->insert('book_genre', $data);
    }

    public function edit_school($id) {
        $this->load->helper('url');

        $changes = array(
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email')
        );

        $this->db->set($changes);
        $this->db->where('id', $id);

        return $this->db->update('school');
    }

    public function edit_class($id) {
        $this->load->helper('url');

        $changes = array(
            'name' => $this->input->post('name'),
            'school_id' => $this->input->post('school_id')
        );

        $this->db->set($changes);
        $this->db->where('id', $id);

        return $this->db->update('class');
    }

    public function edit_book($id) {
        $this->load->helper('url');

        $changes = array(
            'title' => $this->input->post('title'),
            'lang' => $this->input->post('lang'),
            'year' => $this->input->post('year')
        );

        $this->db->set($changes);
        $this->db->where('id', $id);

        return $this->db->update('book');
    }

    public function edit_reading_list($class_id) {
        $this->load->helper('url');

        $changes = array(
            'class_id' => $this->input->post('class_id')
        );

        $this->db->set($changes);
        $this->db->where('class_id', $class_id);

        return $this->db->update('reading_list');
    }

    public function edit_keyword($keyword_id) {
        $this->load->helper('url');

        $changes = array(
            'name' => $this->input->post('name')
        );

        $this->db->set($changes);
        $this->db->where('id', $keyword_id);

        return $this->db->update('keyword');
    }

    public function edit_author($author_id) {
        $this->load->helper('url');

        $changes = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname')
        );

        $this->db->set($changes);
        $this->db->where('id', $author_id);

        return $this->db->update('author');
    }

    public function edit_genre($genre_id) {
        $this->load->helper('url');

        $changes = array(
            'name' => $this->input->post('name')
        );

        $this->db->set($changes);
        $this->db->where('id', $genre_id);

        return $this->db->update('genre');
    }

    public function delete_school($id=NULL) {
        $this->load->helper('url');
        if (!$id) {
            $id = $this->input->post('item_id');
        }
        $classes = $this->get_classes($id);
        foreach ($classes as $class) {
            $this->delete_class($class['id']);
        }
        $this->db->where('id', $id);

        return $this->db->delete('school');
    }

    public function delete_class($id=NULL) {
        $this->load->helper('url');
        if (!$id) {
            $id = $this->input->post('item_id');
        }

        $this->delete_reading_list($id);

        $this->db->where('id', $id);
        return $this->db->delete('class');
    }

    public function delete_reading_list($class_id) {
        $this->db->where('class_id', $class_id);
        return $this->db->delete('reading_list');
    }

    public function delete_from_reading_list($id) {
        $this->db->where('id', $id);
        return $this->db->delete('reading_list');
    }

    public function delete_book_from_reading_lists($book_id) {
        $this->db->where('book_id', $book_id);
        return $this->db->delete('reading_list');
    }

    public function delete_book($book_id) {
        $this->delete_book_from_reading_lists($book_id);
        foreach ($this->get_authors($book_id) as $entry) {
            $this->delete_author_from_book($entry['id']);
        }
        foreach ($this->get_keywords($book_id) as $entry) {
            $this->delete_keyword_from_book($entry['id']);
        }
        foreach ($this->get_genres($book_id) as $entry) {
            $this->delete_genre_from_book($entry['id']);
        }
        $this->db->where('id', $book_id);
        return $this->db->delete('book');
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('account');
    }

    public function delete_keyword($keyword_id) {
        $this->db->where('id', $keyword_id);
        return $this->db->delete('keyword');
    }

    public function delete_keyword_from_book($id) {
        $this->db->where('id', $id);
        return $this->db->delete('book_keyword');
    }

    public function delete_author($author_id) {
        $this->db->where('id', $author_id);
        return $this->db->delete('author');
    }

    public function delete_author_from_book($id) {
        $this->db->where('id', $id);
        return $this->db->delete('book_author');
    }

    public function delete_genre($genre_id) {
        $this->db->where('id', $genre_id);
        return $this->db->delete('genre');
    }

    public function delete_genre_from_book($id) {
        $this->db->where('id', $id);
        return $this->db->delete('book_genre');
    }


    public function search($authors, $keywords, $languages, $year, $genres) {
        $this->db->select('book.*');
        $this->db->from('book');
        if (!empty($keywords)) {
            $this->db->join('book_keyword', 'book.id = book_keyword.book_id', 'inner');
            $this->db->join('keyword', 'book_keyword.keyword_id = keyword.id', 'inner');
        }
        if (!empty($authors)) {
            $this->db->join('book_author', 'book.id = book_author.book_id', 'inner');
            $this->db->join('author', 'book_author.author_id = author.id', 'inner');
        }
        if (!empty($genres)) {
            $this->db->join('book_genre', 'book.id = book_genre.book_id', 'inner');
            $this->db->join('genre', 'book_genre.genre_id = genre.id', 'inner');
        }
        if (!empty($keywords)) {
            $this->db->where_in("keyword.name", $keywords);
            //$this->db->group_by("book.id, book.title");
            //$this->db->having('COUNT(DISTINCT keyword.id) = ', count($keywords));
        }
        if (!empty($authors)) {
            $this->db->where_in('author.lastname', $authors, 'after');
        }
        if (!empty($genres)) {
            $this->db->where_in('genre.name', $genres);
        }
        if (!empty($languages)) {
            $this->db->where_in('book.lang', $languages);
        }
        if (!empty($year)) {
            if (count($year) == 1) {
                $this->db->where('book.year', $year[0]);
            } else {
                $this->db->where('book.year >=', $year[0]);
                $this->db->where('book.year <=', $year[1]);
            }
        }
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result_array();
    }
}