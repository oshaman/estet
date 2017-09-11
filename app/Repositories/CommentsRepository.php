<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Blogcomment;
use Fresh\Estet\Establishmentcomment;
use Fresh\Estet\Eventcomment;
use Fresh\Estet\Horocomment;
use Validator;
use Fresh\Estet\Article;
use Fresh\Estet\Establishment;
use Fresh\Estet\Blog;
use Fresh\Estet\Event;
use Fresh\Estet\Comment;
use Config;


class CommentsRepository
{
    public function get($source)
    {
        switch ($source) {
            case 1:
                $comments = Comment::where('approved', 0)->select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            case 2:
                $comments = Blogcomment::where('approved', 0)->select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            case 3:
                $comments = Establishmentcomment::where('approved', 0)->select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            case 4:
                $comments = Eventcomment::where('approved', 0)->select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            case 5:
                $comments = Horocomment::where('approved', 0)->select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            default:
                return ['error'=>'Ошибка получения коментария'];
        }
    }
    public function getOne($id, $source)
    {
        switch ($source) {
            case 1:
                $comment = Comment::find($id);

                return $comment;
            case 2:
                $comment = Blogcomment::find($id);

                return $comment;
            case 3:
                $comment = Establishmentcomment::find($id);

                return $comment;
            case 4:
                $comment = Eventcomment::find($id);

                return $comment;
            default:
                return null;
        }

    }

    /**
     * @param $request
     * @return Status array
     */
    public function addComment($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:255',
            'comment_post_ID' => 'required|integer',
            'comment_source' => 'required|integer',
            'comment_parent' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $data = $request->except('_token');

        $data['parent_id'] = $data['comment_parent'];

        switch ($data['comment_source']) {
            case 1:
                if (!Article::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                $data['article_id'] = $data['comment_post_ID'];
                $model = new Comment();
                break;
            case 2:
                if (!Blog::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                $data['blog_id'] = $data['comment_post_ID'];
                $model = new Blogcomment();
                break;
            case 3:
                if (!Establishment::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                $data['establishment_id'] = $data['comment_post_ID'];
                $model = new Establishmentcomment();
                break;
            case 4:
                if (!Event::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                $data['event_id'] = $data['comment_post_ID'];
                $model = new Eventcomment();
                break;
            case 5:
                $model = new Horocomment();
                break;
            default:
                return ['error'=>'Ошибка получения коментария'];
        }
        if (empty($model)) {
            return ['error'=>'Ошибка получения коментария'];
        }
        $result = $model->fill($data)->save();

        if($result) {
            return ['status' => trans('admin.comment_added')];
        } else {
            return ['error'=>'Ошибка получения коментария'];
        }
    }

    public function updateComment($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:255',
            'comment_post_ID' => 'required|integer',
            'comment_source' => 'required|integer',
            'comment_parent' => 'required|integer',
            'confirmed' => 'boolean|nullable',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $data = $request->except('_token');

        $data['parent_id'] = $data['comment_parent'];
        $data['approved'] = $data['confirmed'];

        $id = (int)$id;
        switch ($data['comment_source']) {
            case 1:
                $model = Comment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $data['article_id'] = $data['comment_post_ID'];
                break;
            case 2:
                $model = Blogcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $data['blog_id'] = $data['comment_post_ID'];
                break;
            case 3:
                $model = Establishmentcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $data['establishment_id'] = $data['comment_post_ID'];
                break;
            case 4:
                $model = Eventcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $data['event_id'] = $data['comment_post_ID'];
                break;
            case 5:
                $model = Horocomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                break;
            default:
                return ['error'=>'Ошибка получения коментария'];
        }

        $result = $model->fill($data)->save();

        if ($result) {
            $result = ['status' => 'Коментарий обновлен'];
        }

        return $result;

    }

    public function delComment($request, $id)
    {
        $id = (int)$id;

        switch ($request->get('comment_source')) {
            case 1:
                $model = Comment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                break;
            case 2:
                $model = Blogcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                break;
            case 3:
                $model = Establishmentcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                break;
            case 4:
                $model = Eventcomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                break;
            case 5:
                $model = Horocomment::where('id', '=', $id)->first();

                if (!$model) {
                    return ['error'=>'Ошибка получения коментария'];
                }
                break;
            default:
                return ['error'=>'Ошибка получения коментария'];
        }

        try {
            $model->delete();
        } catch (Exception $e) {
            \Log::info('Ошибка удаления коментария: ', $e->getMessage());
        }

        return ['status' => 'Коментарий удален'];

    }
}