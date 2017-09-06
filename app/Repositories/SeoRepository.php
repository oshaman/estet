<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Seo;
use Validator;

class SeoRepository extends Repository
{
    /**
     * construct
     */
    public function __construct(Seo $seo)
    {
        $this->model = $seo;
    }

    /**
     * @param $request
     * @param $seo
     * @return array
     */
    public function updateSeo($request, $seo)
    {
        $validator = Validator::make($request->all(), [
            'seo_title' => 'string|max:255|nullable',
            'seo_keywords' => 'string|max:255|nullable',
            'seo_description' => 'string|max:255|nullable',
            'og_image' => 'string|max:255|nullable',
            'og_title' => 'string|max:255|nullable',
            'og_description' => 'string|max:255|nullable',
            'seo_text' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        try {
            $seo->fill($request->except('_token'))->save();
        } catch (Exception $e) {
            \Log::info('Ошибка записи SEO: ', $e->getMessage());
            $error[] = ['SEO' => 'Ошибка записи тегов'];
            return $error;
        }
        $this->clearCache();
        return ['status' => trans('admin.material_updated')];
    }

    /**
     * @param $uri
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getSeo($uri)
    {
        return $this->model->select(['seo_title', 'seo_keywords', 'seo_description', 'seo_text', 'og_title', 'og_description', 'og_image'])->where('uri', $uri)->first();
    }

    public function clearCache()
    {
        Cache::forget('seo_horoscope');
        Cache::forget('seo_main');
    }
}