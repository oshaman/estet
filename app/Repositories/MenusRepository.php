<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Menu;

class MenusRepository extends Repository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function updateMenus($request)
    {
        $data = $request->except('_token');

        if (!empty($data['cats'])) {

            $this->model->where('own', 'patient')->delete();
            foreach ($data['cats'] as $cat) {
                $this->model->create(['category_id'=>$cat, 'own'=>'patient']);
            }
            return ['status' => 'Меню обновлено'];
        } elseif (!empty($data['docs_cats'])) {
            $this->model->where('own', 'docs')->delete();
            foreach ($data['docs_cats'] as $cat) {
                $this->model->create(['category_id'=>$cat, 'own'=>'docs']);
            }
            return ['status' => 'Меню обновлено'];
        } else {
            return ['error' => 'Нет данных'];
        }
    }
}