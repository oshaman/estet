<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Premium;
use Validator;
use Cache;

class PremiumsRepository
{
    /**
     * @param $category
     * @return Premium Collection $result
     */
    public function getPrem($category)
    {
        switch ($category) {
            case 'clinic':
                $result = Premium::where('category', 'clinic')->get();
                return $result;
            case 'distributor':
                $result = Premium::where('category', 'distributor')->get();
                return $result;
            case 'brand':
                $result = Premium::where('category', 'brand')->get();
                return $result;
            case 'event':
                $result = Premium::where('category', 'event')->get();
                return $result;
            default:
                return null;
        }
    }

    public function getPremIds($category)
    {
        switch ($category) {
            case 'clinic':
                $result = Premium::where('category', 'clinic')->select('prem_id')->get();
                break;
            case 'distributor':
                $result = Premium::where('category', 'distributor')->select('prem_id')->get();
                break;
            case 'brand':
                $result = Premium::where('category', 'brand')->select('prem_id')->get();
                break;
            case 'event':
                $result = Premium::where('category', 'event')->select('prem_id')->get();
                break;
            default:
                return null;
        }
        $result = $result->toArray();

        $ids = array_flatten($result);

        if (empty($ids[0])) {
            array_forget($ids, 0);
        } elseif (null == $ids[1]) {
            array_forget($ids, 1);
        }

        return $ids;
    }

    /**
     * @param $request
     * @return Status array
     */
    public function updatePrem($request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'prem1' => 'integer|nullable|min:1',
            'prem2' => 'integer|nullable|min:1',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $data = $request->except('_token');

        switch ($data['category']) {
            case 'clinic':
                try {
                    Premium::where('name', 'prem1')->where('category', 'clinic')->update(['prem_id' => $data['prem1']]);
                    Premium::where('name', 'prem2')->where('category', 'clinic')->update(['prem_id' => $data['prem2']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления премиум: ', $e->getMessage());
                }
                break;
            case 'distributor':
                try {
                    Premium::where('name', 'prem1')->where('category', 'distributor')->update(['prem_id' => $data['prem1']]);
                    Premium::where('name', 'prem2')->where('category', 'distributor')->update(['prem_id' => $data['prem2']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления премиум: ', $e->getMessage());
                }
                break;
            case 'brand':
                try {
                    Premium::where('name', 'prem1')->where('category', 'brand')->update(['prem_id' => $data['prem1']]);
                    Premium::where('name', 'prem2')->where('category', 'brand')->update(['prem_id' => $data['prem2']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления премиум: ', $e->getMessage());
                }
                break;
            case 'event':
                try {
                    Premium::where('name', 'prem1')->where('category', 'event')->update(['prem_id' => $data['prem1']]);
                    Premium::where('name', 'prem2')->where('category', 'event')->update(['prem_id' => $data['prem2']]);
                } catch (Exception $e) {
                    \Log::info('Ошибка обновления премиум: ', $e->getMessage());
                }
                break;
            default:
                return ['error'=>'Ошибка записи'];
        }
        Cache::forget('prems');
        Cache::forget('event_prem');

        return ['status' => 'Записи обновлены'];
    }
}