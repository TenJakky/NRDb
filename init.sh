#!/usr/bin/env bash

echo 'Composer'
composer install &> /dev/null

echo 'Bower'
bower install &> /dev/null

echo 'Compiles SCSS'
sassc scss/common.scss                      > scss/dist/common.css
sassc scss/iframe.scss                      > scss/dist/iframe.css
sassc scss/component/ratingForm.scss        > scss/dist/ratingForm.css
sassc scss/component/entityList.scss        > scss/dist/entityList.css
sassc scss/component/entitySmallList.scss   > scss/dist/entitySmallList.css

echo 'Minify JS'
uglifyjs js/common.js                       > js/dist/common.min.js
uglifyjs js/coreValidator.js                > js/dist/coreValidator.min.js
uglifyjs js/selectizePlugins.js            > js/dist/selectizePlugins.min.js
uglifyjs js/component/entityForm.js         > js/dist/entityForm.min.js
uglifyjs js/component/statElementCount.js   > js/dist/statElementCount.min.js
uglifyjs js/component/statUserActivity.js   > js/dist/statUserActivity.min.js
uglifyjs js/component/statUserRadar.js      > js/dist/statUserRadar.min.js

echo 'Combine SQL scripts'
