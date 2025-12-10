<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // =========================================================================
    // MANAJEMEN DATA PENGGUNA (LOGIN & REGISTER)
    // =========================================================================

    /**
     * Mengambil data user berdasarkan username.
     * Digunakan saat proses LOGIN untuk memverifikasi apakah user ada
     * dan mengambil hash password untuk dicocokkan.
     * * @param string $username Username yang diinput user
     * @return object Data user (row) atau NULL jika tidak ditemukan
     */
    public function get_by_username($username) {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    /**
     * Menyimpan data user baru ke database.
     * Digunakan saat proses REGISTER.
     * * @param array $data Array asosiatif berisi (username, email, password_hash)
     */
    public function insert($data) {
        $this->db->insert('users', $data);
    }

}