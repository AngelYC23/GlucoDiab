<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - GlucoDiab</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/glc.png') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
</head>
<body class="login-page">
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="neu-icon">
          <div class="icon-inner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
        </div>
        <h2>Crear una cuenta</h2>
        <p>Únete a GlucoDiab y empieza a monitorear tu salud</p>
      </div>

      <form class="login-form" action="<?= site_url('auth/do_register') ?>" method="post">
        <div class="form-group">
          <div class="input-group neu-input">
            <input type="text" id="nombre" name="nombre" required placeholder=" ">
            <label for="nombre">Nombre completo</label>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group neu-input">
            <input type="email" id="email" name="email" required placeholder=" ">
            <label for="email">Correo electrónico</label>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group neu-input">
            <input type="password" id="password" name="password" required placeholder=" ">
            <label for="password">Contraseña</label>
          </div>
        </div>

        <button type="submit" class="neu-button login-btn">Registrarme</button>
      </form>

      <div class="signup-link">
        <p>¿Ya tienes cuenta? <a href="<?= site_url('auth/login') ?>">Inicia sesión</a></p>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/js/form-utils.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
