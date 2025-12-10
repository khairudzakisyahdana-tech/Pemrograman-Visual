<?php
// Pastikan file diakses melalui CodeIgniter
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISUAL251L1 | Shop</title>
    
    <script src="https://kit.fontawesome.com/3cd64c1c44.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">      
    <link rel="stylesheet" href="<?= base_url('assets/style/style_etalase.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/style/style_shop.css'); ?>">
</head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url('auth/home') ?>"> 
                    <img src="<?= base_url('assets/images/logo1.svg'); ?>" alt="Rymo Shop Logo" height="60">
                </a> 
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
                        
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('auth/home') ?>">Home</a></li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Shop
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="shopDropdown">
                                <li><a class="dropdown-item" href="<?= site_url('auth/shop') ?>">All Products</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/Hoodie') ?>">Hoodies</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/Shoes') ?>">Shoes</a></li>
                                <li><a class="dropdown-item" href="<?= site_url('auth/category/UNISEX') ?>">T-Shirts</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item"><a class="nav-link" href="#card">Contact Us</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('auth/cart') ?>"><i class="fas fa-shopping-bag"></i></a> 
                        </li>
                        
                        <?php 
                        $username = $this->session->userdata('username');
                        if ($username): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> Halo, <?= htmlspecialchars($username) ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('auth/login') ?>">
                                    <i class="fas fa-user"></i> Login
                                </a>
                            </li>
                        <?php endif; ?>
                        
                    </ul> 
                </div> 
            </div>
        </nav>

        <!-- Bagian PRODUK -->
        <section id="featured" class="my-5 pb-5">
            
            <div class="container mt-5 py-5">
                <h2 class="font-weight-bold">Our Products</h2> 
                <hr>
                <p>Here you can check out all our products with fair price on novara.</p>
            </div>
            
            <div class="row mx-auto container">
                    
                <?php 
                // 1. CEK DATA KOSONG
                if(empty($products)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h3>Produk tidak ditemukan.</h3>
                        <p class="text-muted">Cek database atau reset filter kategori.</p>
                        <a href="<?= site_url('auth/shop') ?>" class="btn btn-outline-dark mt-2">Lihat Semua Produk</a>
                    </div>
                <?php else: ?>

                <?php 
                // 2. LOOPING PRODUK
                foreach ($products as $p): 
                ?>
                <div class="product text-center col-lg-3 col-md-4 col-12">
                    
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" alt="<?= $p->name ?>">
                    </a>
                    
                    <div class="star">
                        <?php
                        $rating = isset($p->rating) ? $p->rating : 4.0;
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < floor($rating)) { echo '<i class="fas fa-star text-warning"></i>'; }
                            elseif ($i < $rating) { echo '<i class="fas fa-star-half-alt text-warning"></i>'; }
                            else { echo '<i class="far fa-star text-warning"></i>'; }
                        }
                        ?>
                    </div>
                    
                    <h5 class="p-name"><?= $p->name ?></h5>
                    <h4 class="p-price">Rp. <?= number_format($p->price, 0, ',', '.') ?></h4>
                    
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <button class="buy-btn">Buy Now</button>
                    </a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            
            </div>

            <div class="container mt-5 d-flex justify-content-center">
                <?= isset($pagination_links) ? $pagination_links : '' ?>
            </div>

        </section>

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