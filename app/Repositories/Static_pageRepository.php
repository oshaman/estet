<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Static_page;
use Validator;
use Cache;

class Static_pageRepository extends Repository
{
    /**
     * construct
     */
    public function __construct(Static_page $rep)
    {
        $this->model = $rep;
    }

    /**
     * @param $request
     * @param $advertising
     * @return array
     */
    public function updateStatic_page($request, $static_page)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'title' => 'required|string',
            'seo_title' => 'string|nullable',
            'seo_keywords' => 'string|nullable',
            'seo_description' => 'string|nullable',
            'seo_text' => 'string|nullable',
            'og_image' => 'string|nullable',
            'og_title' => 'string|nullable',
            'og_description' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator];
        }
        $data = $request->except('_token');
        $static_page->title = $data['title'];
        $static_page->text = $data['text'];
        // SEO handle
        if (!empty($data['seo_title'] || !empty($data['seo_keywords']) || !empty($data['seo_description']) || !empty($data['seo_text'])
            || !empty($data['og_image']) || !empty($data['og_title']) || !empty($data['og_description']))) {
            $obj = new \stdClass;
            $obj->seo_title = $data['seo_title'] ?? '';
            $obj->seo_keywords = $data['seo_keywords'] ?? '';
            $obj->seo_description = $data['seo_description'] ?? '';
            $obj->seo_text = $data['seo_text'] ?? '';
            $obj->og_image = $data['og_image'] ?? '';
            $obj->og_title = $data['og_title'] ?? '';
            $obj->og_description = $data['og_description'] ?? '';
            $static_page->seo = json_encode($obj);
        } else {
            $static_page->seo = null;
        }

        try {
            $static_page->save();
        } catch (Exception $e) {
            \Log::info('Ошибка записи static_page: ', $e->getMessage());
            $error[] = ['static_page' => 'Ошибка записи страницы'];
            return $error;
        }

        return ['status' => trans('admin.material_updated')];
    }
}