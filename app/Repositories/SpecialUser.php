<?php

namespace App\Repositories;

use App\Models\Order\Order;
use App\Models\SpecialUser as Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;

class SpecialUser extends BaseRepository
{
    protected static $model = Model::class;
    protected static $disk = 'public';

    protected static $rules = [
        'save' => [],
        'update' => []
    ];

    public static function save($data): array
    {
        //dd($data);
        if ($data['document']) {
            //dd($data['document']);
            // Check validation.
            $validator = Validator::make($data, [
                'document' => 'required|max:2048'
            ]);
            // If validation failed then return the error.
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()->toArray(),
                ];
            }

            // Upload document
            $path = 'special-users/document';

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777, true);
            }

            $name = uniqid('special-users-', true) . '.' . $data['document']->getClientOriginalExtension();

            Storage::disk(static::$disk)->put("{$path}/{$name}", File::get($data['document']));

        }


        return parent::save($data);

    }

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'full_name' => 'required',
            'company_name' => 'required',
            'type' => 'required',
            'email' => "required|email|unique:special_users,email," . $id,
            'mobile' => 'numeric|min:10',
            'address' => 'required',
            'country_id' => 'required',
            'city' => 'required',
        ];

        //dd($data['document']);
        if ($data['document']) {
            //dd($data['document']);
            // Check validation.
            $validator = Validator::make($data, [
                'document' => 'required'
            ]);
            // If validation failed then return the error.
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()->toArray(),
                ];
            }

            // Upload document
            $path = 'special-users/document';

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777, true);
            }

            $name = uniqid('special-users-', true) . '.' . $data['document']->getClientOriginalExtension();

            Storage::disk(static::$disk)->put("{$path}/{$name}", File::get($data['document']));

            $data['document'] = $name;
        }
        else{

            $data['document'] = $data['oldDocument'];
            unset($data['oldDocument']);

        }

        return parent::update($id, $data);
    }

//    public static function delete($id): array
//    {
//        if (Order::whereUserId($id)->exists()) {
//            return [
//                'status' => 'error',
//                'data' => "The special user had an order. please delete the order first to delete the special user "
//            ];
//        }
//
//        return parent::delete($id);
//    }

}
