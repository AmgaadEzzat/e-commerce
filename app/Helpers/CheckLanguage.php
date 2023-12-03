<?php

function getCurrentLanguage(): string
{
    return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
}
