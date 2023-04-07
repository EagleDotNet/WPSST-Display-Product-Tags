// Here's an example code for the plugin.js file:

// Wrap code in jQuery ready function to ensure the DOM is fully loaded
jQuery(document).ready(function ($) {

    // Define a function to be called when the user clicks a button
    function handleClick(event) {
        event.preventDefault();
        console.log("Button clicked!");
    }

    // Bind the handleClick function to the click event of a button
    $('.my-button').on('click', handleClick);

});
jQuery(document).ready(function ($) {
    var swiper = new Swiper('.swiper-container', {
        loop: true, // يسمح بالتمرير بشكل لا نهائي
        autoplay: {
            delay: 3000, // تحديد مدة التمرير بين السلايدات
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
