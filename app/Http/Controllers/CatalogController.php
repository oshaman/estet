<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\TmpPerson;

class CatalogController extends Controller
{
    protected $title;

    public function index ()
    {
        $this->title = 'Каталог';
        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * @param alias $doc
     * @return view
     */
    public function docs ($doc = false)
    {
        if ($doc) {
            $docs = new TmpPersonRepository(new TmpPerson);
            $profile = $docs->one($doc);
            if (!$profile) {
                abort(404);
            }
            $this->title = $profile->name . ' ' . $profile->lastname;
            return view('catalog.doc_profile')->with('profile', $profile);
        }
        $this->title = 'Врачи';
        $docs = new TmpPersonRepository(new TmpPerson);
        $profiles = $docs->get(['name', 'lastname', 'specialty', 'address', 'photo', 'job','alias'], false, true);
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
