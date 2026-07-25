<?php snippet('header') ?>

<?php $titleImage = $page->titleImage()->toFile(); ?>

<article class="project">

  <section class="project-hero">
    <div class="project-hero__text">
      <div class="project-hero__top">
        <h1 class="project-title"><?= $page->title()->esc() ?></h1>

        <div class="project-metadata">
          <span class="project-metadata-row1">
            <p><?= $page->type()->esc() ?></p>
            <p><?= $page->occasion()->esc() ?></p>
          </span>
          <span class="project-metadata-row1">
            <p><?= $page->year()->esc() ?></p>
            <p><?= $page->city()->esc() ?></p>
            <p><?= $page->place()->esc() ?></p>
          </span>
        </div>
      </div>

      <?php if ($page->description()->isNotEmpty()): ?>
        <div class="project-hero__desc text">
          <p>what about/</p>
          <?= $page->description()->kt() ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($titleImage): ?>
      <figure class="project-hero__image">
        <img
          src="<?= $titleImage->url() ?>"
          alt="<?= $titleImage->alt()->or($page->title())->esc() ?>"
          width="<?= $titleImage->width() ?>"
          height="<?= $titleImage->height() ?>"
          loading="eager"
          decoding="async"
        >
      </figure>
    <?php endif; ?>
  </section>

  <?php if ($page->photoSections()->isNotEmpty()): ?>
    <section class="project-images">
      <?php foreach ($page->photoSections()->toBlocks() as $block): ?>

        <?php if ($block->type() === 'oneImage'): ?>
          <?php $img = $block->image()->toFile(); ?>
          <?php if ($img): ?>
            <figure class="project-image project-image--one">
              <img
                src="<?= $img->url() ?>"
                alt="<?= $img->alt()->or($img->filename())->esc() ?>"
                loading="lazy"
              >
            </figure>
          <?php endif; ?>

        <?php elseif ($block->type() === 'twoImages'): ?>
          <?php
            $left  = $block->left()->toFile();
            $right = $block->right()->toFile();
          ?>
          <?php if ($left || $right): ?>
            <figure class="project-image project-image--two">
              <?php if ($left): ?>
                <img
                  class="project-image__img"
                  src="<?= $left->url() ?>"
                  alt="<?= $left->alt()->or($left->filename())->esc() ?>"
                  loading="lazy"
                >
              <?php endif; ?>

              <?php if ($right): ?>
                <img
                  class="project-image__img"
                  src="<?= $right->url() ?>"
                  alt="<?= $right->alt()->or($right->filename())->esc() ?>"
                  loading="lazy"
                >
              <?php endif; ?>
            </figure>
          <?php endif; ?>

        <?php endif; ?>

      <?php endforeach; ?>
    </section>
  <?php endif; ?>

  <?php if ($page->description()->isNotEmpty()): ?>
    <div class="project-desc text">
      <p>what about/</p>
      <?= $page->description()->kt() ?>
    </div>
  <?php endif; ?>

</article>

<?php snippet('footer') ?>