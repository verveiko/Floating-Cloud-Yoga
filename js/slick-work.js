// jQuery(document).ready(function($){
            jQuery('.testimonials').slick({
            	dots: true,
                arrows: false,
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplaySpeed: 6000, // speed is in milliseconds
                responsive: [
                {
                  breakpoint: 480,
                  settings: {
                    autoplay: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 4000 // speed is in milliseconds
                  }
                } ]                        
            });
         // });