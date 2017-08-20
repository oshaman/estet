<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Carbon\Carbon;
use Cache;
use Fresh\Estet\Subscriber;

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

        $artilce = new Article;

        $where = array(['own', 'patient'], ['approved', 1], ['created_at', '>', Carbon::yesterday()->toDateString()], ['created_at', '<', Carbon::now()->toDateString()] );
        $articles = $artilce->select('title')->where($where)->get();
        if ($articles->isNotEmpty()) {
            $patient = view('subscribers.patient')->with('articles', $articles)->render();
            Cache::forever('sub_patient', $patient);
        }


        Cache::forget('sub_doc');

        $where = array(['own', 'docs'], ['approved', 1], ['created_at', '>', Carbon::yesterday()->toDateString()], ['created_at', '<', Carbon::now()->toDateString()] );
        $articles = $artilce->select('title')->where($where)->get();
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
}