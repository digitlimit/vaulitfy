<?php

//use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('vault:rotate-token')->hourly();
