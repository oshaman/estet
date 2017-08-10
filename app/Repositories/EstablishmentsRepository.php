<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Establishment;
use Gate;
use Image;
use Config;
use File;



class EstablishmentsRepository extends Repository
{
    public function __construct(Establishment $establishment)
    {
        $this->model = $establishment;
    }

    /**
     * Getting distributiors
     * @return array
     */
    public function getParents()
    {
        $results = $this->model->where([['parent', null], ['category', 'distributor']])
            ->select(['id', 'title'])
            ->get();
        $parents = [];
        foreach ($results as $result) {
            $parents[$result->id] = $result->title;
        }
        return $parents;
    }

    /**
     * @param $request
     * @return Result array
     */
    public function addEstablishment($request)
    {
        if (Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }
        $data = $request->except('_token', 'logo');

        if (null == $data['alias']) {
            $data['alias'] = $this->transliterate($data['title']);
        } else {
            $data['alias'] = $this->transliterate($data['alias']);
        }
        if ($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

        switch ($data['category']) {
            case 0:
                $data['category'] = 'clinic';
                break;
            case 1:
                $data['category'] = 'distributor';
                break;
            case 2:
                $data['category'] = 'brand';
                break;
            default:
                $data['category'] = 'clinic';

        }

        $data['services'] = array_diff($data['services'], ['']);
        $data['services'] = count($data['services']) ? json_encode($data['services']) : null;

        if ($data['extra']) {
            foreach ($data['extra'] as $value){
                if ((null == $value[0]) || (null == $value[1])) {
                    continue;
                }

                $result[] = $value;
            }

            if ($result) {
                $data['extra'] = json_encode($result);
            }

        }
        // Main Image handle
        if ($request->hasFile('logo')) {
            $path = $this->addImg($request->file('logo'), $data['alias']);

            if (false === $path) {
                return ['error' => 'Ошибка записи логотипа'];
            }
            $data['logo'] = $path;
        } else {
            return ['error' => 'Ошибка записи логотипа'];
        }


        try {
            $new = $this->model->firstOrCreate($data);
        } catch (Exception $e) {
            \Log::info('Ошибка записи учреждения: ', $e->getMessage());
            return ['error' => 'Ошибка записи'];
        }

        if (!empty($new)) {
            return ['status' => trans('admin.material_added')];
        }

    }

    /**
     * @param $request
     * @param Instance of Establishment $establishment
     * @return Status array
     */
    public function updateEstablishment($request, $establishment)
    {
        $data = $request->except('_token', 'logo');

        if ((null !== $data['alias']) && ($data['alias'] != $establishment->alias)) {
            $data['alias'] = $this->transliterate($data['alias']);
        } elseif (null == $data['alias']) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        if ($data['alias'] != $establishment->alias) {
            if ($this->one($data['alias'],FALSE)) {
                $request->merge(array('alias' => $data['alias']));
                $request->flash();

                return ['error' => trans('admin.alias_in_use')];
            }
        }


        switch ($data['category']) {
            case 0:
                $data['category'] = 'clinic';
                break;
            case 1:
                $data['category'] = 'distributor';
                break;
            case 2:
                $data['category'] = 'brand';
                break;
            default:
                $data['category'] = 'clinic';

        }

        $data['services'] = array_diff($data['services'], ['']);
        $data['services'] = count($data['services']) ? json_encode($data['services']) : null;

        if ($data['extra']) {
            foreach ($data['extra'] as $value){
                if ((null == $value[0]) || (null == $value[1])) {
                    continue;
                }

                $result[] = $value;
            }

            if ($result) {
                $data['extra'] = json_encode($result);
            }

        }
        // Main Image handle
        if ($request->hasFile('logo')) {
            $path = $this->addImg($request->file('logo'), $data['alias']);

            if (false === $path) {
                $request->flash();
                return ['error' => 'Ошибка записи логотипа'];
            }
            $data['logo'] = $path;
        }
        $old_logo = $establishment->logo;

        try {
            $updated = $establishment->fill($data)->save();
        } catch (Exception $e) {
            \Log::info('Ошибка записи учреждения: ', $e->getMessage());
            $request->flash();
            return ['error' => 'Ошибка записи'];
        }

        if (!empty($updated)) {
            if (!empty($path)) $this->deleteOldImage($old_logo);
            return ['status' => trans('admin.material_updated')];
        }

    }

    /**
     * @param Instance of Establishment $establishment
     * @return Result array
     */
    public function deleteEstablishment($establishment)
    {
        // $establishment->comments()->delete();
        // $establishment->ratios()->delete();
        if (!empty($establishment->logo)) {
            $old_img = $establishment->logo;
        }

        if($establishment->delete()) {

            if (!empty($old_img)) {
                $this->deleteOldImage($old_img);
            }
            
            return ['status' => trans('admin.deleted')];
        }
    }

    /**
     * delete old main image
     * @param $path
     * @return true
     */
    public function deleteOldImage($path)
    {
        if (File::exists(public_path('/images/establishment/main/') . $path)) {
            File::delete(public_path('/images/establishment/main/') . $path);
        }
        if (File::exists(public_path('/images/establishment/middle/'). $path)) {
            File::delete(public_path('/images/establishment/middle/') . $path);
        }
        if (File::exists(public_path('/images/establishment/small/'). $path)) {
            File::delete(public_path('/images/establishment/small/'). $path);
        }
        return true;
    }

    /**
     * @param File $image
     * @param $alias
     * @param string $position
     * @return bool|string
     */
    public function addImg($image, $alias, $position = 'center')
    {
        if($image->isValid()) {

            $path = substr($alias, 0, 64) . '-' . time() . '.jpeg';

            $img = Image::make($image);

            $img->fit(Config::get('settings.establishment_img')['main']['width'], Config::get('settings.establishment_img')['main']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/establishment/main/'.$path, 100);
            $img->fit(Config::get('settings.establishment_img')['middle']['width'], Config::get('settings.establishment_img')['middle']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/establishment/middle/'.$path, 100);
            $img->fit(Config::get('settings.establishment_img')['small']['width'], Config::get('settings.establishment_img')['small']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/establishment/small/'.$path, 100);
            return $path;
        } else {
            return false;
        }
    }

    public function convertParams($establishment)
    {
        if (is_string($establishment->extra)
            && (is_array(json_decode($establishment->extra)) || is_object(json_decode($establishment->extra)))
            && (json_last_error() == JSON_ERROR_NONE)) {

            $establishment->extra = json_decode($establishment->extra);
            if (!is_array($establishment->extra)) $establishment->extra = (array)$establishment->extra;

        }

        if (is_string($establishment->services)
                    && (is_array(json_decode($establishment->services)) || is_object(json_decode($establishment->services)))
                    && (json_last_error() == JSON_ERROR_NONE)) {
            
            $establishment->services = json_decode($establishment->services);
            if (!is_array($establishment->services)) $establishment->services = (array)$establishment->services;
        }

        switch ($establishment->category) {
            case 'clinic':
                $establishment->category = 0;
                break;
            case 'distributor':
                $establishment->category = 1;
                break;
            case 'brand':
                $establishment->category = 2;
                break;
        }

        return $establishment;
    }

    public function findByTitle($title)
    {
        $result = $this->model->where('title', $title)->first();

        return $result;
    }

}