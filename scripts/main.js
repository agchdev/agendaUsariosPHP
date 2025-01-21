document.addEventListener("DOMContentLoaded", () => {
    const popUp = document.querySelector(".popup")
    const btnCerrarPopUp = document.querySelector(".popup > button")

    btnCerrarPopUp.addEventListener("click", () => {
        popUp.classList.add("popupCerrar")
        
        setTimeout(() => {
            popUp.remove();
        }, 500);
        
    })
})