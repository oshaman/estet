<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Tmpblog;
use Gate;
use File;
use Image;
use Config;
use Validator;

class TmpblogsRepository extends Repository {


    public function __construct(Tmpblog $blog) {
        $this->model = $blog;
    }

    public function getBlog($tmpid, $blogid)
    {
        dd($blogid);

        if (0 == $tmpid) {
            $blog = 
        } else {

        }
    }

    public function addBlog($request) {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }

        $data = $request->except('_token','img');
        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }
//dd($request);
        $blog['title'] = $data['title'];

        $blog['alias'] = $this->transliterate($data['title']);

        if (!empty($data['cats'])) {
            $blog['category'] = $data['cats'];
        }

        if (!empty($data['moder'])) {
            $blog['moderate'] = true;
        }
//        Content
        if (!empty($data['content'])) {
            $blog['content'] = $data['content'];
        }
//        END Content
        // Main Image handle
        if ($request->hasFile('img')) {
            $path = $this->mainImg($request->file('img'), $blog['alias']);

            if (false === $path) {
                return redirect()->back()->withErrors('Ошибка загрузки картинки');
            } else {
                $blog['image'] = $path;
            }
        }
//        dd($blog);
        $this->model->fill($blog);

        $new = $request->user()->blogs()->save($this->model);

        if (!empty($new)) {
            return ['status' => trans('admin.material_added')];
        }
        return ['error' => 'Ошибка добавления материала'];
    }

    /*


    public function updateArticle($request, $article) {
        if (Gate::denies('update', $article)) {
            abort(404);
        }

        $data = $request->except('_token','img','_method');

        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']) . '-' .date('Ymd');
        } elseif ($data['alias'] != $article->alias) {
            $data['alias'] = $this->transliterate($data['alias']) . '-' .date('Ymd');
        }

        $result = $this->one($data['alias'],FALSE);

        if(isset($result->id) && ($result->id != $article->id)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

        if (!empty($data['outputtime'])) {
            $data['created_at'] = $data['outputtime'];
        }

        if (empty($data['source'])) {
            $data['source'] = 'www.' . config('app.name');
        }

        if (empty($data['description'])) {
            $data['description'] = str_limit($data['text'], 320);
        }

        if (empty($data['keywords'])) {
            $data['keywords'] = preg_replace("#[^a-zA-zа-яА-Яїі0-9\()]+#u", ', ', $data['title']);
        }

        if (empty($data['meta_desc'])) {
            $data['meta_desc'] = preg_replace("#[^a-zA-zа-яА-Яїі0-9\()]+#u", ', ', $data['title']);
        }

        if (!empty($data['approved'])) {
            if (Gate::denies('CONFIRMATION_DATA')) {
                array_forget($data, 'approved');
            } else {
                $data['approved'] = true;
            }
        } else {
            $data['approved'] = false;
        }

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            if($image->isValid()) {

                $str = substr($data['alias'], 0, 32) . '-' . time();
                $obj = new \stdClass;

                $obj->micro = $str.'_micro.jpg';
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path, 100);

                $img->widen(Config::get('settings.articles_img')['max']['width'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max, 100);

                $img->fit(Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini, 100);

                $img->fit(Config::get('settings.articles_img')['micro']['width'],
                    Config::get('settings.articles_img')['micro']['height'])->save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->micro, 100);

                if (is_string($article->img) && is_object(json_decode($article->img)) && (json_last_error() ==    JSON_ERROR_NONE)) {
                    $old_img = json_decode($article->img);
                    // dd($old_img);
                    foreach ($old_img as $pic) {
                        if (File::exists(config('settings.theme').'/images/articles/'.$pic)) {
                            File::delete(config('settings.theme').'/images/articles/'.$pic);
                        }
                    }
                }

                $data['img'] = json_encode($obj);
            }
        }

        $article->fill($data);

        if($article->update()) {
            return ['status' => trans('admin.material_updated')];
        }
    }

    

    public function selectArticles($request)
    {
        $data = $request->only('selection', 'param');

        switch ($data['selection']) {
            case 'unapproved':
                $res = $this->get(['id', 'title', 'description', 'alias', 'img', 'category_id', 'approved'],
                    false,
                    true,
                    ['approved', false],
                    ['created_at', 'desc']);
                return $res;
            case 'id':
                $data['param'] = (int)$data['param'];
                $res = $this->get(['id', 'title', 'description', 'alias', 'img', 'category_id', 'approved'],
                    false,
                    true,
                    ['id', $data['param']],
                    ['created_at', 'desc']);
                return $res;
            case 'author':
                if (empty($data['param'])) return false;
                $data['param'] = \Oshaman\Publication\User::select('id')->where('name', $data['param'])->firstOrFail()->id;
                $res = $this->get(['id', 'title', 'description', 'alias', 'img', 'category_id', 'approved'],
                    false,
                    true,
                    ['user_id', $data['param']],
                    ['created_at', 'desc']);
                return $res;
            case 'alias':
                $res = $this->get(['id', 'title', 'description', 'alias', 'img', 'category_id', 'approved'],
                    false,
                    true,
                    ['alias', $data['param']],
                    ['created_at', 'desc']);
                return $res;
            default:
                return false;
        }

        return false;
    }*/
    public function mainImg($image, $alias, $position = 'center')
    {
        if($image->isValid()) {

            $path = substr($alias, 0, 64) . '-' . str_random(2) .  time() . '.jpeg';

            $img = Image::make($image);

            $img->fit(Config::get('settings.blogs_img')['main']['width'], Config::get('settings.blogs_img')['main']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/blog/main/'.$path, 100);
            $img->fit(Config::get('settings.blogs_img')['middle']['width'], Config::get('settings.blogs_img')['middle']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/blog/middle/'.$path, 100);
            $img->fit(Config::get('settings.blogs_img')['small']['width'], Config::get('settings.blogs_img')['small']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/blog/small/'.$path, 100);
            $img->fit(Config::get('settings.blogs_img')['mini']['width'], Config::get('settings.blogs_img')['mini']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/blog/mini/'.$path, 100);
            return $path;

        } else {
            return false;
        }
    }
}