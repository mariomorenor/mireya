<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class ClientController extends VoyagerBaseController
{
    function getClients(Request $request)
    {
        if ($request->ajax()) {

            $query = Client::query();
            if ($request->has("term") && $request->term != "") {
                $clients = $query->where("name", "ilike", "$request->term%")->get();
            } else {
                $clients = $query->get();
            }
            $clients = $clients->map(function (Client $item) {
                return ["text" => $item->name, "id" => $item->id];
            });

            return response()->json([
                "results" => $clients
            ]);
        }
    }
}
