const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./config-builder');

const backendConfig = build('backend', `./assets/backend/`, vendorUiPath); // for admin
const frontendConfig = build('frontend', `./assets/frontend/`, vendorUiPath); // for front

module.exports = [backendConfig, frontendConfig]; // both front and admin
