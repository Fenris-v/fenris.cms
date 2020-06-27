$(document).ready(() => {
    /**
     * PARALLAX
     */
    let parallaxBox = $('body');

    let parallaxIt = (e, target, movementX, movementY) => {
        let relX = e.pageX - parallaxBox.offset().left;
        let relY = e.pageY - parallaxBox.offset().top;

        gsap.to(target, 1, {
            x: (relX - parallaxBox.width() / 2) / parallaxBox.width() * movementX,
            y: (relY - parallaxBox.height() / 2) / parallaxBox.height() * movementY
        });
    }

    parallaxBox.on('mousemove', (e) => {
        if (window.innerWidth > 1000) {
            parallaxIt(e, '#sun', 200, 100);
        }
    });
});
