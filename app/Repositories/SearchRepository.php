<?php
namespace Fresh\Estet\Repositories;

use Validator;

class SearchRepository
{

    protected $a_rep;
    protected $comm_rep;
    protected $est_rep;
    protected $cat_rep;

    /**
     * SearchRepository constructor.
     * @param ArticlesRepository $article
     * @param CommentsRepository $comment
     * @param EstablishmentsRepository $establishment
     * @param CategoriesRepository $category
     */
    public function __construct(ArticlesRepository $article, CommentsRepository $comment,
                                EstablishmentsRepository $establishment, CategoriesRepository $category)
    {
        $this->a_rep = $article;
        $this->comm_rep = $comment;
        $this->est_rep = $establishment;
        $this->cat_rep = $category;
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
dd($data);
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
                $order = 'false';
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
            case 3:
                $order[0] = 'view';
                $order[1] = 'asc';
                break;
            default:
                $limit = 20;
        }












        switch ($data['coincidence']) {
            case 'all':
                $coincidence = 20;
                break;
            case 'any':
                $coincidence = 50;
                break;
            case 'exact':
                $coincidence = 100;
                break;
            default:
                $coincidence = 20;
        }

    }
}