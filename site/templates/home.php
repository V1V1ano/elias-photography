<?php
/*
  Templates render the content of your pages.

  They contain the markup together with some control structures
  like loops or if-statements. The `$page` variable always
  refers to the currently active page.

  To fetch the content from each field we call the field name as a
  method on the `$page` object, e.g. `$page->title()`.

  This home template renders content from others pages, the children of
  the `photography` page to display a nice gallery grid.

  Snippets like the header and footer contain markup used in
  multiple templates. They also help to keep templates clean.

  More about templates: https://getkirby.com/docs/guide/templates/basics
*/

?>
<?php snippet('header') ?>

<?php
$mobile   = $page->heromobile()->toFile();
$desktop  = $page->herodesktop()->toFile();
$projects = page('projects')->children()->listed();
?>

<?php if ($mobile || $desktop): ?>
  <?php
    $fallback = $mobile ?: $desktop;
  ?>
  <section class="home-hero">
    <picture>
      <?php if ($desktop): ?>
        <source media="(min-width: 60rem)" srcset="<?= $desktop->resize(2400)->url() ?>">
      <?php endif ?>
      <img
        class="home-hero-img"
        src="<?= $fallback->resize(1400)->url() ?>"
        alt="<?= $fallback->alt()->esc() ?>"
      >
    </picture>

    <?php if ($page->heroheadline()->isNotEmpty()): ?>
      <h1 class="home-hero-headline">
        <?= nl2br($page->heroheadline()->esc()) ?>
      </h1>
    <?php endif ?>
  </section>
<?php endif ?>

<ul id="projects" class="home-project-list">
  <?php foreach ($projects as $project): ?>
    <?php $img = $project->titleImage()->toFile(); ?>
    <li class="home-project-item">
      <!-- <span class="home-project-arrow home-project-arrow--left" aria-hidden="true">
        <img src="<?= url('assets/icons/arrow_right.svg') ?>" alt="">
      </span>
      <span class="home-project-arrow home-project-arrow--right" aria-hidden="true">
        <img src="<?= url('assets/icons/arrow_left.svg') ?>" alt="">
      </span> -->
      <a class="home-project-link" href="<?= $project->url() ?>">
        <?php if ($img): ?>
          <figure class="home-project-figure">
            <img
              class="home-project-img"
              src="<?= $img->resize(1200)->url() ?>"
              alt="<?= $img->alt()->or($project->title())->esc() ?>"
              loading="lazy"
            >
            <figcaption class="home-project-caption">
              <span class="home-project-name"><?= $project->title()->esc() ?></span>
              <?php if ($project->year()->isNotEmpty()): ?>
                <span class="home-project-year"><?= $project->year()->esc() ?></span>
              <?php endif ?>
            </figcaption>
          </figure>
        <?php else: ?>
          <span class="home-project-title"><?= $project->title()->esc() ?></span>
        <?php endif ?>
      </a>
    </li>
  <?php endforeach ?>
</ul>


<?php snippet('footer') ?>
