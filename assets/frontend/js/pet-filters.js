const $grid = $('[data-pets]');

$(document).ready(function () {
    const $form = $('form', '.animal-filter');
    const url = $grid.data('url');
    let formData = getFormData();

    $('.sylius-filters input').each(function (index, el) {
        $(el).click((e) => {
            formData = getFormData();
            applyFilter(url);
        });
    });

    function getFormData() {
        return $form.serialize();
    }

    function applyFilter(url) {
        $.get(`${url}?${formData}`, function (data) {
            $grid.html(data);
        });
    }
});
