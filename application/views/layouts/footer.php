  </main>

  <footer class="footer">
    <p>© <?= date('Y') ?> GlucoDiab</p>
  </footer>

  <script>
    window.USER_ID = "<?= $this->session->userdata('id_usuario'); ?>";
    window.USER_ROLE = "<?= $this->session->userdata('rol'); ?>";
    window.USER_NAME = "<?= $this->session->userdata('nombre'); ?>";
  </script>


  <script type="module" src="<?= base_url('assets/js/firebase-config.js') ?>"></script>
  <script type="module" src="<?= base_url('assets/js/chat-paciente.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>
  <script src="<?= base_url('assets/js/form-utils.js') ?>"></script>
</body>
</html>
