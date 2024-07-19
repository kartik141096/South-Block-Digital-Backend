<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Category_Slave;
use App\Models\News;
use App\Models\News_Slave;
use App\Models\News_Tags;

class WebAPI extends Controller
{
    // Weather APIs ======================================================================================================================================================
    public function get_weather()
    {   
        if($_SERVER['REMOTE_ADDR'] == "127.0.0.1")
            $q = "New Delhi";
        else{
            $q = $_SERVER['REMOTE_ADDR'];
        }

        $response = Http::get('http://api.weatherapi.com/v1/current.json', [

            'key' => '497bbe3effae4d6799050929241804',
            'q' => $q,
        ]);
        
        if ($response->successful()) 
        {
            $weatherData = $response->json();
            $weatherData['location']['date'] = date("D, j M Y");
            $weatherData['current']['condition']['icon'] = str_replace("//","",$weatherData['current']['condition']['icon']);

            return json_encode($weatherData);
        }else {
            $error = $response->status();
        }
    }
    
    // Category APIs =====================================================================================================================================================
    public function add_category(request $request)
    {
        $data = $request->only('name');
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        
        $id = Category::insertGetId($data);
        return $id;
    }

    public function add_sub_category(request $request)
    {
        $data = $request->only('category_id','name');


        $data['category_id'] = filter_var($data['category_id'], FILTER_SANITIZE_STRING);
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        
        $id = Category_Slave::insertGetId($data);
        return $id;
    }
    
    public function get_category()
    {

        $categories = Category::with('slaves')->get();
        foreach ($categories as $category) {
            if($category->is_deleted == 0){

                $categoryData = [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'is_active' => (int)$category->is_active,
                    'is_parent' => (int)$category->is_parent,
                    'slaves' => []
                ];
                $v=0;
                foreach ($category->slaves as $slave) {

                    if($slave ->is_deleted == 0){

                        $categoryData['slaves'][$v]['subcategory_id'] = $slave->id;
                        $categoryData['slaves'][$v]['subcategory_name'] = $slave->name;
                        $categoryData['slaves'][$v]['is_active'] = (int)$slave->is_active;
                    }
                    $v++;
                }
                
                $categoriesData[][] = $categoryData;
            }
        }
        // return $categoriesData;
        return json_encode($categoriesData);
    }

    public function update_category(Request $request)
    {
        $data = $request->only('id','name','is_parent','is_active','is_deleted');
        $status = FALSE;
        $updateData = [];
        
        if (isset($data['id']) && $data['id']!= NULL){
    
            $rowsAffected = Category::where('id', $data['id'])->update($data);

            if ($rowsAffected > 0) {

                $status = TRUE;
            } else {

                $status = FALSE;
            }
        }
        return $status;
    }
    
    public function update_sub_category(Request $request)
    {
        $data = $request->only('id','name','is_active','is_deleted');
        $status = FALSE;
        $updateData = [];
        
        if (isset($data['id']) && $data['id']!= NULL){
    
            $rowsAffected = Category_Slave::where('id', $data['id'])->update($data);

            if ($rowsAffected > 0) {

                $status = TRUE;
            } else {

                $status = FALSE;
            }
        }
        return $status;
    }



    // News APIs ===========================================================================================================================================================
    // public function add_news(Request $request)
    // {
    //     $data['is_active'] = $request->is_active;
    //     $data['category_id'] = $request->category_id;
    //     $data['tag'] = $request->tags_id;
    //     $data['heading'] = $request->heading;
    //     $data['paragraph'] = $request->paragraph;
    //     $data['img'] = $request->img;
    //     $data['created_by'] = 'Admin';
    //     $data['created_at'] = $data['updated_at'] = date("Y-m-d",time());

    //     $name = $_FILES['img']['name']->getClientOriginalName();
    //     $fileNameOnly = pathinfo($_FILES['img']['name'], PATHINFO_FILENAME);
    //     $extension = $_FILES['img']['name']->getClientOriginalExtension();

    //     $id = News::insertGetId($data);

    //     $slave = $request->slave;
        
        
    //     for($i=0; $i<count($slave); $i++){
    //         $slave[$i]['news_id'] = $id;
    //         $slave[$i]['created_at'] = $slave[$i]['updated_at'] = date("Y-m-d",time());
    //         News_Slave::insert($slave[$i]);
    //     }
    // }


    public function add_news(Request $request)
{
    // Validate incoming request
    // $validatedData = $request->validate([
    //     'is_active' => 'required|boolean',
    //     'category_id' => 'required|integer',
    //     'tags_id' => 'required|integer',
    //     'heading' => 'required|string',
    //     'paragraph' => 'required|string',
    //     'slave' => 'required|array',
    //     'slave.*.sub_heading' => 'nullable|string',
    //     'slave.*.paragraph' => 'nullable|string',
    // ]);

    // Handle main image upload using $_FILES['img']
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['img'];
        return $file;
        $fileName = $file['name'];
        $fileNameOnly = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileNameToStore = $fileNameOnly . '_' . time() . '.' . $extension;

        // Move uploaded file to storage directory (public/uploads)
        move_uploaded_file($file['tmp_name'], public_path('storage/news' . $fileNameToStore));

        // Save file path in database
        $validatedData['category_id'] = $request['category_id'];
        $validatedData['img'] = 'storage/news' . $fileNameToStore;
    } else {
        return response()->json(['message' => 'No file uploaded or error occurred'], 400);
    }

    // Add additional data
    $validatedData['created_by'] = 'Admin';
    $validatedData['created_at'] = now();
    $validatedData['updated_at'] = now();

    // Create news entry
    $news = News::create($validatedData);
    $newsId = $news->id;

    // Handle news_slave entries
    foreach ($request->slave as $slave) {
        $slaveData = [
            'news_id' => $newsId,
            'sub_heading' => $slave['sub_heading'] ?? null,
            'paragraph' => $slave['paragraph'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert news_slave record
        News_Slave::create($slaveData);
    }

    return response()->json(['message' => 'News added successfully'], 201);
}

    public function filter_news(Request $request)
    {   
        $where = '1';

        if($request['tag_id'] != '0')
            $where = $where." and tag=".$request['tag_id'];
        
        if($request['category'] != 0 && ($request['sub_category'] == 0))
            $where = $where." and category_id=".$request['category'];

        $dbnews = News::with('slaves')
              ->whereRaw($where)
              ->get();
        // $dbnews = News::with('slaves')->where('tag', $request['tag_id'])->get();

        return $dbnews;
    }

    public function get_news_list()
    {
        $i=0;

        $dbNews = News::with('slaves')->get();

        foreach ($dbNews as $news) {
            $newsData[] = [
                'id' => $news->id,
                'category_id' => $news->category_id,
                'heading' => $news->heading,
                'paragraph' => $news->paragraph,
                'img' => $news->img,
                'tag' => $news->tag,
                'created_by' => $news->created_by,
                'is_active' => $news->is_active,
                'is_deleted' => $news->is_deleted,
                'created_at' => $news->created_at,
                'updated_at' => $news->updated_at,
                'slaves' => []
            ];
        
            foreach ($news->slaves as $slave) {
                $newsData[$i]['slaves'][] = [

                    'sub_heading' => $slave->sub_heading,
                    'paragraph' => $slave->paragraph,
                    'img' => $slave->img,
                ];
            }
            $i++;
        }
            // dd($newsData);
        return json_encode($newsData);
    }


    // News Tags ======================================================================================================================================
    public function get_news_tags()
    {
        $News_tags = News_Tags::all();
        return json_encode($News_tags);
    }
}
