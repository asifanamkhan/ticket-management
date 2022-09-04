<?php

namespace App\Repositories;

use App\Models\Activity as Model;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Activity extends BaseRepository
{
    protected static $model = Model::class;
    protected static $disk = 'public';

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:activities,name,NULL,id,deleted_at,NULL',
        ],
        'update' => []
    ];

    public static function save($data): array
    {
        $images = [];

        if (sizeof($data['images']) > 0) {
            $path = 'uploads/activity';

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777,true);
            }

            foreach($data['images'] as $image) {

                if ($image != null) {

                    $name = uniqid() . '_' . $image->getClientOriginalName();
                    $images[] = $name;
                
                    Storage::disk(static::$disk)->put("{$path}/{$name}", File::get($image));
                }
            }
            $data['images'] = $images;
        }

        if (sizeof($images) < 1) {
            unset($data['images']);
        }

        return parent::save($data);
    }

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => "required|unique:activities,name,{$id},id,deleted_at,NULL",
        ];

        $images = [];

        if (sizeof($data['images']) > 0) {
            $path = 'uploads/activity';

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777,true);
            }

            foreach($data['images'] as $image) {
                if ($image != null) {
                    $name = uniqid() . '_' . $image->getClientOriginalName();
                    $images[] = $name;
                
                    Storage::disk(static::$disk)->put("{$path}/{$name}", File::get($image));
                }
            }
            $data['images'] = $images;
        }
        
        if (sizeof($images) < 1) {
            unset($data['images']);
        }

        return parent::update($id, $data);
    }

    public static function delete($id): array
    {
        if (DB::table('package_activity')->where('activity_id', $id)->exists()) {
            return [
                'status' => 'error',
                'data' => "The Activity already used in packages."
            ];
        }

        return parent::delete($id);
    }

    public static function imageDelete($id,$images){

        try{
            return parent::update($id,[
                'images'=>$images
            ]);

        }catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }

    }

    public static function totalCount(){
        $count = Model::count();

        if(isset($count)){
            return [
                'status' => 'success',
                'data' => $count
            ];
        }

    }

}
