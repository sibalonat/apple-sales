<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return User::vendors()->get();
    }
}
