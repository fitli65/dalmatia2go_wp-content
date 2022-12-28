/*-------------------------------------
Template name:  	One Listing
Version:        	1.0
Author Name:        wpWax
---------------------------------------
JS INDEX
=======================================
#. Preloadeer
#. Search Popup
#. Mobile Menu
#. Magnific Popup
#. Counter Up
#. Click to Copy
#. Average Rating Cont
#. Author Dropdown Activation
#. Listing With map
#. Search Home category Icon
#. Responsive Menu Trigger
#. Botstrap Tooltip
#. Contact Info
---------------------------------------*/

"use strict";

(function ($) {
    var theme = {

        /* Preloader */
        preloader: function () {
            if ($('#theme-preloader') !== null) {
                $('#theme-preloader').fadeOut('slow', function () {
                    // $(this).remove();
                });
            }
        },

        /* Search Popup */
        searchPopup: function () {
            const searchTrigger = document.querySelector('.theme-menu-action-box__search--trigger');
            const seachPopup = document.querySelector('#theme-search-popup');
            const btnClose = document.querySelector('.theme-popup-close');
            const shade = document.querySelector('.theme-shade');

            function triggerSearchPopup(e) {
                e.preventDefault();
                if (seachPopup) {
                    seachPopup.classList.add("theme-popup-open");
                    shade.classList.add("theme-show");
                }
            }

            function closeSearchPopup(e) {
                e.preventDefault();
                seachPopup.classList.remove("theme-popup-open");
                shade.classList.remove("theme-show");
            }
            if (searchTrigger) {
                searchTrigger.addEventListener('click', triggerSearchPopup);
            }

            if(btnClose){
                btnClose.addEventListener('click', closeSearchPopup)
            }
            if(shade){
                shade.addEventListener('click', closeSearchPopup)
            }
        },


        /* Swiper Slider */
        swiperSlider: function () {

            /* Check Slider Data */
            let checkData = function (data, value) {
                return typeof data === 'undefined' ? value : data;
            };

            /* Swiper Slider */
            let swiperCarousel = document.querySelectorAll('.theme-swiper');
            let swiperCarouselNested = document.querySelectorAll('.theme-swiper-nested');
            swiperCarousel.forEach(function (el, i) {
                let hasPagination = false;
                let hasNav = false;
                const alllistingSlider = el.closest('.theme-swiper-slider');
                el.classList.add(`theme-swiper-${i}`);

                if (alllistingSlider) {
                    alllistingSlider.querySelector('.theme-swiper-slider__top').childNodes.forEach(elm => {
                        if (elm.className === "theme-swiper-button-nav-wrap") {
                            hasNav = true;
                        }
                    });
                } else if (el.querySelector('.theme-swiper-button-nav-wrap')) {
                    hasNav = true;
                }

                let navBtnPrev = el.querySelectorAll('.theme-swiper-button-prev');
                let navBtnNext = el.querySelectorAll('.theme-swiper-button-next');
                if (alllistingSlider) {
                    navBtnPrev = alllistingSlider.querySelectorAll('.theme-swiper-button-prev');
                    navBtnNext = alllistingSlider.querySelectorAll('.theme-swiper-button-next');
                }

                el.childNodes.forEach(elc => {
                    if (elc.className === "theme-swiper-pagination") {
                        hasPagination = true;
                    }
                    if (elc.className === "theme-swiper-navigation") {

                        hasNav = true;
                    }
                });

                const paginationElement = document.querySelectorAll(".theme-swiper-pagination");
                hasNav && navBtnPrev.forEach((el) => {
                    el.classList.add(`theme-swiper-button-prev-${i}`);
                });
                hasNav && navBtnNext.forEach((el) => {
                    el.classList.add(`theme-swiper-button-next-${i}`);
                });

                hasPagination && paginationElement.forEach((el) => el.classList.add(`theme-swiper-pagination-${i}`));
                let swiper1 = new Swiper(`.theme-swiper-${i}`, {
                    slidesPerView: parseInt(checkData(el.dataset.swItems, 4)),
                    spaceBetween: parseInt(checkData(el.dataset.swMargin, 30)),
                    loop: checkData(el.dataset.swLoop, true),
                    slidesPerGroup: parseInt(checkData(el.dataset.swPerslide, 2)),
                    speed: parseInt(checkData(el.dataset.swSpeed, 3000)),
                    autoplay: checkData(el.dataset.swAutoplay, {}),
                    freeMode: checkData(el.dataset.swFreemode, false),
                    watchSlidesProgress: checkData(el.dataset.swWatchprogress, false),
                    slideToClickedSlide: checkData(el.dataset.swslidetoclickedside, false),
                    navigation: {
                        nextEl: `.theme-swiper-button-next-${i}`,
                        prevEl: `.theme-swiper-button-prev-${i}`,
                    },
                    pagination: {
                        el: `.theme-swiper-pagination-${i}`,
                        type: 'bullets',
                        clickable: true,
                    },
                    breakpoints: checkData(el.dataset.swResponsive ? JSON.parse(el.dataset.swResponsive) : undefined, {})
                });

                var swiper2 = new Swiper(".product-gallery-main", {
                    spaceBetween: 10,
                    loop: true,
                    thumbs: {
                        swiper: swiper1,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        type: "fraction",
                    },
                });
            });

            swiperCarouselNested.forEach(function (el, i) {

                let navBtnPrevNested = document.querySelectorAll('.theme-swiper-button-prev-nested');
                let navBtnNextNested = document.querySelectorAll('.theme-swiper-button-next-nested');

                navBtnPrevNested.forEach((el, i) => {
                    el.classList.add(`theme-swiper-button-prev-nested-${i}`);
                });
                navBtnNextNested.forEach((el, i) => {
                    el.classList.add(`theme-swiper-button-next-nested-${i}`);
                });
                el.classList.add(`theme-swiper-nested-${i}`);
                let swiper = new Swiper(`.theme-swiper-nested-${i}`, {
                    slidesPerView: checkData(parseInt(el.dataset.swItems), 4),
                    spaceBetween: checkData(parseInt(el.dataset.swMargin), 30),
                    loop: checkData(el.dataset.swLoop, true),
                    slidesPerGroup: checkData(parseInt(el.dataset.swPerslide), 1),
                    speed: checkData(parseInt(el.dataset.swSpeed), 3000),
                    autoplay: checkData(el.dataset.swAutoplay, {}),
                    observer: true,
                    observeParents: true,
                    navigation: {
                        nextEl: `.theme-swiper-button-next-nested`,
                        prevEl: `.theme-swiper-button-prev-nested`,
                    },
                    pagination: {
                        el: `.theme-swiper-pagination-nested`,
                        type: 'bullets',
                        clickable: true,
                    },
                    breakpoints: checkData(el.dataset.swResponsive ? JSON.parse(el.dataset.swResponsive) : undefined, {})
                });
            });
        },
        
        /* Mobile Menu */
        mobileMenu(dropDownTrigger, dropDown) {
            $('body').on('click', '.theme-responsive-menu a', function (e) {
                if ($(this).parent().hasClass('menu-item-has-children')) {
                    e.preventDefault();
                }
                if ($(this).closest('.theme-responsive-menu-trigger').length !== 0) {
                    $(this).parent().toggleClass('theme-submenu-open');

                    $(this).siblings(dropDown)
                        .slideToggle().parent().siblings('.sub-menu')
                        .children(dropDown).slideUp().siblings(dropDownTrigger).parent().removeClass('theme-submenu-open');
                }
            });

            $('body').on('click', '.theme-mobile-menu-trigger', function () {
                $('.theme-responsive-menu-trigger .theme-main-navigation-inner').addClass('theme-offcanvas-active');
                $('.theme-mobile-menu-overlay').addClass('theme-mobile-menu-triggered');
            });

            $('body').on('click', '.theme-mobile-menu-close, .theme-mobile-menu-overlay', function (e) {
                e.preventDefault();
                $('.theme-responsive-menu-trigger .theme-main-navigation-inner').removeClass('theme-offcanvas-active');
                $('.theme-mobile-menu-overlay').removeClass('theme-mobile-menu-triggered');
            });
        },

        /* Responsive Menu Trigger */
        responsiveMenuTrigger: function () {

            const menuArea = document.querySelector('.theme-header-menu-area');
            const navCollapse = onelisting_localize_data.resmenuWidth;
            const windowWidth = window.innerWidth;

            if (navCollapse >= windowWidth) {
                document.querySelector('html').classList.add('theme-responsive-menu-trigger');
                menuArea && menuArea.classList.add('theme-responsive-menu');

            } else {
                document.querySelector('html').classList.remove('theme-responsive-menu-trigger');
                menuArea && menuArea.classList.remove('theme-responsive-menu');
            }
        },

        /* Magnific Popup */
        magnificPopup: function () {
            
            const seeAllButton = document.querySelector('.btn-listing-see-all');

            if (seeAllButton) {
                $('body').on('click', '.btn-listing-see-all', function(e) {
                    e.preventDefault();
                    $('.theme-single-listing-slider__item:not(.swiper-slide-duplicate)').magnificPopup('open');
                });
            }

            if ($('.theme-single-listing-slider__item').length !== 0) {
                
                $('.theme-single-listing-slider__item:not(.swiper-slide-duplicate)').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    mainClass: 'mfp-zoom-in',
                    autoFocusLast: false
                });
            }

        },

        /* Counter up */
        counterUpPlugin: function () {
            $(".theme-counter__count").each(function () {
                var options = $(this).data('options');
                $(this).counterUp(options);
            });
        },

        /* Click Copy */
        clickToCopy: function () {

            $('#copyBtn').on('click', function (e) {
                e.preventDefault();
                let copyText = document.getElementById('copyUrl').value;

                // Create Virtual Dom
                let textArea = document.createElement("textarea");
                textArea.value = copyText;
                $(this).append(textArea);
                textArea.select();

                try {
                    document.execCommand("copy");
                    $(this).addClass('copied');
                } catch (err) {
                    alert('Sorry!! Please refresh Your Page to copy again')
                }
                textArea.remove();
            });

        },

        /* Average Rating Count */
        avgRatings: function () {

            const ratingWrapper = document.querySelectorAll('.ratings');
            ratingWrapper.forEach((elm, ind) => {
                const dataRating = elm.getAttribute('data-rating');
                const dataRatingFloat = parseFloat(dataRating);
                switch (dataRatingFloat) {
                    case 1:
                        elm.classList.add('one');
                        break;
                    case 2:
                        elm.classList.add('two');
                        break;
                    case 3:
                        elm.classList.add('three');
                        break;
                    case 4:
                        elm.classList.add('four');
                        break;
                    case 5:
                        elm.classList.add('five');
                        break;
                    default:
                        elm.classList.add('none');
                }

                function fractionClass(v1, v2, classOne, classTwo) {
                    if (dataRatingFloat > v1 && dataRatingFloat < v2) {
                        elm.classList.add(classOne, classTwo);
                    }
                }

                fractionClass(1, 2, 'one', 'one-n-half');
                fractionClass(2, 3, 'two', 'two-n-half');
                fractionClass(3, 4, 'three', 'three-n-half');
                fractionClass(4, 5, 'four', 'four-n-half');
            });
        },

        /* Author Drodown Activation */
        authorDropdownActive: function () {

            const authorTrigger = document.querySelector('.theme-header-action__author--info img');
            const shade = document.querySelector('.theme-white-shade');
            const authorDropdown = document.querySelector('.theme-header-author-navigation');

            function authorDropdownActive() {

                authorDropdown.classList.toggle('theme-show');

                shade.classList.toggle('theme-show');

            }

            function removeDropdown() {

                authorDropdown.classList.remove('theme-show');

                shade.classList.remove('theme-show');

            }

            if (authorTrigger) {
                authorTrigger.addEventListener('click', authorDropdownActive);
            }

            if (shade) {
                shade.addEventListener('click', removeDropdown);

                shade.classList.remove('.theme-white-shade');
            }


        },

        /* Listing With Map */
        listingsWithMap: function (param) {
            $('body').on('submit', '#directorist-search-area-form', function (e) {
                var form = $(this);
                $.post(
                    onelisting_localize_data.ajaxurl, {
                        action: 'onelisting_map_header_title',
                        post_id: $('.directorist-listing-map-title').data('post-id'),
                        form: form.serialize(),
                    },
                    function (data) {
                        $('.directorist-listing-map-title').html(data);
                    }
                );

            });
        },

        /* Search Home Category Icon */
        categoriesWithIcon: function () {

            // getOptionIcon
            function getOptionIcon(optionID) {
                return onelisting_localize_data.category_icons[optionID];
            }

            function getOptionColor(optionID) {
                return onelisting_localize_data.category_colors[optionID];
            }

            // convertToSelect2
            function convertToSelect2(field) {
                if (!field) {
                    return;
                }
                if (!field.elm) {
                    return;
                }
                if (!field.elm.length) {
                    return;
                }

                const default_args = {
                    allowClear: true,
                    dropdownCssClass: "theme-home-search-category",
                    width: '100%',
                    templateResult: function (data) {
                        // We only really care if there is an element to pull classes from
                        if (!data.element) {
                            return data.text;
                        }
                        var $element = $(data.element);
                        var color = getOptionColor(data.id);
                        var icon = getOptionIcon(data.id);
                        if (icon) {
                            var content = `<i class="directorist-icon-mask theme-category-icon" aria-hidden="true" style="--directorist-icon: url(${icon}); background-color: #${color};";></i> ${data.text}`;

                        } else {
                            let iconURL = directorist.assets_url + 'icons/line-awesome/svgs/tag-solid.svg';
                            let iconHTML = directorist.icon_markup.replace( '##URL##', iconURL ).replace( '##CLASS##', 'theme-category-icon' );
                            var content = `${iconHTML} ${data.text}`;
                        }
                        var $wrapper = $('<span>' + content + '</span>');

                        $wrapper.addClass($element[0].className);

                        return $wrapper;
                    }
                };

                var args = (field.args && typeof field.args === 'object') ? Object.assign(default_args, field.args) : default_args;

                var options = field.elm.find('option');
                var placeholder = (options.length) ? options[0].innerHTML : '';

                if (placeholder.length) {
                    args.placeholder = placeholder;
                }

                field.elm.select2(args);
            }

            // Init Select 2
            if ($('.cat_with_icon').length > 0) {
                convertToSelect2({
                    elm: $('.cat_with_icon')
                });
            }

            if ($('#directorist-search-area-form select').length > 0) {
                convertToSelect2({
                    elm: $('#directorist-search-area-form select')
                });
            }

        },

        /* listing slider */
        listingSlider: function () {
            const thumbList = document.querySelectorAll('.directorist-listing-single__thumb-slider');
            thumbList.forEach(function (el) {
                let totalItem = el.dataset.items;
                let iconLeft = directorist.assets_url + 'icons/line-awesome/svgs/angle-left-solid.svg';
                let iconRight = directorist.assets_url + 'icons/line-awesome/svgs/angle-right-solid.svg';
                var slider = tns({
                    "container": el,
                    "items": totalItem,
                    "slideBy": 1,
                    "autoplay": false,
                    "loop": false,
                    "controls": true,
                    "gutter": 0,
                    "speed": 1000,
                    "mouseDrag": true,
                    "controlsText": [iconLeft, iconRight],
                    "nav": true,
                });
            });
        },

        /* Search Dropdown */
        searchDropDown: function () {

            $("body").on("click", ".directorist-filter-btn", function () {
                $(this).closest(".directorist-filter-btn").toggleClass("active");
            });

            $("body").on("click", ".theme-search-dropdown .theme-search-dropdown__label", function () {
                console.log(this)
                $(this).closest(".theme-search-dropdown").toggleClass("active");
            });

            $('body').on('click', function (e) {
                if (!$(e.target).closest('.theme-search-dropdown').length) {
                    $(".theme-search-dropdown").removeClass("active");
                }
            });
        },


        directory_type: function () {
            var deviceType = $("body").attr("data-elementor-device-mode");
            if(deviceType === 'mobile'){
                const typeNavigation = document.querySelectorAll('.directorist-listing-type-selection');
                typeNavigation.forEach((navElement)=>{
                    navElement.scrollLeft = 0;
                    let navItems = navElement.querySelectorAll('.search_listing_types');
                    for(let i=0; i<navItems.length; i++){
                        if(navItems[i].classList.contains('directorist-listing-type-selection__link--current')){
                            navElement.scrollLeft = navItems[i].offsetLeft;
                        }
                    }
                });
            }
        },

        /* Search Dropdown */
        updateArchiveListings: function () {

            $('.directorist-thumb-listing-author').closest('.directorist-listing-single').addClass('directorist-listing-has-thumb-active');

            $("body").on('click', '.directorist-type-nav__list li', function () {
                $(".directorist-type-nav__list li.current").removeClass("current");
                $(this).addClass("current");
            });

            $('.elementor-page .elementor-widget-wpwaxtheme-all-listings .directorist-archive-contents .directorist-type-nav a.directorist-type-nav__link').click(function (e) {
                e.preventDefault();

                let href = $(e.target).attr('href');
                if (undefined === href) {
                    return;
                }

                let start = href.indexOf("=");
                let type = href.slice(start + 1);
                let parentDiv = e.target.closest('.directorist-archive-contents');
                let atts = $(parentDiv).data('atts');

                $.post(
                    onelisting_localize_data.ajaxurl, {
                        action: 'onelisting_archive_listings',
                        type: type,
                        atts: atts,
                    },
                    function (data) {

                        if (data) {

                            let gridFound = $(parentDiv).find('.directorist-archive-grid-view');
                            if (gridFound) {
                                $(gridFound).remove()
                            }

                            let listFound2 = $(parentDiv).find('.directorist-archive-list-view');
                            if (listFound2) {
                                $(listFound2).remove()
                            }

                            $(parentDiv).append(data);
                        }
                    }
                );
            });

        },

        /* Contact Button  */
        contactButton: function () {

            if ($('#onelisting-contact-owner-form') !== null) {
                $('body').on('submit', '#onelisting-contact-owner-form', function (e) {
                    e.preventDefault();

                    $('#directorist-contact-message-display').append('<div class="atbdp-spinner"></div>');

                    // Post via AJAX
                    const data = {
                        action: 'atbdp_public_send_contact_email',
                        post_id: $('#onelisting-post-id').val(),
                        name: $('#atbdp-contact-name').val(),
                        email: $('#atbdp-contact-email').val(),
                        listing_email: $('#atbdp-listing-email').val(),
                        message: $('#atbdp-contact-message').val(),
                        directorist_nonce: directorist.directorist_nonce,
                    };

                    $.post(
                        onelisting_localize_data.ajaxurl,
                        data,
                        function (response) {
                            if (response.error == 1) {
                                $('#directorist-contact-message-display')
                                    .addClass('text-danger')
                                    .html(response.message);
                            } else {
                                $('#atbdp-contact-message').val('');
                                $('#directorist-contact-message-display')
                                    .addClass('text-success')
                                    .html(response.message);
                            }
                        },
                        'json'
                    );
                });
            }

        },
    }

    theme.responsiveMenuTrigger();
    /* Window Resize */
    $(window).resize(function () {
        theme.responsiveMenuTrigger();
    });

    /* Content Ready Scripts */
    function content_ready_scripts() {
        theme.searchPopup();
        theme.mobileMenu('.menu-item a', '.sub-menu');
        theme.clickToCopy();
        theme.counterUpPlugin();
        theme.avgRatings();
        theme.authorDropdownActive();
        theme.listingsWithMap();
        theme.categoriesWithIcon();
        theme.updateArchiveListings();
        theme.contactButton();
        theme.responsiveMenuTrigger();
    }

    /* Content Load Scripts */
    function content_load_scripts() {
        theme.preloader();
        theme.swiperSlider();
        theme.listingSlider();
        theme.magnificPopup();
        theme.categoriesWithIcon();
        theme.directory_type();
        theme.responsiveMenuTrigger();
    }

    window.addEventListener('directorist-reload-listings-map-archive', function () {
        // theme.searchDropDown();
        theme.categoriesWithIcon();
        theme.listingSlider();
    });

    window.addEventListener('directorist-search-form-nav-tab-reloaded', function () {
        // theme.searchDropDown();
        theme.categoriesWithIcon();
    });
    
     window.addEventListener('directorist-instant-search-reloaded', function () {
        // theme.searchDropDown();
    });

    /* Load Scripts after Change Directory Type*/
    function initSetup() {
        theme.categoriesWithIcon();
        theme.searchDropDown();
        theme.directory_type();
    }
    $(window).on('load', initSetup);
    // $(window).on('directorist-search-form-nav-tab-reloaded', initSetup);
    
    $(document).ready(function () {
        content_ready_scripts();
    });

    $(window).on('load', function () {
        content_load_scripts();
    });



    /* Elementor Edit Mode */
    $(window).on('elementor/frontend/init', function () {
        setTimeout(() => {
            if (elementorFrontend.isEditMode()) {
                //elementorFrontend.hooks.addAction('frontend/element_ready/widget', function() {
                content_ready_scripts()                
                theme.swiperSlider();
                theme.categoriesWithIcon();
                //});
            }
        }, 6000);
    });

    // Bootstrap Tooltip Initialize
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
})(jQuery);