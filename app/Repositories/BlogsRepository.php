<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Blog;
use Gate;
use File;
use Image;
use Config;
use Validator;

class BlogsRepository extends Repository {


    public function __construct(Blog $blog) {
        $this->model = $blog;
    }

    /**
     *
     * @param $alias
     * @param array $attr
     * @return mixed
     */
    public function one($alias, $attr = array()) {
        $blog = parent::one($alias, $attr);

        if($blog && !empty($attr)) {
            $blog->load('category');
            $blog->load('tags');
            // $blog->load('comments');
            // $blog->comments->load('user');
        }

        return $blog;
    }

    public function addBlog($request) {
        if (Gate::denies('create', $this->model)) {
            abort(404);
        }

        $data = $request->except('_token','img');
        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }
//dd($data);
        $blog['title'] = $data['title'];

        if ($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }
        $blog['alias'] = $this->transliterate($data['alias']);

        $blog['category_id'] = $data['cats'];

        if (!empty($data['outputtime'])) {
            $blog['created_at'] = $data['outputtime'];
        }


        if (!empty($data['confirmed'])) {
            if (Gate::denies('CONFIRMATION_DATA')) {
                array_forget($data, 'confirmed');
            } else {
                $blog['approved'] = true;
            }
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
            $obj->og_og_title = $data['og_title'] ?? '';
            $obj->og_description = $data['og_description'] ?? '';
            $blog['seo'] = json_encode($obj);
        }
//        Content
        if (!empty($data['content'])) {

            $content = $this->contentHandle($data['content'], $blog['alias']);

            if (false == $content['content']) {
                $blog['content'] = $data['content'];
            } else {
                $blog['content'] = $content['content'];
            }
        }
//        END Content

        $this->model->fill($blog);

        $new = $request->user()->blogs()->save($this->model);

        $error = '';
        if (!empty($new)) {

            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $blog['alias']);

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $new->blog_img()->create(['path'=>$path]);
                }

                if (null == $img) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
            }


            // Tags
            if (!empty($data['tags'])) {

                try {
                    $new->tags()->attach($data['tags']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи тегов: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи тегов'];
                }
            }
            // content imgs
            if (!empty($content['path'])) {
                try {
                    $new->blogphoto()->createMany($content['path']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи фотографий'];
                }
            }


            return ['status' => trans('admin.material_added')];
        }
        return ['error' => $error];
    }

    public function deleteBlog($blog)
    {
        $pics = $blog->blogphoto()->get();

        if ($pics->isNotEmpty()) {
            $old_pic = [];
            foreach ($pics as $pic) {
                $old_pic[] = $pic->path;
            }
        }
        // $blog->comments()->delete();
        $blog->tags()->detach();
        if (!empty($blog->blog_img->path)) {
            $old_img = $blog->blog_img->path;
        }

        if($blog->delete()) {

            if (!empty($old_img)) {
                if (File::exists(public_path('/images/blog/main/') . $old_img)) {
                    File::delete(public_path('/images/blog/main/') . $old_img);
                }
                if (File::exists(public_path('/images/blog/middle/'). $old_img)) {
                    File::delete(public_path('/images/blog/middle/') . $old_img);
                }
                if (File::exists(public_path('/images/blog/small/'). $old_img)) {
                    File::delete(public_path('/images/blog/small/'). $old_img);
                }
                if (File::exists(public_path('/images/blog/mini/'). $old_img)) {
                    File::delete(public_path('/images/blog/mini/'). $old_img);
                }
            }

            if (!empty($old_pic)) {
                foreach ($old_pic as $pic) {

                    if (File::exists(public_path('/images/blog/photos/main/') . $pic)) {
                        File::delete(public_path('/images/blog/photos/main/') . $pic);
                    }

                    if (File::exists(public_path('/images/blog/photos/middle/'). $pic)) {
                        File::delete(public_path('/images/blog/photos/middle/') . $pic);
                    }

                    if (File::exists(public_path('/images/blog/photos/small/'). $pic)) {
                        File::delete(public_path('/images/blog/photos/small/'). $pic);
                    }
                }
            }


            return ['status' => trans('admin.deleted')];
        }

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

            $path = substr($alias, 0, 64) . '-' . time() . '.jpeg';

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

    public function contentHandle($content, $alias)
    {
//        return $content;

        $reg = '#(?<=<img src="\/photos\/)\d+\/[a-zA-z0-9-_]+\.(jpg|jpeg|png|bmp)(?=.*?>)#i';

        preg_match_all($reg, $content, $imgs);

        if (!empty($imgs[0])) {
            //          resize imgs
            $new_path = [];

            foreach ($imgs[0] as $val) {
                $new_path[] = $this->addPhotos($val, $alias);
            }

//            convert img's tags
            $picture = array_map(function ($v) {
                return
                    '<picture>
                            <source srcset="http://estet-portal.loc/images/blog/photos/small/' .$v. '" media="(max-width: 320px)">
                            <source srcset="http://estet-portal.loc/images/blog/photos/middle/' .$v. '" media="(max-width: 768px)">
                            <source srcset="http://estet-portal.loc/images/blog/photos/main/' .$v. '" media="(max-width: 1024px)">
                            <source srcset="http://estet-portal.loc/images/blog/photos/main/' .$v. '">
                            <img srcset="http://estet-portal.loc/images/blog/photos/small/' .$v. '" alt="My default image">
                        </picture>';
            }, $new_path);
//          convert content text
            $patterns = array_map(function($v){ return '#<img src="\/photos\/' .addcslashes($v, '\./'). '.*?>#i'; }, $imgs[0]);
            $result['content'] = preg_replace($patterns, $picture, $content);
            $new_path = array_map(function ($v) {
                return ['path'=>$v];
            }, $new_path);
            $result['path'] = $new_path;
            return $result;
        } else {
            return false;
        }


    }

    /**
     * convert end resize photos
     * @param $path to original img
     * @param $alias
     * @return string new img's name
     */
    public function addPhotos($path, $alias)
    {
        if(file_exists(public_path('/photos') . '/' .$path)) {

            $img = Image::make(asset('photos'). '/' .$path);

            $str = substr($alias, 0, 32) . '-' . str_random(2) . time() .'.jpg';

            $width = $img->width();
            if ($width <= 312) {
                $img->save(public_path('images/blog/photos/small/') . $str, 100);
                $img->save(public_path('images/blog/photos/middle/') . $str, 100);
                $img->save(public_path('images/blog/photos/main/') . $str, 100);
                return $str;
            } elseif ($width <= 335) {
                $img->widen(312)->save(public_path('images/blog/photos/small/') . $str, 100);
                $img->save(public_path('images/blog/photos/middle/') . $str, 100);
                $img->save(public_path('images/blog/photos/main/') . $str, 100);
                return $str;
            } elseif ($width <= 535) {
                $img->widen(312)->save(public_path('images/blog/photos/small/') . $str, 100);
                $img->widen(335)->save(public_path('images/blog/photos/middle/') . $str, 100);
                $img->save(public_path('images/blog/photos/main/') . $str, 100);
                return $str;
            } else {
                $img->widen(312)->save(public_path('images/blog/photos/small/') . $str, 100);
                $img->widen(335)->save(public_path('images/blog/photos/middle/') . $str, 100);
                $img->widen(535)->save(public_path('images/blog/photos/main/') . $str, 100);
                return $str;
            }
        } else return 'Ошибка добавления файла';
    }
}