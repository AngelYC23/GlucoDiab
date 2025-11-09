<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($titulo) ? $titulo : 'GlucoDiab' ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/glc.png') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
</head>
<body>
  <header class="header">
    <div class="logo">Gluco<span>Diab</span></div>
    
    <nav>
      <?php if (!$this->session->userdata('logueado')): ?>
        <button class="neu-button-header user-btn" onclick="window.location.href='<?= site_url('auth/login') ?>'">Iniciar sesión</button>
      <?php else: ?>
        <div class="user-menu">
          <button class="neu-button-header user-btn" id="userMenuBtn">

            <?php 
              $foto = $this->session->userdata('foto_perfil');
              $tieneFoto = ($foto && file_exists(FCPATH . 'uploads/perfiles/' . $foto));
            ?>

            <?php if ($tieneFoto): ?>
                <img src="<?= base_url('uploads/perfiles/' . $foto) ?>" class="user-avatar" alt="Perfil">
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="20" height="20">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                </svg>
            <?php endif; ?>
            
          </button>

          <div class="user-dropdown" id="userDropdown">
            <a href="<?= site_url('perfil') ?>">Mi Perfil</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
          </div>
        </div>
      <?php endif; ?>
    </nav>
  </header>


  <main class="content">
