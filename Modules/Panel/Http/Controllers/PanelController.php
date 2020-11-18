<?php

namespace Modules\Panel\Http\Controllers;

use Modules\Panel\Entities\Panel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Platform\Core\Http\Controllers\AppBaseController;
use GuzzleHttp\Client;

class PanelController extends AppBaseController
{
    public $access_token = 'aAsdMCyPtsPvFiTQjraLBWpUck41mV4H1f0C1m2D';

    public function index()
    {
        return view('panel::index');
    }

    public function data()
    {
        $client = new Client(['base_uri' => 'http://192.168.44.127']);

        $headers = [
            'Authorization' => 'Bearer ' . $this->access_token,
            'Accept' => 'application/json'
        ];

        $response = $client->request('GET', '/xibo-cms/web/api/library?length=20', [
            'headers' => $headers
        ]);

        $contents = $response->getBody();
        $content = json_decode($contents, true);

        return $content;
    }

    public function main()
    {
        $panel = Panel::all();

        return $panel;
    }

    public function addmedia(Request $request)
    {
        $file = request('file');

        $fileName = $file->getClientOriginalName();
        $imagePath = $file->store('uploads', 'public');

        $imageName = explode("/", $imagePath);

        $client = new Client(['base_uri' => 'http://192.168.44.127']);

        $headers = [
            'Authorization' => 'Bearer ' . $this->access_token,
            'Accept' => 'application/json'
        ];

        $multipart = [
            [
                'name' => 'name',
                'contents' => $fileName
            ],
            [
                'name' => 'files',
                'contents' => fopen('C:/Users/thena/Desktop/laravel_bap/storage/app/public/' . $imagePath, 'r')
            ]
        ];

        $response = $client->request('POST', '/xibo-cms/web/api/library', [
            'headers' => $headers,
            'multipart' => $multipart
        ]);

        $contents = $response->getBody();
        $content = json_decode($contents, true);

        $form_data = array(
            'image_database_name' => $imageName[1],
            'image_name' => $fileName,
            'image_path' => $imagePath,
            'media_id' => '',
            'retired' => '',
            'size' => '',
            'type' => '',
            'duration' => '',
        );
        
        if ( !isset($content["files"][0]["error"])) {
            $panel = Panel::create($form_data);

            $panels = $panel->getAttributes();

            $panelmediaid = Panel::find($panels["id"]);

            if($panelmediaid) {
                $panelmediaid->media_id = $content["files"][0]["mediaId"];
                $panelmediaid->retired = $content["files"][0]["retired"];
                $panelmediaid->size = $content["files"][0]["size"];
                $panelmediaid->type = $content["files"][0]["type"];
                $panelmediaid->duration = $content["files"][0]["duration"];
                $panelmediaid->save();
            }
        }

        return $content;
    }
}
