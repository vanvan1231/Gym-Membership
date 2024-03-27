document.addEventListener('DOMContentLoaded', ()=>{
    const paymentType = document.querySelector('select#payment-type')
    const transCode = document.querySelector('.trans-code')
    paymentType.addEventListener('change', (e)=>{
        (e.target.value === 'cash') ? transCode.classList.add('d-none') : transCode.classList.remove('d-none')
    })
    console.log('test')
})
