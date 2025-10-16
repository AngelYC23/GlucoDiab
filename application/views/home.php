<div class="home-container">
  <div class="home-card">
    <div class="home-header">
      <div class="neu-icon">
        <div class="icon-inner">
          <img src="<?= base_url('assets/img/glc.png') ?>" alt="Logo GlucoDiab" class="icon-logo">
        </div>
      </div>
      <h2>Bienvenido a Gluco<span>Diab</span></h2>
      <p>Monitorea tu glucosa y mejora tu salud día a día.</p>
      <img src="<?= base_url('assets/img/glucodiab_home.jpg') ?>" alt="Controla tu glucosa con GlucoDiab" class="home-image">
    </div>
  </div>
</div>

<!-- ============================= -->
<!-- Sección educativa -->
<!-- ============================= -->
<div class="home-container">
  <div class="home-card">
    <div class="home-header">
      <h2>Aprende sobre la glucosa</h2>
      <p>Entiende cómo cuidar tus niveles de glucosa y mejora tu bienestar con información clara y confiable.</p>
    </div>

    <div class="educacion-grid">
      <div class="edu-card neu-section">
        <h3>🔬 ¿Qué es la glucosa?</h3>
        <p>
          La glucosa es el principal tipo de azúcar en la sangre y la fuente de energía más importante para el cuerpo.
          Mantenerla en niveles normales es esencial para la salud y el buen funcionamiento del organismo.
        </p>
      </div>

      <div class="edu-card neu-section">
        <h3>💉 Valores recomendados</h3>
        <p>
          En adultos, los valores normales de glucosa suelen oscilar entre <strong>70 y 100 mg/dL</strong> en ayuno.
          Niveles superiores o inferiores deben ser evaluados por un profesional de la salud.
        </p>
      </div>

      <div class="edu-card neu-section">
        <h3>🍎 Cómo mantenerla estable</h3>
        <p>
          Mantén una alimentación balanceada, realiza actividad física regularmente y evita el consumo excesivo de azúcares.
          El monitoreo constante te ayudará a prevenir complicaciones.
        </p>
      </div>

      <div class="edu-card neu-section">
        <h3>⚠️ Síntomas del descontrol de glucosa</h3>
        <p>
          Cuando los niveles de glucosa son anormales, pueden aparecer síntomas como sed excesiva, cansancio,
          visión borrosa, hambre constante o mareos.  
          Si estos síntomas persisten, consulta a un médico para un diagnóstico adecuado.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- ============================= -->
<!-- Sección "Sobre nosotros" -->
<!-- ============================= -->
<div class="home-container">
  <div class="home-card">
    <div class="home-header">
      <h2>Sobre Gluco<span>Diab</span></h2>
    </div>
    <section class="neu-section">
      <p>
        GlucoDiab es una plataforma desarrollada para apoyar el control y comprensión de los niveles de glucosa en sangre,
        ofreciendo información confiable y fácil de entender. Nuestro objetivo es ayudar a las personas a adoptar hábitos saludables
        y tomar decisiones informadas sobre su bienestar. Este proyecto busca integrar tecnología, ciencia y educación para acompañarte en tu cuidado diario,
        recordándote que la prevención es la clave para una mejor calidad de vida.
      </p>
    </section>
  </div>
</div>

<!-- ============================= -->
<!-- Sección "Contacto" -->
<!-- ============================= -->
<div class="home-container">
  <div class="home-card">
    <div class="home-header">
      <h2>Contáctanos</h2>
      <p>¿Tienes alguna pregunta o sugerencia? ¡Nos encantará saber de ti!</p>
    </div>

    <form class="contact-form neu-section">
      <div class="form-group">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre">
      </div>

      <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo">
      </div>

      <div class="form-group">
        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="4"></textarea>
      </div>

      <button type="submit" class="neu-button login-btn">Enviar mensaje</button>
    </form>
  </div>
</div>
