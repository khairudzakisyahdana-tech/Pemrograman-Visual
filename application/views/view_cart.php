<?php
// Mencegah akses langsung ke file ini
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISUAL251L1 | Cart</title>
    
    <script src="https://kit.fontawesome.com/3cd64c1c44.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">      
    <link rel="stylesheet" href="<?= base_url('assets/style/style_etalase.css'); ?>">
</head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url('auth/home') ?>"> 
                    <img src="<?= base_url('assets/images/logo1.svg'); ?>" alt="Logo" height="60">
                </a> 
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('auth/home') ?>">Home</a></li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown">Shop</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= site_url('auth/shop') ?>">All Products</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/Hoodie') ?>">Hoodies</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/Shoes') ?>">Shoes</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/UNISEX') ?>">T-Shirts</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="#card">Contact Us</a></li>
                        
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('auth/cart') ?>"><i class="fas fa-shopping-bag"></i></a> 
                        </li>

                        <?php if ($this->session->userdata('username')) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> Halo, <?= htmlspecialchars($this->session->userdata('username')) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('auth/login') ?>">Login</a></li>
                        <?php } ?>
                    </ul> 
                </div> 
            </div>
        </nav>

        <!-- Bagian HEADER KERANJANG -->
        <section id="cart-header" class="pt-5 mt-5 container">
            <h2 class="font-weight-bold pt-5">Shopping Cart</h2>
            <hr>
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>
        </section>

        <!-- Bagian TABEL KERANJANG -->
        <section id="cart-container" class="container my-5">
            
            <?php 
            // 1. Jika Keranjang Kosong
            if (empty($cart_items)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-shopping-basket fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">Keranjang Anda Kosong</h3>
                    <p class="text-muted">Yuk, isi dengan barang-barang impianmu.</p>
                    <a href="<?= site_url('auth/shop') ?>" class="btn btn-primary mt-3 text-white fw-bold">Mulai Belanja</a>
                </div>

            <?php else: ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <td>Remove</td>
                            <td>Image</td>
                            <td>Product</td>
                            <td>Size</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Total</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $subtotal_belanja = 0;
                        
                        // Looping item keranjang
                        foreach ($cart_items as $item): 
                            // Hitung total per baris (Harga x Qty)
                            $total_per_item = $item->price * $item->qty;
                            $subtotal_belanja += $total_per_item;
                        ?>
                        <tr>
                            <td>
                                <a href="<?= site_url('auth/remove_cart/' . $item->id) ?>" onclick="return confirm('Hapus barang ini?')">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </td>
                            
                            <td><img src="<?= base_url('assets/images/featured/' . $item->image1); ?>" alt=""></td>
                            
                            <td><h5><?= $item->name ?></h5></td>
                            
                            <td><h5><?= isset($item->size) ? $item->size : '-' ?></h5></td>
                            
                            <td><h5>Rp. <?= number_format($item->price, 0, ',', '.') ?></h5></td>
                            
                            <td>
                                <form action="<?= site_url('auth/update_cart') ?>" method="post" class="d-flex align-items-center">
                                    <input type="hidden" name="cart_id" value="<?= $item->id ?>">
                                    
                                    <input class="pl-2 border rounded" type="number" name="qty" value="<?= $item->qty ?>" min="1" style="width: 60px; height: 35px;">
                                    
                                    <button type="submit" class="btn btn-sm btn-dark ms-2" title="Update Quantity">
                                        <i class="fas fa-sync-alt" style="font-size: 0.8rem;"></i>
                                    </button>
                                </form>
                            </td>
                            
                            <td><h5>Rp. <?= number_format($total_per_item, 0, ',', '.') ?></h5></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <!-- Bagian COUPON & TOTAL -->
        <?php if (!empty($cart_items)):                     
            // Hitung Total Akhir (Subtotal - Diskon)
            $diskon = $this->session->userdata('discount_amount') ? $this->session->userdata('discount_amount') : 0;
            $grand_total = $subtotal_belanja - $diskon;
            if ($grand_total < 0) $grand_total = 0; // Mencegah total minus
        ?>

        <section id="cart-bottom" class="container">
            <div class="row">
                
                <div class="coupon col-lg-6 col-md-6 col-12 mb-4">
                    <div>
                        <h5>COUPON</h5>
                        <p>Enter your coupon code if you have one.</p>
                        
                        <form action="<?= site_url('auth/apply_coupon') ?>" method="post">
                            <input type="text" name="coupon_code" placeholder="Masukkan kode kupon (contoh: DISKON10)" value="<?= $this->session->userdata('coupon_code') ?>">
                            <button type="submit">APPLY COUPON</button>
                        </form>
                        
                        <?php if($diskon > 0): ?>
                            <div class="mt-2 ps-3">
                                <small class="text-success fw-bold">
                                    <i class="fas fa-check-circle"></i> Kupon dipakai: <?= $this->session->userdata('coupon_code') ?>
                                </small>
                                <a href="<?= site_url('auth/remove_coupon') ?>" class="text-danger ms-2 small" style="text-decoration: underline;">[Hapus]</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="total col-lg-6 col-md-6 col-12">
                    <div>
                        <h5>Cart Total</h5>
                        
                        <div class="d-flex justify-content-between">
                            <h6>Subtotal</h6>
                            <p>Rp. <?= number_format($subtotal_belanja, 0, ',', '.') ?></p>
                        </div>
                        
                        <?php if($diskon > 0): ?>
                        <div class="d-flex justify-content-between text-success fw-bold">
                            <h6>Discount</h6>
                            <p>- Rp. <?= number_format($diskon, 0, ',', '.') ?></p>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between">
                            <h6>Shipping</h6>
                            <p>Gratis</p>
                        </div>
                        
                        <hr class="second-hr">
                        
                        <div class="d-flex justify-content-between">
                            <h6>Total</h6>
                            <p>Rp. <?= number_format($grand_total, 0, ',', '.') ?></p>
                        </div>
                        
                        <button class="ms-auto" onclick="alert('Terima kasih! Pesanan diproses.\nTotal Bayar: Rp. <?= number_format($grand_total, 0, ',', '.') ?>')">PROCEED TO CHECKOUT</button>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <footer id="card" class="mt-5 py-5">
            <div class="row container mx-auto pt-5">
                
                <div class="footer-one col-lg-3 col-md-6 col-12">
                    <img src="<?= base_url('assets/images/logo1.svg'); ?>" alt="">
                    <p class="pt-3">Novara menghadirkan koleksi fashion streetwear berkualitas tinggi yang memadukan kenyamanan dan gaya modern. Temukan jati dirimu dalam setiap desain kami.</p>
                </div>

                <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
                    <h5 class="pb-2">Featured</h5>
                    <ul class="text-uppercase list-unstyled">
                        <li><a href="<?= site_url('auth/category/UNISEX') ?>">T-Shirts</a></li>
                        <li><a href="<?= site_url('auth/category/Hoodie') ?>">Hoodies</a></li>
                        <li><a href="<?= site_url('auth/category/Shoes') ?>">Shoes</a></li>
                        <li><a href="<?= site_url('auth/shop') ?>">All Products</a></li>
                    </ul>
                </div>

                <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
                    <h5 class="pb-2">Contact Us</h5>
                    <div>
                        <h6 class="text-uppercase">Address</h6>
                        <p>Jl. Sudirman No. 45, Jakarta Pusat, Indonesia 10220</p>
                    </div>
                    <div>
                        <h6 class="text-uppercase">Phone</h6>
                        <p>+62 812-3456-7890</p>
                    </div>
                    <div>
                        <h6 class="text-uppercase">Email</h6>
                        <p>customerservice@novara.com</p>
                    </div>
                </div>

                <div class="footer-one col-lg-3 col-md-6 col-12">
                    <h5 class="pb-2">Instagram</h5>
                    <div class="row g-2">
                        <?php 
                        // Loop dari 1 sampai 6 untuk menampilkan gambar IG 
                        for ($i = 1; $i <= 6; $i++): 
                        ?>
                            <div class="col-4">
                                <div class="ratio ratio-1x1">
                                    <img src="<?= base_url('assets/images/insta/' . $i . '.jpg'); ?>" 
                                        class="img-fluid object-fit-cover rounded" 
                                        alt="Insta Feed">
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div> 
            
            <div class="copyright mt-5">
                <div class="row container mx-auto">
                    <div class="col-lg-3 col-md-6 col-12 mb-4">
                        <img src="<?= base_url('assets/images/payment.png') ?>" alt="">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 text-nowrap">
                        <p>NOVARA eCommerce © <?= date('Y'); ?>. All Rights Reserved</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
        
    </body>
</html>