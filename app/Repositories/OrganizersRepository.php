<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Organizer;

class OrganizersRepository extends Repository {


    public function __construct(Organizer $rep) {
        $this->model = $rep;
    }

    /**
     * Create new organizer
     * @param $request
     * @return bool
     */
    public function addOrganizer($request)
    {
        $data = $request->except('_token');

        $organizer['name'] = $data['organizer'];

        if (empty($data['alias'])) {
            $organizer['alias'] = $this->transliterate($data['organizer']);
        } else {
            $organizer['alias'] = $this->transliterate($data['alias']);
        }
        if ($this->one($organizer['alias'],FALSE)) {
            $request->merge(array('alias' => $organizer['alias']));
            $request->flash();

            return ['error' => trans('admin.alias_in_use')];
        }

        if (!empty($data['parent'])) {
            $organizer['parent'] = $data['parent'];
        }

        $res = $this->model->fill($organizer)->save();

        return $res;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateOrganizer($request, $organizer)
    {
        if ($organizer->name != $request->organizer) {
            $organizer->name = $request->organizer;
        }

        if (empty($request->alias)) {
            $alias = $this->transliterate($request->organizer);
            if ($alias != $organizer->alias) {
                if ($this->one($alias)) {
                    $request->merge(array('alias' => $alias));
                    $request->flash();

                    return ['error' => trans('admin.alias_in_use')];
                }
                $organizer->alias = $alias;
            }
        } else {
            $alias = $this->transliterate($request->alias);
            if ($alias != $organizer->alias) {
                $organizer->alias = $alias;
            }
        }
        $organizer['parent'] = $request->parent ? : null;

        $res = $organizer->save();
        return $res;
    }

    public function organizerSelect()
    {
        $organizers = $this->model->select(['name', 'id'])->get();
        $lists = array();
        foreach($organizers as $organizer) {
            $lists[$organizer->id] = $organizer->name;
        }
        return $lists;
    }

}

?>