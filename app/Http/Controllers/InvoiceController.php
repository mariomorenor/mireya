<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class InvoiceController extends VoyagerBaseController
{

    function create(Request $request)
    {
        $clients = Client::all();
        return view("invoices.create")->with(["clients" => $clients]);
    }

    function store(Request $request)
    {

        $invoice = new Invoice();
        $invoice->date = $request->date;
        $invoice->client_id = $request->client_id;
        $invoice->total = $request->total;

        $invoice->save();

        $details = [];

        for ($i = 0; $i < count($request->products); $i++) {
            array_push($details, new InvoiceDetail([
                "product_id" => $request->products[$i],
                "quantity" => $request->units[$i],
                "pounds" => $request->pounds[$i],
                "price" => $request->prices[$i],
                "discount" => $request->discounts[$i],
            ]));
        }
        $invoice->invoice_detail()->saveMany($details);

        return redirect()->route("voyager.invoices.index");
    }

    function edit(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $clients = Client::all();
        return view("invoices.edit")->with(["invoice" => $invoice, "clients" => $clients]);
    }

    function update(Request $request, $id) {
        
        $invoice = Invoice::find($id);
        $invoice->date = $request->date;
        $invoice->client_id = $request->client_id;
        $invoice->total = $request->total;

        $invoice->save();

        $invoice->invoice_detail()->delete();

        $details = [];

        for ($i = 0; $i < count($request->products); $i++) {
            array_push($details, new InvoiceDetail([
                "product_id" => $request->products[$i],
                "quantity" => $request->units[$i],
                "pounds" => $request->pounds[$i],
                "price" => $request->prices[$i],
                "discount" => $request->discounts[$i],
            ]));
        }
        $invoice->invoice_detail()->saveMany($details);

        return redirect()->route("voyager.invoices.index");
    }
}
