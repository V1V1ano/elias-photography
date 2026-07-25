// Lightbox
Array.from(document.querySelectorAll("[data-lightbox]")).forEach(element => {
  element.onclick = (e) => {
    e.preventDefault();
    basicLightbox.create(`<img src="${element.href}">`).show();
  };
});

// Home hero: toggle body classes so header/footer text can adapt to
// the hero image's brightness (light image = black text, dark image = white text).
// Once the hero no longer overlaps a given bar, that bar defaults to black.
(() => {
  const hero = document.querySelector(".home-hero");
  if (!hero) return;

  const img = hero.querySelector("img");
  const body = document.body;
  const header = document.querySelector(".header");
  const footer = document.querySelector(".footer");

  let topDark = false;
  let bottomDark = false;

  const sampleBrightness = () => {
    try {
      const nW = img.naturalWidth;
      const nH = img.naturalHeight;
      if (!nW || !nH) return;

      const stripH = Math.max(1, Math.floor(nH * 0.2));
      const sample = 24;

      const canvas = document.createElement("canvas");
      canvas.width = sample;
      canvas.height = sample * 2;
      const ctx = canvas.getContext("2d");

      ctx.drawImage(img, 0, 0, nW, stripH, 0, 0, sample, sample);
      ctx.drawImage(img, 0, nH - stripH, nW, stripH, 0, sample, sample, sample);

      const avg = (data) => {
        let sum = 0;
        for (let i = 0; i < data.length; i += 4) {
          sum += 0.2126 * data[i] + 0.7152 * data[i + 1] + 0.0722 * data[i + 2];
        }
        return sum / (data.length / 4);
      };

      const top = avg(ctx.getImageData(0, 0, sample, sample).data);
      const bottom = avg(ctx.getImageData(0, sample, sample, sample).data);

      topDark = top < 128;
      bottomDark = bottom < 128;
    } catch (e) {
      // canvas taint or other error — leave defaults
    }
  };

  const overlaps = (a, b) =>
    a && b && a.top < b.bottom && a.bottom > b.top;

  const update = () => {
    const heroRect = hero.getBoundingClientRect();
    const headerHit = header && overlaps(header.getBoundingClientRect(), heroRect);
    const footerHit = footer && overlaps(footer.getBoundingClientRect(), heroRect);

    body.classList.toggle("hero-header-dark", headerHit && topDark);
    body.classList.toggle("hero-footer-dark", footerHit && bottomDark);
  };

  const onReady = () => {
    sampleBrightness();
    update();
  };

  if (img.complete && img.naturalWidth) {
    onReady();
  } else {
    img.addEventListener("load", onReady, { once: true });
  }

  window.addEventListener("scroll", update, { passive: true });
  window.addEventListener("resize", update);
})();

// Home page: hide the "scroll for more projects" footer hint
// once the last project in the list is (partly) visible in the viewport.
(() => {
  const hint = document.querySelector(".footer-hint");
  if (!hint) return;

  const projects = document.querySelectorAll(".home-project-item");
  if (projects.length === 0) return;

  const last = projects[projects.length - 1];

  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          hint.classList.toggle("is-hidden", entry.isIntersecting);
        });
      },
      { threshold: 0.01 }
    );
    observer.observe(last);
  }
})();

