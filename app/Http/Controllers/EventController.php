<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $baseFolder = 'public/article';

    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        $eventRegister = new EventRegister();
        $eventRegister->firstname = $request->input('firstname');
        $eventRegister->lastname = $request->input('lastname');
        $eventRegister->email = $request->input('email');
        $eventRegister->phone = $request->input('phone');
        $eventRegister->company = $request->input('company');
        $eventRegister->role = $request->input('role');
        $eventRegister->government_related = $request->input('government_related');
        $eventRegister->country = $request->input('country');
        $eventRegister->id_event = 1;
        $eventRegister->is_deleted = 0;
        $eventRegister->save();

        if($eventRegister){
            return response()->json(["code" => 200, "message" => "Event registration successfully created!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Event registration creation trouble, please contact Administrator!"]);
        }
    }

    public function list(Request $request, $page, $limit)
    {
        $start = $limit * ($page-1);
        
        // Get total count
        $totalitems = 0;
        $totalpage = 0;
        
        if($page != '0' && $limit != '0'){
            $totalitems = EventRegister::where('event_register.is_deleted', '=', 0)->count();
            $totalpage = ceil($totalitems / $limit);
            $regs = EventRegister::select(
                        'event_register.id',
                        'event_register.firstname',
                        'event_register.lastname',
                        'event_register.email',
                        'event_register.phone',
                        'event_register.company',
                        'event_register.role',
                        'event_register.government_related',
                        'event_register.country',
                        'event_register.created_at'
                    )
                    ->where('event_register.is_deleted', '=', 0)
                    ->orderBy('event_register.id', 'DESC')
                    ->offset($start)
                    ->limit($limit)
                    ->get();
        }else{
            $regs = EventRegister::select(
                        'event_register.id',
                        'event_register.firstname',
                        'event_register.lastname',
                        'event_register.email',
                        'event_register.phone',
                        'event_register.company',
                        'event_register.role',
                        'event_register.government_related',
                        'event_register.country',
                        'event_register.created_at'
                    )
                    ->where('event_register.is_deleted', '=', 0)
                    ->orderBy('event_register.id', 'DESC')
                    ->get();
        }

        foreach($regs as $r){
            $r->fullname = trim($r->firstname . ' ' . $r->lastname);
            if(isset($r->created_at)){
                $temp = strval($r->created_at);
                $r->created_string = explode('T', $temp)[0];
            }
        }
        return response()->json(["status" => "success", "totalitems" => $totalitems, "totalpage" => $totalpage, "data" => $regs]);
    }

    
}
