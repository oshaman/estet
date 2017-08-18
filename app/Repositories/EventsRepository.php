<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Event;
use Image;
use Config;
use File;

class EventsRepository extends Repository
{
    protected $model;

    public function __construct(Event $event)
    {
        $this->model = $event;
    }

    public function addEvent($request)
    {
        $data = $request->except('_token');

        if (empty($data['alias'])) {
            $event['alias'] = $this->transliterate($data['title']);
        } else {
            $event['alias'] = $this->transliterate($data['alias']);
        }

        if ($this->one($event['alias'])) {
            $request->merge(array('alias' => $event['alias']));
            $request->flash();
            return ['error' => trans('admin.alias_in_use')];
        }

        $event['title'] = $data['title'];
        $event['country_id'] = $data['country'];
        $event['city_id'] = $data['city'];

        $event['organizer_id'] = $data['organizer'];
        $event['cat_id'] = $data['cats'];

        $event['start'] = date('Y-m-d', strtotime($data['start']));
        $event['stop'] = date('Y-m-d', strtotime($data['stop']));

        $event['content'] = $data['content'];
        $event['description'] = $data['description'];

        $img_prop['imgalt'] = $data['imgalt'] ? $data['imgalt'] : null;
        $img_prop['imgtitle'] = $data['imgtitle'] ? $data['imgtitle'] : null;


        if (!empty($data['confirmed'])) {
            $event['approved'] = 1;
        }
        // SEO handle
        if (!empty($data['seo_title'] || !empty($data['seo_keywords']) || !empty($data['seo_description']) || !empty($data['seo_text'])
            || !empty($data['og_image']) || !empty($data['og_title']) || !empty($data['og_description']))) {
            $obj = new \stdClass;
            $obj->seo_title = $data['seo_title'] ?? '';
            $obj->seo_keywords = $data['seo_keywords'] ?? '';
            $obj->seo_description = $data['seo_description'] ?? '';
            $obj->seo_text = $data['seo_text'] ?? '';
            $obj->og_image = $data['og_image'] ?? '';
            $obj->og_title = $data['og_title'] ?? '';
            $obj->og_description = $data['og_description'] ?? '';
            $event['seo'] = json_encode($obj);
        }

        $new = $this->model->firstOrCreate($event);
        $error = ['model' => 'Ошибка записи'];
        if (!empty($new)) {
            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $event['alias']);

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $new->logo()->create(['path'=>$path, 'alt' => $img_prop['imgalt'], 'title' => $img_prop['imgtitle']]);
                }

