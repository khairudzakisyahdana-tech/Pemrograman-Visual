<?php
// Mencegah akses langsung ke file ini tanpa lewat Controller (Keamanan Dasar)
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISUAL251L1 | Novara</title>
    
    <script src="https://kit.fontawesome.com/3cd64c1c44.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">      
    <link rel="stylesheet" href="<?= base_url('assets/style/style_etalase.css'); ?>">
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

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= site_url('auth/home') ?>">Home</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        // Mengambil data username dari session
                        $username = $this->session->userdata('username');
                        
                        // Jika username ada (artinya user SUDAH login)
                        if ($username): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> Halo, <?= htmlspecialchars($username) ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Logout</a></li>
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

        <!-- Bagian HOME -->
        <section id="home">
            <div class="container">
                <h5>NEW ARRIVALS</h5>
                <h1><span>Best Price</span> This Year</h1>
                <p>Shoomatic offers your very comfortable time<br>on walking and exercises.</p> 
                <button onclick="window.location.href='<?= site_url('auth/shop') ?>'">Shop Now</button>
            </div>
        </section>
        
        <!-- Bagian BRAND -->
        <section id="brand" class="container">
            <div class="row m-0 py-4 justify-content-center align-items-center">
                <?php for($i=1; $i<=5; $i++): ?>
                    <img class="img-fluid col-lg-2 col-md-4 col-6" src="<?= base_url('assets/images/brand/'.$i.'.png'); ?>" alt="">
                <?php endfor; ?>
            </div>
        </section>

        <!-- Bagian NEW ARRIVALS -->
        <section id="new" class="w-100">
            <div class="row p-0 m-0">
                <div class="one col-lg-4 col-md-12 col-12 p-0">
                    <img class="img-fluid" src="<?= base_url('assets/images/new/1.png'); ?>" alt="">
                    <div class="details">
                        <h2>Urban Edge Hoodies</h2>
                        <button class="text-uppercase" onclick="document.getElementById('hoodie').scrollIntoView({behavior: 'smooth'})">Shop Now</button>
                    </div>
                </div>
                <div class="one col-lg-4 col-md-12 col-12 p-0">
                    <img class="img-fluid" src="<?= base_url('assets/images/new/2.png'); ?>" alt="">
                    <div class="details">
                        <h2>Elite Street Kicks</h2>
                        <button class="text-uppercase" onclick="document.getElementById('Shoes').scrollIntoView({behavior: 'smooth'})">Shop Now</button>
                    </div>
                </div>
                <div class="one col-lg-4 col-md-12 col-12 p-0">
                    <img class="img-fluid" src="<?= base_url('assets/images/new/3.png'); ?>" alt="">
                    <div class="details">
                        <h2>Signature Essential Tees</h2>
                        <button class="text-uppercase" onclick="document.getElementById('TShirt').scrollIntoView({behavior: 'smooth'})">Shop Now</button>
                    </div>
                </div>    
            </div>
        </section>

        <!-- Bagian FEATURED PRODUCTS -->
        <section id="featured" class="my-5 pb-5">
            <div class="container text-center mt-5 py-5">
                <h3>Our Featured</h3>
                <hr class="mx-auto">
                <p>Here you can check out our new products with fair price on novara.</p>
            </div>
            <div class="row mx-auto container-fluid">
                
                <?php 
                // LOOPING PRODUK:
                // Mengambil array $featured_products yang dikirim dari Controller
                // $p adalah variabel sementara untuk satu produk
                foreach ($featured_products as $p): 
                ?>
                <div class="product text-center col-lg-3 col-md-4 col-12">
                    
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" alt="">
                    </a>
                    
                    <div class="star">
                        <?php
                        // 1. Cek apakah ada rating? Jika tidak, default 4.0
                        $rating = isset($p->rating) ? $p->rating : 4.0; 
                        
                        // 2. Loop 5 kali (untuk 5 bintang)
                        for ($i = 0; $i < 5; $i++) {
                            // Jika index lebih kecil dari rating (misal 3 < 4.5), cetak bintang penuh
                            if ($i < floor($rating)) { 
                                echo '<i class="fas fa-star text-warning"></i>'; 
                            }
                            // Jika ada sisa desimal (setengah bintang)
                            elseif ($i < $rating) { 
                                echo '<i class="fas fa-star-half-alt text-warning"></i>'; 
                            }
                            // Sisanya bintang kosong
                            else { 
                                echo '<i class="far fa-star text-warning"></i>'; 
                            }
                        }
                        ?>
                    </div>
                    
                    <h5 class="p-name"><?= $p->name ?></h5>
                    <h4 class="p-price">Rp. <?= number_format($p->price, 0, ',', '.') ?></h4>
                    
                    <a href="<?= site_url('auth/product/' . $p->id) ?>"><button class="buy-btn">Buy Now</button></a>
                </div>
                <?php endforeach; // Akhir looping ?>
                
            </div>
        </section>

        <!-- Bagian BANNER -->
        <section id="banner">
            <div class="container" class="my-5 py-5">
                <h4>MID SEASON'S SALE</h4>
                <h1>Autumn Collection<br>UP TO 20% OFF</h1>
                <button class="text-uppercase" onclick="window.location.href='<?= site_url('auth/shop') ?>'">Shop Now</button>
            </div>
        </section>

        <!-- Bagian CATEGORY PRODUCTS -->
        <section id="hoodie" class="my-5 pb-5">
            <div class="container text-center mt-5 py-5">
                <h3>Our Hoodies</h3>
                <hr class="mx-auto">
                <p>Here you can check out our new products with fair price on novara.</p>
            </div>
            <div class="row mx-auto container-fluid">
                <?php if(empty($hoodie_products)) echo '<p class="text-center">Produk Hoodie belum tersedia.</p>'; ?>
                
                <?php foreach ($hoodie_products as $p): ?>
                <div class="product text-center col-lg-3 col-md-4 col-12">
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" alt="">
                    </a>
                    <div class="star">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <h5 class="p-name"><?= $p->name ?></h5>
                    <h4 class="p-price">Rp. <?= number_format($p->price, 0, ',', '.') ?></h4>
                    <a href="<?= site_url('auth/product/' . $p->id) ?>"><button class="buy-btn">Buy Now</button></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Bagian CATEGORY PRODUCTS -->
        <section id="Shoes" class="my-5 pb-5">
            <div class="container text-center mt-5 py-5">
                <h3>Our Shoes</h3> <hr class="mx-auto">
                <p>Here you can check out our new products with fair price on novara.</p>
            </div>
            <div class="row mx-auto container-fluid">
                <?php if(empty($shoes_products)) echo '<p class="text-center">Produk Sepatu belum tersedia.</p>'; ?>
                <?php foreach ($shoes_products as $p): ?>
                <div class="product text-center col-lg-3 col-md-4 col-12">
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" alt="">
                    </a>
                    <div class="star">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <h5 class="p-name"><?= $p->name ?></h5>
                    <h4 class="p-price">Rp. <?= number_format($p->price, 0, ',', '.') ?></h4>
                    <a href="<?= site_url('auth/product/' . $p->id) ?>"><button class="buy-btn">Buy Now</button></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Bagian CATEGORY PRODUCTS -->
        <section id="TShirt" class="my-5 pb-5">
            <div class="container text-center mt-5 py-5">
                <h3>Our T-Shirts</h3>
                <hr class="mx-auto">
                <p>Here you can check out our new products with fair price on novara.</p>
            </div>
            <div class="row mx-auto container-fluid">
                <?php foreach ($tshirt_products as $p): ?>
                <div class="product text-center col-lg-3 col-md-4 col-12">
                    <a href="<?= site_url('auth/product/' . $p->id) ?>">
                        <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" alt="">
                    </a>
                    <div class="star">
                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    </div>
                    <h5 class="p-name"><?= $p->name ?></h5>
                    <h4 class="p-price">Rp. <?= number_format($p->price, 0, ',', '.') ?></h4>
                    <a href="<?= site_url('auth/product/' . $p->id) ?>"><button class="buy-btn">Buy Now</button></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Bagian FOOTER -->
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