# 🛍️ Novara - Streetwear E-Commerce Platform

**Novara** adalah aplikasi e-commerce berbasis web yang dibangun menggunakan **CodeIgniter 3**. Proyek ini dirancang untuk menawarkan pengalaman belanja fashion streetwear yang modern, responsif, dan mudah digunakan.

Aplikasi ini berfokus pada alur transaksi pengguna (*User Experience*), mulai dari pemilihan produk, manajemen keranjang belanja berbasis database, hingga simulasi checkout.

![Novara Screenshot](assets/images/screenshot-home.png)
*(Ganti link gambar di atas dengan screenshot website kamu)*

## 🚀 Fitur Utama

### 🔐 User Authentication
- **Login & Register:** Sistem keamanan menggunakan enkripsi password (`password_hash`).
- **Session Management:** Validasi akses untuk fitur belanja (hanya member yang bisa beli).

### 🛒 Shopping Experience
- **Katalog Produk:** Tampilan Grid responsif dengan Pagination otomatis.
- **Filter Kategori:** Filter produk berdasarkan kategori (Hoodie, Shoes, T-Shirts).
- **Detail Produk:** Galeri gambar interaktif dan pemilihan varian ukuran/jumlah.
- **Related Products:** Rekomendasi produk sejenis di halaman detail.

### 🛍️ Smart Cart System
- **Database-Driven Cart:** Data keranjang disimpan di database MySQL (bukan session browser), sehingga aman saat pindah perangkat.
- **Update Quantity:** Mengubah jumlah barang langsung di halaman keranjang.
- **Voucher/Kupon:** Fitur kode diskon (Contoh: `DISKON10`) dengan kalkulasi otomatis.
- **Total Calculation:** Perhitungan Subtotal, Diskon, dan Grand Total secara real-time.

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP (CodeIgniter 3 Framework)
- **Frontend:** Bootstrap 5, CSS3, JavaScript
- **Database:** MySQL
- **Server:** Apache (XAMPP/WAMP)

## 📦 Cara Instalasi

1. **Clone Repository**
   ```bash
   git clone [https://github.com/username-kamu/novara-ecommerce.git](https://github.com/username-kamu/novara-ecommerce.git)
