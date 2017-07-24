<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\BlogCategory;
use Gate;

class BlogCategoriesRepository extends Repository {


    public function __construct(BlogCategory $cat) {
        $this->model = $cat;
    }

    /**
     * Create new Category
     * @param $request
     * @return bool
     */
    public function addCat($request)
    {
        $data['name'] = $request->only('cat')['cat'];
        $res = $this->model->fill($data)->save();

        return $res;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateCat($request, $id)
    {
        $model = $this->findById($id);
        $model->name = $request->cat;

        $res = $model->save();
        return $res;
    }

    public function catSelect()
    {
        $cats = $this->model->select(['name', 'id'])->get();
        $lists = array();

        foreach($cats as $category) {
            $lists[$category->id] = $category->name;
        }
        return $lists;
    }

}

?>