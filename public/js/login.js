'use strict';

document.addEventListener('DOMContentLoaded', e => {
    document.querySelector(".btnSubmit").addEventListener('click',function(e){
        let login =String(document.querySelector(".rgLogin").value);
        let password = String(document.querySelector(".rgPassword").value);
        if(password.length<6){
            e.preventDefault();
         document.querySelector(".passwordError").innerHTML="minimum length password 6";
        
        }
       
       
     })
  })
