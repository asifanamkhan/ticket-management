<?php

namespace App\Repositories;

use Illuminate\Validation\Rule;
use App\Models\Package as Model;
use App\Repositories\BaseRepository;

class Package extends BaseRepository
{
    protected static $model = Model::class;

    public static function save($data): array
    {
        static::$rules['save'] = [
            'day_id' => 'required',
            'package_type_id' => 'required',
            'name' => [
                'required',
                Rule::unique('packages')->where(function ($query) use ($data) {
                    return $query->where('name', $data['name'])->where('day_id', $data['day_id'])->whereNull('deleted_at');
                })
            ],
            'arabic_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ];

        $activities = $data['activities'];
        $day_limit = $data['day_limit'];
        $limit_per_visitor = $data['limit_per_visitor'];

        unset($data['activities']);
        unset($data['day_limit']);
        unset($data['limit_per_visitor']);

        $response = parent::save($data);

        if ($response['status'] === 'success') {
            foreach ($activities as $key => $value) {
                $response['data']->activities()->attach($value, [
                    'day_limit' => $day_limit[$key] ?? '',
                    'limit_per_visitor' => $limit_per_visitor[$key] ?? '',
                ]);
            }
        }

        return $response;
    }

    public static function update($id, $data): array
    {
        //dd($data);
        static::$rules['update'] = [
            'day_id' => 'required',
            'package_type_id' => 'required',
            'name' => [
                'required',
                Rule::unique('packages')->where(function ($query) use ($data) {
                    return $query->where('name', $data['name'])->where('day_id', $data['day_id'])->whereNull('deleted_at');
                })->ignore($id)
            ],
            'arabic_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',

        ];

        $activities = $data['activities'];
        $day_limit = $data['day_limit'];
        $limit_per_visitor = $data['limit_per_visitor'];

        unset($data['activities']);
        unset($data['day_limit']);
        unset($data['limit_per_visitor']);

        $response = parent::update($id, $data);

        if ($response['status'] === 'success') {

            $syncData = [];

            foreach ($activities as $key => $value) {

                $syncData[$value] = [
                    'day_limit' => $day_limit[$key] ?? '',
                    'limit_per_visitor' => $limit_per_visitor[$key] ?? '',
                ];
            }
            //dd($syncData);
            $response['data']->activities()->sync($syncData);
        }

        return $response;
    }

    public static function updateQuantity($id, $data)
    {
        static::$rules['update'] = [
            'quantity' => 'required',
        ];
        $response = parent::update($id, $data);

        if ($response['status'] === 'success') {
            return response()->json([
                'status' => 'error',
                'data' => $response['data']
            ]);
        }

    }

    public static function totalCount()
    {
        $count = Model::count();

        if (isset($count)) {
            return [
                'status' => 'success',
                'data' => $count
            ];
        }

    }

    public static function loadPackages($packageType, $day){
        $packages = Model::where('package_type_id',$packageType)
            ->where('day_id',$day)
            ->get();

        if(!$packages){
            return [
                'status' => 'error',
                'data' => 'Not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $packages
        ];
    }


}
