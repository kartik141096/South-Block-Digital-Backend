<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Category_Slave;
use App\Models\News;
use App\Models\News_Slave;

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
    public function add_news(Request $request)
    {
        return $request;
       
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
}
