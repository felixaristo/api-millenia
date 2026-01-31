<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HealthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    public function check()
    {
        return response()->json(["code" => 200, "message" => "ok"]);
    }

}
