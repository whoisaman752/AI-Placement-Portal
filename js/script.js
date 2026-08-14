document.addEventListener('DOMContentLoaded', function () {
    var nav = document.querySelector('.cc-navbar');
    if (!nav) return;

    function onScroll() {
        if (window.scrollY > 12) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});
