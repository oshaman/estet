<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Blog;
use Gate;
use File;
use Image;
use Config;
use Validator;
use Cache;

class BlogsRepository extends Repository {


    public function __construct(Blog $blog) {
        $this->model = $blog;
    }


    /**
     * @param $id Blog's ID
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
    /**
     *
     * @param $alias
     * @param array $attr
     * @return mixed
     */
    public function one($alias, $attr = array())
    {
        $blog = parent::one($alias, $attr);

        if($blog && !empty($attr)) {
            $blog->load('category');
            $blog->load('tags');
            $blog->load('person');
            $blog->load('blog_img');

            $midnight = strtotime('today midnight');
            $created = strtotime($blog->created_at);

            if ($created > $midnight) {
                $blog->created = date('H:i:s', $created);
            } else {
                $blog->created = date('d-m-Y H:i:s', $created);
            }
            // $blog->load('comments');
            // $blog->comments->load('user');
        }

        return $blog;
    }

    public function addBlog($request)
    {
        if (Gate::denies('DELETE_BLOG')) {
            abort(404);
        }

        $data = $request->except('_token','img');
        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }
        $blog['title'] = $data['title'];

        if ($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }
        $blog['alias'] = $this->transliterate($data['alias']);

        $blog['category_id'] = $data['cats'];

        if (!empty($data['imgalt'])) {
            $img_prop['imgalt'] = $data['imgalt'];
        } else {
            $img_prop['imgalt'] = null;
        }

        if (!empty($data['imgtitle'])) {
            $img_prop['imgtitle'] = $data['imgtitle'];
        } else {
            $img_prop['imgtitle'] = null;
        }

        if (!empty($data['outputtime'])) {
            $blog['created_at'] = date('Y-m-d H:i:s', strtotime($data['outputtime']));
        }
        if (!empty($data['confirmed'])) {
            if (Gate::allows('CONFIRMATION_DATA')) {
                $blog['approved'] = 1;
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
            $obj->og_title = $data['og_title'] ?? '';
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
        if ($request->session()->has('user_id')) {
            $blog['user_id'] = $request->session()->get('user_id');
        }
        $new = $this->model->firstOrCreate($blog);

        $error = '';
        if (!empty($new)) {
            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $blog['alias']);

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $new->blog_img()->create(['path'=>$path, 'alt' => $img_prop['imgalt'], 'title' => $img_prop['imgtitle']]);
                }

                if (null == $img) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
            } elseif (!empty($request->session()->has('image'))) {
                $path = $this->tmpImg($request->session()->get('image'));

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $new->blog_img()->create(['path'=>$path, 'alt' => $img_prop['imgalt'], 'title' => $img_prop['imgtitle']]);
                }

