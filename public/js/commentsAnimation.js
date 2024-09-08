'use strict';

class AnimationForComments {

    init() {
        let categoryes = document.querySelectorAll(".comment")
        categoryes.forEach(function (ev) {
            ev.style.opacity = 0;
        })
        categoryes.forEach(function (ev) {
            let pos = document.documentElement.scrollTop;
            var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
            let categoryPosition = parseInt(ev.offsetTop) - parseInt(window.innerHeight) + 20;
            if (pos >= categoryPosition) {

                if (!ev.classList.contains("fadeInUp")) {
                    ev.style.opacity = 1;
                    ev.classList.add("fadeInUp");
                }

            }
        });
        window.onscroll = function (e) {
            categoryes.forEach(function (ev) {
                let pos = document.documentElement.scrollTop;
                let categoryPosition = parseInt(ev.offsetTop) - parseInt(window.innerHeight) + 20;
                if (pos >= categoryPosition) {
                    if (!ev.classList.contains("fadeInUp")) {
                        ev.style.opacity = 1;
                        ev.classList.add("fadeInUp");
                    }

                }
            });


        }
    }
}
new AnimationForComments().init()

