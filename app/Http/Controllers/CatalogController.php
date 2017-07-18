<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;

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
    public function docs (PersonsRepository $rep, $doc = false)
    {
        if ($doc) {
            $docs = new PersonsRepository(new Person);
            $profile = $docs->one($doc);
//            dd($profile);
            if (!$profile) {
                abort(404);
            }
            if (!empty($profile->expirience)) {
                $profile->expirience = date_create()->diff(date_create($profile->expirience))->y;
            }

            $this->title = $profile->name . ' ' . $profile->lastname;
            return view('catalog.doc_profile')->with('profile', $profile);
        }
        $this->title = 'Врачи';

        $profiles = $rep->get(['name', 'address', 'phone', 'site', 'alias', 'photo'], false, true, false, false, 'specialties');
//        dd($profiles);
//        $profiles->load('specialties');
//        $profiles = Person::with('specialties')->paginate(5)->get();

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
    public function salons ($salon = false)
    {
        $this->title = 'Салоны';
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
