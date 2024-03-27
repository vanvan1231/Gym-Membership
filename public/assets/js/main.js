document.addEventListener('DOMContentLoaded', () =>{
    const results = document.querySelector('.results-wrapper')
    if(results){
        let count = 5
        const countEl = document.querySelector('.second-remain')
        const coundownInterval = setInterval(()=>{

            if(count < 0){
                clearInterval(coundownInterval)
                window.location.href = window.location.origin
                return
            }
            countEl.textContent = count
            count--

        }, 1000)
    }
})
