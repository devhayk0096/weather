@extends('index')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="col-md-8">
        <select class="form-control" id="basicAutoSelect" name="simple_select" placeholder="Type city name to search..." autocomplete="off" ></select>

        <section class="weather-section">
            <ul class="cities">

            </ul>
        </section>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
    <script defer>

        $('#basicAutoSelect').autoComplete({
            resolver: 'custom',
            minLength: 1,
            autoSelect: false,
            events: {
                search: function (query, callback) {
                    $.ajax({
                        url: "{{ route('autocomplete.search') }}",
                        method: "GET",
                        dataType: "json",
                        async: true,
                        data: {
                            query: query
                        },
                        success: response => {
                            callback(response);
                        }
                    });
                }
            }
        });


        let cityNames = [];
        $('#basicAutoSelect').focus();

        /* Get selected city and send backend to save searched city data */
        $('#basicAutoSelect').on('autocompletechange change', function () {
            document.body.className = 'waiting';

            setTimeout(function () {
                let city = $('input[name=simple_select]').val().trim();

                $.ajax({
                    url: "{{ route('city.weather') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "html",
                    async: true,
                    data: {
                        city: city,
                    },
                    error: err => {
                        document.body.className = '';
                        console.log('error',err);
                    },
                    success: response => {
                        document.body.className = '';

                        if (cityNames.indexOf(city) !== -1) {
                            $(`#city-${city}`).remove();
                        } else {
                            cityNames.push(city);
                        }

                        $('.weather-section .cities').append(response);
                        $('#basicAutoSelect').val('').focus();
                    }
                });
            }, 1500);
        });

    </script>
@endsection