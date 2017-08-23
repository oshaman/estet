<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Fresh\Estet\Establishment;
use Validator;

class SearchRepository
{

    protected $article;
    protected $establishment;

    /**
     * SearchRepository constructor.
     * @param ArticlesRepository $article
     * @param CommentsRepository $comment
     * @param EstablishmentsRepository $establishment
     * @param CategoriesRepository $category
     */
    public function __construct(Article $article, Establishment $establishment)
    {
        $this->article = $article;
        $this->establishment = $establishment;
    }

    public function get($request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string|max:128',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $data = $request->all();
//dd($data);
        switch ($data['order']) {
            case 0:
                $order[0] = 'created_at';
                $order[1] = 'desc';
                break;
            case 1:
                $order[0] = 'created_at';
                $order[1] = 'asc';
                break;
            case 2:
                $order[0] = 'title';
                $order[1] = 'asc';
                break;
            case 3:
                $order[0] = 'view';
                $order[1] = 'asc';
                break;
            default:
                $order = 'false';
        }

        switch ($data['limit']) {
            case 0:
                $limit = 20;
                break;
            case 1:
                $limit = 50;
                break;
            case 2:
                $limit = 100;
                break;
            default:
                $limit = 20;
        }
        $builder = $this->article->select('title', 'id');

//        UNION
        /*SELECT title,alias,created_at,own AS article FROM articles WHERE title LIKE '%test%'
        UNION
        SELECT title,alias,created_at,('blog') FROM blogs WHERE title LIKE '%test%'
        UNION
        SELECT title,alias,created_at,category FROM establishments WHERE title LIKE '%Бренд%'*/
//        UNION

        $res = $this->sql($builder, $data['coincidence'], $data['value']);
        dd($res);

    }

    public function sql($builder, $coincidence, $value)
    {


        switch ($coincidence) {
            case 'all':
                $builder->where('title', 'like', '%'.$value.'%');
                $builder->orWhere('content', 'like', '%'.$value.'%');
                break;
            case 'any':
                $builder->whereRaw("MATCH(title, content)AGAINST(?)", $value);
                break;
            case 'exact':
                $builder->where('title', $value);
                $builder->orWhere('content', $value);
                break;
            default:
                $builder->where('title', 'like', '%'.$value.'%');
                $builder->orWhere('content', 'like', '%'.$value.'%');
        }
        return $builder->get();
    }


}