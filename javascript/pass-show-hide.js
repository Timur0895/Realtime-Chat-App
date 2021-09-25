const pswrdFieled = document.querySelector(".form input[type='password']"),
    toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = () => {
    if (pswrdFieled.type == "password") {
        pswrdFieled.type = "text";
        toggleBtn.classList.add("active");
    } else {
        pswrdFieled.type = "password";
        toggleBtn.classList.remove("active");
    }
};