<?php

function isEn() {
    return app()->getLocale() === 'en';
}

function isAr() {
    return app()->getLocale() === 'ar';
}
