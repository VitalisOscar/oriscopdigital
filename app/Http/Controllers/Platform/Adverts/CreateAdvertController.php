<?php

namespace App\Http\Controllers\Platform\Adverts;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Screen;
use App\Models\ScreenPackage;
use App\Rules\VideoDimension;
use App\Traits\CreatesAdverts;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreateAdvertController extends Controller {
    use CreatesAdverts;

    function __invoke(Request $request){

        $min_date = Carbon::now()->addDays(3)->format('Y-m-d');

        $prices = ScreenPackage::all();

        $all_screens = Screen::count();
        $all_packages = Package::count();

        if($request->isMethod('GET')){
            return $this->view('web.ads.create', [
                'min_date' => $min_date,
                'prices' => $prices,
                'screens' => Screen::all(),
                'packages' => Package::all(),
            ]);
        }

        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string', 'max:255'],
            'media' => ['required', 'file', 'mimetypes:image/png,image/jpg,image/jpeg,video/mp4'],
            'slots' => ['required', 'array'],
            'slots.*.screen_id' => ['required', 'exists:screens,id'],
            'slots.*.play_date' => ['required', 'array'],
            'slots.*.play_date.*' => ['date', 'date_format:Y-m-d', 'after_or_equal:'.$min_date],
            'slots.*.package' => ['required', 'exists:packages,id'],
        ];

        // if($request->file('media')){
        //     if(preg_match('/image/', $request->file('media')->getMimeType())){
        //         array_push($rules['media'], 'dimensions:width=1920,height=1080', 'max:10240k');
        //     }else if(preg_match('/video/', $request->file('media')->getMimeType())){
        //         array_push($rules['media'], new VideoDimension(1920, 1080), 'max:204800k');
        //     }
        // }

        $validator = validator($request->all(), $rules, [
            'category_id.exists' => 'Select a valid category',
            'category_id.required' => 'Select a valid category',
            'media.dimensions' => 'Video or image should have 1920x1080p dimensions',
            'media.required' => 'You need to select an image or video file to be aired',
            'media.mimetypes' => 'Only image (png,jpg,jpeg) and video (mp4) format files are supported',
            'slots.*.required' => 'You need to select at least one slot',
            'slots.*.screen_id.required' => 'Select a screen from provided screens',
            'slots.*.screen_id.exists' => 'Select a screen from provided screens',
            'slots.*.play_date.*.required' => 'Airing date is required for each slot',
            'slots.*.play_date.*.array' => 'Airing date is required for each slot',
            'slots.*.play_date.*.date' => 'Use a valid airing date',
            'slots.*.play_date.*.date_format' => 'Use a valid airing date',
            'slots.*.play_date.*.after_or_equal' => 'Airing date should be on or after '.$min_date,
            'slots.*.package.required' => 'Select a package for each slot',
            'slots.*.package.exists' => 'Select a package from the given options',
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors()->all());
        }

        $result = $this->createNew(
            $validator->validated(),
            $request->file('media'),
            $this->user()
        );

        if(is_bool($result) && $result){
            return $this->json->success();
        }

        return $this->json->error($result);
    }
}
