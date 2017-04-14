#!/usr/bin/env bash

composer install

bower install

sassc scss/common.scss > scss/dist/common.css

uglifyjs js/common.js                       > js/dist/common.min.js
uglifyjs js/selectize-plugins.js            > js/dist/selectize-plugins.min.js
uglifyjs js/component/entityForm.js         > js/dist/entityForm.min.js
uglifyjs js/component/statElementCount.js   > js/dist/statElementCount.min.js
uglifyjs js/component/statUserActivity.js   > js/dist/statUserActivity.min.js
uglifyjs js/component/statUserRadar.js      > js/dist/statUserRadar.min.js
