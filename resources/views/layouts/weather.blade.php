@if(!is_null($data))
    <li class="city" id="city-{{$data['location']['name']}}">
        <div class="city-name" data-name="{{ $data['location']['name'] }},{{ $data['location']['country'] }}">
            <span>{{ $data['location']['name'] }}</span>
            <sup>{{ $data['location']['country'] }}</sup>
        </div>
        <div class="city-temp">{{ $data['forecast']['temp'] == '0' ? ltrim($data['forecast']['temp'], '-') : $data['forecast']['temp'] }}<sup>°C</sup></div>
        <figure>
            <img class="city-icon" src="{{ $data['condition']['icon'] }}" alt="{{ $data['condition']['desc'] }}">
            <figcaption>{{ $data['condition']['desc'] }}</figcaption>
        </figure>
    </li>
@endif