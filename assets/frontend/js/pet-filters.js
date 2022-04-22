$(document).ready(function () {
    const $grid = $('[data-pets]');
    const $form = $('form', '.animal-filter');
    const url = $grid.data('url');
    let formData = getFormData();
    const $colorFilter = $('.filter-color');
    const currentUrl = window.location.origin + window.location.pathname;

    $('.sylius-filters input').each(function (index, el) {
        $(el).click(() => {
            formData = getFormData();
            applyFilter(url);
            updateWindowUrl(formData);
        });
    });

    function updateWindowUrl(queryString) {
        window.history.pushState('', window.title, `${currentUrl}?${queryString}`);
    }

    function updatePaginationUrl() {
        $('ul.pagination li a').each(function () {
            const newHref = $(this).attr('href').replace(url, currentUrl);
            $(this).attr('href', newHref);
        });
    }

    function getFormData() {
        return $form.serialize();
    }

    function applyFilter(url) {
        $.get(`${url}?${formData}`, function (data) {
            $grid.html(data);
            updatePaginationUrl();
        });
    }

    $('input', $colorFilter).change(function () {
        const $label = $(this).parent();
        $label.toggleClass('active');
    })
});
