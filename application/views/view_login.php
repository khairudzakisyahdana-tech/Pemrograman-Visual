<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Logika Mode (Login/Register)
$current_mode = $this->input->get('mode') === 'register' ? 'register' : 'login';
$title = ($current_mode === 'login') ? 'Login ke Akun' : 'Registrasi Akun Baru';
$form_action_url = ($current_mode === 'login') ? site_url('auth/login_action') : site_url('auth/register_action');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VISUAL251L1 | <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/style/style_login.css'); ?>"> 
    <script src="https://kit.fontawesome.com/3cd64c1c44.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Bagian LOGIN/REGISTER -->
    <div class="login-wrapper">
        <div class="login-container">
            
            <div class="image-panel">
                <div class="image-overlay">
                    <div class="image-content">
                        <h2>Discover Your Style</h2>
                        <p>Join us and explore the best fashion collection.</p>
                    </div>
                </div>
            </div>

            <div class="form-panel">
                
                <div class="mode-switcher">
                    <a href="<?= site_url('auth/login?mode=login') ?>" class="<?= ($current_mode === 'login') ? 'active' : '' ?>">Login</a>
                    <span>/</span>
                    <a href="<?= site_url('auth/login?mode=register') ?>" class="<?= ($current_mode === 'register') ? 'active' : '' ?>">Register</a>
                </div>
                
                <div class="form-content">
                    <h3><?= ($current_mode === 'login') ? 'Welcome Back!' : 'Create Account' ?></h3>
                    <p class="subtitle"><?= ($current_mode === 'login') ? 'Please login to your account' : 'Fill details to register' ?></p>

                    <form method="post" action="<?= $form_action_url ?>">
                        
                        <?php if ($current_mode === 'register'): ?>
                            <div class="input-group">
                                <label for="reg_email">Email Address</label>
                                <input type="email" id="reg_email" name="email" placeholder="name@example.com" required>
                            </div>
                        <?php endif; ?>
                        
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        
                        <div class="msg-container">
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn-submit">
                            <?= ($current_mode === 'login') ? 'Login' : 'Sign Up' ?>
                        </button>
                        
                        <div class="footer-link">
                            <?php if ($current_mode === 'login'): ?>
                                Don't have an account? <a href="<?= site_url('auth/login?mode=register') ?>">Sign Up</a>
                            <?php else: ?>
                                Already have an account? <a href="<?= site_url('auth/login?mode=login') ?>">Login</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>