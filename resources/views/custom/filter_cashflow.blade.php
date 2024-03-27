<form class="my-5">
    <div class="d-flex flex-md-row">
        <div class="custom-filter-container form-control bg-transparent border-0 ps-0 form-group flex-grow-1 pb-0 me-3 w-100 d-flex flex-column">
            <label for="filter">Filter</label>
            <select name="filter" id="filter" class="form-control">
                <option value="">Select Filter</option>
                <option value="day">This Day</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
                <option value="gcash" data-date="show">GCash Payments</option>
                <option value="cash" data-date="show">Cash Payments</option>
                <option value="session" data-date="show">Session</option>
                <option value="custom" data-date="show">Custom</option>
            </select>
        </div>
        <div class="d-flex align-items-end ms-3 d-flex flex-row">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-secondary ms-3" id="clear-filter-btn">Clear</button>
        </div>
    </div>
</form>
@php
    Widget::add()->type('script')->content(asset('assets/js/admin/filter.js'));
@endphp
