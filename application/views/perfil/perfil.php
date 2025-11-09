<div class="doctor-dashboard">
  <div class="agenda-card perfil-card">
    <form action="<?= site_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data" class="profile-form neu-section">

      <!-- FOTO -->
      <div class="profile-photo-container">
        <img id="previewFoto" 
          src="<?= base_url('uploads/perfiles/' . ($usuario->foto_perfil ?? 'default.png')) ?>" 
          alt="Foto de perfil">
        
        <label class="neu-button change-photo">
          Cambiar foto
          <input type="file" id="fotoInput" name="foto" accept="image/*" hidden>
        </label>
      </div>

      <!-- INPUT NOMBRE -->
      <label for="nombre">Nombre completo:</label>
      <input type="text" id="nombre" name="nombre" value="<?= $usuario->nombre ?>" required>

      <div class="botones">
        <button type="submit" class="neu-button">Guardar Cambios</button>
      </div>

    </form>

  </div>
</div>

<script>
// Previsualización instantánea
document.getElementById("fotoInput")?.addEventListener("change", function(e) {
  const file = e.target.files[0];
  if (file) {
    document.getElementById("previewFoto").src = URL.createObjectURL(file);
  }
});
</script>

<style>
/* Centrar tarjeta */
.perfil-card {
  max-width: 550px;
  margin: 0 auto;
}

/* Caja del formulario */
.profile-form {
  padding: 30px;
  border-radius: 25px;
  box-shadow: inset 6px 6px 12px #bec3cf, inset -6px -6px 12px #ffffff;
}

/* Sección de foto */
.profile-photo-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px; /* separa la foto del botón */
  margin-bottom: 30px;
}

.profile-photo-container img {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  object-fit: cover;
  box-shadow: 6px 6px 14px #bec3cf, -6px -6px 14px #ffffff;
  transition: 0.25s;
}

.profile-photo-container img:hover {
  transform: scale(1.05);
}

/* Botón "Cambiar foto" con estilo coherente */
.change-photo {
  display: inline-block;
  padding: 8px 16px;
  border-radius: 14px;
  cursor: pointer;
  text-align: center;
  font-weight: 600;
  width: auto;
  color: #3d4468;
  background: #e0e5ec;
  box-shadow: 5px 5px 10px #bec3cf, -5px -5px 10px #ffffff;
  transition: 0.2s;
}

.change-photo:hover {
  background: linear-gradient(145deg, #ffffff, #d9dee5);
  transform: translateY(-2px);
}

.change-photo:active {
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff;
  transform: translateY(0);
}


/* Input estilo neu */
#nombre {
  width: 100%;
  margin-top: 8px;
  padding: 12px 14px;
  border: none;
  border-radius: 12px;
  background: #f5f7fb;
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff;
  font-size: 15px;
  color: #3d4468;
  transition: 0.25s;
}

#nombre:focus {
  outline: none;
  box-shadow: inset 4px 4px 8px #bec3cf, inset -4px -4px 8px #ffffff;
}

/* Botones */
.botones {
  margin-top: 25px;
  text-align: center;
}

.neu-button {
  padding: 10px 22px !important;
}
</style>
