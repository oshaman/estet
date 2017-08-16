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

        if (!empty($data['comments'])) {
            $comments = true;
        } else {
            $comments = false;
        }

        if (!empty($data['materials'])) {
            $materials = true;
        } else {
            $materials = false;
        }

        if (!empty($data['categories'])) {
            $categories = true;
        } else {
            $categories = false;
        }

        if (!empty($data['contacts'])) {
            $contacts = true;
        } else {
            $contacts = false;
        }

        if (!empty($data['rss'])) {
            $rss = true;
        } else {
            $rss = false;
        }

        if (!empty($data['links'])) {
            $links = true;
        } else {
            $links = false;
        }










        switch ($data['coincidence']) {
            case 'all':
                $coincidence = 20;
                break;
            case 'any':
                $limit = 50;
                break;
            case 'exact':
                $limit = 100;
                break;
            default:
                $limit = 20;
        }

    }
}