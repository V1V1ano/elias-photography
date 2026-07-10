<?php
/*
  Snippets are a great way to store code snippets for reuse
  or to keep your templates clean.

  This footer snippet is reused in all templates.

  More about snippets:
  https://getkirby.com/docs/guide/templates/snippets
*/
?>
  </main>

  <footer class="footer">
      <div class="logo">
        <span class="logo-inline"> call: +49 17672270664 </span>
        <a class="logo-inline" href="mailto:elias.bernhardt@outlook.com">mail: contact@eliasbernhardt.com</a>
      </div>

      <?php if ($page->template()->name() === 'home'): ?>
        <div class="logo footer-hint">
          <span class="logo-inline"> scroll </span>
          <span class="logo-inline"> for more projects </span>
        </div>
      <?php endif ?>


      <!-- need to add pages imprint and data privacy -->
      <div class="logo">
        <?php if ($imprint = page('imprint')): ?>
          <a class="logo-inline" href="<?= $imprint->url() ?>"> imprint </a>
        <?php else: ?>
          <span class="logo-inline"> imprint </span>
        <?php endif ?>
        <?php if ($privacy = page('privacy')): ?>
          <a class="logo-inline" href="<?= $privacy->url() ?>"> data privacy</a>
        <?php else: ?>
          <span class="logo-inline"> data privacy</span>
        <?php endif ?>
      </div>
      
  </footer>


</body>
</html>
