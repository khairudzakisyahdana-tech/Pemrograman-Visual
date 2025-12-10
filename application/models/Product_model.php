<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    // =========================================================================
    // BAGIAN 1: MANAJEMEN PRODUK (GET DATA)
    // =========================================================================

    /**
     * Mengambil detail satu produk berdasarkan ID.
     * Digunakan di halaman Detail Produk.
     */
    public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    /**
     * Mengambil produk terkait (Related Products) untuk rekomendasi.
     */
    public function get_related_products($current_product_id, $category, $limit = 4) {
        $this->db->where('id !=', $current_product_id); // Exclude produk ini
        $this->db->where('category', $category);         // Filter kategori
        $this->db->order_by('id', 'DESC');               // Urutkan dari terbaru
        $this->db->limit($limit); 
        return $this->db->get('products')->result();
    }

    /**
     * Mengambil produk berdasarkan kategori (Tanpa Pagination).
     * Digunakan untuk section di Halaman Home.
     */
    public function get_products_by_category($kategori, $limit) {
        return $this->db->get_where('products', ['category' => $kategori], $limit)->result();
    }

    /**
     * Mengambil produk secara acak.
     * Digunakan untuk section "Featured" di Home.
     */
    public function get_featured_products($limit) {
        $this->db->order_by('id', 'RANDOM');
        return $this->db->get('products', $limit)->result();
    }


    // =========================================================================
    // BAGIAN 2: PAGINATION (SHOP & KATEGORI)
    // =========================================================================

    /**
     * Menghitung total semua produk di database.
     * Diperlukan oleh Library Pagination untuk menentukan jumlah halaman.
     */
    public function get_count_all() {
        return $this->db->count_all('products');
    }

    /**
     * Mengambil semua produk dengan batasan Limit dan Offset.
     */
    public function get_products_paginated($limit, $start) {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('products')->result();
    }

    /**
     * Menghitung jumlah produk berdasarkan Kategori spesifik.
     */
    public function get_count_category($category) {
        $this->db->where('category', $category);
        return $this->db->count_all_results('products');
    }

    /**
     * Mengambil produk kategori tertentu dengan Pagination.
     */
    public function get_products_by_category_paginated($category, $limit, $start) {
        $this->db->where('category', $category);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('products')->result();
    }


    // =========================================================================
    // BAGIAN 3: MANAJEMEN KERANJANG (CART DATABASE)
    // =========================================================================

    /**
     * Menambahkan item ke keranjang.
     */
    public function add_to_cart($data) {
        // 1. Cek apakah user ini sudah punya produk ID sama dengan UKURAN yang sama?
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('size', $data['size']); 
        $cek = $this->db->get('cart')->row();

        if ($cek) {
            // SKENARIO A: Barang sudah ada, update jumlahnya saja
            $this->db->where('id', $cek->id);
            $this->db->update('cart', ['qty' => $cek->qty + $data['qty']]);
        } else {
            // SKENARIO B: Barang belum ada, masukkan sebagai baris baru
            $this->db->insert('cart', $data);
        }
    }
    /**
     * Mengupdate jumlah (qty) barang di keranjang berdasarkan ID Cart.
     */
    // Update jumlah barang di keranjang (Plus/Minus)


    /**
     * Mengambil seluruh isi keranjang milik user tertentu.
     * Menggunakan JOIN TABLE untuk mengambil detail produk (Nama, Harga, Gambar)
     * berdasarkan product_id yang ada di tabel cart.
     */
    public function get_cart_by_user($user_id) {
        $this->db->select('cart.*, products.name, products.price, products.image1');
        $this->db->from('cart');
        // Hubungkan tabel cart dengan products
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        $this->db->order_by('cart.id', 'DESC'); 
        return $this->db->get()->result();
    }

    /**
     * Menghapus satu item dari keranjang berdasarkan ID Cart.
     */
    public function remove_cart_item($id) {
        $this->db->where('id', $id);
        $this->db->delete('cart');
    }

    // ... fungsi lain ...

    // FUNGSI UPDATE QTY DISINI
    public function update_cart_qty($cart_id, $qty) {
        $this->db->where('id', $cart_id);
        $this->db->update('cart', ['qty' => $qty]);
    }

} // <--- INI TUTUP KURUNG CLASS (JANGAN TARUH SETELAH INI)
