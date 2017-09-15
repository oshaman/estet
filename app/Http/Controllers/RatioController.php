<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Docsratio;
use Fresh\Estet\Establishmentratio;
use Fresh\Estet\Repositories\DocratioRepository;
use Fresh\Estet\Repositories\EstablishmentratioRepository;
use Illuminate\Http\Request;
use Validator;

class RatioController extends Controller
{
    public function setRatio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_id' => 'integer|required',
            'source_id' => 'integer|required|between:1,5',
            'ratio' => 'integer|required|between:1,5',
        ]);
        if ($validator->fails()) {
            return \Response::json(['error' => $validator->errors()->all()]);
        }

        switch ($request->get('source_id')) {
            case 1:
                $est_rep = new EstablishmentratioRepository(new Establishmentratio());
                $result = $est_rep->setRatio($request);

                if (!empty(($result['establishment_id']))) {
                    $result[0] = $est_rep->getRatio($result['establishment_id'])[0];
                }
                break;
            case 2:
                $doc_rep = new DocratioRepository(new Docsratio());
                $result = $doc_rep->setRatio($request);

                if (!empty(($result['doc_id']))) {
                    $result[0] = $doc_rep->getRatio($result['doc_id'])[0];
                }


                if (true == $result) {
                    $result = $doc_rep->getRatio($result);
                } else {
                    $result = false;
                }
                break;
            default:
                $result = false;
        }
        return \Response::json(['success' => $result]);
    }
}
