'use strict';


class AnimationForHome {

    init() {
        let movies = document.querySelectorAll(".movie")
        let menu=document.querySelector(".menuItem");
        let array = []
        movies.forEach(function (e) {
            array.push(e);
            e.style.opacity=0;
        });
        menu.style.opacity=0;
        array.push(menu);
        this.update(array, 0);
    }
    update(array, currentIndex = 0) {
        array[currentIndex].style.opacity=1;
                array[currentIndex].classList.add("fadeInDown");
          
            currentIndex++;
        setTimeout(function () {
            new AnimationForHome().update(array, currentIndex);
        }, 200);
    }
}
new AnimationForHome().init();