                if (null == $img) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
            }

            $slider_path = [];
            if ($request->hasFile('slider')) {
                foreach ($request->file('slider') as $slider) {
                    $slider_path[] = $this->sliderImg($slider, $event['alias']);
                }

            }
            // slider imgs
            if (!empty($slider_path)) {
                try {
                    $new->slider()->createMany($slider_path);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий слайдера: ', $e->getMessage());
                    $error[] = ['slider' => 'Ошибка записи фотографий слайдера'];
                }
            }

            return ['status' => trans('admin.material_added'), $error];
        }
        return ['error' => $error];

    }

    public function updateEvent($request, $event)
    {
        $event->load('logo');
        $event->load('slider');
        
        $data = $request->except('_token', 'logo', 'slider');

        $new['title'] = $data['title'];

        $new['alias'] = $this->transliterate($data['alias']);
        $new['country_id'] = $data['country'];
        $new['city_id'] = $data['city'];


        $new['organizer_id'] = $data['organizer'];
        $new['cat_id'] = $data['cats'];

        $new['start'] = date('Y-m-d', strtotime($data['start']));
        $new['stop'] = date('Y-m-d', strtotime($data['start']));

        $new['content'] = $data['content'];
        $new['description'] = $data['description'];

        if (!empty($data['confirmed'])) {
            $new['approved'] = 1;
        } else {
            $new['approved'] = 0;
        }
        // SEO handle
        if (!empty($data['seo_title'] || !empty($data['seo_keywords']) || !empty($data['seo_description']) || !empty($data['seo_text'])
            || !empty($data['og_image']) || !empty($data['og_title']) || !empty($data['og_description']))) {
            $obj = new \stdClass;
            $obj->seo_title = $data['seo_title'] ?? '';
            $obj->seo_keywords = $data['seo_keywords'] ?? '';
            $obj->seo_description = $data['seo_description'] ?? '';
            $obj->seo_text = $data['seo_text'] ?? '';
            $obj->og_image = $data['og_image'] ?? '';
            $obj->og_title = $data['og_title'] ?? '';
            $obj->og_description = $data['og_description'] ?? '';
            $new['seo'] = json_encode($obj);
        }
        // SEO handle
        // Logo props
        if ($data['imgalt'] !== $event->logo->title) {
            $new['imgalt'] = $data['imgalt'];
        } else {
            $new['imgalt'] = $event->logo->title;
        }

        if ($data['imgtitle'] !== $event->logo->title) {
            $new['imgtitle'] = $data['imgtitle'];
        } else {
            $new['imgtitle'] = $event->logo->title;
        }
        // Logo props


        $updated = $event->fill($new)->save();

        $error = '';
        if (!empty($updated)) {

            // Main Image handle
            if ($request->hasFile('img')) {
                $old_img = $event->logo->path;
                $path = $this->mainImg($request->file('img'), $event['alias']);

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $event->logo()->update(['path'=>$path, 'alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                }

                if (null == $img) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
                //DELETE OLD IMAGE
                $this->deleteOldImages($old_img, 'event');
            } else {
                try {
                    $event->logo()->update(['alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления главного изображения статьи: ', $e->getMessage());
                    $error[] = ['img' => 'Ошибка обновления главного изображения статьи'];
                }
            }
            //Slider
            $slider_path = [];
            if ($request->hasFile('slider')) {
                foreach ($request->file('slider') as $slider) {
                    $slider_path[] = $this->sliderImg($slider, $event['alias']);
                }

            }
            // slider imgs
            if (!empty($slider_path)) {
                try {
                    $event->slider()->createMany($slider_path);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий слайдера: ', $e->getMessage());
                    $error[] = ['slider' => 'Ошибка записи фотографий слайдера'];
                }
            }

            return ['status' => trans('admin.material_updated'), $error];
        }
        return ['error' => $error];
    }

    /**
     * @param $event
     * @return array
     */
    public function deleteEvent($event)
    {

        $logo = $event->logo()->first();
        $slider = $event->slider()->select('path')->get();


        if ($slider->isNotEmpty()) {
            foreach ($slider->toArray() as $name) {
                $this->deleteOldImages($name['path'], 'event/slider');
            }
        }
        $this->deleteOldImages($logo->path, 'event');

        try {
            $event->delete();
        } catch (Exception $e) {
            \Log::info('Ошибка удаления мероприятия: ', $e->getMessage());
        }

        return ['status' => trans('admin.deleted')];
    }
    /**
     * @param File $image
     * @param $alias
     * @param string $position
     * @return bool|string
     */
    public function mainImg($image, $alias, $position = 'center')
    {
        if($image->isValid()) {

            $path = substr($alias, 0, 64) . '-' . time() . '.jpeg';

            $img = Image::make($image);

            $img->fit(Config::get('settings.events_img')['main']['width'], Config::get('settings.events_img')['main']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/main/'.$path, 100);
            $img->fit(Config::get('settings.events_img')['middle']['width'], Config::get('settings.events_img')['middle']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/middle/'.$path, 100);
            $img->fit(Config::get('settings.events_img')['small']['width'], Config::get('settings.events_img')['small']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/small/'.$path, 100);
            $img->fit(Config::get('settings.events_img')['mini']['width'], Config::get('settings.events_img')['mini']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/mini/'.$path, 100);
            return $path;
        } else {
            return false;
        }
    }

    /**
     * @param File $image
     * @param $alias
     * @param string $position
     * @return bool|string
     */
    public function sliderImg($image, $alias, $position = 'center')
    {
        if($image->isValid()) {

            $path = substr($alias, 0, 64) . '-slider-' . str_random(2) . time() . '.jpeg';

            $img = Image::make($image);

            $img->fit(Config::get('settings.events_slider_img')['main']['width'], Config::get('settings.events_slider_img')['main']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/slider/main/'.$path, 100);
            $img->fit(Config::get('settings.events_slider_img')['middle']['width'], Config::get('settings.events_slider_img')['middle']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/slider/middle/'.$path, 100);
            $img->fit(Config::get('settings.events_slider_img')['small']['width'], Config::get('settings.events_slider_img')['small']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/event/slider/small/'.$path, 100);
            $arr['path'] = $path;
            return $arr;
        } else {
            return false;
        }
    }
    /**
     * delete old main image
     * @param $path
     * @return true
     */
    public function deleteOldImages($name, $path)
    {

//        dd(File::exists(public_path('/images/'. $path .'/main/') . $name));
        if (File::exists(public_path('/images/'. $path .'/main/') . $name)) {
            File::delete(public_path('/images/'. $path .'/main/') . $name);
        }
        if (File::exists(public_path('/images/'. $path .'/middle/'). $name)) {
            File::delete(public_path('/images/'. $path .'/middle/') . $name);
        }
        if (File::exists(public_path('/images/'. $path .'/small/'). $name)) {
            File::delete(public_path('/images/'. $path .'/small/'). $name);
        }
        if (File::exists(public_path('/images/'. $path .'/mini/'). $name)) {
            File::delete(public_path('/images/'. $path .'/mini/'). $name);
        }
        if (File::exists(public_path('/images/'. $path .'/tmp/'). $name)) {
            File::delete(public_path('/images/'. $path .'/tmp/'). $name);
        }
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function displayed($id)
    {
        try {
            $this->model->find($id)->increment('view');

        } catch (Exception $e) {
            \Log::info('Ошибка записи просмотра: ', $e->getMessage());

        }
        return true;
    }

    public function getWithoutPrems($pagination=false, $where=false, $wherenot=false, $order=false)
    {
        $builder = $this->model->with('logo');

        if ($where) {
            if (is_array($where[0])) {
                $builder->where($where);
            } else {
                $builder->where($where[0], $where[1], $where[2] = false);
            }
        }

        if ($wherenot) {
            $wherenot = array_diff($wherenot, ['']);
            $builder->whereNotIn('id', $wherenot);
        }

        if ($order) {
            $builder->orderBy($order[0], $order[1]);
        }

        if($pagination) {
            return $builder->paginate(Config::get('settings.paginate'));
        }

        return $builder->get();
    }

    /**
     * @param $ids
     * @return \Illuminate\Support\Collection
     */
    public function getPrems($ids)
    {
        $result = $this->model->with('logo')
                        ->whereIn('id', $ids)
                        ->get();
        return $result;
    }
}