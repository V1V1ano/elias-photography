<?php snippet('header') ?>

<article class="imprint">
  <header class="imprint-header">
    <h1 class="h1"><?= $page->headline()->or($page->title())->esc() ?></h1>
  </header>

  <?php
    // Render up to 9 headline/text pairs. Empty sections are skipped.
    for ($i = 1; $i <= 11; $i++):
      $headline = $page->{'section' . $i . '_headline'}();
      $text     = $page->{'section' . $i . '_text'}();

      if ($headline->isEmpty() && $text->isEmpty()) {
        continue;
      }
  ?>
    <section class="imprint-section">
      <?php if ($headline->isNotEmpty()): ?>
        <h2 class="imprint-subheadline"><?= $headline->esc() ?></h2>
      <?php endif ?>

      <?php if ($text->isNotEmpty()): ?>
        <div class="imprint-text text">
          <?= $text->kt() ?>
        </div>
      <?php endif ?>
    </section>
  <?php endfor ?>
</article>

<?php snippet('footer') ?>
