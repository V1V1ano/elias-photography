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
  </section>
<?php endif ?>

<ul class="home-project-list">
  <?php foreach ($projects as $project): ?>
    <li>
      <a href="<?= $project->url() ?>">
        <?= $project->title()->esc() ?>
      </a>
    </li>
  <?php endforeach ?>
</ul>


<?php snippet('footer') ?>
