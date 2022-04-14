import 'babel-polyfill';
import './shim-semantic-ui';

import 'sylius/ui/js/app';
import 'sylius/ui/js/sylius-auto-complete';

import './app-date-time-picker';
import './app-images-preview';
import './sylius-compound-form-errors';
import './sylius-move-taxon';

import SyliusTaxonomyTree from './sylius-taxon-tree';

import '../scss/main.scss';

$(document).ready(function () {
    $(document).previewUploadedImage('#sylius_admin_user_avatar');
    $(document).previewUploadedImage('#app_pet_images');
    $('.sylius-autocomplete').autoComplete();
    $('.sylius-tabular-form').addTabErrors();
    $('.ui.accordion').addAccordionErrors();
    $('#sylius_customer_createUser').change(function () {
        $('#user-form').toggle();
    });

    $('.app-date-picker').datePicker();
    $('.app-date-time-picker').dateTimePicker();

    new SyliusTaxonomyTree();

    $('.sylius-taxon-move-up').taxonMoveUp();
    $('.sylius-taxon-move-down').taxonMoveDown();
});
