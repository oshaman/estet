<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\BlogsRepository;
use DB;

class CatalogController extends Controller
{
    protected $title;

    public function index ()
    {
        $this->title = 'Каталог';
        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * View Doctor's Profile
     * @param alias $doc
     * @return view
     */
    public function docs (PersonsRepository $rep, BlogsRepository $blog_rep, $doc = false)
    {
        if ($doc) {
            $docs = new PersonsRepository(new Person);
            $profile = $docs->one($doc);

            if (!empty($profile->services)) {
                $profile->services = json_decode($profile->services);
            }
            if (!$profile) {
                abort(404);
            }
            if (!empty($profile->expirience)) {
                $profile->expirience = date_create()->diff(date_create($profile->expirience))->y;
            }

            //  Blogs preview
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['user_id', $profile->user_id]);
            $blogs = $blog_rep->get(['alias', 'title', 'created_at'], 3, false, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);

            $this->title = $profile->name . ' ' . $profile->lastname;
            return view('catalog.doc_profile')->with(['profile' => $profile, 'blogs' => $blogs]);
        }
        $this->title = 'Врачи';

        $profiles = $rep->get(['name', 'address', 'phone', 'site', 'alias', 'photo'], false, true, false, false, 'specialties');

        return view('catalog.index')->with(['title' => $this->title, 'profiles' => $profiles]);
    }

    /**
     * @param alias $clinic
     * @return view
     */
    public function clinics ($clinic = false)
    {
        $this->title = 'Клиники';
        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * @param alias $salon
     * @return view
     */
    public function distributors ($distributor = false)
    {
        $this->title = 'Дистрибьюторы';
        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * @param alias $brand
     * @return $this
     */
    public function brands ($brand = false)
    {
        $this->title = 'Бренды';
        return view('catalog.index')->with('title', $this->title);
    }

}
