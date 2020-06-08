import 'foundation-sites';
import '../scss/main.scss';

import 'babel-polyfill';
import './shim-lightbox';
import './shim-semantic-ui';

const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).ready(function () {
    $(document).foundation();
});
