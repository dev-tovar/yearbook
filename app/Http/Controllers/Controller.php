<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\FractalFacade as Fractal;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function transform($data, $transformerName)
    {
        if (!($transformerName instanceof TransformerAbstract)) {
            $transformer = new $transformerName;
        } else {
            $transformer = $transformerName;
        }


        return response()->json(Fractal::create($data, $transformer));
    }
}
