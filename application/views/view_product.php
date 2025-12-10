<?php
// Pastikan file diakses melalui CodeIgniter untuk keamanan
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISUAL251L1 | <?= isset($p->name) ? $p->name : 'Product Detail' ?></title>
    
    <script src="https://kit.fontawesome.com/3cd64c1c44.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">      
    <link rel="stylesheet" href="<?= base_url('assets/style/style_etalase.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/style/style_product.css'); ?>">
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
                            <a class="nav-link" href="<?= site_url('auth/cart') ?>"><i class="fas fa-shopping-bag"></i></a> 
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

        <!-- Bagian PRODUK -->
        <section class="container sproduct my-5 pt-5">
            <div class="row mt-5">
                
                <div class="col-lg-5 col-md-12 col-12">
                    <img class="img-fluid w-100" src="<?= base_url('assets/images/featured/' . $p->image1); ?>" id="MainImg" alt="">

                    <div class="small-img-group">
                        <?php 
                        // Buat array berisi 4 gambar dari database
                        $images = [$p->image1, $p->image2, $p->image3, $p->image4];                       
                        foreach($images as $img): 
                            $show_img = !empty($img) ? $img : $p->image1;
                        ?>
                        <div class="small-img-col">
                            <img src="<?= base_url('assets/images/featured/' . $show_img); ?>" width="100%" class="small-img" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <h6>Home / <?= htmlspecialchars($p->category) ?></h6>
                    
                    <h3 class="py-4"><?= htmlspecialchars($p->name) ?></h3>
                    <h2>Rp. <?= number_format($p->price, 0, ',', '.') ?></h2>

                    <div class="mb-3">
                        <?php
                        $rating = isset($p->rating) ? $p->rating : 4.0;
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < floor($rating)) { echo '<i class="fas fa-star text-warning"></i>'; }
                            elseif ($i < $rating) { echo '<i class="fas fa-star-half-alt text-warning"></i>'; }
                            else { echo '<i class="far fa-star text-warning"></i>'; }
                        }
                        ?>
                        <span class="text-muted ms-2">(<?= $rating ?> / 5.0)</span>
                    </div>

                    <form action="<?= site_url('auth/add_to_cart_process') ?>" method="post">
                        
                        <input type="hidden" name="product_id" value="<?= $p->id ?>">
                        
                        <select name="size" class="my-3" required>
                            <option value="">Select Size</option>
                            <?php 
                            // Pecah string ukuran dari DB (misal: "S,M,L") jadi array
                            if (!empty($p->sizes)) {
                                $ukuran_array = explode(',', $p->sizes);
                                foreach ($ukuran_array as $ukuran) {
                                    echo '<option value="' . trim($ukuran) . '">' . trim($ukuran) . '</option>';
                                }
                            } else {
                                echo '<option value="All Size">All Size</option>';
                            }
                            ?>
                        </select>

                        <input type="number" name="qty" value="1" min="1" style="width: 50px; padding: 5px;">
                        
                        <button type="submit" class="buy-btn">Add To Cart</button>
                    </form>

                    <h4 class="mt-5 mb-5">Product Details</h4>
                    <p><?= nl2br(htmlspecialchars($p->description)) ?></p>
                </div>  
            </div>
        </section>

        <!-- Bagian PRODUK TERKAIT -->
        <section id="featured" class="my-5 pb-5">
            <div class="container text-center mt-5 py-5">
                <h3>Related Products</h3>
                <hr class="mx-auto">
            </div>
            <div class="row mx-auto container-fluid">
                <?php 
                // Menggunakan variabel $related_products yang dikirim dari Controller
                if (!empty($related_products)):
                    foreach ($related_products as $r_p): ?>
                    
                    <div class="product text-center col-lg-3 col-md-4 col-12">
                        <a href="<?= site_url('auth/product/' . $r_p->id) ?>">
                            <img class="img-fluid mb-3" src="<?= base_url('assets/images/featured/' . $r_p->image1); ?>" alt="">
                        </a>
                        
                        <div class="star">
                            <?php
                            $r_rating = isset($r_p->rating) ? $r_p->rating : 4.0;
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < floor($r_rating)) { echo '<i class="fas fa-star text-warning"></i>'; }
                                elseif ($i < $r_rating) { echo '<i class="fas fa-star-half-alt text-warning"></i>'; }
                                else { echo '<i class="far fa-star text-warning"></i>'; }
                            }
                            ?>
                        </div>
                        
                        <h5 class="p-name"><?= $r_p->name ?></h5>
                        <h4 class="p-price">Rp. <?= number_format($r_p->price, 0, ',', '.') ?></h4>
                        
                        <a href="<?= site_url('auth/product/' . $r_p->id) ?>">
                            <button class="buy-btn">Buy Now</button>
                        </a>
                    </div>
                    
                    <?php endforeach; 
                else: ?>
                    <p class="text-center w-100">Tidak ada produk terkait.</p>
                <?php endif; ?>
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
        
        <script>
            var MainImg = document.getElementById('MainImg');
            var smallimg = document.getElementsByClassName('small-img');

            for (let i = 0; i < smallimg.length; i++) {
                smallimg[i].onclick = function() {
                    MainImg.src = smallimg[i].src;
                }
            }
        </script>
    </body>
</html>