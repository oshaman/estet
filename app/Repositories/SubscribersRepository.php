<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Carbon\Carbon;
use Cache;
use Fresh\Estet\Subscriber;
use Validator;

class SubscribersRepository extends Repository
{
    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function getAll()
    {
        Cache::forget('sub_patient');

        $article = new Article;

        $where = array(['own', 'patient'], ['approved', 1], ['created_at', '>', Carbon::yesterday()->toDateString()], ['created_at', '<', Carbon::now()->toDateString()] );
        $articles = $article->select('title')->where($where)->get();

        if ($articles->isNotEmpty()) {
            $patient = view('subscribers.patient')->with('articles', $articles)->render();
            Cache::forever('sub_patient', $patient);
        }


        Cache::forget('sub_doc');

        $where = array(['own', 'docs'], ['approved', 1], ['created_at', '>', Carbon::yesterday()->toDateString()], ['created_at', '<', Carbon::now()->toDateString()] );
        $articles = $article->select('title')->where($where)->get();
        if ($articles->isNotEmpty()) {
            $patient = view('subscribers.patient')->with('articles', $articles)->render();
            Cache::forever('sub_doc', $patient);
        }
        return true;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDocs()
    {
        return Subscriber::select('email')->where('source', 'doctor')->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPatients()
    {
        return Subscriber::select('email')->where('source', 'patient')->get();
    }

    public function addSubscriber($request)
    {
        Cache::flush();

        $messages = [
            'status.required' => 'Вы пациент или врач? Дайте нам больше информации!',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'status' => 'required|max:7|numeric',
        ], $messages);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }
        $data['email'] = $request->get('email');
        $status = $request->get('status');
        if (0 == $status) {
            $data['source'] = 'patient';
        } else {
            $data['source'] = 'doctor';
        }
        $subscriber = Subscriber::updateOrCreate($data);
        if(!empty($subscriber)) {
            return ['status' => trans('ru.subscribe')];
        }
        return ['error'=>'Ошибка добавления подписки, попробуйте повторить подписку позже.'];
    }
}