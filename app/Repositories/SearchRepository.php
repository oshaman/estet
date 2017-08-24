<?php
namespace Fresh\Estet\Repositories;

use Validator;
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
     * @param Search $search
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string|max:128',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $data = $request->all();

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
                $order[1] = 'desc';
                break;
            default:
                $order = 'false';
        }

        switch ($data['limit']) {
            case 0:
                $limit = 2;
                break;
            case 1:
                $limit = 5;
                break;
            case 2:
                $limit = 10;
                break;
            default:
                $limit = 2;
        }

        $status = [];
        if (!empty($data['doctor'])) {
            $status[] = 'docs';
        }
        if (!empty($data['patient'])) {
            $status[] = 'patient';
        }
        if (!empty($data['blog'])) {
            $status[] = 'blog';
        }
        if (!empty($data['catalog'])) {
            $status[] = 'clinic';
            $status[] = 'distributor';
            $status[] = 'brand';
        }
        if (empty($data['doctor']) && empty($data['patient']) && empty($data['blog']) && empty($data['catalog'])) {
            $status[] = 'docs';
            $status[] = 'patient';
        }

        $builder = $this->search->select('title', 'status', 'created_at', 'alias', 'view');
        $builder = $builder->where(function ($q) use ($status) { $q->whereIn('status', $status); });
        $coincidence = $data['coincidence'];
        $val = $data['value'];
        $builder = $builder->where(function ($q) use ($coincidence, $val) {
            $q = $this->sql($q, $coincidence, $val);
            return $q;
        });

        if ($order) {
            $builder->orderBy($order[0], $order[1]);
        }

        return $this->check($builder->paginate($limit));

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
                $value = $this->verifyVal($value);
                $values = explode(' ', $value);
                foreach ($values as $val) {
                    $builder->orWhere('title', 'like', '%'.$val.'%');
                    $builder->orWhere('content', 'like', '%'.$val.'%');
                }
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

    /**
     * @param $val
     * @return string
     */
    public function verifyVal($val)
    {
        $val = preg_replace('/[^а-яА-ЯёЁ\w\s\-;:\.,\(\)]/u', ' ', $val);
        $val = preg_replace('/\b([а-яА-ЯёЁ\w\s\-;:\.,\(\)]{1,2})\b/u', ' ', $val);
        return trim(preg_replace('/\s\s+/', ' ', $val));
    }

    protected function check($result)
    {

        if($result->isEmpty()) {
            return FALSE;
        }

        $result->transform(function($item) {

            if (!empty($item->created_at)) {
                $created = strtotime($item->created_at);
                $item->created = date('d', $created) . ' ' . trans('ru.' . date('m', $created)) . ' ' . date('Y', $created);
            } else {
                $item->created = date('d') . ' ' . trans('ru.' . date('m')) . ' ' . date('Y');
            }

            if (!empty($item->status)) {
                switch ($item->status) {
                    case 'docs':
                        $item->path = route('doctors').'/'. $item->alias;
                        break;
                    case 'patient':
                        $item->path = route('articles').'/'. $item->alias;
                        break;
                    case 'blog':
                        $item->path = route('blogs').'/'. $item->alias;
                        break;
                    case 'distributor':
                        $item->path = route('distributors').'/'. $item->alias;
                        break;
                    case 'brand':
                        $item->path = route('brands').'/'. $item->alias;
                        break;
                    case 'clinic':
                        $item->path = route('clinics').'/'. $item->alias;
                        break;
                }
            }

            return $item;

        });

        return $result;

    }
}
