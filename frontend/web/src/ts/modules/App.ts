import AppHelper from './AppHelper';
import JqPlugins from './JqPlugins';
import 'slick-carousel';
import 'particles.js/particles.js';
//import 'wowjs/dist/wow.min.js';
declare let jQuery: any;
declare let window: any;
declare let particlesJS: any;
declare let WOW: any;


window.jQuery = jQuery;
window.$ = jQuery;

let appHelper = new AppHelper;
let plugins = new JqPlugins;

export default class App {

    constructor() {

        ($ => {

            $(() => {
                $('.burger-menu').on('click', function () {
                    $(this).toggleClass('burger-click');
                    $('.mobile__header_nav-menu').slideToggle();
                });

                $('.slider__slick').slick({
                    slidesToShow: 3,
                    nextArrow: '<button id="next" type="button" class="next">' + '</button>',
                    prevArrow: '<button id="prev" type="button" class="prev">' + '</button>',
                    autoplay: true,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });

                $('.industries-slider').slick({
                    slidesToShow: 3,
                    nextArrow: '<button id="next" type="button" class="next-right">' + '</button>',
                    prevArrow: '<button id="prev" type="button" class="prev-left">' + '</button>',
                    autoplay: true,
                    responsive: [
                        {
                            breakpoint: 790,
                            settings: {
                                slidesToShow: 2,
                            }
                        },
                        {
                            breakpoint: 620,
                            settings: {
                                slidesToShow: 1,
                            }
                        },
                    ]
                });
                $('#next-right').on('click', function () {
                    $('.next-right').trigger('click');
                });
                $('#prev-left').on('click', function () {
                    $('.prev-left').trigger('click');
                });

                $('#download_file_form').on('click', function (e:any) {
                    e.preventDefault();
                    $('body').addClass('modal-window_open');
                });
                $('.modal-over').on('click', function () {
                    $('body').removeClass('modal-window_open');
                });

                (()=>{

                    let timer: number = null,
                        menuItem =  document.getElementsByClassName('header__menu')[0].getElementsByTagName('li')[1],
                        dropDown = document.getElementsByClassName("dropdown-menu")[0];

                    menuItem.addEventListener('mouseenter', function (e:any) {
                        clearTimeout(timer);
                        (<HTMLElement>  dropDown).style.display="flex";
                    });

                    menuItem.addEventListener('mouseleave', function () {
                        timer = setTimeout(()=> {
                            (<HTMLElement>  dropDown).style.display="none";
                        },1000);
                    });

                })();

                // (()=>{
                //     let liSubmenu = document.querySelectorAll('.dropdown-menu-services >li');
                //
                //     for(let i = 0; i < liSubmenu.length; i++ ){
                //
                //         let imgWr = document.getElementsByClassName('ddmenu-it-img');
                //
                //         liSubmenu[i].addEventListener('mouseenter', function () {
                //
                //             let ind = appHelper.indexInParent(this);
                //
                //             imgWr[ind].classList.add('fadeIn-img');
                //
                //         });
                //
                //         liSubmenu[i].addEventListener('mouseleave', function () {
                //
                //             let ind = appHelper.indexInParent(this);
                //
                //             imgWr[ind].classList.remove('fadeIn-img');
                //
                //         });
                //     }
                //
                // })();


                appHelper.modal();

                $('.comp-team__slider').slick({
                    slidesToShow: 4,
                    arrows: false,
                    autoplay: true,
                    responsive: [
                        {
                            breakpoint: 1279,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 860,
                            settings: {
                                slidesToShow: 2,
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                });
                $('.reviews__slider').slick({
                    slidesToShow: 3,
                    arrows: false,
                    centerMode: true,
                    autoplay: true,
                    dots: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });

                if ($('#particles-blog').length) {

                    particlesJS("particles-blog", {
                        "particles": {
                            "number": {
                                "value": 80,
                                "density": {
                                    "enable": true,
                                    "value_area": 800
                                }
                            },
                            "color": {
                                "value": "#ffffff"
                            },
                            "shape": {
                                "type": "circle",
                                "stroke": {
                                    "width": 0,
                                    "color": "#000000"
                                },
                                "polygon": {
                                    "nb_sides": 5
                                },
                                "image": {
                                    "src": "img/github.svg",
                                    "width": 100,
                                    "height": 100
                                }
                            },
                            "opacity": {
                                "value": 0.7,
                                "random": false,
                                "anim": {
                                    "enable": false,
                                    "speed": 1,
                                    "opacity_min": 0.1,
                                    "sync": false
                                }
                            },

                            "size": {
                                "value": 3,
                                "random": true,
                                "anim": {
                                    "enable": false,
                                    "speed": 40,
                                    "size_min": 0.1,
                                    "sync": false
                                }
                            },
                            "line_linked": {
                                "enable": true,
                                "distance": 150,
                                "color": "#ffffff",
                                "opacity": 0.4,
                                "width": 1
                            },
                            "move": {
                                "enable": true,
                                "speed": 6,
                                "direction": "none",
                                "random": false,
                                "straight": false,
                                "out_mode": "out",
                                "bounce": false,
                                "attract": {
                                    "enable": false,
                                    "rotateX": 600,
                                    "rotateY": 1200
                                }
                            }
                        },
                        "interactivity": {
                            "detect_on": "canvas",
                            "events": {
                                "onhover": {
                                    "enable": true,
                                    "mode": "grab"
                                },
                                "onclick": {
                                    "enable": true,
                                    "mode": "push"
                                },
                                "resize": true
                            },
                            "modes": {
                                "grab": {
                                    "distance": 191.80819180819182,
                                    "line_linked": {
                                        "opacity": 1
                                    }
                                },
                                "bubble": {
                                    "distance": 400,
                                    "size": 40,
                                    "duration": 2,
                                    "opacity": 8,
                                    "speed": 3
                                },
                                "repulse": {
                                    "distance": 200,
                                    "duration": 0.4
                                },
                                "push": {
                                    "particles_nb": 4
                                },
                                "remove": {
                                    "particles_nb": 2
                                }
                            }
                        },
                        "retina_detect": true
                    });
                }
                if ($('#particles-wr').length) {
                    particlesJS("particles-wr",
                        {
                            "particles": {
                                "number": {
                                    "value": 293,
                                    "density": {
                                        "enable": true,
                                        "value_area": 1341.5509907748635
                                    }
                                },
                                "color": {
                                    "value": "#fc7701"
                                },
                                "shape": {
                                    "type": "circle",
                                    "stroke": {
                                        "width": 0,
                                        "color": "#000000"
                                    },
                                    "polygon": {
                                        "nb_sides": 3
                                    },
                                    "image": {
                                        "src": "img/github.svg",
                                        "width": 100,
                                        "height": 100
                                    }
                                },
                                "opacity": {
                                    "value": 0.5,
                                    "random": false,
                                    "anim": {
                                        "enable": false,
                                        "speed": 1,
                                        "opacity_min": 0.1,
                                        "sync": false
                                    }
                                },
                                "size": {
                                    "value": 5,
                                    "random": true,
                                    "anim": {
                                        "enable": false,
                                        "speed": 40,
                                        "size_min": 0.1,
                                        "sync": false
                                    }
                                },
                                "line_linked": {
                                    "enable": true,
                                    "distance": 150,
                                    "color": "#fc7701",
                                    "opacity": 0.5,
                                    "width": 1
                                },
                                "move": {
                                    "enable": true,
                                    "speed": 6,
                                    "direction": "none",
                                    "random": false,
                                    "straight": false,
                                    "out_mode": "out",
                                    "bounce": false,
                                    "attract": {
                                        "enable": false,
                                        "rotateX": 600,
                                        "rotateY": 1200
                                    }
                                }
                            },
                            "interactivity": {
                                "detect_on": "canvas",
                                "events": {
                                    "onhover": {
                                        "enable": true,
                                        "mode": "grab"
                                    },
                                    "onclick": {
                                        "enable": true,
                                        "mode": "push"
                                    },
                                    "resize": true
                                },
                                "modes": {
                                    "grab": {
                                        "distance": 215.7842157842158,
                                        "line_linked": {
                                            "opacity": 1
                                        }
                                    },
                                    "bubble": {
                                        "distance": 400,
                                        "size": 40,
                                        "duration": 2,
                                        "opacity": 8,
                                        "speed": 3
                                    },
                                    "repulse": {
                                        "distance": 200,
                                        "duration": 0.4
                                    },
                                    "push": {
                                        "particles_nb": 4
                                    },
                                    "remove": {
                                        "particles_nb": 2
                                    }
                                }
                            },
                            "retina_detect": true
                        });
                }
                $('.joinus__vacancies').simpleAccordion();

               setTimeout(()=>{
                   $('.form-question input[type="radio"]').after('<div class="p-after"></div>');
                   $('.form-question input[type="checkbox"]').after('<div class="p-after"></div>');
               }, 500);

               let wow = new WOW;
               wow.init();

               $('.mod-lang__currlang').on('click', function () {
                 $(this).next().find('ul').slideToggle();
               });

                (()=>{

                    let wowCounter = new WOW({
                        boxClass: 'section-expirience__count',
                        animateClass: '',
                        callback: function(el:string):void {

                            let i: number = 0,
                                finValue: number = parseInt($(el).data('value'));

                            let counterInterval: number = setInterval(() => {
                                i++;
                                $(el).text(i);
                                if (i == finValue) {
                                    clearInterval(counterInterval);
                                }

                            }, 1200 / finValue);
                        }
                    });
                    wowCounter.init();
                })();
            });
        })(jQuery);
    }
}