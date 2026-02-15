<?php snippet('header') ?>


<?php
  $image = $page->images()->filterBy('type', 'image')->sortBy('sort', 'asc')->first();
?>

<article class="about">
  <div class="about-layout">

    <div class="about-left">
      <header class="about-title">
        <h1><?= $page->name()->or($page->title())->esc() ?></h1>
      </header>

      <section class="about-texts">
        <div class="about-text about-text--top text">
          <?= $page->textupper()->kt() ?>
        </div>

        <div class="about-text about-text--bottom">
          <h2 class="clients-title">
            <?= $page->clientsheadline()->or('Clients')->esc() ?>
          </h2>

          <?php if ($page->clients()->isNotEmpty()): ?>
            <ul class="clients-list">
              <?php foreach ($page->clients()->toStructure() as $client): ?>
                <li class="clients-item">
                  <span class="clients-icon" aria-hidden="true">✶</span>
                  <span class="clients-name"><?= $client->name()->esc() ?></span>
                </li>
              <?php endforeach ?>
            </ul>
          <?php endif ?>
        </div>
      </section>
    </div>

    <div class="about-media">
      <?php if ($image): ?>
        <img
          class="about-img"
          src="<?= $image->resize(1600)->url() ?>"
          alt="<?= $image->alt()->or($image->filename())->esc() ?>"
        >
      <?php endif ?>
    </div>

  </div>
</article>

<?php snippet('footer') ?>
