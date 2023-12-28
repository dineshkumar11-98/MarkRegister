document.addEventListener("DOMContentLoaded", ()=>{
    var profileToggle = false
    var navbarToggle = false
    var childOpened = false
    var logOutToggle = false
    var navbarMobileToggle = false

    var childrens = document.querySelectorAll(".has-children")
    var leftsidebar = document.querySelector(".left-sidebar")
    var logOutCol = document.querySelector(".navbar-toggle.collapsed")

    document.querySelector(".user-info-handle").addEventListener("click", ()=>{
        if (profileToggle === false) {
            document.querySelector(".user-info").classList.remove("closed")
            profileToggle = true
        }else {
            document.querySelector(".user-info").classList.add("closed")
            profileToggle = false
        }
    })
    document.querySelector(".small-nav-handle").addEventListener("click", ()=>{
        if (navbarToggle === false) {
            document.querySelector(".navbar-header").classList.add("small-nav-header")
            document.querySelector(".left-sidebar").classList.add("small-nav")
            navbarToggle = true
        }else {
            document.querySelector(".navbar-header").classList.remove("small-nav-header")
            document.querySelector(".left-sidebar").classList.remove("small-nav")
            navbarToggle = false
        }
    })
    childrens.forEach(child =>{
        child.querySelector("a").addEventListener("click", ()=>{
            // console.log()
            if (leftsidebar.classList.contains("small-nav") == false){
                if (child.classList.contains("open")) {
                    child.classList.remove("open")
                    child.querySelector(".child-nav").style.display = "none";
                } else {
                    child.classList.add("open")
                    child.querySelector(".child-nav").style.display = "block";
                }
            }
        })
    });
    logOutCol.addEventListener("click", () => {
        if(logOutToggle == false) {
            logOutCol.classList.remove("collapsed")
            document.querySelector(".navbar-collapse").classList.add("in")
            logOutToggle = true
        } else {
            logOutCol.classList.add("collapsed")
            document.querySelector(".navbar-collapse").classList.remove("in")
            logOutToggle = false
        }
    })
    document.querySelector(".navbar-toggle.mobile-nav-toggle").addEventListener("click", ()=>{
        if (navbarMobileToggle == false) {
            leftsidebar.style.display = "block";
            navbarMobileToggle = true
        } else {
            leftsidebar.style.display = "none";
            navbarMobileToggle = false
        }
    })
})