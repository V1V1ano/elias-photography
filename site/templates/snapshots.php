<?php snippet('header') ?>

<?php
  // Only image files, keep Kirby's manual sort order (Panel sorting) if available
  $images = $page->images()->filterBy('type', 'image')->sortBy('sort', 'asc');

  // Build plain PHP arrays (avoids collection/map edge cases)
  $urls = [];
  $alts = [];

  foreach ($images as $img) {
    // Serve a resized thumbnail instead of the multi-megabyte original.
    // 2000px on the long edge is plenty for retina full-screen viewing;
    // Kirby caches the thumbnail on first request under /media/, so
    // subsequent visits are served from disk without re-processing.
    $urls[] = $img->resize(2000)->url();
    $alts[] = $img->alt()->or($img->filename())->value();
  }

  $total = count($urls);
?>

<div class="snapshots-nav-zones" aria-hidden="true">
  <button class="snapshots-zone snapshots-zone--prev" type="button" tabindex="-1" data-zone-prev></button>
  <button class="snapshots-zone snapshots-zone--next" type="button" tabindex="-1" data-zone-next></button>
</div>

<section class="snapshots">
  <?php if ($total === 0): ?>
    <p class="snapshots-empty">No images yet.</p>
  <?php else: ?>
    <div class="snapshots-frame">
      

      <figure class="snapshots-figure">
        <div class="snapshots-stage">
            <img
                class="snapshots-img"
                src="<?= esc($urls[0]) ?>"
                alt="<?= esc($alts[0] ?? '') ?>"
                decoding="async"
                fetchpriority="high"
                data-urls='<?= esc(json_encode($urls), 'attr') ?>'
                data-alts='<?= esc(json_encode($alts), 'attr') ?>'
            />
        </div>

        <figcaption class="snapshots-counter" aria-live="polite">
            <!-- <button class="snapshots-btn" type="button" data-prev aria-label="Previous photo"></button> -->
            <span class="snapshots-number"> 
                <span data-count>1</span> / <span data-total><?= $total ?></span>
              </span>
            <!-- <button class="snapshots-btn" type="button" data-next aria-label="Next photo"></button> -->
        </figcaption>
      </figure>

      
    </div>
  <?php endif ?>
</section>

<script>
  (function () {
    const img = document.querySelector(".snapshots-img");
    if (!img) return;

    const urls = JSON.parse(img.dataset.urls || "[]");
    const alts = JSON.parse(img.dataset.alts || "[]");

    const btnPrev = document.querySelector("[data-prev]");
    const btnNext = document.querySelector("[data-next]");
    const countEl = document.querySelector("[data-count]");

    let i = 0;

    // Warm the browser cache for a given index (wraps around) so
    // clicking prev/next feels instant instead of triggering a fresh
    // network round-trip each time.
    function preload(idx) {
      const n = urls.length;
      if (n <= 1) return;
      const k = ((idx % n) + n) % n;
      const im = new Image();
      im.src = urls[k];
    }

    function render() {
      img.src = urls[i];
      img.alt = alts[i] || "";
      if (countEl) countEl.textContent = String(i + 1);
      preload(i + 1);
      preload(i - 1);
    }

    // Kick off the very first neighbour preload without waiting for the
    // first user interaction.
    preload(1);

    function prev() {
      i = (i - 1 + urls.length) % urls.length;
      render();
    }

    function next() {
      i = (i + 1) % urls.length;
      render();
    }

    btnPrev?.addEventListener("click", prev);
    btnNext?.addEventListener("click", next);

    document.querySelector("[data-zone-prev]")?.addEventListener("click", prev);
    document.querySelector("[data-zone-next]")?.addEventListener("click", next);

    window.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") prev();
      if (e.key === "ArrowRight") next();
    });
  })();
</script>

<?php snippet('footer') ?>
