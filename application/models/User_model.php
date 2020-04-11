<?php

class User_model extends CI_Model {
        private $table = "user";

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function find_all()
        {
                $this->db->from($this->table);
                $query = $this->db->get();
                if(!isset($query) || empty($query)) {
                        return null;
                }
                return $query;
        }

        public function find_limit($limit, $offset) {
                $this->db->from($this->table);
                $this->db->limit($limit, $offset);
                $query = $this->db->get();
                if(!isset($query) || empty($query)) {
                        return null;
                }
                return $query;
        }

        public function create($statement = array())
        {
                if(!isset($statement['username']) || empty($statement['username'])) {
                        return false;
                }
                $result = $this->find_by_username($statement['username']);
                if($result != null) {
                        return false;
                }
                $this->db->from($this->table);
                $this->db->set($statement);
                return $this->db->insert();
        }

        public function update($id = null, $statement = array())
        {
                if(empty($statement)) { return false; }
                if(!$id) { return false; }

                $this->db->where('id', $id);
                $this->db->update($this->table, $statement);

                return ($this->db->affected_rows() > 0);

        }

        public function delete($id = null) {
                if(!$id) { return false; }

                $this->db->from($this->table);
                $this->db->where('id', $id);

                $result = $this->db->delete();

                return ($this->db->affected_rows() > 0);
        }

        public function find_by_username($username) {
                $this->db->from($this->table);
                $this->db->where('username', $username);

                $user = $this->db->get()->row();

                if(isset($user) && $user) {
                        return $user;
                }
                return null;
        }

        public function find_by_id($id) {
                $this->db->from($this->table);
                $this->db->where('id', $id);

                $user = $this->db->get()->row();

                if(isset($user) && $user) {
                        return $user;
                }
                return null;
        }

}