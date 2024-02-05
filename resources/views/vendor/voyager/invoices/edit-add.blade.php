@extends('voyager::bread.edit-add')
@section('content')
    <div class="container" id="app">
        <div class="card">
            <div class="card-body">
                <form action="" class="">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="date">Fecha</label>
                                <input type="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="client_id">Cliente</label>
                                @php
                                    $clients = App\Models\Client::all();
                                @endphp
                                <select name="client_id" class="form-control select2" id="client_id">
                                    <option value="" disabled selected>Seleccione...</option>
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
                            <div class="table-responsive">
                                <table class="table">
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
                                        <tr v-for="">
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">X</button>
                                            </td>
                                            <td>
                                                <select name="products[]" style="width:100%"
                                                    class="form-control select_products"
                                                    data-ajax-uri="/admin/api/products"></select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="units[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="pounds[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="prices[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="discounts[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="totals[]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('javascript')
    <script>
        function addProduct() {

            let $template = `
            <tr>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">X</button>
                                            </td>
                                            <td>
                                                <select name="products[]" style="width:100%" class="form-control select_products"
                                                    data-ajax-uri="/admin/api/products"></select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="units[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="pounds[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="prices[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="discounts[]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="totals[]">
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

        }
    </script>
@endpush
