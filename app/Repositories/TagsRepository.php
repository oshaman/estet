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
        $data['name'] = $request->only('tag')['tag'];
        $res = $this->model->fill($data)->save();

        return $res;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateTag($request, $id)
    {
        $model = $this->findById($id);
        $model->name = $request->tag;

        $res = $model->save();
        return $res;
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