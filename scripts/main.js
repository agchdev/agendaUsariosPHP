document.addEventListener("DOMContentLoaded", () => {
    const popUp = document.querySelector(".popup")
    const btnCerrarPopUp = document.querySelector(".popup > button")

    if(btnCerrarPopUp){
        btnCerrarPopUp.addEventListener("click", () => {
            popUp.classList.add("popupCerrar")
            
            setTimeout(() => {
                popUp.remove();
            }, 400);
            
        })
    }

})