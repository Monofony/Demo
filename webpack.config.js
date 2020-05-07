const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./config-builder');

const backendConfig = build('backend', `./assets/backend/`, vendorUiPath);
const frontendConfig = build('frontend', `./assets/frontend/`, vendorUiPath);

// module.exports = [backendConfig]; // for admin only
module.exports = [backendConfig, frontendConfig]; // for front and admin
