<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Eventscategory;

class EventCategoriesRepository extends Repository {


    public function __construct(Eventscategory $cat) {
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

        $cat['name'] = $data['eventcat'];

        if (empty($data['alias'])) {
            $cat['alias'] = $this->transliterate($data['eventcat']);
        } else {
            $cat['alias'] = $this->transliterate($data['alias']);
        }
        if ($this->one($cat['alias'],FALSE)) {
            $request->merge(array('alias' => $cat['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

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
        if ($cat->name != $request->eventcat) {
            $cat->name = $request->eventcat;
        }
        if (empty($request->alias)) {
            $alias = $this->transliterate($request->eventcat);
            if ($alias != $cat->alias) {
//                dd($alias);
//                dd($this->one($alias));
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