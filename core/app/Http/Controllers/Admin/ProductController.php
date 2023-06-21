<?php

namespace App\Http\Controllers\Admin;

use App\AssignProductAttribute;
use App\Brand;
use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use App\ProductAttribute;
use App\ProductImage;
use App\ProductReview;
use App\ProductStock;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $page_title = "All Products";
        $empty_message = "No Product Yet";
        $products = Product::latest()->with(['categories','brand', 'stocks', 'productImages'])
                        ->whereHas('categories')
                        ->whereHas('brand')
                        ->paginate(getPaginate());

        return view('admin.products.index', compact('page_title', 'empty_message', 'products', 'now'));
    }

    public function trashed()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $page_title = "Trashed Products";
        $empty_message = "No Product Yet";
        $products = Product::with(['brand','categories', 'stocks'])
        ->whereHas('categories')
        ->whereHas('brand')
        ->onlyTrashed()
        ->orderByDesc('id')->paginate(getPaginate());

        return view('admin.products.index', compact('page_title', 'empty_message', 'products', 'now'));
    }

    public function productSearch(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        if ($request->search != null) {
            $empty_message  = 'No product found';
            $search         = trim(strtolower($request->search));
            $products       = Product::with(['brand', 'categories', 'stocks'])
            ->whereHas('brand')
            ->whereHas('categories')
            ->orderByDesc('id')
            ->where('name', 'like', "%$search%")->paginate(getPaginate());

            $page_title     = 'Product Search - ' . $search;
            return view('admin.products.index', compact('page_title', 'empty_message', 'products', 'now'));
        }else{
            return redirect()->route('admin.product');
        }
    }


    public function productTrashedSearch(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        if ($request->search != null) {
            $empty_message  = 'No product found';
            $search         = trim(strtolower($request->search));
            $products       = Product::with(['brand', 'categories', 'stocks'])
            ->whereHas('brand')
            ->whereHas('categories')
            ->orderByDesc('id')
            ->onlyTrashed()->orderByDesc('id')
            ->where('name', 'like', "%$search%")->paginate(getPaginate());
            $page_title     = 'Trashed Product Search - ' . $search;
            return view('admin.products.index', compact('page_title', 'empty_message', 'products', 'now'));
        }else{
            return redirect()->route('admin.product');
        }
    }

    public function create()
    {
        $page_title     = "Add New Product";
        $categories     = Category::with('allSubcategories')->where('parent_id', null)->get();

        $brands         = Brand::orderBy('name')->get();
        return view('admin.products.create', compact('page_title', 'categories', 'brands'));
    }

    public function edit($id)
    {
        $page_title     = "Edit Product";
        $product        = Product::whereId($id)->with(['productPreviewImages', 'categories'])->first();
        $categories     = Category::with('allSubcategories')->where('parent_id', null)->get();

        $brands         = Brand::orderBy('name')->get();
        $images         = [];

        foreach($product->productPreviewImages as $key=>$image){
            $img['id'] = $image->id;
            $img['src'] = getImage(imagePath()['product']['path']. '/' . $image->image);
            $images[] = $img;
        }

        return view('admin.products.create', compact('page_title', 'categories', 'brands', 'product', 'images'));
    }


    public function store(Request $request, $id)
    {
        $validation_rule = [
            'name'                  => 'required|string|max:191',
            'model'                 => 'nullable|string|max:100',
            'brand_id'              => 'required|integer',
            'base_price'            => 'required|numeric',
            "categories"            => 'required|array|min:1',
            'has_variants'          => 'sometimes|required|numeric|min:1|max:1',
            'track_inventory'       => 'sometimes|required|numeric|min:1|max:1',
            'show_in_frontend'      => 'sometimes|required|numeric|min:1|max:1',
            'description'           => 'nullable|string',
            'summary'               => 'nullable|string|max:360',
            'sku'                   => 'nullable|required_without:has_variants|string|max:100',
            'extra'                 => 'sometimes|required|array',
            'extra.*.key'           => 'required_with:extra',
            'extra.*.value'         => 'required_with:extra',
            'specification'         => 'sometimes|required|array',
            'specification.*.name'  => 'required_with:specification',
            'specification.*.value' => 'required_with:specification',
            'meta_title'            => 'nullable|string|max:191',
            'meta_description'      => 'nullable|string|max:191',
            'meta_keywords'         => 'nullable|array',
            'meta_keywords.array.*' => 'nullable|string',
            'video_link'            => 'nullable|string',
            'photos'                => 'required_if:id,0|array|min:1',
            'photos.*'              => ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ];

        if($id==0){
            $product = new Product();
            $validation_rule['main_image']  = ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        } else{
            $product = Product::findOrFail($id);

            $prev_track_inventory   = $product->track_inventory;
            $prev_has_variants      = $product->has_variants;

            $validation_rule['main_image']  = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
        }

        $validation_rule['specification.*.name'] = 'required';
        $validation_rule['specification.*.value'] = 'required';
        $request->validate($validation_rule,['specification.*.name.required'=>'All specification name is required','specification.*.value.required'=> 'All specification value is required']);

        // if($validator->fails()) {
        //     return response()->json(['status'=>'error', 'message'=>$validator->errors()]);
        // }

        //Check if the sku is already taken
        if($request->sku){

            $sku_check = Product::where('sku', $request->sku)->where('id', '!=', $id)->with('stocks')->orWhereHas('stocks', function($q)use($request, $id){
                $q->where('sku', $request->sku)->where('product_id', '!=', $id);
            })->first();

            if($sku_check){
                
                 $notify[] = ['error', 'This SKU has already been taken'];
                 return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('main_image')) {

            try {
                $request->merge(['image' => uploadImage($request->main_image, imagePath()['product']['path'], imagePath()['product']['size'], @$product->main_image ,imagePath()['product']['thumb'])]);
            } catch (\Exception $exp) {
               
                $notify[] = ['error', 'Could not upload the main image'];
                 return back()->withNotify($notify);
            }
        }else{
            $request->merge(['image'=>$product->main_image]);
        }


        $product->brand_id          = $request->brand_id;
        $product->sku               = $request->has_variants?null:$request->sku;
        $product->name              = $request->name;
        $product->model             = $request->model;
        $product->has_variants      = $request->has_variants??0;
        $product->track_inventory   = $request->track_inventory??0;
        $product->show_in_frontend  = $request->show_in_frontend??0;
        $product->main_image        = $request->image;
        $product->video_link        = $request->video_link;
        $product->description       = $request->description;
        $product->summary           = $request->summary;
        $product->specification     = $request->specification??null;
        $product->extra_descriptions= $request->extra??null;
        $product->base_price        = $request->base_price;
        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_keywords     = $request->meta_keywords??null;
        $product->save();

        //Check Old Images
        $previous_images = $product->productPreviewImages->pluck('id')->toArray();
        $image_to_remove = array_values(array_diff($previous_images, $request->old??[]));

        foreach($image_to_remove as $item){
            $productImage   = ProductImage::find($item);
            $location       = imagePath()['product']['path'];

            removeFile($location . '/' . $productImage->image);
            $productImage->delete();
        }

        if ($request->hasFile('photos')) {
            foreach($request->photos as $image){
                try {
                    $product_img = uploadImage($image, imagePath()['product']['path'], imagePath()['product']['size'],null, imagePath()['product']['thumb']);
                }catch (\Exception $exp) {
                    
                    $notify[] = ['error', 'Could not upload additional images'];
                    return back()->withNotify($notify);
                }
                $productImage = new ProductImage();
                $productImage->product_id   = $product->id;
                $productImage->image        = $product_img;
                $productImage->save();
            }
        }

        if($id != 0){
            $product->categories()->sync($request->categories);
            $message = 'Product Updated Successfully';
            $reload = false;

            //If the value of track_inventory or has_varieants is changed then delete the prev inventory

            if(($prev_has_variants != $product->has_variants) || $prev_track_inventory != $product->track_inventory){
                $product_stocks = $product->stocks();
                foreach($product_stocks->get() as $st){
                    $st->stockLogs()->delete();
                }
                $product_stocks->delete();
            }

            //Check stock table to update the sku in stock table
            if($product->sku){
                $stock = ProductStock::where('id', $product->id)->first();
                if($stock){
                    $stock->sku = $product->sku;
                    $stock->save();
                }
            }
        }else{
            $product->categories()->attach($request->categories);
            $reload = true;
            $message = 'Product Added Successfully';
        }

        $notify[] = ['success', 'Product addded successfully!'];

        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $product = Product::where('id', $id)->withTrashed()->first();
        if ($product->trashed()){
            $product->restore();
            $notify[] = ['success', 'Product Restored Successfully'];
            return redirect()->back()->withNotify($notify);
        }else{
            $product->delete();
            $notify[] = ['success', 'Product Deleted Successfully'];
            return redirect()->back()->withNotify($notify);
        }
    }

    public function createAttribute($product_id)
    {
        $product                = Product::whereId($product_id)->first();
        if($product->has_variants == 0){
            $notify[] = ['error', 'Sorry! This Product Has No Variants'];
            return redirect()->back()->withNotify($notify);
        }
        $product_name           = $product->name;
        $page_title             = "Add Product Variants";
        $empty_message          = "No Variants Added Yet";

        $existing_attributes    = AssignProductAttribute::where('product_id', $product_id)
        ->with('productAttribute')
        ->get()
        ->groupBy('product_attribute_id');


        $attributes     = ProductAttribute::all();
        return view('admin.products.attributes.create', compact('page_title', 'attributes', 'product_id','empty_message', 'existing_attributes', 'product_name'));
    }

    public function storeAttribute(Request $request, $id)
    {
        $data = [];
        $request->validate([
            'attr_type' =>'required|integer|in:1,2,3',
            'attr_id'   =>'required',

            'text' => 'required_if:attr_type,1|array|min:1',
            'text.*.name'=>'required_with:text|max:50',
            'text.*.value'=>'required_with:text|max:191',
            'text.*.price'=>'required_with:text',

            'color' => 'required_if:attr_type,2|array|min:1',
            'color.*.name'=>'required_with:color|max:50',
            'color.*.value'=>'required_with:color|max:191',
            'color.*.price'=>'required_with:color',

            'img' => 'required_if:attr_type,3|array|min:1',
            'img.*.name' => 'required_with:img|max:50',
            'img.*.price' => 'required_with:img',
            'img.*.value' => ['required_with:img', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ],[],[
            'text.*.name'   => 'Name Field',
            'text.*.price'  => 'Price Field',

            'color.*.name'  => 'Name Field',
            'color.*.value' => 'Value Field',
            'color.*.price' => 'Price Field',

            'img.*.name'    => 'Name Field',
            'img.*.price'   => 'Price Field',
            'img.*.value'     => 'Image Field'
        ]);

        //Check Stock

        if($request->attr_type == 1){
            $data       = $request->text;
        }else if($request->attr_type == 2){
            $data = $request->color;
            $data_value = $request->value;
        }else if($request->attr_type == 3){
            foreach ($request->img as $key=>$item) {
                $data[$key]['name'] = $item['name'];
                $data[$key]['price'] =$item['price'];
                if(is_file($item['value'])) {
                    try {
                        $data[$key]['value'] = uploadImage($item['value'], imagePath()['attribute']['path'], imagePath()['attribute']['size']);
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Couldn\'t upload the Image.'];
                        return back()->withNotify($notify);
                    }
                }
            }
        }

        $exist = AssignProductAttribute::where('product_id',$id)->where('product_attribute_id',$request->attr_id)->count();

        if($exist==0){
            $stocks = ProductStock::where('product_id', $id)->cursor();
            foreach($stocks as $stock){
                $stock->delete();
            }
        }

        foreach($data as $attr){
            $assign_attr = new AssignProductAttribute();
            $assign_attr->product_attribute_id  = $request->attr_id;
            $assign_attr->product_id            = $id;
            $assign_attr->name                  = $attr['name'];
            $assign_attr->value                 = $attr['value']??'';
            $assign_attr->extra_price           = $attr['price'];
            $assign_attr->save();
        }

        $notify[] = ['success', 'New Variant Added Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function updateAttribute(Request $request, $id)
    {
        $attr_data = AssignProductAttribute::findorFail($id);
        if($attr_data->productAttribute->type == 1 || $attr_data->productAttribute->type == 2){
            $request->validate([
                'name'  =>'required',
                'value' =>'required',
                'price' =>'required',
            ]);
        }elseif($attr_data->productAttribute->type == 3){
            $request->validate([
                'name'    => 'required',
                'image'   => ['required','image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
                'price'   => 'required'
                ]);

                $old_img =(isset($attr_data->value))? $attr_data->value :'';

                if($request->hasFile('image')) {
                try {
                    $request->merge(['value' => uploadImage($request->image, imagePath()['attribute']['path'], imagePath()['attribute']['size'], $old_img)]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload the Image.'];
                    return back()->withNotify($notify);
                }
            }
        }
        $attr_data->name   = $request->name;
        $attr_data->value  = $request->value??'';
        $attr_data->extra_price  = $request->price;
        $attr_data->save();
        $notify[] = ['success', 'Product Variant Updated Successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function highlight(Request $request)
    {
        $request->validate([
            'product_id'    =>'required|integer|gt:0',
            'featured'      =>'nullable|integer|between:0,1',
            'special'       =>'nullable|integer|between:0,1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $product->is_featured   = $request->featured??0;
        $product->is_special    = $request->special??0;

        $product->save();

        $notify[] = ['success', 'Updated Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function deleteAttribute($id)
    {
        $attr_data = AssignProductAttribute::findorFail($id);
        if($attr_data->productAttribute->type == 3){
            {
                $location = imagePath()['attribute']['path'];
                removeFile($location . '/' . $attr_data->value);
            }
        }
        $attr_data->delete();
        $notify[] = ['success', 'Variant Deleted Successfully'];
        return back()->withNotify($notify);
    }


    public function reviews()
    {
        $page_title = "All Product Reviews";
        $empty_message = "No Review Yet";
        $reviews = ProductReview::with(['product','user'])->whereHas('product')->whereHas('user')->latest()->paginate(getPaginate());

        return view('admin.products.reviews', compact('page_title', 'empty_message', 'reviews'));
    }

    public function reviewSerach (Request $request)
    {
        if ($request->key != null) {
            $page_title = "All Product Reviews";
            $empty_message = "No Review Yet";

            $search         = trim(strtolower($request->key));
            $reviews = ProductReview::
            where('review', 'like', "%$search%")
            ->orWhere('rating', 'like', "%$search%")
            ->orWhereHas('product', function ($product) use ($search) {
                $product->where('name', 'like', "%$search%");
            })
            ->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            })

            ->with(['product','user'])
            ->whereHas('product')
            ->whereHas('user')
            ->latest()
            ->paginate(getPaginate());

            return view('admin.products.reviews', compact('page_title', 'empty_message', 'reviews'));
        }else{
            return redirect()->route('admin.product.reviews');
        }
    }

    public function trashedReviews()
    {
        $page_title = "All Product Reviews";
        $empty_message = "No Review Yet";
        $reviews = ProductReview::onlyTrashed()->with(['product','user'])->whereHas('product')->whereHas('user')->latest()->paginate(getPaginate());
        return view('admin.products.reviews', compact('page_title', 'empty_message', 'reviews'));
    }

    public function reviewDelete ($id)
    {
        $review = ProductReview::where('id', $id)->withTrashed()->first();
        if ($review->trashed()){
            $review->restore();
            $notify[] = ['success', 'Review Restored Successfully'];
            return redirect()->back()->withNotify($notify);
        }else{
            $review->delete();
            $notify[] = ['success', 'Review Deleted Successfully'];
            return redirect()->back()->withNotify($notify);
        }
    }


    public function addVariantImages($id)
    {
        $variant        = AssignProductAttribute::whereId($id)->with('product', 'productImages','productAttribute')->firstOrFail();
        $product_name   = $variant->product->name;
        $images         = [];
        foreach($variant->productImages as $key=>$image){
            $img['id'] = $image->id;
            $img['src'] = getImage(imagePath()['product']['path']. '/' . $image->image);
            $images[] = $img;
        }
        $page_title = "Add Variant Images";
        return view('admin.products.attributes.add_variant_image', compact('page_title', 'variant', 'images','product_name'));
    }

    public function saveVariantImages(Request $request, $id)
    {
        $variant = AssignProductAttribute::whereId($id)->with('product', 'productImages')->firstOrFail();

        $validation_rule = [
            'photos'                =>  'required_if:id,0|array|min:1',
            'photos.*'              =>  ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ];

        $request->validate($validation_rule);

        //Check Old Images
        $previous_images = $variant->productImages->pluck('id')->toArray();

        $image_to_remove = array_values(array_diff($previous_images, $request->old??[]));

        foreach($image_to_remove as $item){
            $productImage   = ProductImage::find($item);
            $location       = imagePath()['product']['path'];

            removeFile($location . '/' . $productImage->image);
            $productImage->delete();
        }

        if ($request->hasFile('photos')) {
            foreach($request->photos as $image){
                try {
                    $product_img = uploadImage($image, imagePath()['product']['path'], imagePath()['product']['size'],null, imagePath()['product']['thumb']);
                }catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the Image.'];
                    return back()->withNotify($notify);
                }
                $productImage = new ProductImage();
                $productImage->product_id                       = $variant->product->id;
                $productImage->assign_product_attribute_id      = $id;
                $productImage->image                            = $product_img;
                $productImage->save();
            }
        }
        $notify[] = ['success', 'Images Added Successfully'];
        return redirect()->back()->withNotify($notify);
    }

}
