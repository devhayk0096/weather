@extends('index')

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .results-datatable td:first-child,
        .results-datatable th:first-child {
            width: 50px !important;
            text-align: center;
        }
    </style>
@endsection

@section('content')

    <div class="col-md-10">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Result of searched cities') }}</div>

                        <div class="card-body">
                            <div class="results-content">

                                <div class="mt-3">
                                    <table class="results-datatable table table-bordered table-responsive" style="overflow-x: scroll; width: 100%">
                                        <thead>
                                            <tr>
                                                <td><input id="searching-id" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-city" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-country_code" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-latitude" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-longitude" type="text" class="form-control searching-field"/></td>
                                                <td>&nbsp;</td>
                                                <td><input id="searching-temperature" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-temp_max" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-temp_min" type="text" class="form-control searching-field"/></td>
                                                <td><input id="searching-description" type="text" class="form-control searching-field"/></td>
                                                {{--<td><input id="searching-condition_name" type="text" class="form-control searching-field"/></td>--}}
                                                {{--<td><input id="searching-formatted_date" type="text" class="form-control searching-field"/></td>--}}
                                                {{--<td><input id="searching-formatted_day" type="text" class="form-control searching-field"/></td>--}}
                                                <td><input id="searching-created_at" type="text" class="form-control searching-field"/></td>
                                            </tr>
                                            <tr>
                                                <th>ID</th>
                                                <th>City</th>
                                                <th>Country code</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Icon</th>
                                                <th>Temperature</th>
                                                <th>Temp max</th>
                                                <th>Temp min</th>
                                                <th>Description</th>
                                                {{--<th>Condition Name</th>--}}
                                                {{--<th>Formatted date</th>--}}
                                                {{--<th>Formatted day</th>--}}
                                                {{--<th>Timestamp</th>--}}
                                                <th>Searched At</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>City</th>
                                                <th>Country code</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Icon</th>
                                                <th>Temperature</th>
                                                <th>Temp max</th>
                                                <th>Temp min</th>
                                                <th>Description</th>
                                                {{--<th>Condition Name</th>--}}
                                                {{--<th>Formatted date</th>--}}
                                                {{--<th>Formatted day</th>--}}
                                                {{--<th>Timestamp</th>--}}
                                                <th>Searched At</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        var table = $('.results-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'city', name: 'city'},
                {data: 'country_code', name: 'country_code'},
                {data: 'latitude', name: 'latitude'},
                {data: 'longitude', name: 'longitude'},
                {data: 'icon', name: 'icon', orderable: false, searchable: false },
                {data: 'temperature', name: 'temperature'},
                {data: 'temp_max', name: 'temp_max'},
                {data: 'temp_min', name: 'temp_min'},
                {data: 'description', name: 'description'},
                // {data: 'condition_name', name: 'condition_name'},
                // {data: 'formatted_date', name: 'formatted_date'},
                // {data: 'formatted_day', name: 'formatted_day'},
                {data: 'created_at', name: 'created_at', orderable: false},
            ],
            ajax: {
                url: "{{ route('searched.results') }}",
                data: data => {
                    data.id = $('#searching-id').val();
                    data.city = $('#searching-city').val();
                    data.country_code = $('#searching-country_code').val();
                    data.latitude = $('#searching-latitude').val();
                    data.longitude = $('#searching-longitude').val();
                    data.temperature = $('#searching-temperature').val();
                    data.temp_max = $('#searching-temp_max').val();
                    data.temp_min = $('#searching-temp_min').val();
                    data.description = $('#searching-description').val();
                    data.icon = $('#searching-icon').val();
                    // data.condition_name = $('#searching-condition_name').val();
                    // data.formatted_date = $('#searching-formatted_date').val();
                    // data.formatted_day = $('#searching-formatted_day').val();
                    data.created_at = $('#searching-created_at').val();
                    data.search = $('.results-content input[type="search"]').val();
                }
            }
        });

        /* Reload the table data by searching inputs */
        $('.searching-field').on('keyup change clear', function () {
            table.ajax.reload();
        });
    </script>
@endsection