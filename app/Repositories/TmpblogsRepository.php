<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Tmpblog;
use Fresh\Estet\Blog;
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
        if ('0' !== $tmpid) {
            $tmp = $this->findById($tmpid);

            if (null == $tmp) {
                return false;
            }
            if (Gate::denies('update', $tmp)) {
                return false;
            }
            return $tmp;
        } else {
            $blog = Blog::where('id', $blogid)->first();

            if (null == $blog) {
                return false;
            }

            if (Gate::denies('view', $blog)) {
                return false;
            }

            $tmp = $this->model->where('blog_id', $blog->id)->first();
            if (null !== $tmp) {
                return $tmp;
            }
            $blog->load('blog_img');
            if (!empty($blog->blog_img->path)) {
                $blog->image = $blog->blog_img->path;
            }

            $blog->blog_session = $blog->id;
            $blog->category = $blog->category_id;

            return $blog;
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function addBlog($request)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }

        $data = $request->except('_token','img');
        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }

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
        } elseif (!empty($request->session()->has('image'))) {
            $blog['image'] = $request->session()->get('image');
        }

        if (!empty($request->session()->has('blog_id'))) {
            $blog['blog_id'] = $request->session()->get('blog_id');
        }
        $this->model->fill($blog);

        $new = $request->user()->blogs()->save($this->model);

        if (!empty($new)) {
            return ['status' => trans('admin.material_added')];
        }
        return ['error' => 'Ошибка добавления материала'];
    }

    /**
     *
     * @param $request
     * @param $tmp_id
     * @return $this|array
     */
    public function updateBlog($request, $tmp_id)
    {
        $tmpblog = $this->findById($tmp_id);

        if (null == $tmpblog) {
            abort(404);
        }

        if (Gate::denies('update', $tmpblog)) {
            abort(404);
        }

        $data = $request->except('_token','img');
        if (empty($data)) {
            return array('error' => trans('admin.no_data'));
        }

        $blog['title'] = $data['title'];

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
            $path = $this->mainImg($request->file('img'), $this->transliterate($data['title']));

            if (false === $path) {
                return redirect()->back()->withErrors('Ошибка загрузки картинки');
            } else {
                $blog['image'] = $path;
            }
        }

        $res = $tmpblog->fill($blog)->save();
        if (!empty($res)) {
            return ['status' => trans('admin.material_updated')];
        }
        return ['error' => 'Ошибка изменения материала'];

    }
    /**
     * @param Instance of Tmp Blog $blog
     * @return Status array
     */
    public function deleteBlog($blog)
    {
        if (Gate::denies('delete', $blog)) {
            abort(404);
        }

        if($blog->delete()) {
            return ['status' => trans('admin.deleted')];
        }
        return ['error'=>'Ошибка удаления'];

    }

    /**
     * Main Image Handler
     * @param $image
     * @param $alias
     * @return bool|string
     */
    public function mainImg($image, $alias)
    {
        if($image->isValid()) {

            $path = substr($alias, 0, 64) . '-' . str_random(2) .  time() . '.jpeg';

            $img = Image::make($image);

            $img->save(public_path() . '/images/blog/tmp/'.$path, 100);
            return $path;

        } else {
            return false;
        }
    }
}