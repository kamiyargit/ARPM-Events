<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class ApiCalendarControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        
        return response(CalendarEvent::where('user_id', Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CalendarEvent::create([
            'user_id' => $request->user()->id,
            'eventId' => $request->eventId,
            'calendarId' => $request->calendarId,
            'title' => $request->title,
            'start' => date($request->start['d']['d']),
            'end' => date($request->end['d']['d']),
        ]);
        return response($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $item = CalendarEvent::firstWhere('eventId', $request->id);
 
        $item->calendarId = $request->calendarId;
        $item->title = $request->title;
        $item->start = date($request->start['d']['d']);
        $item->end = date($request->end['d']['d']);

        $item->save();

        return response($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        CalendarEvent::firstWhere('eventId', $request->id)->delete();

        return response('ok')->status(200);
    }
}
