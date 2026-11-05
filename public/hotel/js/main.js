/* Hotel Nagar Palace — site scripts */
(function () {
  'use strict';

  var topBar = document.getElementById('Top_bar');
  var placeholder = document.querySelector('.header_placeholder');

  // Sticky header
  if (topBar) {
    var stickyStart = 0;
    var measure = function () {
      topBar.classList.remove('is-sticky');
      placeholder.style.height = '0';
      stickyStart = topBar.getBoundingClientRect().top + window.pageYOffset;
      onScroll();
    };
    var onScroll = function () {
      var y = window.pageYOffset;
      var barHeight = topBar.offsetHeight;
      if (y > stickyStart + barHeight) {
        if (!topBar.classList.contains('is-sticky')) {
          placeholder.style.height = barHeight + 'px';
          topBar.classList.add('is-sticky');
        }
      } else if (topBar.classList.contains('is-sticky')) {
        topBar.classList.remove('is-sticky');
        placeholder.style.height = '0';
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', measure);
    window.addEventListener('load', measure);
    measure();
  }

  // Logo fallback: show text if the image is unavailable
  var logo = document.getElementById('logo');
  if (logo) {
    var mainImg = logo.querySelector('img.logo-main');
    if (mainImg) {
      var fail = function () { logo.classList.add('no-image'); };
      if (mainImg.complete && mainImg.naturalWidth === 0) fail();
      mainImg.addEventListener('error', fail);
    }
  }

  // Search
  var searchBtn = document.querySelector('.search_button');
  var searchWrap = document.querySelector('.search_wrapper');
  if (searchBtn && searchWrap) {
    searchBtn.addEventListener('click', function (e) {
      e.preventDefault();
      searchWrap.classList.toggle('open');
      if (searchWrap.classList.contains('open')) searchWrap.querySelector('input.field').focus();
    });
    searchWrap.querySelector('.icon_close').addEventListener('click', function (e) {
      e.preventDefault();
      searchWrap.classList.remove('open');
    });
    searchWrap.querySelector('form').addEventListener('submit', function (e) {
      e.preventDefault();
      var q = searchWrap.querySelector('input.field').value.trim();
      var site = searchWrap.querySelector('form').getAttribute('data-site') || 'hotelnagarpalace.com';
      if (q) window.open('https://www.google.com/search?q=' + encodeURIComponent('site:' + site + ' ' + q), '_blank');
    });
  }

  // Mobile side menu
  var side = document.getElementById('Side_slide');
  var overlay = document.getElementById('body_overlay');
  var toggle = document.querySelector('.responsive-menu-toggle');
  if (side && toggle) {
    var sideMenu = side.querySelector('.menu_wrapper');
    var mainMenu = document.getElementById('menu');
    if (sideMenu && mainMenu && !sideMenu.children.length) sideMenu.innerHTML = mainMenu.innerHTML;
    var openSide = function (e) { e.preventDefault(); side.classList.add('open'); overlay.classList.add('open'); };
    var closeSide = function (e) { if (e) e.preventDefault(); side.classList.remove('open'); overlay.classList.remove('open'); };
    toggle.addEventListener('click', openSide);
    side.querySelector('.close').addEventListener('click', closeSide);
    overlay.addEventListener('click', closeSide);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSide(); });
  }

  // Back to top
  var backTop = document.getElementById('back_to_top');
  if (backTop) {
    backTop.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Home slider
  var slider = document.querySelector('.hero-slider');
  if (slider) {
    var slides = slider.querySelectorAll('.slide');
    var current = 0;
    var timer;
    var show = function (i) {
      slides[current].classList.remove('active');
      current = (i + slides.length) % slides.length;
      slides[current].classList.add('active');
    };
    var start = function () {
      clearInterval(timer);
      if (slides.length > 1) timer = setInterval(function () { show(current + 1); }, 9000);
    };
    var prev = slider.querySelector('.prev');
    var next = slider.querySelector('.next');
    if (prev) prev.addEventListener('click', function () { show(current - 1); start(); });
    if (next) next.addEventListener('click', function () { show(current + 1); start(); });
    start();
  }

  // Gallery lightbox
  var items = Array.prototype.slice.call(document.querySelectorAll('.bwg_lightbox'));
  if (items.length) {
    var lb = document.createElement('div');
    lb.className = 'lightbox';
    lb.innerHTML =
      '<button class="lb-close" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>' +
      '<button class="lb-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>' +
      '<img alt="">' +
      '<button class="lb-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>' +
      '<div class="lb-title"></div>';
    document.body.appendChild(lb);
    var lbImg = lb.querySelector('img');
    var lbTitle = lb.querySelector('.lb-title');
    var idx = 0;
    var openAt = function (i) {
      idx = (i + items.length) % items.length;
      var thumb = items[idx].querySelector('img');
      lbImg.src = items[idx].getAttribute('href');
      lbImg.alt = thumb ? thumb.alt : '';
      lbTitle.textContent = thumb ? thumb.title : '';
      lb.classList.add('open');
    };
    var closeLb = function () { lb.classList.remove('open'); };
    items.forEach(function (a, i) {
      a.addEventListener('click', function (e) { e.preventDefault(); openAt(i); });
    });
    lb.querySelector('.lb-close').addEventListener('click', closeLb);
    lb.querySelector('.lb-prev').addEventListener('click', function () { openAt(idx - 1); });
    lb.querySelector('.lb-next').addEventListener('click', function () { openAt(idx + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLb(); });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') closeLb();
      if (e.key === 'ArrowLeft') openAt(idx - 1);
      if (e.key === 'ArrowRight') openAt(idx + 1);
    });
  }

  // Book Now form: no server here, so hand the booking to the visitor's mail app
  var form = document.getElementById('wpforms-form-71');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var val = function (name) { return (form.elements[name].value || '').trim(); };
      var body =
        'Name: ' + val('name') + '\n' +
        'Email: ' + val('email') + '\n' +
        'Phone: ' + val('phone') + '\n' +
        'Package: ' + val('package') + '\n' +
        'Booking Date Start: ' + val('date_start') + '\n' +
        'Booking Date End: ' + val('date_end') + '\n\n' +
        val('message');
      var mailTo = form.getAttribute('data-mailto') || 'nagarvelabd@gmail.com';
      window.location.href = 'mailto:' + mailTo +
        '?subject=' + encodeURIComponent('Booking request - ' + val('name')) +
        '&body=' + encodeURIComponent(body);
      document.querySelector('.wpforms-confirmation').classList.add('show');
    });
  }
})();
