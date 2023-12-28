var usersData = {};

function UpdateUsersData(usersDataArg) {
    fetch("./server/newuser.php", {
        method: 'POST',
        headers: {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        body: JSON.stringify(usersDataArg)
    }).then(
        res => res.json()
    ).then(
        resJson => {
            if(resJson["Status"]){
                window.location = "dashboard.php";
            } else {
                usersData = resJson;
            }
        }
    )
}

function SignInValidation() {
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    for(i=0; i < usersData.length; i++){
        if(usersData[i]['username'] === username.children[0].value && usersData[i]['password'] === password.children[0].value) {
            UpdateUsersData(({"session":username.children[0].value}))
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {

    UpdateUsersData();

    var wrapper = document.querySelector('.wrapper'),
        signUpLink = document.querySelector('.link .signup-link'),
        signInLink = document.querySelector('.link .signin-link');

    var currentPage = "signin";

    signUpLink.addEventListener('click', () => {
        wrapper.classList.add('animated-signin');
        wrapper.classList.remove('animated-signup');
        currentPage = "signin";
    });

    signInLink.addEventListener('click', () => {
        wrapper.classList.add('animated-signup');
        wrapper.classList.remove('animated-signin');
        currentPage = "signup";
    });

    document.querySelector(".Popup").style.zIndex = "-1";

    document.getElementById("signin-btn").addEventListener("click", () => {
        SignInValidation()
        console.log(usersData)
    })
});