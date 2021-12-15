<?php

namespace App\Http\Controllers;

use App\Products;
use App\Functions\RandomId;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class ProductController extends Controller
{
    /**
     * Fix textarea data without wrap from front_end.
     */
    // private function replaceEnter(Bool $database, String $content)
    // {
    //     if ($database)
    //         return str_replace("\n", "<br />", str_replace("\r\n", "<br />", $content));
    //     else
    //         return str_replace("<br />", "\n", $content);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Products::orderby('order')->get();
        foreach ($products as $data) {
            $data->path = explode('/', $data->path);
        }
        return view('grv.CMS.product.index', ['products' => $products,'count'=>count($products)]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $img = $request->input('product_photo');
        $img = str_replace('data:image/jpeg;base64,', '', $img); // 需注意 data url 格式 與來源是否相符 ex:image/jpeg
        $data = base64_decode($img); //解base64碼
        $file = '../storage/app/product/' .$request->input('name').'.jpg'; //檔名 包含資料夾路徑 請記得此資料夾需 777 權限 方可寫入圖檔
        $success = file_put_contents($file, $data);

        $request->validate([
            'name' => 'required|string',
            'url' => 'nullable|string',
            'product_photo' => 'required|string'
        ]);

        $product_ids = Products::select('products_id')->get()->map(function ($product) {
            return $product->products_id;
        })->toArray();
        $id = RandomId::getNewId($product_ids);
        // if ($request->hasFile('product_photo')) {
        //     if ($request->product_photo->isValid()) {
        //         $product_photo = $request->product_photo->storeAs('product', $request->product_photo->getClientOriginalName());
        //     }
        // }

        $post = Products::create([
            'name' => $request->input('name'),
            'user_id' => \Auth::user()->user_id,
            'products_id' => $id,
            'url' => $request->input('url'),
            'order' => count($product_ids) + 1,
            'path' => 'product/' .$request->input('name').'.jpg',
        ]);

        return redirect()->route('product.index');
    }

    public function update(Request $request, String $i, String $id)
    {
        $temp = 'path_' . $i;
        $product = Products::find($id);
        if ($request->$temp != null) {
            \Illuminate\Support\Facades\Storage::delete([$product->path]);
            $img = $request->input('product_photo_' . $i);
            $img = str_replace('data:image/jpeg;base64,', '', $img); // 需注意 data url 格式 與來源是否相符 ex:image/jpeg
            $data = base64_decode($img); //解base64碼
            $file = '../storage/app/product/' .$request->input('name').'.jpg'; //檔名 包含資料夾路徑 請記得此資料夾需 777 權限 方可寫入圖檔
            $success = file_put_contents($file, $data);
            $product->path = 'product/' .$request->input('name').'.jpg';
        }


        $order = $request->input('order_' . $i);
        if ($order != $product->order) {
            $product_1 = Products::where('order', '=', $order)->get();
            $order_temp = $product->order;
            $product->order = $order;
            $product_1[0]->order = $order_temp;
            $product_1[0]->save();
        }

        $product->name = $request->input('name_' . $i);
        $product->url = $request->input('url_' . $i);

        $product->save();
        // $product->update($request->except('_method', '_token', 'path_'.$i));

        return redirect()->route('product.index');
    }
    public function destroy(String $id)
    {
        $product = Products::find($id);
        $products = Products::orderby('order')->get();
        foreach($products as $data){
            if($data->order>$product->order){
                $data->order=$data->order - 1;
                $data->save() ;
            }
        }
        \Illuminate\Support\Facades\Storage::delete([$product->path]);
        $product->delete();
        return redirect()->route('product.index');
    }
    public function multipleDestroy(Request $request)
    {
        $check = $request->input('checkbox');
        // echo $check;
        foreach($check as $data){
            $product = Products::where('order', '=', $data)->get();
            
            \Illuminate\Support\Facades\Storage::delete([$product[0]->path]);
            $product[0]->delete();
        }
        return redirect()->route('product.index');

    }
}
