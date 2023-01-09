<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\VisitorRequest;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Ticket;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitor = Visitor::all();

        return response()->json([
            'visitors' => $visitor,
        ], 232);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $TicketUses = Ticket::where("id", $request->get("ticketid"))->value("maxUse");
        $VisitorUses = Visitor::where("ticketid", $request->get("ticketid"))->count();

        if ($TicketUses > $VisitorUses) {
            $visitor = Visitor::create($request->all());

            $visitorAll = Visitor::all();
            return response()->json([
                "visitors" => $visitorAll,
                "data" => $visitor,
                "ticketUses" => $TicketUses,
                "visitorUses" => $VisitorUses,
            ], 222);
        }
        return response()->json([
            'message' => "Hát szívás.",
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(VisitorRequest $request, Visitor $visitor)
    {
        $visitor->update($request->all());
        $visitorAll = Visitor::all();
        return response()->json([
            "visitors" => $visitorAll,
            'message' => "Nagyon ügyes vagy - update",
        ], 222);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        $visitorAll = Visitor::all();
        return response()->json([
            "visitors" => $visitorAll,
            'message' => "Nagyon ügyes vagy - delete",
        ], 222);
    }
}