<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Tag;
use Gate;

class TagsRepository extends Repository {


    public function __construct(Tag $tag) {
        $this->model = $tag;
    }

    /**
     * Create new Tag
     * @param $request
     * @return bool
     */
    public function addTag($request)
    {
        $data = $request->except('_token');

        $tag['name'] = $data['tag'];

        if (empty($data['alias'])) {
            $tag['alias'] = $this->transliterate($data['tag']);
        } else {
            $tag['alias'] = $this->transliterate($data['alias']);
        }
        if ($this->one($tag['alias'],FALSE)) {
            $request->merge(array('alias' => $tag['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

        $res = $this->model->fill($tag)->save();

        return $res;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateTag($request, $tag)
    {
        if ($tag->name != $request->tag) {
            $tag->name = $request->tag;
        }

        if (empty($request->alias)) {
            $alias = $this->transliterate($request->tag);
            if ($alias != $tag->alias) {
                if ($this->one($alias)) {
                    $request->merge(array('alias' => $alias));
                    $request->flash();

                    return ['error' => trans('admin.alias_in_use')];
                }
                $tag->alias = $alias;
            }
        } else {
            $alias = $this->transliterate($request->alias);
            if ($alias != $tag->alias) {
                $tag->alias = $alias;
            }
        }

        $res = $tag->save();
        return $res;
    }

    public function deleteTag($tag)
    {
        if($tag->delete()) {
            return ['status' => trans('Тег удален')];
        }

    }
    /**
     *
     * @return tags array
     */
    public function tagSelect()
    {
        $tags = $this->model->select(['name', 'id'])->get();
        $lists = array();

        foreach($tags as $tag) {
            $lists[$tag->id] = $tag->name;
        }
        return $lists;
    }

}

?>