<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Gate;
use File;
use Image;
use Config;
use Validator;

class ArticlesRepository extends Repository
{
    public function __construct(Article $rep)
    {
        $this->model = $rep;
    }


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
     * @param $select
     * @param $where
     * @param $with
     * @param $take
     * @param $order
     * @return Instance of Article
     */
    public function getMain($select, $where, $with, $take, $order)
    {
         $res = $this->check($this->model->where($where)
            ->take($take)
            ->with($with)
            ->select($select)
            ->orderBy($order[0], $order[1])
            ->get());
         if (!empty($res)) {
             $res = $res->transform(function($item) {

                 if (!empty($item->content)) {
                     if (preg_replace('/<p><picture>.+<\/picture><\/p>/s', '', $item->content)) {
                         $item->content = preg_replace('/<p><picture>.+<\/picture><\/p>/s', '', $item->content);
                     }
                     if (!empty($item->content)) {
                         $item->content = preg_replace('/<p><iframe .+<\/iframe><\/p>/s', '', $item->content);
                     }
                 }

                 return $item;

             });
         }
        return $res;
    }

    public function getLast($select, $where, $take, $order)
    {
        return $this->check($this->model->where($where)
            ->take($take)
            ->select($select)
            ->orderBy($order[0], $order[1])
            ->get());
    }

    public function mostDisplayed($select, $where, $take, $order)
    {
        return $this->check($this->model->where($where)
            ->take($take)
            ->select($select)
            ->orderBy($order[0], $order[1])
            ->get());
    }

