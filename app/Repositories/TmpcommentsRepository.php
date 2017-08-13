<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Tmpcomment;
use Validator;
use Fresh\Estet\Article;
use Fresh\Estet\Establishment;
use Fresh\Estet\Blog;
use Fresh\Estet\Comment;
use Config;


class TmpcommentsRepository
{
    public function get($source)
    {
        switch ($source) {
            case 1:
                $comments = Tmpcomment::select(['name', 'email', 'id', 'text'])->orderBy('created_at', 'desc')->paginate(Config::get('settings.paginate_comments'));
                return $comments;
            case 2:
                return '2';
            case 3:
                return '3';
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
                return '2';
            case 3:
                return '3';
            default:
                return ['error'=>'Ошибка получения коментария'];
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

        $data['article_id'] = $data['comment_post_ID'];
        $data['parent_id'] = $data['comment_post_ID'];

        switch ($data['comment_source']) {
            case 1:
                if (!Article::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $model = new Tmpcomment();
                break;
            case 2:
                if (!Blog::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $model = new Tmpcomment();
                break;
            case 3:
                if (!Establishment::where('id', '=', $data['comment_post_ID'])->exists()) {
                    return ['error'=>'Ошибка получения коментария'];
                }

                $model = new Tmpcomment();
                break;
            default:
                return ['error'=>'Ошибка получения коментария'];
        }

        $result = $model->fill($data)->save();

        if($result) {
            return ['status' => trans('admin.comment_added')];
        } else {
            return ['error'=>'Ошибка получения коментария'];
        }
    }
}