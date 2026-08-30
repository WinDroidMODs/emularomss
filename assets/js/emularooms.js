/* EmulaROOMs JS - WordPress */
(function() {
    'use strict';

    // Theme toggle
    var themeCheckbox = document.getElementById('theme-toggle');
    if (themeCheckbox) {
        var savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
            themeCheckbox.checked = true;
        }
        themeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('light-theme');
                localStorage.setItem('theme', 'light');
            } else {
                document.body.classList.remove('light-theme');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // Scroll header y back-to-top
    var header = document.getElementById('header');
    var backToTop = document.getElementById('back-to-top');

    if (header && backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 80) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            var umbralScroll = document.documentElement.scrollHeight * 0.4;
            if (window.scrollY > umbralScroll) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Cookie banner
    var cookieBanner = document.getElementById('cookie-banner');
    var cookieAccept = document.getElementById('cookie-accept');
    var cookieReject = document.getElementById('cookie-reject');

    if (cookieBanner && !localStorage.getItem('cookieConsent')) {
        cookieBanner.style.display = 'flex';
        if (cookieAccept) {
            cookieAccept.addEventListener('click', function() {
                localStorage.setItem('cookieConsent', 'accepted');
                cookieBanner.style.display = 'none';
            });
        }
        if (cookieReject) {
            cookieReject.addEventListener('click', function() {
                localStorage.setItem('cookieConsent', 'rejected');
                cookieBanner.style.display = 'none';
            });
        }
    }

    // Nav toggle y dropdowns en móvil
    var navMenu = document.getElementById('navMenu');
    var navCheckbox = document.getElementById('nav-check');

    if (navMenu) {
        function handleDropdownClick(e) {
            if (window.innerWidth > 768) return;
            var link = e.currentTarget;
            var dropdown = link.closest('.dropdown');
            if (!dropdown) return;
            e.preventDefault();
            e.stopPropagation();
            dropdown.classList.toggle('open');
        }

        var dropdownLinks = navMenu.querySelectorAll('.dropdown > a');
        dropdownLinks.forEach(function(link) {
            link.removeEventListener('click', handleDropdownClick);
            link.addEventListener('click', handleDropdownClick);
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                var openDropdowns = navMenu.querySelectorAll('.dropdown.open');
                openDropdowns.forEach(function(dd) {
                    dd.classList.remove('open');
                });
            }
        });

        if (navCheckbox) {
            navCheckbox.addEventListener('change', function() {
                if (!this.checked) {
                    var openDropdowns = navMenu.querySelectorAll('.dropdown.open');
                    openDropdowns.forEach(function(dd) {
                        dd.classList.remove('open');
                    });
                }
            });
        }
    }

    // Telegram tooltip
    var telegramBtn = document.querySelector('#telegram-floating-widget a');
    var tooltip = document.querySelector('#telegram-floating-widget .tooltip');
    var shown = false;
    var timer;

    if (telegramBtn && tooltip) {
        function showTooltip() {
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = '1';
            tooltip.style.left = window.innerWidth <= 768 ? '70px' : '85px';
        }

        function hideTooltip() {
            tooltip.style.opacity = '0';
            tooltip.style.visibility = 'hidden';
        }

        timer = setTimeout(function() {
            if (!shown) {
                showTooltip();
                shown = true;
                setTimeout(hideTooltip, 5000);
            }
        }, 10000);

        telegramBtn.addEventListener('mouseenter', function() {
            clearTimeout(timer);
            showTooltip();
        });

        telegramBtn.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    }

    // Carrusel (si existe)
    function setupCarousel(gridId, prevId, nextId) {
        var grid = document.getElementById(gridId);
        var prevBtn = document.getElementById(prevId);
        var nextBtn = document.getElementById(nextId);

        if (!grid || !prevBtn || !nextBtn) return;

        function updateButtons() {
            var tolerance = 2;
            if (grid.scrollLeft <= tolerance) {
                prevBtn.classList.add('hidden-btn');
            } else {
                prevBtn.classList.remove('hidden-btn');
            }
            if (grid.scrollLeft + grid.clientWidth >= grid.scrollWidth - tolerance) {
                nextBtn.classList.add('hidden-btn');
            } else {
                nextBtn.classList.remove('hidden-btn');
            }
        }

        prevBtn.addEventListener('click', function() { grid.scrollBy({ left: -300, behavior: 'smooth' }); });
        nextBtn.addEventListener('click', function() { grid.scrollBy({ left: 300, behavior: 'smooth' }); });
        grid.addEventListener('scroll', updateButtons);
        window.addEventListener('resize', updateButtons);
        updateButtons();
    }

    setupCarousel('related-posts-grid', 'carousel-prev', 'carousel-next');

    // Reply to comment
    window.replyToComment = function(button) {
        var commentId = button.getAttribute('data-comment-id');
        var author = button.getAttribute('data-comment-author');
        var notice = document.getElementById('reply-notice');
        var authorSpan = document.getElementById('reply-author-name');

        if (notice && authorSpan) {
            authorSpan.textContent = 'Respondiendo a ' + author;
            notice.classList.add('show');
            var commentField = document.getElementById('comment');
            if (commentField) {
                commentField.focus();
            }
        }
    };

    window.cancelReply = function() {
        var notice = document.getElementById('reply-notice');
        if (notice) {
            notice.classList.remove('show');
        }
    };
})();