    /**
     * @param $request
     * @return Result array
     */
    public function addArticle($request)
    {
        if (Gate::denies('ADD_ARTICLES')) {
            abort(404);
        }

        $data = $request->except('_token');

        $article['title'] = $data['title'];

        $article['category_id'] = $data['cats'];

        $article['alias'] = $this->transliterate($data['alias']);
        if ($this->one($article['alias'],FALSE)) {
            $request->merge(array('alias' => $article['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

        if (!empty($data['confirmed'])) {
            if (Gate::allows('CONFIRMATION_DATA')) {
                $article['approved'] = 1;
            }
        }

        if ($data['own']) {
            $article['own'] = 'docs';
        } else {
            $article['own'] = 'patient';
        }

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
            $article['created_at'] = date('Y-m-d H:i:s', strtotime($data['outputtime']));
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
            $article['seo'] = json_encode($obj);
        }
        //        Content
        if (!empty($data['content'])) {

            $content = $this->contentHandle($data['content'], $article['alias']);

            if (false == $content['content']) {
                $article['content'] = $data['content'];
            } else {
                $article['content'] = $content['content'];
            }
        }
//        END Content
        $new = $this->model->firstOrCreate($article);

        $error = [];
        if (!empty($new)) {
            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $article['alias']);

                if (false === $path) {
                    $error[] =  ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $new->image()->create(['path'=>$path, 'alt' => $img_prop['imgalt'], 'title' => $img_prop['imgtitle']]);
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
                    $new->photo()->createMany($content['path']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи фотографий'];
                }
            }

            return ['status' => trans('admin.material_added'), $error];
        }
        return ['error' => $error];
    }

    /**
     * @param $request
     * @param Article $article
     * @return array - Result
     */
    public function updateArticle($request, $article)
    {
        $data = $request->except('_token', 'img');
        $article->load('image');

        if ($data['title'] !== $article->title) {
            $new['title'] = $data['title'];
        }

        if ($data['alias'] !== $article->alias) {
            $new['alias'] = $this->transliterate($data['alias']);
        } else {
            $new['alias'] = $article->alias;
        }

        if ($data['own']) {
            $article['own'] = 'docs';
        } else {
            $article['own'] = 'patient';
        }

        if ($data['cats'] !== $article->category_id) {
            $new['category_id'] = $data['cats'];
        }

        if ($data['imgalt'] !== $article->image->alt) {
            $new['imgalt'] = $data['imgalt'];
        } else {
            $new['imgalt'] = $article->image->alt;
        }

        if (empty($data['tags'])) {
            $data['tags'] = null;
        }

        if ($data['imgtitle'] !== $article->image->title) {
            $new['imgtitle'] = $data['imgtitle'];
        } else {
            $new['imgtitle'] = $article->image->title;
        }

        if (!empty($data['outputtime'])) {
            $new['created_at'] = date('Y-m-d H:i:s', strtotime($data['outputtime']));
        }

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
        } else { $new['seo'] = null; }

        //        Content
        if (!empty($data['content']) && ($data['content'] != $article['content'])) {

            $content = $this->contentHandle($data['content'], $new['alias']);

            if (false == $content['content']) {
                $new['content'] = $data['content'];
            } else {
                $new['content'] = $content['content'];
            }
        }
//        END Content

        $updated = $article->fill($new)->save();

        $error = '';
        if (!empty($updated)) {

            try {
                $article->establishments()->sync($data['mentions'] ?? []);
            } catch (Exception $e) {
                \Log::info('Ошибка обновления рекламодателей: ', $e->getMessage());
                $error[] = ['mentions' => 'Ошибка обновления рекламодателей'];
            }

            $old_img = $article->image->path;
            // Main Image handle
            if ($request->hasFile('img')) {
                $path = $this->mainImg($request->file('img'), $new['alias']);

                if (false === $path) {
                    $error[] = ['img' => 'Ошибка загрузки картинки'];
                } else {
                    $img = $article->image()->update(['path' => $path, 'alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                }

                if (empty($img)) {
                    $error[] = ['img' => 'Ошибка записи картинки'];
                }
                //DELETE OLD IMAGE
                $this->deleteOldImage($old_img);
            } else {
                try {
                    $article->image()->update(['alt' => $new['imgalt'], 'title' => $new['imgtitle']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления главного изображения статьи: ', $e->getMessage());
                    $error[] = ['img' => 'Ошибка обновления главного изображения статьи'];
                }
            }

            try {
                $article->tags()->sync($data['tags']);
            } catch (Exception $e) {
                \Log::info('Ошибка записи тегов: ', $e->getMessage());
                $error[] = ['tag' => 'Ошибка записи тегов'];
            }

            $old_photos = $article->photo()->get();
            //            delete old imgs
            if (!$old_photos->isEmpty()) {
                foreach ($old_photos as $img) {
                    if (preg_match('#'.$img->path.'#', $data['content'])) {
                        continue;
                    }
                    if (File::exists(public_path('images/article/photos/small/') . $img->path)) {
                        File::delete(public_path('images/article/photos/small/') . $img->path);
                    }
                    if (File::exists(public_path('images/article/photos/middle/') . $img->path)) {
                        File::delete(public_path('images/article/photos/middle/'). $img->path);
                    }
                    if (File::exists(public_path('images/article/photos/main/') . $img->path)) {
                        File::delete(public_path('images/article/photos/main/') . $img->path);
                    }
                    try {
                        $article->photo()->where('id', $img->id)->delete();
                    } catch (Exception $e) {
                        Log::alert($e->getMessage());
                    }
                }
            }

            // content imgs
            if (!empty($content['path'])) {
                try {
                    $article->photo()->createMany($content['path']);
                } catch (Exception $e) {
                    \Log::info('Ошибка записи фотографий: ', $e->getMessage());
                    $error[] = ['tag' => 'Ошибка записи фотографий'];
                }
            }

            return ['status' => trans('admin.material_updated'), $error];
        }
        return ['error' => $error];
    }
    /**
     *
     * @param $article
     * @return Result array
     */
    public function deleteArticle($article)
    {
        $pics = $article->photo()->get();

        if ($pics->isNotEmpty()) {
            $old_pic = [];
            foreach ($pics as $pic) {
                $old_pic[] = $pic->path;
            }
        }
        // $article->comments()->delete();
        if (!empty($article->image->path)) {
            $old_img = $article->image->path;
        }

        if($article->delete()) {

            if (!empty($old_img)) {
                $this->deleteOldImage($old_img);
            }

            if (!empty($old_pic)) {
                foreach ($old_pic as $pic) {

                    if (File::exists(public_path('/images/article/photos/main/') . $pic)) {
                        File::delete(public_path('/images/article/photos/main/') . $pic);
                    }

                    if (File::exists(public_path('/images/article/photos/middle/'). $pic)) {
                        File::delete(public_path('/images/article/photos/middle/') . $pic);
                    }

                    if (File::exists(public_path('/images/article/photos/small/'). $pic)) {
                        File::delete(public_path('/images/article/photos/small/'). $pic);
                    }
                }
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
        if (File::exists(public_path('/images/article/main/') . $path)) {
            File::delete(public_path('/images/article/main/') . $path);
        }
        if (File::exists(public_path('/images/article/middle/'). $path)) {
            File::delete(public_path('/images/article/middle/') . $path);
        }
        if (File::exists(public_path('/images/article/small/'). $path)) {
            File::delete(public_path('/images/article/small/'). $path);
        }
        if (File::exists(public_path('/images/article/mini/'). $path)) {
            File::delete(public_path('/images/article/mini/'). $path);
        }
        if (File::exists(public_path('/images/article/tmp/'). $path)) {
            File::delete(public_path('/images/article/tmp/'). $path);
        }
        return true;
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
                            <source srcset="http://estet-portal.loc/images/article/photos/small/' .$v. '" media="(max-width: 320px)">
                            <source srcset="http://estet-portal.loc/images/article/photos/middle/' .$v. '" media="(max-width: 768px)">
                            <source srcset="http://estet-portal.loc/images/article/photos/main/' .$v. '" media="(max-width: 1024px)">
                            <source srcset="http://estet-portal.loc/images/article/photos/main/' .$v. '">
                            <img srcset="http://estet-portal.loc/images/article/photos/small/' .$v. '" alt="My default image">
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
                $img->save(public_path('images/article/photos/small/') . $str, 100);
                $img->save(public_path('images/article/photos/middle/') . $str, 100);
                $img->save(public_path('images/article/photos/main/') . $str, 100);
                return $str;
            } elseif ($width <= 335) {
                $img->widen(312)->save(public_path('images/article/photos/small/') . $str, 100);
                $img->save(public_path('images/article/photos/middle/') . $str, 100);
                $img->save(public_path('images/article/photos/main/') . $str, 100);
                return $str;
            } elseif ($width <= 535) {
                $img->widen(312)->save(public_path('images/article/photos/small/') . $str, 100);
                $img->widen(335)->save(public_path('images/article/photos/middle/') . $str, 100);
                $img->save(public_path('images/article/photos/main/') . $str, 100);
                return $str;
            } else {
                $img->widen(312)->save(public_path('images/article/photos/small/') . $str, 100);
                $img->widen(335)->save(public_path('images/article/photos/middle/') . $str, 100);
                $img->widen(535)->save(public_path('images/article/photos/main/') . $str, 100);
                return $str;
            }
        } else return 'Ошибка добавления файла';
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

            $img->fit(Config::get('settings.articles_img')['main']['width'], Config::get('settings.articles_img')['main']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/article/main/'.$path, 100);
            $img->fit(Config::get('settings.articles_img')['middle']['width'], Config::get('settings.articles_img')['middle']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/article/middle/'.$path, 100);
            $img->fit(Config::get('settings.articles_img')['small']['width'], Config::get('settings.articles_img')['small']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/article/small/'.$path, 100);
            $img->fit(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'],
                function ($constraint) { $constraint->upsize();},
                $position)->save(public_path() . '/images/article/mini/'.$path, 100);
            return $path;
        } else {
            return false;
        }
    }

    /**
     * @param $tag
     * @return articles collection
     */
    public function getByTag($tag)
    {
        $articles = $this->model->whereHas('tags', function($q) use ( $tag )
        {
            $q->where('tag_id', $tag);
        })->select('title', 'alias')->get();

        return $articles;
    }

}