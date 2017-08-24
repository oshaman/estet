<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Fresh\Estet\Establishment;
use Validator;
use Fresh\Estet\Blog;
use DB;
use Fresh\Estet\Search;

class SearchRepository
{

    protected $article;
    protected $establishment;
    protected $blog;
    protected $search;

    /**
     * SearchRepository constructor.
     * @param ArticlesRepository $article
     * @param CommentsRepository $comment
     * @param EstablishmentsRepository $establishment
     * @param CategoriesRepository $category
     */
    public function __construct(Article $article, Establishment $establishment, Blog $blog, Search $search)
    {
        $this->article = $article;
        $this->establishment = $establishment;
        $this->blog = $blog;
        $this->search = $search;
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

        $data['value'] = $this->verifyVal($data['value']);
//        dd(empty($data['value']));
        if (empty($data['value'])) {
            return false;
        }
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


//        $result = $this->search->where('created_at', '<', DB::raw('NOW()'))->orderBy('view', 'desc')->paginate(7);
        
//        $result = $this->search->where('title', 'like', '%'.$value.'%')->orderBy('view', 'desc')->paginate(7);
//        $result = $this->search->where('content', 'like', '%'.$value.'%')->orderBy('view', 'desc')->paginate(7);

        $result = $this->search->where('content', 'like', '%'.$value.'%')->orderBy('view', 'desc')->paginate(7);
dd($result);


        if (!empty($data['doctor']) && !empty($data['patient'])) {
            $builder = $this->article->select('title', 'alias', 'created_at', 'view as view', 'own as status');
            $builder->where('approved', 1);
            $builder = $this->sql($builder, $data['coincidence'], $data['value']);

            if (!empty($data['blog'])) {
                $builder->union($this->blog($data['coincidence'], $data['value']));
            }

            if (!empty($data['catalog'])) {
                $builder->union($this->establishment($data['coincidence'], $data['value']));
            }
        } elseif (!empty($data['doctor']) && empty($data['patient'])) {
            $builder = $this->article->select('title', 'alias', 'created_at', 'view', 'own as status');
            $builder->where([['own', 'doctor'], ['approved', 1]]);
            $builder = $this->sql($builder, $data['coincidence'], $data['value']);

            if (!empty($data['blog'])) {
                $builder->union($this->blog($data['coincidence'], $data['value']));
            }

            if (!empty($data['catalog'])) {
                $builder->union($this->establishment($data['coincidence'], $data['value']));
            }
        } elseif (empty($data['doctor']) && !empty($data['patient'])) {
            $builder = $this->article->select('title', 'alias', 'created_at', 'view', 'own as status');
            $builder->where([['own', 'patient'], ['approved', 1]]);
            $builder = $this->sql($builder, $data['coincidence'], $data['value']);

            if (!empty($data['blog'])) {
                $builder->union($this->blog($data['coincidence'], $data['value']));
            }

            if (!empty($data['catalog'])) {
                $builder->union($this->establishment($data['coincidence'], $data['value']));
            }
        } else {
            if (!empty($data['catalog'])) {
                $builder = $this->establishment($data['coincidence'], $data['value']);
                if (!empty($data['blog'])) {
                    $builder->union($this->blog($data['coincidence'], $data['value']));
                }
            } elseif (!empty($data['blog'])) {
                $builder = $this->blog($data['coincidence'], $data['value']);
            } else {
                $builder = $this->article->select('title', 'alias', 'created_at', 'view', 'own as status');
                $builder->where('approved', 1);
                $builder = $this->sql($builder, $data['coincidence'], $data['value']);
            }
        }

        if ($order) {
            $builder->orderBy($order[0], $order[1]);
        }

        $res = $builder->paginate($limit);



        dd($res);

    }

    /**
     * @param $coincidence
     * @param $value
     * @return $this|mixed
     */
    public function blog($coincidence, $value)
    {
        $blog = $this->blog->select('title', 'alias', 'created_at', 'view', DB::raw("('blog')"));
        $blog->where('approved', 1);
        $blog = $this->sql($blog, $coincidence, $value);
        return $blog;
    }

    /**
     * @param $coincidence
     * @param $value
     * @return $this|mixed
     */
    public function establishment($coincidence, $value)
    {
        $establishment = $this->establishment->select('title', 'alias', 'created_at', DB::raw("'1' as 'view'"), 'category as status');
        $establishment = $this->sql($establishment, $coincidence, $value);
        return $establishment;
    }

    /**
     * @param $builder
     * @param $coincidence
     * @param $value
     * @return mixed
     */
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
        return $builder;
    }

    public function verifyVal($val)
    {
        $val = preg_replace('/[^а-яА-ЯёЁ\w\s\-;:\.,\(\)]/', ' ', $val);
        $val = preg_replace('/\b(\S{1,2})\b/', ' ', $val);
        return trim(preg_replace('/\s\s+/', ' ', $val));
    }
}
