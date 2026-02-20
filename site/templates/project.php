<?php snippet('header') ?>

<article class="project">
  <h1 class="project-title"><?= $page->title()->esc() ?></h1>

  <div class="project-metadata"> 
    <span class="project-metadata-row1"> 
      <p> <?= $page->type()->esc() ?> </p>
      <p> <?= $page->occasion()->esc() ?> </p>
    </span> 
    <span class="project-metadata-row1"> 
      <p> <?= $page->year()->esc() ?> </p>
      <p> <?= $page->city()->esc() ?> </p>
      <p> <?= $page->place()->esc() ?> </p>
    </span> 
  </div>

  <?php
    // all images in this project folder
    $images = $page->images()->sortBy('sort', 'asc');
  ?>

  <?php if ($images->isNotEmpty()): ?>
    <section class="project-images">
      <?php foreach ($images as $image): ?>
        <figure class="project-image">
          <img
            src="<?= $image->url() ?>"
            alt="<?= $image->alt()->or($image->filename())->esc() ?>"
          >
        </figure>
      <?php endforeach ?>
    </section>
  <?php endif ?>

  <?php if ($page->description()->isNotEmpty()): ?>
      <p class="project-desc"><?= $page->description()->kt() ?></p>
  <?php endif ?>

</article>

<?php snippet('footer') ?>
