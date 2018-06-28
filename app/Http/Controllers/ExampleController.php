<?php

namespace App\Http\Controllers;

use App\Helper\MicrosoftSpeechAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $AzureService = new MicrosoftSpeechAPI('nagranie4.wav');
        $AzureService->setLanguage('pl-PL');
        $AzureService->execute();
        $response = $AzureService->getResponse();
        return $response;
    }

    public function register(Request $request)
    {
        $tmp_name = $_FILES["file"]["tmp_name"];
        $name = md5(date('Y-m-d H:i:s')) . ".wav";
        move_uploaded_file($tmp_name, storage_path('app/' . $name));

        $AzureService = new MicrosoftSpeechAPI($name);
        $AzureService->setLanguage(Input::get('language'));
        $AzureService->execute();
        $response = $AzureService->getResponse();
        return $response;
    }

}
