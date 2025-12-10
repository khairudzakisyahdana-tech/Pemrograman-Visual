<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Model dan Library yang dibutuhkan di seluruh controller ini
        $this->load->model('User_model');
        $this->load->model('Product_model');
        $this->load->library('session');
        $this->load->library('pagination');
    }


    // =========================================================================
    // BAGIAN 1: HALAMAN UTAMA (HOME)
    // =========================================================================

    public function home() {
        // Mengambil data untuk 4 Section berbeda di Home Page
        // Limit diatur agar tampilan pas dengan grid layout
        $data['featured_products'] = $this->Product_model->get_featured_products(16);
        $data['hoodie_products']   = $this->Product_model->get_products_by_category('Hoodie', 12);
        $data['shoes_products']    = $this->Product_model->get_products_by_category('Shoes', 12);
        $data['tshirt_products']   = $this->Product_model->get_products_by_category('UNISEX', 12);
        
        $this->load->view('view_home', $data);
    }


    // =========================================================================
    // BAGIAN 2: OTENTIKASI & AKUN (LOGIN / REGISTER / LOGOUT)
    // =========================================================================

    public function index() {
        // Jika akses root auth, lempar ke login
        $this->login();
    }

    public function login() {
        $this->load->view('view_login');
    }

    /**
     * Proses Verifikasi Login
     */
    public function login_action() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        // Cek user di database
        $user = $this->User_model->get_by_username($username);
        
        if($user && password_verify($password, $user->password)) {
            // Login Berhasil: Simpan ID dan Username ke Session
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            redirect('auth/home');
        } else {
            // Login Gagal: Beri pesan error
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('auth/login?mode=login');
        }
    }

    /**
     * Proses Registrasi Akun Baru
     * Password di-hash menggunakan Bcrypt (PASSWORD_DEFAULT) sebelum disimpan.
     */
    public function register_action() {
        if($this->input->post()) {
            $data = [
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            ];
            
            $this->User_model->insert($data);
            $this->session->set_flashdata('success', 'Akun berhasil dibuat, silakan login!');
            redirect('auth/login?mode=login');
        } else {
            redirect('auth/login?mode=register');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login?mode=login');
    }


    // =========================================================================
    // BAGIAN 3: HALAMAN SHOP & KATEGORI (DENGAN PAGINATION)
    // =========================================================================

    /**
     * Halaman Shop Utama (Menampilkan Semua Produk)
     */
    public function shop() {
        // 1. Konfigurasi Pagination
        $config['base_url']   = site_url('auth/shop');
        $config['total_rows'] = $this->Product_model->get_count_all();
        $config['per_page']   = 12; 
        $config['uri_segment']= 3; // Angka halaman ada di segmen 3 URL

        // 2. Terapkan Styling Bootstrap ke Pagination
        $this->_style_pagination($config);

        // 3. Inisialisasi
        $this->pagination->initialize($config);

        // 4. Ambil Data Sesuai Halaman (Offset)
        $page = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
        
        $data['products'] = $this->Product_model->get_products_paginated($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('view_shop', $data);
    }

    /**
     * Halaman Filter Kategori (Menu Dropdown)
     */
    public function category($kategori_url = NULL) {
        if ($kategori_url == NULL) {
            redirect('auth/shop');
        }

        $kategori = urldecode($kategori_url);

        $config['base_url']   = site_url('auth/category/' . $kategori_url);
        $config['total_rows'] = $this->Product_model->get_count_category($kategori);
        $config['per_page']   = 16;
        $config['uri_segment']= 4; // Angka halaman ada di segmen 4 URL

        $this->_style_pagination($config);
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? (int)$this->uri->segment(4) : 0;
        
        $data['products'] = $this->Product_model->get_products_by_category_paginated($kategori, $config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('view_shop', $data);
    }


    // =========================================================================
    // BAGIAN 4: DETAIL PRODUK
    // =========================================================================

    public function product($id = NULL) {
        if ($id == NULL) { redirect('auth/shop'); }
        
        // Ambil data produk utama
        $data['p'] = $this->Product_model->get_product_by_id($id);

        if (!$data['p']) { show_404(); } // Error jika ID tidak ditemukan
        
        // Ambil Produk Terkait (Related) berdasarkan kategori yang sama
        $category = $data['p']->category;
        $data['related_products'] = $this->Product_model->get_related_products($id, $category, 8); 

        $this->load->view('view_product', $data);
    }


    // =========================================================================
    // BAGIAN 5: KERANJANG BELANJA (CART)
    // =========================================================================

    /**
     * Menambah item ke keranjang via Form Detail Produk.
     */
    public function add_to_cart_process() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $data = [
            'user_id'    => $this->session->userdata('user_id'),
            'product_id' => $this->input->post('product_id'),
            'qty'        => $this->input->post('qty'),
            'size'       => $this->input->post('size')
        ];

        // Validasi: Jika size kosong (misal aksesoris), set default
        if(empty($data['size'])) {
             $data['size'] = 'All Size';
        }

        $this->Product_model->add_to_cart($data);
        redirect('auth/cart');
    }
    
    /**
     * Shortcut "Buy Now" dari halaman depan.
     */
    public function add_to_cart($product_id) {
         if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $data = [
            'user_id'    => $this->session->userdata('user_id'),
            'product_id' => $product_id,
            'qty'        => 1,
            'size'       => 'All Size' // Default
        ];
        
        $this->Product_model->add_to_cart($data);
        redirect('auth/cart');
    }

    public function cart() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $user_id = $this->session->userdata('user_id');
        // Ambil data keranjang + join tabel produk untuk gambar & nama
        $data['cart_items'] = $this->Product_model->get_cart_by_user($user_id);
        
        $this->load->view('view_cart', $data);
    }

    public function remove_cart($id) {
        $this->Product_model->remove_cart_item($id);
        redirect('auth/cart');
    }

    // Fungsi Update Qty Cart (Plus / Minus)
    public function update_cart() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $cart_id = $this->input->post('cart_id');
        $qty     = $this->input->post('qty');

        // --- TAMBAHKAN BARIS INI UNTUK CEK ---
        echo "ID Cart: " . $cart_id . "<br>";
        echo "Jumlah Baru: " . $qty;

        // Validasi: Qty minimal 1
        if ($qty < 1) { $qty = 1; }

        $this->Product_model->update_cart_qty($cart_id, $qty);
        redirect('auth/cart');
    }


    // =========================================================================
    // BAGIAN 6: FITUR KUPON (LOGIKA SESSION)
    // =========================================================================

    /**
     * Sistem Kupon Sederhana.
     */
    public function apply_coupon() {
        $code = $this->input->post('coupon_code');

        // Cek Kode Kupon (Hardcoded)
        if ($code == 'DISKON10') {
            $this->session->set_userdata('discount_amount', 10000);
            $this->session->set_userdata('coupon_code', $code);
            $this->session->set_flashdata('success', 'Kupon Berhasil! Potongan Rp 10.000');
        } 
        elseif ($code == 'HEMAT50') {
            $this->session->set_userdata('discount_amount', 50000);
            $this->session->set_userdata('coupon_code', $code);
            $this->session->set_flashdata('success', 'Wow! Potongan Hemat Rp 50.000');
        }
        elseif ($code == 'KONTOL') {
            $this->session->set_userdata('discount_amount', 20000000000);
            $this->session->set_userdata('coupon_code', $code);
            $this->session->set_flashdata('success', 'Wow! Potongan Kontol Jadi Gratis Dong');
        }
        else {
            $this->session->set_flashdata('error', 'Kode kupon tidak valid.');
        }

        redirect('auth/cart');
    }

    public function remove_coupon() {
        // Hapus data diskon dari session
        $this->session->unset_userdata('discount_amount');
        $this->session->unset_userdata('coupon_code');
        $this->session->set_flashdata('success', 'Kupon dihapus.');
        redirect('auth/cart');
    }


    // =========================================================================
    // FUNGSI BANTUAN (PRIVATE HELPER)
    // =========================================================================
    
    /**
     * Konfigurasi Styling Pagination Bootstrap 5.
     */
    private function _style_pagination(&$config) {
        $config['full_tag_open']    = '<nav><ul class="pagination justify-content-center mt-5">';
        $config['full_tag_close']   = '</ul></nav>';
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';
        $config['next_link']        = '&raquo;';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']   = '</span></li>';
        $config['prev_link']        = '&laquo;';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '</span></li>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
    }
}