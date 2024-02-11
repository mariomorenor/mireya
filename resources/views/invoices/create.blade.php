@extends('voyager::master')

@section('page_header')
    <div class="container">
        <h1 class="page-title">
            <i class="voyager-receipt"></i>
            Crear Factura
        </h1>
    </div>
@stop

@section('content')
    <div class="container" id="app">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('voyager.invoices.store') }}" class="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="date">Fecha</label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="client_id">Cliente</label>
                                <select name="client_id" class="form-control select2" id="client_id" required>
                                    @if (count($clients) == 0)
                                        <option value="" disabled selected>No hay Clientes</option>
                                    @else
                                        <option value="" disabled selected>Seleccione...</option>
                                    @endif
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-sm btn-info" type="button" onclick="addProduct()">Agregar</button>
                            <h3><strong>Total:</strong> $<span id="total"></span></h3>
                            <input type="hidden" name="total" id="inpTotal">
                            <div class="table-responsive">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Producto</th>
                                            <th>Unidades</th>
                                            <th>Libras</th>
                                            <th>Costo</th>
                                            <th>Descuento</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <button class="btn btn-success btn-block">GENERAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .input-number {
            width: 80px;
        }
    </style>
@endsection


@push('javascript')
    <script>
        var total = 0;
        $("#total").html(total)

        function addProduct() {

            let $template = `
            <tr>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm btnRemove">X</button>
                                            </td>
                                            <td>
                                                <select name="products[]" style="width:200px" class="form-control select_products"
                                                    data-ajax-uri="/admin/api/products" required></select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control input-number" name="units[]" value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control input-number" name="pounds[]" value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control input-number" name="prices[]" value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control input-number" name="discounts[]" value="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control input-number total" name="totals[]" value="0">
                                            </td>
                                        </tr>
            `;

            $("#products_body").append($template);

            $(".select_products").select2({
                ajax: {
                    url: "/admin/api/products",
                    dataType: 'json'
                }
            });

            $(".input-number").on("change", function(ev) {
                let $inputTarget = $(ev.target);
                let $childrens = $inputTarget.parent().parent().children();
                let $units = $($($childrens[2]).children()[0]);
                let $pounds = $($($childrens[3]).children()[0]);
                let $price = $($($childrens[4]).children()[0]);
                let $discount = $($($childrens[5]).children()[0]);
                let $total = $($($childrens[6]).children()[0]);

                $total.val($units.val() * $price.val())

                total = 0;
                $(".total").toArray().forEach(element => {
                    total += parseFloat($(element).val());
                });;



                $("#total").empty();
                $("#total").html(total);
                $("#inpTotal").val(total);

            });

            $(".btnRemove").on("click", function(ev) {
                let $row = $(this).parent().parent();
                $row.remove();
                
                total = 0;
                $(".total").toArray().forEach(element => {
                    total += parseFloat($(element).val());
                });

                $("#total").empty();
                $("#total").html(total);
                $("#inpTotal").val(total);

            });

        }
    </script>
@endpush
