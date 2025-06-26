/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Check if current page is home page
    function isHomePage() {
        const path = window.location.pathname;
        return path === '/';
    }

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        
        // Only apply scroll behavior on home page
        if (isHomePage()) {
            if (window.scrollY === 0) {
                navbarCollapsible.classList.remove('navbar-shrink')
            } else {
                navbarCollapsible.classList.add('navbar-shrink')
            }
        } else {
            // For non-home pages, always show navbar in shrunk state
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Initialize navbar state based on page type
    const navbarCollapsible = document.body.querySelector('#mainNav');
    if (navbarCollapsible) {
        if (isHomePage()) {
            // On home page, shrink navbar based on scroll position
            navbarShrink();
            // Add scroll listener only for home page
            document.addEventListener('scroll', navbarShrink);
        } else {
            // On other pages, immediately show navbar in shrunk state
            navbarCollapsible.classList.add('navbar-shrink');
        }
    }

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Counter Animation untuk Stats Section
    // Fungsi untuk animasi counter
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        const timer = setInterval(() => {
            start += increment;
            element.textContent = Math.floor(start);
            
            if (start >= target) {
                element.textContent = target;
                clearInterval(timer);
            }
        }, 16);
    }
    
    // Intersection Observer untuk trigger animasi saat elemen terlihat
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-target'));
                    animateCounter(stat, target);
                });
                
                // Hentikan observasi setelah animasi dijalankan
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Mulai observasi pada stats section
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
    
    // Smooth scrolling untuk link anchor (jika ada)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Parallax effect untuk background (optional)
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const aboutSection = document.querySelector('.about-section');
    });

    // ===== MODAL FUNCTIONS - TAMBAHAN UNTUK POP-UP =====
    
    // Fungsi untuk membuka modal
    window.openModal = function() {
        const modal = document.getElementById('companyModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    };

    // Fungsi untuk menutup modal
    window.closeModal = function() {
        const modal = document.getElementById('companyModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }
    };

    // Setup modal event listeners
    const modal = document.getElementById('companyModal');
    if (modal) {
        // Menutup modal saat klik di luar container
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                window.closeModal();
            }
        });
    }

    // Menutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeModal();
        }
    });

    // ===== END MODAL FUNCTIONS =====

});
    // News Modal Functions
    window.openNewsModal = function(newsId) {
        const modal = document.getElementById('newsModal' + newsId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeNewsModal = function(newsId) {
        const modal = document.getElementById('newsModal' + newsId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    };

    // Setup modal event listeners when document is ready
    $(document).ready(function() {
        // Close modal when clicking outside
        $('.news-modal-overlay').on('click', function(e) {
            if (e.target === this) {
                const newsId = this.id.replace('newsModal', '');
                window.closeNewsModal(newsId);
            }
        });
        
        // Close modal with ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                const activeNewsModal = document.querySelector('.news-modal-overlay.active');
                if (activeNewsModal) {
                    const newsId = activeNewsModal.id.replace('newsModal', '');
                    window.closeNewsModal(newsId);
                }
            }
        });
    });

