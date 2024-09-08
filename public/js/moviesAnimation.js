'use strict';

class AnimationForMovies{

    init(){
        let categoryes=document.querySelectorAll(".category")
        let lefOrRi=false;
        categoryes.forEach(function(ev){
            ev.style.opacity=0;
        })
        categoryes.forEach(function(ev){
            let pos=document.documentElement.scrollTop;
            var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
            let categoryPosition=parseInt(ev.offsetTop)-parseInt(window.innerHeight)+50;
            if(pos>=categoryPosition){
              
                if(!ev.classList.contains("fadeInRight")&&!ev.classList.contains("fadeInLeft")){
                    ev.style.opacity=1;
                    if(lefOrRi){
                        ev.classList.add("fadeInRight");
                    }else{
                        ev.classList.add("fadeInLeft");
                    }
                    lefOrRi= !lefOrRi;
                }
              
            }
        });
        let lefOrRiQ=false;
        window.onscroll=function(e){
            categoryes.forEach(function(ev){
                let pos=document.documentElement.scrollTop;
                let categoryPosition=parseInt(ev.offsetTop)-parseInt(window.innerHeight)+50;
                if(pos>=categoryPosition){
                    if(!ev.classList.contains("fadeInRight")&&!ev.classList.contains("fadeInLeft")){
                        ev.style.opacity=1;
                        console.log(1);
                        if(lefOrRiQ){
                            ev.classList.add("fadeInRight");
                        }else{
                            ev.classList.add("fadeInLeft");
                        }
                        lefOrRiQ= !lefOrRiQ;
                    }
                  
                }
            });
           

        }
    }
}
    new AnimationForMovies().init()

