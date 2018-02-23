<?php

namespace App\Http\Controllers;

use App;
use File;

class HomeController extends Controller
{
	public function index()
	{
		if (App::environment('local')) {
			return view('welcome');
		} else {
			return File::get(public_path() . '/client/index.html');
		}
	}
}
