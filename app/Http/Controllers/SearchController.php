<?php

namespace App\Http\Controllers;

use App\Models\SearchResult;
use Dnsimmons\OpenWeather\OpenWeather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function autoCompleteSearch(Request $request)
    {
        $settings = new \GoogleSearchResults('demo');
        $data = [];

        if ($request->has('query') && $request->get('query') != '') {
            $params = [
                "q" => $request->get('query'),
                "type" => "city",
                "engine" => "google"
            ];

            $result = $settings->locations($params);

            if (is_array($result->locations) && !empty($result->locations)) {
                foreach ($result->locations as $location) {
                    $data[] = ['value' => $location->name, 'text' => $location->full_name];
                }
            }
        }

        return response()->json($data);
    }


    public function searchedResults(Request $request)
    {
        if ($request->ajax()) {
            $model = SearchResult::query();
            $columns = Schema::getColumnListing('search_results');
//            $columns = ['city', 'country_code', 'latitude', 'longitude', 'temperature', 'temp_max', 'temp_min', 'description', 'icon'];

            return datatables()->eloquent($model)
                ->addIndexColumn()
                ->addColumn('icon', function($row) {
                    return '<img src="'. $row['icon'] .'" />';
                })
                ->addColumn('temperature', function($row) {
                    return $row['temperature'] . '°C';
                })
                ->addColumn('temp_max', function($row) {
                    return !is_null($row['temp_max']) ? $row['temp_max'] . '°C' : $row['temp_max'];
                })
                ->addColumn('temp_min', function($row) {
                    return !is_null($row['temp_min']) ? $row['temp_min'] . '°C' : $row['temp_min'];
                })
                ->addColumn('created_at', function($row) {
                    return date('d-m-Y H:i', strtotime($row['created_at'])) . ' UTC';
                })
                ->filter(function ($query) use($request, $columns) {
                    foreach ($columns as $column) {
                        if ($request->has($column) && $request->get($column) != '') {
                            $query->where($column, 'like', "%{$request->get($column)}%");
                        }
                    }

                    if ($request->has('search') && $request->get('search') != '') {
                        $query->where('id', 'like', "%{$request->search}%")
                            ->orWhere('city', 'like', "%{$request->search}%")
                            ->orWhere('country_code', 'like', "%{$request->search}%")
                            ->orWhere('latitude', 'like', "%{$request->search}%")
                            ->orWhere('longitude', 'like', "%{$request->search}%")
                            ->orWhere('temperature', 'like', "%{$request->search}%")
                            ->orWhere('temp_max', 'like', "%{$request->search}%")
                            ->orWhere('temp_min', 'like', "%{$request->search}%")
                            ->orWhere('description', 'like', "%{$request->search}%")
                            ->orWhere('icon', 'like', "%{$request->search}%");
                    }
                })
                ->orderColumn('id', 'id DESC')
                ->rawColumns(['icon'])
                ->toJson();
        }

        return response()->json([]);
    }


    public function getStoreCityWeather(Request $request)
    {
        $weather = new OpenWeather();
        $data = $weather->getCurrentWeatherByCityName($request->get('city'), 'metric');

        try {
            if (isset($data['location']['name']) && !is_null($data['location']['name'])
                && isset($data['forecast']['temp']) && !is_null($data['forecast']['temp']) ) {

                SearchResult::create([
                    'city' => $data['location']['name'],
                    'country_code' => $data['location']['country'] ?? null,
                    'latitude' => $data['location']['latitude'] ?? null,
                    'longitude' => $data['location']['longitude'] ?? null,
                    'temperature' => $data['forecast']['temp'],
                    'temp_max' => $data['forecast']['temp_max'] ?? null,
                    'temp_min' => $data['forecast']['temp_min'] ?? null,
                    'description' => $data['condition']['desc'] ?? null,
                    'icon' => $data['condition']['icon'] ?? null,
                    'condition_name' => $data['condition']['name'] ?? null,
                    'formatted_date' => $data['datetime']['formatted_date'] ? date('Y-m-d', strtotime($data['datetime']['formatted_date'])) : null,
                    'formatted_day' => $data['datetime']['formatted_day'] ?? null,
                    'timestamp' => $data['datetime']['timestamp'] ?? null,
                ]);

                return View::make('layouts.weather', compact('data'));
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }

        return response()->json(['message' => 'There is some issue with the response data'], 400);
    }
}
