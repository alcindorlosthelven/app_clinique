<?php
/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 3/22/2020
 * Time: 5:05 PM
 */
use app\DefaultApp\DefaultApp as App;
App::get("/", "install.index");
App::post("/", "install.index");