                if (empty($img)) {
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
            Cache::forget('doc');
            return ['status' => trans('admin.material_added')];
        }
        return ['error' => $error];
    }

    /**
     * @param $blog
     * @return array
     */
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
        if (!empty($blog->blog_img->path)) {
            $old_img = $blog->blog_img->path;
        }

        if($blog->delete()) {

            if (!empty($old_img)) {
                $this->deleteOldImage($old_img);
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
            Cache::forget('doc');
            return ['status' => trans('admin.deleted')];
        }

    }

    /**
     * @param $request
     * @param $blog
     * @return array
     */
    public function updateBlog($request, $blog)
    {
        $data = $request->except('_token', 'img');
        $blog->load('blog_img');
        if ($data['title'] !== $blog->title) {
            $new['title'] = $data['title'];
        }
        if ($data['alias'] !== $blog->alias) {
            $new['alias'] = $this->transliterate($data['alias']);
        } else {
            $new['alias'] = $blog->alias;
        }

        if ($data['cats'] !== $blog->category_id) {
            $new['category_id'] = $data['cats'];
        }

        if ($data['imgalt'] !== $blog->blog_img->alt) {
            $new['imgalt'] = $data['imgalt'];
        } else {
            $new['imgalt'] = $blog->blog_img->alt;
        }

        if ($data['imgtitle'] !== $blog->blog_img->title) {
            $new['imgtitle'] = $data['imgtitle'];
        } else {
            $new['imgtitle'] = $blog->blog_img->title;
        }

        if (!empty($data['outputtime'])) {
            $new['created_at'] = date('Y-m-d H:i:s', strtotime($data['outputtime']));
        }

        if (!empty($data['confirmed'])) {
            if (Gate::allows('CONFIRMATION_DATA')) {
                $new['approved'] = 1;
            }
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

        $old_imgs = $blog->blogphoto()->get();

        //        Content
        if (!empty($data['content']) && ($data['content'] != $blog['content'])) {

            $content = $this->contentHandle($data['content'], $new['alias']);

            if (false == $content['content']) {
                $new['content'] = $data['content'];
            } else {
                $new['content'] = $content['content'];
            }
        }
//        END Content
        $updated = $blog->fill($new)->save();

        $error = [];
        if (!empty($updated)) {
            $old_img = $blog->blog_img->path;
            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $new['alias']);

                if (false === $path) {
                    $error[] = ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $blog->blog_img()->update(['path' => $path, 'alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                }

                if (empty($img)) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
                //DELETE OLD IMAGE
                $this->deleteOldImage($old_img);
            } elseif ($request->session()->has('image') && ($request->session()->get('image') !== $blog->blog_img->path)) {
                $path = $this->tmpImg($request->session()->get('image'));

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $blog->blog_img()->update(['path'=>$path, 'alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                }

                if (empty($img)) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
                //DELETE OLD IMAGE
                $this->deleteOldImage($old_img);
            } else {
                $img = $blog->blog_img()->update(['alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                if (empty($img)) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
            }

            // Tags
            if (!empty($data['tags'])) {
                try {
                    $blog->tags()->sync($data['tags']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи тегов: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи тегов'];
                }
            }
    //            delete old imgs
            if (!$old_imgs->isEmpty()) {
                foreach ($old_imgs as $img) {
                    if (preg_match('#'.$img->path.'#', $data['content'])) {
                        continue;
                    }
                    if (File::exists(public_path('images/blog/photos/small/') . $img->path)) {
                        File::delete(public_path('images/blog/photos/small/') . $img->path);
                    }
                    if (File::exists(public_path('images/blog/photos/middle/') . $img->path)) {
                        File::delete(public_path('images/blog/photos/middle/'). $img->path);
                    }
                    if (File::exists(public_path('images/blog/photos/main/') . $img->path)) {
                        File::delete(public_path('images/blog/photos/main/') . $img->path);
                    }
                    try {
                        $blog->blogphoto()->where('id', $img->id)->delete();
                    } catch (Exception $e) {
                        Log::alert($e->getMessage());
                    }
                }
            }

            // content imgs
            if (!empty($content['path'])) {
                try {
                    $blog->blogphoto()->createMany($content['path']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи фотографий'];
                }
            }
            Cache::forget('doc');
            return ['status' => trans('admin.material_added')];
        }
        return ['error' => $error];
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

    /**
     * @param string $image_path
     * @param string $position
     * @return bool
     */
    public function tmpImg($image_path, $position = 'center')
    {
        if (File::exists(public_path('images/blog/tmp/') . $image_path)) {
            $path = $image_path;

            $img = Image::make(public_path('images/blog/tmp/') . $image_path);

            $img->fit(Config::get('settings.blogs_img')['main']['width'], Config::get('settings.blogs_img')['main']['height'],
                function ($constraint) {
                    $constraint->upsize();
                },
                $position)->save(public_path() . '/images/blog/main/' . $path, 100);
            $img->fit(Config::get('settings.blogs_img')['middle']['width'], Config::get('settings.blogs_img')['middle']['height'],
                function ($constraint) {
                    $constraint->upsize();
                },
                $position)->save(public_path() . '/images/blog/middle/' . $path, 100);
            $img->fit(Config::get('settings.blogs_img')['small']['width'], Config::get('settings.blogs_img')['small']['height'],
                function ($constraint) {
                    $constraint->upsize();
                },
                $position)->save(public_path() . '/images/blog/small/' . $path, 100);
            $img->fit(Config::get('settings.blogs_img')['mini']['width'], Config::get('settings.blogs_img')['mini']['height'],
                function ($constraint) {
                    $constraint->upsize();
                },
                $position)->save(public_path() . '/images/blog/mini/' . $path, 100);
            return $path;
        }
        return false;
    }

    /**
     * @param $content
     * @param $alias
     * @return bool
     */
    public function contentHandle($content, $alias)
    {
        if (preg_replace('/<picture>&nbsp;<\/picture>/', '', $content)) {
            $content = preg_replace('/<picture>&nbsp;<\/picture>/', '', $content);
        }

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

    public function findById($id, $attr = array())
    {
        $result = $this->model->where('id', $id)->first();
        if (!empty($result->seo)) {
            if (is_string($result->seo) && is_object(json_decode($result->seo)) && (json_last_error() == JSON_ERROR_NONE)) {
                $result->seo = json_decode($result->seo);
            }
        }
        return $result;
    }

    /**
     * delete old main image
     * @param $path
     * @return true
     */
    public function deleteOldImage($path)
    {
        if (File::exists(public_path('/images/blog/main/') . $path)) {
            File::delete(public_path('/images/blog/main/') . $path);
        }
        if (File::exists(public_path('/images/blog/middle/'). $path)) {
            File::delete(public_path('/images/blog/middle/') . $path);
        }
        if (File::exists(public_path('/images/blog/small/'). $path)) {
            File::delete(public_path('/images/blog/small/'). $path);
        }
        if (File::exists(public_path('/images/blog/mini/'). $path)) {
            File::delete(public_path('/images/blog/mini/'). $path);
        }
        if (File::exists(public_path('/images/blog/tmp/'). $path)) {
            File::delete(public_path('/images/blog/tmp/'). $path);
        }
        return true;
    }


    public function get($select = '*', $take = false, $pagination = false, $where = false, $order = false, $with=false, $check=false)
    {
        $builder = $this->model->select($select);

        if ($with) {
            $builder = $this->model->with($with);
        }

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            if (is_array($where[0]) && !empty(($where[3]))) {
                $builder->where([$where[0], $where[1], $where[2], $where[3]]);
            } elseif (is_array($where[0]) && !empty(($where[2]))) {
                $builder->where([$where[0], $where[1], $where[2]]);
            } elseif(is_array($where[0])) {
                $builder->where([$where[0], $where[1]]);
            } else {
                $builder->where($where[0], $where[1], $where[2] = false);
            }
        }

        if ($order) {
            $builder->orderBy($order[0], $order[1]);
        }
       /* if($pagination) {
            return $builder->paginate(Config::get('settings.paginate'));
        }*/

        if ($check) {
            if($pagination) {
                return $this->check($builder->paginate(Config::get('settings.paginate')));
            }
            return $this->check($builder->get());
        } else {
            if($pagination) {
                return $builder->paginate(Config::get('settings.paginate'));
            }
            return $builder->get();
        }
    }

    /**
     * @param $tag
     * @return articles collection
     */
    public function getByTag($tag)
    {
        $blogs = $this->model->whereHas('tags', function($q) use ( $tag )
        {
            $q->where('tag_id', $tag);
        })->select('title', 'alias')->get();

        return $blogs;
    }

    /**
     * @param $select
     * @param $where
     * @param $take
     * @param $order
     * @return bool
     */
    public function getLast($select, $where, $take, $order)
    {
        return $this->check($this->model->where($where)
            ->take($take)
            ->select($select)
            ->orderBy($order[0], $order[1])
            ->get());
    }

    public function getThreeOwn()
    {

    }
}