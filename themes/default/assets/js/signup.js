$(document).ready(function(){
    "use strict";

    $('.cancel-signup').on('click', function(){
        $.fancybox.close();
    });

    //open 1-step sign-up init
    open_step1();

    function open_step1(){
         $.fancybox.open($('.signup-step1'),{
            wrapCSS: "abaris-modal",
            padding: 5,
            afterShow: function(){
                $('.signup-step1').find('.next-step').on('click', function(){
                    open_step2();
                });
            }
        });
    };

    function open_step2(){
        $.fancybox.open($('.signup-step2'),{
            wrapCSS: "abaris-modal",
            padding: 5,
            afterShow: function(){
                //open step3
                $('.signup-step2').find('.next-step').on('click', function(){
                    open_step3();
                });
                //go back
                $('.signup-step2').find('.prev-step').on('click', function(){
                    open_step1();
                });
            }
        });
    };

    function open_step3(){
        $.fancybox.open($('.signup-step3'),{
            wrapCSS: "abaris-modal",
            padding: 5,
            afterShow: function(){
                //open 3-step sign-up
            }
        });
    };           
});