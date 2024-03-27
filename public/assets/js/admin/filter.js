document.addEventListener('DOMContentLoaded', () => {
    const filter = document.querySelector('#filter');
    const urlParams = new URLSearchParams(window.location.search);
    const startDateParam = urlParams.get('startDate');
    const endDateParam = urlParams.get('endDate');
    const filterVal = urlParams.get('filter')

    if (endDateParam || filterVal === 'gcash' || filterVal === 'cash') {
        let container = document.createElement('div');
        container.classList.add('custom-filter-container', 'pb-0', 'form-control', 'bg-transparent', 'border-0', 'd-flex', 'flex-column', 'flex-grow-1', 'mx-3', 'dates');
        container.innerHTML = `
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" name="endDate" value="${endDateParam}" id="end-date">
            `;
        filter.parentNode.parentNode.insertBefore(container, filter.parentNode.nextSibling);
    }
    if (startDateParam || filterVal === 'gcash' || filterVal === 'cash') {
        let container2 = document.createElement('div');
        container2.classList.add('custom-filter-container', 'pb-0', 'form-control', 'bg-transparent', 'border-0', 'd-flex', 'flex-column', 'flex-grow-1', 'mx-3', 'dates');
        container2.innerHTML = `
                    <label for="startDate">Start Date</label>
                    <input type="date" class="form-control" value="${startDateParam}" name="startDate" id="start-date">
            `;
        filter.parentNode.parentNode.insertBefore(container2, filter.parentNode.nextSibling);
    }
    if(filterVal){
        filter.value = filterVal
    }

    filter.addEventListener('change', (e) => {
        const showDate = e.target.options[e.target.selectedIndex].getAttribute('data-date')
        if (showDate === 'show') {
            const endDateElem = document.querySelector('#end-date')

            if (!endDateElem) {
                let container = document.createElement('div');
                container.classList.add('custom-filter-container', 'pb-0', 'form-control', 'bg-transparent', 'border-0', 'd-flex', 'flex-column', 'flex-grow-1', 'mx-3', 'dates');
                container.innerHTML = `
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" name="endDate" id="end-date">
            `;
                filter.parentNode.parentNode.insertBefore(container, filter.parentNode.nextSibling);
            }

            const startDateElem = document.querySelector('#start-date')

            if (!startDateElem) {
                let container2 = document.createElement('div');
                container2.classList.add('custom-filter-container', 'pb-0', 'form-control', 'bg-transparent', 'border-0', 'd-flex', 'flex-column', 'flex-grow-1', 'mx-3', 'dates');

                container2.innerHTML = `
                    <label for="startDate">Start Date</label>
                    <input type="date" class="form-control" name="startDate" id="start-date">
            `;
                filter.parentNode.parentNode.insertBefore(container2, filter.parentNode.nextSibling);
            }
            return
        }

        document.querySelectorAll('.dates').forEach(el => {
            el.remove()
        })
    })

    const clearBtn = document.querySelector('#clear-filter-btn')
    clearBtn.addEventListener('click', ()=>{
        const url = new URL(window.location.href)
        const params = new URLSearchParams(url.search);
        for (const key of params.keys()) {
            params.delete(key);
        }
        window.location.href = url.origin + url.pathname
    })
})
