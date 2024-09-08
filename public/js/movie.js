'use strict';
class MoviesController{

    init(){
        let comment= document.querySelector(".commentInput");
        if(comment!=null){
         comment.addEventListener('click', function (e) {
             e.target.style = `
             margin-left: 7%;
             width: 93%;
             height: 2.2em;
             font-size: 2em;
             outline: none;
             padding: 7px;
             background-color: transparent;
             border: 2px solid rgb(192, 0, 96);
             border-radius: 10px;
             transition: 0.7s ease-in-out;`;
     
     
         })
        }
         document.querySelector('html').addEventListener('click', function (e) {
             if (!(e.target.classList.contains("commentInput"))) {
                 document.querySelector(".commentInput").style = `
                 margin-left: 7%;
                 width: 93%;
                 height: 1.4em;
                 font-size: 2em;
                 outline: none;
                 padding: 7px;
                 background-color: transparent;
                 border: 2px solid rgb(0, 65, 86);
                 border-radius: 10px;
                 transition: 0.7s ease-in-out;`;
             }
         });
         document.querySelector("html").addEventListener("click", function (e) {
           if(e.target.classList.contains("arrow")){
            if (e.target.classList.contains("left")) {
                e.target.classList.remove("left");
                e.target.classList.add("right");
                let menu = document.querySelector(".menu");
                menu.classList.remove("fadeOutLeftBig");
                menu.classList.add("fadeInLeftBig");
            } else {
                e.target.classList.remove("right");
                e.target.classList.add("left");
                let menu = document.querySelector(".menu");
                menu.classList.remove("fadeInLeftBig");
                menu.classList.add("fadeOutLeftBig");
            }
           }
            
     
         })
    }
} 
new MoviesController().init();

