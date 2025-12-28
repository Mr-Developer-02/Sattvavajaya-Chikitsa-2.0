(function($) {

    "use strict";
                // init Chocolat light box
                var initChocolat = function () {
                  Chocolat(document.querySelectorAll('.image-link'), {
                    imageSize: 'contain',
                    loop: true,
                  })
                }

        document.addEventListener("DOMContentLoaded", function(){
        
          window.addEventListener('scroll', function() {
              
            if (window.scrollY > 50) {
              document.getElementById('primary-header').classList.add('fixed-top');
            } else {
              document.getElementById('primary-header').classList.remove('fixed-top');
              // remove padding top from body
              document.body.style.paddingTop = '0';
            } 
          });
        }); 
        // DOMContentLoaded  end



        $(document).ready(function() {

          initChocolat();
  

          $(".user-items .search-item").click(function(){
              $(".search-box").toggleClass('active');
              $(".search-box .search-input").focus();
            });
            $(".close-button").click(function(){
              $(".search-box").toggleClass('active');
            });  

          var swiper = new Swiper(".testimonial-swiper", {
            loop: true,
            pagination: {
              el: ".swiper-pagination",
              clickable: true,
            },
          }); 


          var swiper = new Swiper(".team-swiper", {
            slidesPerView: 2,
            spaceBetween: 20,
            pagination: {
              el: "#our-team .swiper-pagination",
              clickable: true,
            },
            breakpoints: {
              0: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
              1200: {
                slidesPerView: 2,
                spaceBetween: 10,
              },
            },
          });  

          window.addEventListener("load", (event) => {
            //isotope
            $('.isotope-container').isotope({
              // options
              itemSelector: '.item',
              layoutMode: 'masonry'
            });
      
      
      
            // Initialize Isotope
            var $container = $('.isotope-container').isotope({
              // options
              itemSelector: '.item',
              layoutMode: 'masonry'
            });
      
            $(document).ready(function () {
              //active button
              $('.filter-button').click(function () {
                $('.filter-button').removeClass('active');
                $(this).addClass('active');
              });
            });
      
            // Filter items on button click
            $('.filter-button').click(function () {
              var filterValue = $(this).attr('data-filter');
              if (filterValue === '*') {
                // Show all items
                $container.isotope({ filter: '*' });
              } else {
                // Show filtered items
                $container.isotope({ filter: filterValue });
              }
            });
      
          });
      
      


        }); // End of a document      



    })(jQuery);


    document.addEventListener("DOMContentLoaded", function() {
      var toggler = document.querySelector('.navbar-toggler');
      var togglerIcon = document.querySelector('.navbar-toggler-icon');
      var closeIcon = document.querySelector('.navbar-close-icon');
      var navbarCollapse = document.getElementById('navbar-primary');

      if (togglerIcon) {
        togglerIcon.style.backgroundImage =
          "url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 30 30\" xmlns=\"http://www.w3.org/2000/svg\"><path stroke=\"%231CBCCF\" stroke-width=\"3\" stroke-linecap=\"round\" stroke-miterlimit=\"10\" d=\"M4 7h22M4 15h22M4 23h22\"/></svg>')";
        togglerIcon.style.backgroundRepeat = "no-repeat";
        togglerIcon.style.backgroundPosition = "center";
        togglerIcon.style.backgroundSize = "2rem 2rem";
      }

      // Toggle open/close icon
      if (toggler && togglerIcon && closeIcon && navbarCollapse) {
        toggler.addEventListener('click', function() {
          setTimeout(function() {
            var isOpen = navbarCollapse.classList.contains('show');
            if (isOpen) {
              togglerIcon.style.display = "none";
              closeIcon.style.display = "flex";
            } else {
              togglerIcon.style.display = "block";
              closeIcon.style.display = "none";
            }
          }, 200); // Wait for collapse animation
        });

        // Also handle closing when nav is closed by clicking outside or link
        navbarCollapse.addEventListener('hidden.bs.collapse', function () {
          togglerIcon.style.display = "block";
          closeIcon.style.display = "none";
        });
        navbarCollapse.addEventListener('shown.bs.collapse', function () {
          togglerIcon.style.display = "none";
          closeIcon.style.display = "flex";
        });
      }
    });