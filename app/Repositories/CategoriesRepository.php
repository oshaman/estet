<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Category;
use Cache;

class CategoriesRepository extends Repository {


    public function __construct(Category $cat) {
        $this->model = $cat;
    }

    /**
     * Create new Category
     * @param $request
     * @return bool
     */
    public function addCat($request)
    {
        $data = $request->except('_token');

        $cat['name'] = $data['cat'];

        if (empty($data['alias'])) {
            $cat['alias'] = $this->transliterate($data['cat']);
        } else {
            $cat['alias'] = $this->transliterate($data['alias']);
        }
        if ($this->one($cat['alias'],FALSE)) {
            $request->merge(array('alias' => $cat['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }
        Cache::forget('allCats');
        $res = $this->model->fill($cat)->save();

        return $res;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateCat($request, $cat)
    {
        if ($cat->name != $request->cat) {
            $cat->name = $request->cat;
        }

        if (empty($request->alias)) {
            $alias = $this->transliterate($request->cat);
            if ($alias != $cat->alias) {
                if ($this->one($alias)) {
                    $request->merge(array('alias' => $alias));
                    $request->flash();

                    return ['error' => trans('admin.alias_in_use')];
                }
                $cat->alias = $alias;
            }
        } else {
            $alias = $this->transliterate($request->alias);
            if ($alias != $cat->alias) {
                $cat->alias = $alias;
            }
        }
        Cache::forget('patientMenu');
        Cache::forget('docsMenu');
        Cache::forget('catalogMenu');
        Cache::forget('allCats');

        $res = $cat->save();
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