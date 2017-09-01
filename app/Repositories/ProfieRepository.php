<?php

namespace Fresh\Estet\Repositories;


use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Specialty;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProfieRepository
{

    protected $tmp_rep;
    protected $person_rep;

    public function __construct(TmpPersonRepository $tmp_rep, PersonsRepository $pers)
    {
        $this->tmp_rep = $tmp_rep;
        $this->person_rep = $pers;
    }

    /**
     * @param $id
     * @param $exp - convert expirience
     * @return obj Profile
     */
    public function getProfile($user, $exp=null)
    {
        $tmp = $this->tmp_rep->findByUserId($user->id);
        $person = $this->person_rep->findByUserId($user->id);

        $profile = new \stdClass();

        if ((null == $tmp) && (null != $person)) {
            $profile->approved = 1;
        }

        if (!empty($tmp->name)) {
            $profile->name = $tmp->name;
        } elseif (!empty($person->name)) {
            $profile->name = $person->name;
        }
        if (!empty($tmp->user_id)) {
            $profile->user_id = $tmp->user_id;
        } elseif (!empty($person->user_id)) {
            $profile->user_id = $person->user_id;
        }
        if (!empty($tmp->lastname)) {
            $profile->lastname = $tmp->lastname;
        } elseif (!empty($person->lastname)) {
            $profile->lastname = $person->lastname;
        }
        if (!empty($tmp->phone)) {
            $profile->phone = $tmp->phone;
        } elseif (!empty($person->phone)) {
            $profile->phone = $person->phone;
        }
        if (!empty($tmp->category)) {
            $profile->category = $tmp->category;
        } elseif (!empty($person->category)) {
            $profile->category = $person->category;
        }
        if (!empty($tmp->job)) {
            $profile->job = $tmp->job;
        } elseif (!empty($person->job)) {
            $profile->job = $person->job;
        }
        if (!empty($tmp->address)) {
            $profile->address = $tmp->address;
        } elseif (!empty($person->address)) {
            $profile->address = $person->address;
        }
        if (!empty($tmp->shedule)) {
            $profile->shedule = $tmp->shedule;
        } elseif (!empty($person->shedule)) {
            $profile->shedule = $person->shedule;
        }
        if (!empty($tmp->site)) {
            $profile->site = $tmp->site;
        } elseif (!empty($person->site)) {
            $profile->site = $person->site;
        }
        if (!empty($tmp->content)) {
            $profile->content = $tmp->content;
        } elseif (!empty($person->content)) {
            $profile->content = $person->content;
        }
        if (!empty($tmp->photo)) {
            $profile->photo = $tmp->photo;
        } elseif (!empty($person->photo)) {
            $profile->photo = $person->photo;
        }
        if (!empty($tmp->services)) {
            $profile->services = json_decode($tmp->services);
        } elseif (!empty($person->services)) {
            $profile->services = json_decode($person->services);
        }

        if (!empty($tmp->expirience)) {
            if ($exp) {
                $profile->month = (int)date('m', strtotime($tmp->expirience));
                $profile->year = (int)date('Y', strtotime($tmp->expirience));
            } else {
                $profile->expirience = date_create()->diff(date_create($tmp->expirience))->y;
            }
        } elseif (!empty($person->expirience)) {
            if ($exp) {
                $profile->month = (int)date('m', strtotime($person->expirience));
                $profile->year = (int)date('Y', strtotime($person->expirience));
            } else {
                $profile->expirience = date_create()->diff(date_create($person->expirience))->y;
            }
        }
        if (!empty($tmp->specialty)) {
            $profile->specialty = $tmp->specialty;
        } elseif (!empty($person)) {
            $profile->specialty = $person->specialties->implode('name', ', ');
        }
        if (!empty($tmp->alias)) {
                $profile->alias = $tmp->alias;
            } elseif (!empty($person)) {
                $profile->alias = $person->alias;
            }

        if ($tmp) {
            $profile->email = $user->email;
        } elseif ($person) {
            $profile->email = $user->email;
        }

        return $profile;
    }

    public function updateProfile($request)
    {
        if ($request->request->has('month') && $request->request->has('year')) {
            $month = $request->request->get('month');
            $year = $request->request->get('year');
            if (($month < 1 || $month > 12) || (($year < 1970 || $month > 2020))) {
                $result['error'] = 'Ошибка в поле Дата';
                return $result;
            }
            $exp = date("Y-m-d H:i:s", strtotime($year . '-' . str_pad((int)$month, 2, 0, STR_PAD_LEFT) . '-01'));

            $request->request->add(['expirience'=>$exp]);
        }

        $result = $this->tmp_rep->update($request);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getSpecialties()
    {
        $spec = Specialty::all()->reduce(function ($returnSpec, $spec) {
            $returnSpec[$spec->id] = $spec->name;
            return $returnSpec;
        }, []);
        return $spec;
    }

    public function isAuthor($user)
    {
        return $user->hasRole('author');
    }

    public function croppPhoto($request)
    {

        $validator = Validator::make($request->all(), [
            'img' => 'mimes:jpg,bmp,png,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->all()];
        }

        $cropped_value = $request->input("cropped_value"); //// Width,height,x,y,rotate for cropping
        $cp_v = explode(",", $cropped_value); /// Explode width,height,x etc
        $file_name = Auth::user()->id . 'jpg';
        if ($request->hasFile('img')) {
            $img = Image::make($request->file('img'));
            $path = public_path("/estet/img/tmp_tmp_profile/$file_name"); ///  Cropped Image Path
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3])
                ->save($path); // Crop and Save
            return ['img' => base64_encode(file_get_contents($path))];
        }
    }
}