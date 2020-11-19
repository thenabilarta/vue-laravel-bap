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
    public $access_token = 'DobDJnDkHg8Wheh8mQtM2aNfUYBVrDnWiXPpZpFG';

    public function index()
    {
        return view('panel::index');
    }

    public function data()
    {
        $client = new Client(['base_uri' => 'http://192.168.1.5']);

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

        $client = new Client(['base_uri' => 'http://192.168.1.5']);

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
                'contents' => fopen('C:/Users/thena/Desktop/vue-laravel-bap/storage/app/public/' . $imagePath, 'r')
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

        if (!isset($content["files"][0]["error"])) {
            $panel = Panel::create($form_data);

            $panels = $panel->getAttributes();

            $panelmediaid = Panel::find($panels["id"]);

            if ($panelmediaid) {
                $panelmediaid->media_id = $content["files"][0]["mediaId"];
                $panelmediaid->retired = $content["files"][0]["retired"];
                $panelmediaid->size = $content["files"][0]["size"];
                $panelmediaid->type = $content["files"][0]["type"];
                $panelmediaid->duration = $content["files"][0]["duration"];
                $panelmediaid->save();
            }
        }

        // $fileName = $file->getClientOriginalName();
        // $imagePath = $file->store('uploads', 'public');

        // $imageName = explode("/", $imagePath);

        // $client = new Client(['base_uri' => 'http://192.168.1.5']);

        // $headers = [
        //     'Authorization' => 'Bearer ' . $this->access_token,
        //     'Accept' => 'application/json'
        // ];

        // $multipart = [
        //     [
        //         'name' => 'name',
        //         'contents' => $fileName
        //     ],
        //     [
        //         'name' => 'files',
        //         'contents' => fopen('C:/Users/thena/Desktop/laravel_bap/storage/app/public/' . $imagePath, 'r')
        //     ]
        // ];

        // $response = $client->request('POST', '/xibo-cms/web/api/library', [
        //     'headers' => $headers,
        //     'multipart' => $multipart
        // ]);

        // $contents = $response->getBody();
        // $content = json_decode($contents, true);

        // $form_data = array(
        //     'image_database_name' => $imageName[1],
        //     'image_name' => $fileName,
        //     'image_path' => $imagePath,
        //     'media_id' => '',
        //     'retired' => '',
        //     'size' => '',
        //     'type' => '',
        //     'duration' => '',
        // );

        // if ( !isset($content["files"][0]["error"])) {
        //     $panel = Panel::create($form_data);

        //     $panels = $panel->getAttributes();

        //     $panelmediaid = Panel::find($panels["id"]);

        //     if($panelmediaid) {
        //         $panelmediaid->media_id = $content["files"][0]["mediaId"];
        //         $panelmediaid->retired = $content["files"][0]["retired"];
        //         $panelmediaid->size = $content["files"][0]["size"];
        //         $panelmediaid->type = $content["files"][0]["type"];
        //         $panelmediaid->duration = $content["files"][0]["duration"];
        //         $panelmediaid->save();
        //     }
        // }

        // foreach ($files as $file) {
        //     $fileName = $file->getClientOriginalName();
        //     $imagePath = $file->store('uploads', 'public');

        //     $imageName = explode("/", $imagePath);

        //     $client = new Client(['base_uri' => 'http://192.168.1.5']);

        //     $headers = [
        //         'Authorization' => 'Bearer ' . $this->access_token,
        //         'Accept' => 'application/json'
        //     ];

        //     $multipart = [
        //         [
        //             'name' => 'name',
        //             'contents' => $fileName
        //         ],
        //         [
        //             'name' => 'files',
        //             'contents' => fopen('C:/Users/thena/Desktop/laravel_bap/storage/app/public/' . $imagePath, 'r')
        //         ]
        //     ];

        //     $response = $client->request('POST', '/xibo-cms/web/api/library', [
        //         'headers' => $headers,
        //         'multipart' => $multipart
        //     ]);

        //     $contents = $response->getBody();
        //     $content = json_decode($contents, true);

        //     $form_data = array(
        //         'image_database_name' => $imageName[1],
        //         'image_name' => $fileName,
        //         'image_path' => $imagePath,
        //         'media_id' => '',
        //         'retired' => '',
        //         'size' => '',
        //         'type' => '',
        //         'duration' => '',
        //     );

        //     if ( !isset($content["files"][0]["error"])) {
        //         $panel = Panel::create($form_data);

        //         $panels = $panel->getAttributes();

        //         $panelmediaid = Panel::find($panels["id"]);

        //         if($panelmediaid) {
        //             $panelmediaid->media_id = $content["files"][0]["mediaId"];
        //             $panelmediaid->retired = $content["files"][0]["retired"];
        //             $panelmediaid->size = $content["files"][0]["size"];
        //             $panelmediaid->type = $content["files"][0]["type"];
        //             $panelmediaid->duration = $content["files"][0]["duration"];
        //             $panelmediaid->save();
        //         }
        //     }
        // }

        // $files = $request->file('file');

        // if($request->hasFile('file'))
        // {
        //     foreach ($files as $file) {
        //         $fileName = $file->getClientOriginalName();
        //         $imagePath = $file->store('uploads', 'public');

        //         $imageName = explode("/", $imagePath);

        //         $client = new Client(['base_uri' => 'http://192.168.1.5']);

        //         $headers = [
        //             'Authorization' => 'Bearer ' . $this->access_token,
        //             'Accept' => 'application/json'
        //         ];

        //         $multipart = [
        //             [
        //                 'name' => 'name',
        //                 'contents' => $fileName
        //             ],
        //             [
        //                 'name' => 'files',
        //                 'contents' => fopen('C:/Users/thena/Desktop/laravel_bap/storage/app/public/' . $imagePath, 'r')
        //             ]
        //         ];

        //         $response = $client->request('POST', '/xibo-cms/web/api/library', [
        //             'headers' => $headers,
        //             'multipart' => $multipart
        //         ]);

        //         $contents = $response->getBody();
        //         $content = json_decode($contents, true);

        //         $form_data = array(
        //             'image_database_name' => $imageName[1],
        //             'image_name' => $fileName,
        //             'image_path' => $imagePath,
        //             'media_id' => '',
        //             'retired' => '',
        //             'size' => '',
        //             'type' => '',
        //             'duration' => '',
        //         );

        //         if ( !isset($content["files"][0]["error"])) {
        //             $panel = Panel::create($form_data);

        //             $panels = $panel->getAttributes();

        //             $panelmediaid = Panel::find($panels["id"]);

        //             if($panelmediaid) {
        //                 $panelmediaid->media_id = $content["files"][0]["mediaId"];
        //                 $panelmediaid->retired = $content["files"][0]["retired"];
        //                 $panelmediaid->size = $content["files"][0]["size"];
        //                 $panelmediaid->type = $content["files"][0]["type"];
        //                 $panelmediaid->duration = $content["files"][0]["duration"];
        //                 $panelmediaid->save();
        //             }
        //         }
        //     }
        // }

        // return response()->json(["status" => "ok"]);
    }

    public function edit($id)
    {
        $panel = Panel::where('media_id', $id)->firstOrFail();

        return $panel;
    }

    public function editstore(Request $request)
    {
        $newfilename = $request->name;

        $media_id = $request->media_id["image_name"];

        $media_id_real = $request->media_id["media_id"];

        $media_type = explode('.', $media_id);

        $media_type_real = $media_type[1];

        // Make sure you've got the model
        // if($xiboimagename) {
        //     $xiboimagename->image_name = $request->image_name . '.' . $request->image_type;
        //     $xiboimagename->save();
        // }

        $client = new Client(['base_uri' => 'http://192.168.1.5']);

        $headers = [
            'Authorization' => 'Bearer ' . $this->access_token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $formparams = [
            'name' => $newfilename . '.' . $media_type_real,
            'duration' => '10',
            'retired' => '0',
            'tags' => '0',
            'updateInLayouts' => '0'
        ];

        $response = $client->request('PUT', '/xibo-cms/web/api/library/' . $media_id_real, [
            'headers' => $headers,
            'form_params' => $formparams
        ]);

        $status = $response->getStatusCode();

        if ($status === 200) {
            $panelimagename = Panel::where('media_id', $media_id_real)->firstOrFail();

            if ($panelimagename) {
                $panelimagename->image_name = $newfilename . '.' . $media_type_real;
                $panelimagename->save();
            }
        }

        return response()->json(["status" => "ok"]);
    }

    public function delete($id)
    {
        $panel = Panel::where('media_id', $id)->firstOrFail();

        // return response()->json(['name' => 'Abigail', 'state' => 'CA']);

        $client = new Client();

        $url = 'http://192.168.1.5/xibo-cms/web/api/library/' . $panel->media_id;

        $response = $client->delete($url, [
            'headers'  => [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Accept' => 'application/json'
            ]
        ]);

        if ($response->getStatusCode() === 204) {
            $panel->delete();
        }

        return response()->json(["status" => "ok"]);
    }
}