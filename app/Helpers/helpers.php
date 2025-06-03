<?php

use App\Models\Categories;


if (!function_exists('categoriesget')) {
    function categoriesget()
    {
        return  Categories::all();
    }
}
