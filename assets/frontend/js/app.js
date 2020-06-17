import 'foundation-sites';
import '../scss/main.scss';

import 'babel-polyfill';

const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).ready(function () {
    $(document).foundation();
});
