<?php

namespace App\Http\Controllers;

use App\AssignProductAttribute;
use App\Brand;
use App\Language;
use App\Offer;
use App\Product;
use App\Subscriber;
use App\SupportAttachment;
use App\SupportMessage;
use App\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\Frontend;
use App\Order;
use App\OrderDetail;
use App\ProductReview;
use App\ProductStock;

class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $products = Product::with('categories', 'offer', 'offer.activeOffer', 'reviews')
        ->whereHas('categories')
        ->whereHas('brand')
        ->orderBy('id', 'desc')
        ->get();
        $data['page_title']             = 'Home';
        $data['featured_products']      = $products->where('is_featured', 1);
        $data['special_products']       = $products->where('is_special', 1);
        $data['offers']                 = Offer::where('status', 1)
                                            ->where('end_date', '>', Carbon::now())
                                            ->with(['products'=> function($q){
                                                return $q->whereHas('categories')->whereHas('brand');
                                                },
                                                'products.reviews'
                                            ])
                                            ->get();

        $data['top_selling_products'] = Product::topSales();
        $data['top_brands']           = Brand::where('top', 1)->get();
        $data['top_categories']       = Category::where('is_top', 1)->get();
        $data['special_categories']   = Category::where('is_special', 1)->get();
        return view($this->activeTemplate . 'home', $data);
    }

    public function productSearch(Request $request)
    {
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $page_title     = 'Product Search';
        $empty_message  = 'No Product Found';
        $search_key     = $request->search_key;
        $category_id    = $request->category_id;
        if(!isset(request()->perpage)){
            $perpage    = 15;
        }else{
            $perpage    = request()->perpage;
        }

        $all_products   = Product::with(['categories', 'offer', 'offer.activeOffer', 'reviews', 'brand'])
                            ->whereHas('categories')
                            ->whereHas('brand')
                            ->latest()
                            ->get();

        if($category_id == 0){
            $products   = Product::with(['categories', 'offer', 'offer.activeOffer', 'reviews', 'brand'])
                            ->whereHas('categories')
                            ->whereHas('brand')
                            ->orderBy('id', 'desc')
                            ->where(function ($query) use ($search_key) {
                                return $query->where('name', 'like', "%{$search_key}%")->orWhere('summary', 'like', "%{$search_key}%")->orWhere('description', 'like', "%{$search_key}%");
                            })
                            ->whereHas('brand')
                            ->paginate($perpage);
        }else{
            $products   = Category::where('id', $category_id)->firstOrFail()->products()
                            ->with('categories', 'offer', 'offer.activeOffer', 'reviews', 'brand')
                            ->whereHas('categories')
                            ->whereHas('brand')
                            ->where(function($query) use ($search_key){
                                return $query->where('name', 'like', "%{$search_key}%")
                                    ->orWhere('summary', 'like', "%{$search_key}%")
                                    ->orWhere('description', 'like', "%{$search_key}%");
                                })
                            ->paginate($perpage);
        }

        if($request->ajax()){
            $view = 'partials.products_serarch_filter';
        }else{
            $view = 'products_search';
        }

        return view($this->activeTemplate . $view, compact('page_title', 'products', 'empty_message', 'search_key','category_id','perpage'));
    }

    public function products(Request $request)
    {
        $brands                 = Brand::latest()->get();
        $categories             = Category::where('parent_id', null)->latest()->get();
        $page_title             = 'Products';
        $brand                  = $request->brand?$request->brand:['0'];
        $category_id            = $request->category_id??0;
        $min                    = $request->min;
        $max                    = $request->max;

        if(!isset(request()->perpage)){
            $perpage = 15;
        }else{
            $perpage = request()->perpage;
        }

        if($category_id !=0){
            $all_products       = Category::where('id', $category_id)
                                    ->first()
                                    ->products()
                                    ->with('categories', 'offer', 'offer.activeOffer', 'reviews', 'brand')
                                    ->whereHas('categories')
                                    ->whereHas('brand')
                                    ->get();
        }else{
            $all_products       = Product::with('categories', 'offer', 'offer.activeOffer', 'reviews', 'brand')
                                    ->whereHas('categories')
                                    ->whereHas('brand')
                                    ->get();
        }

        $min_price              = $all_products->min('base_price')??0;
        $max_price              = $all_products->max('base_price')??0;
        if (in_array("0", $brand)){
            $productCollection  = $all_products;
        }else{
            $productCollection  = $all_products->whereIn('brand.id', $brand);
        }

        if($min && $max){
            $productCollection = $productCollection->where('base_price', '>=', $min)->where('base_price', '<=', $max);
        }elseif($min){
            $productCollection = $productCollection->where('base_price', '>=', $min);
        }elseif($max){
            $productCollection = $productCollection->where('base_price', '<=', $max);
        }

        $products           =  paginate($productCollection, $perpage, $page = null, $options = []);

        if($request->ajax()){
            $view = 'partials.products_filter';
        }else{
            $view = 'products';
        }

        $empty_message ="¡Lo siento! No se ha encontrado ningún producto.";

        return view($this->activeTemplate . $view, compact('products', 'perpage', 'brand', 'min_price', 'max_price', 'page_title' ,'brands','min', 'max', 'category_id', 'empty_message'));
    }

    public function productsByCategory(Request $request, $id)
    {
        $category               = Category::whereId($id)->firstOrFail();
        $page_title             = 'Products by Category - '.$category->name;

        $categories             = Category::where('parent_id', null)->latest()->get();
        $brand                  = $request->brand?$request->brand:['0'];
        $min                    = $request->min;
        $max                    = $request->max;

        if(!isset(request()->perpage)){
            $perpage = 15;
        }else{
            $perpage = request()->perpage;
        }

        $all_products           = $category->products()
                                    ->with('categories', 'offer', 'offer.activeOffer','brand', 'reviews')
                                    ->whereHas('categories')
                                    ->whereHas('brand')
                                    ->get();

        $min_price              = $all_products->min('base_price')??0;
        $max_price              = $all_products->max('base_price')??0;

        $brands                 = $all_products->unique('brand')->pluck('brand');

        if (in_array("0", $brand)){
            $productCollection  = $all_products;
        }else{
            $productCollection  = $all_products->whereIn('brand.id', $brand);
        }

        if($min && $max){
            $productCollection = $productCollection->where('base_price', '>=', $min)->where('base_price', '<=', $max);
        }elseif($min){
            $productCollection = $productCollection->where('base_price', '>=', $min);
        }elseif($max){
            $productCollection = $productCollection->where('base_price', '<=', $max);
        }

        $products           =  paginate($productCollection, $perpage, $page = null, $options = []);

        if($request->ajax()){
            $view = 'partials.products_filter';
        }else{
            $view = 'products_by_category';
        }

        $empty_message ="Sorry! No Product Found.";

        $seo_contents['meta_title']         = $category->meta_title;
        $seo_contents['meta_description']   = $category->meta_description;
        $seo_contents['meta_keywords']      = $category->meta_keywords;
        $seo_contents['image']              = getImage(imagePath()['category']['path'] .'/'.$category->image);
        $seo_contents['image_size']         = imagePath()['category']['size'];

        return view($this->activeTemplate . $view, compact('products', 'perpage', 'brand' ,'min_price', 'max_price', 'page_title', 'empty_message','min', 'max', 'category', 'brands', 'seo_contents'));

    }

    public function productsByBrand(Request $request, $id)
    {
        $brand                  = Brand::whereId($id)->firstOrFail();
        $page_title             = 'Products by Brand - '.$brand->name;

        $categories             = Category::where('parent_id', null)->latest()->get();
        $category_id            = $request->category_id??0;
        $min                    = $request->min;
        $max                    = $request->max;

        if(!isset(request()->perpage)){
            $perpage = 15;
        }else{
            $perpage = request()->perpage;
        }

        if($category_id !=0){
            $all_products       = Category::where('id', $category_id)->first()->products()->where('brand_id', $id)->with('categories', 'offer', 'offer.activeOffer','brand', 'reviews')
            ->whereHas('categories')
            ->whereHas('brand')
            ->get();
        }else{
            $all_products       = $brand->products()->where('brand_id', $id)->with('categories', 'offer', 'offer.activeOffer','brand', 'reviews')
            ->whereHas('categories')
            ->whereHas('brand')
            ->get();
        }

        $productCollection = $all_products;

        if($min && $max){
            $productCollection = $productCollection->where('base_price', '>=', $min)->where('base_price', '<=', $max);
        }elseif($min){
            $productCollection = $productCollection->where('base_price', '>=', $min);
        }elseif($max){
            $productCollection = $productCollection->where('base_price', '<=', $max);
        }


        $min_price              = $all_products->min('base_price')??0;
        $max_price              = $all_products->max('base_price')??0;

        $products           =  paginate($productCollection, $perpage, $page = null, $options = []);

        if($request->ajax()){
            $view = 'partials.products_filter';
        }else{
            $view = 'products_by_brand';
        }

        $empty_message ="Sorry! No Product Found.";

        $seo_contents['meta_title']         = $brand->meta_title;
        $seo_contents['meta_description']   = $brand->meta_description;
        $seo_contents['meta_keywords']      = $brand->meta_keywords;
        $seo_contents['image']              = getImage(imagePath()['brand']['path'] .'/'.$brand->logo);
        $seo_contents['image_size']         = imagePath()['brand']['size'];

        return view($this->activeTemplate . $view, compact('products', 'perpage', 'brand' ,'min_price', 'max_price', 'page_title', 'empty_message','min', 'max', 'category_id', 'seo_contents'));

    }

    public function productDetails($id, $order_id =null)
    {
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $review_available = false;
        if($order_id){
            $order = Order::where('order_number', $order_id)->where('user_id', auth()->id())->first();
            if($order){
                $od = OrderDetail::where('order_id', $order->id)->where('product_id', $id)->first();
                if($od){
                    $review_available = true;
                }
            }
        }
       $product = Product::where('id', $id)->with('categories','assignAttributes','offer', 'offer.activeOffer', 'reviews', 'productImages')
        ->whereHas('categories')
        ->whereHas('brand')
        ->first();
        if(!$product){
            abort('404');
        }
        $images = $product->productPreviewImages;

        if($images->count() == 0){
            $images = $product->productVariantImages;
        }
        if(optional($product->offer)->activeOffer){
            $discount = calculateDiscount($product->offer->activeOffer->amount, $product->offer->activeOffer->discount_type, $product->base_price);
        }else $discount = 0;

        $rProducts = $product->categories()
                    ->with(
                        [
                            'products' => function($q){
                                return $q->whereHas('categories')->whereHas('brand');
                            },
                            'products.reviews' ,'products.offer', 'products.offer.activeOffer'
                        ]
                    )
                    ->get()->map(function($item) use($id){
                        return $item->products->where('id', '!=', $id)->take(5);
                    });

        $related_products = [];

        foreach ($rProducts as $childArray){
            foreach ($childArray as $value){
                $related_products[] = $value;
            }
        }

        $attributes     = AssignProductAttribute::where('status',1)->with('productAttribute')->where('product_id', $id)->distinct('product_attribute_id')->get(['product_attribute_id']);

        $seo_contents['meta_title']         = $product->meta_title;
        $seo_contents['meta_description']   = $product->meta_description;
        $seo_contents['meta_keywords']      = $product->meta_keywords;
        $seo_contents['image']              = getImage(imagePath()['product']['path'] .'/'.$product->main_image);
        $seo_contents['image_size']         = imagePath()['category']['size'];


        $page_title = 'Product Details';
        return view($this->activeTemplate . 'product_details', compact('product', 'page_title', 'review_available', 'related_products', 'discount', 'attributes', 'images', 'seo_contents'));
    }

    public function quickView(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|gt:0',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $id = $request->id;
        $date_now = Carbon::now()->format('Y-m-d H:i:s');

        $review_available = false;

        $product = Product::where('id', $id)
                    ->with('categories', 'offer', 'offer.activeOffer', 'reviews', 'productImages')
                    ->whereHas('categories')
                    ->whereHas('brand')
                    ->first();

        if(!$product){
            abort('404');
        }

        if(optional($product->offer)->activeOffer){
            $discount = calculateDiscount($product->offer->activeOffer->amount, $product->offer->activeOffer->discount_type, $product->base_price);
        }else $discount = 0;


        $rProducts = $product->categories()->with('products', 'products.offer')->get()->map(function($item) use($id){
            return $item->products->where('id', '!=', $id)->take(5);
        });

        $attributes     = AssignProductAttribute::where('status',1)->where('product_id', $id)->distinct('product_attribute_id')->with('productAttribute')->get(['product_attribute_id']);


        $page_title = 'Product Details';
        return view($this->activeTemplate . 'partials.quick_view', compact('product', 'page_title', 'review_available', 'discount', 'attributes'));
    }

    public function brands()
    {
        $data['brands']         = Brand::latest()->paginate(30);
        $data['page_title']     = 'Brands';
        $data['empty_message']  = 'No Brand Found';

        return view($this->activeTemplate.'brands', $data);
    }

    public function categories ()
    {
        $data['all_categories']      = Category::latest()->paginate(20);
        $data['page_title']     = 'Categories';
        $data['empty_message']  = 'No Category Found';

        return view($this->activeTemplate.'categories', $data);
    }

    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }

    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();
        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();
        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    SupportAttachment::create([
                        'support_message_id' => $message->id,
                        'image' => uploadImage($image, $path),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function placeholderImage($size = null){

        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');


        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function trackOrder()
    {
        $page_title = 'Order Tracking';

        return view($this->activeTemplate. 'order_track', compact('page_title'));
    }

    public function getOrderTrackData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_number' => 'required|max:160',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $page_title = 'Order Tracking';


        $order_number   = $request->order_number;
        $order_data     = Order::where('order_number', $order_number)->first();
        if($order_data){
            $p_status   = $order_data->payment_status;
            $status     = $order_data->status;

            return response()->json(['success'=>true, 'payment_status' => $p_status, 'status' => $status]);
        }
        else{
            $notify = 'No order found';
            return response()->json(['success'=>false,'message'=>$notify]);
        }
    }

    public function addSubscriber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $if_exist = Subscriber::where('email', $request->email)->first();
        if (!$if_exist) {
            Subscriber::create([
                'email' => $request->email
            ]);
            return response()->json(['success' => 'Subscribed Successfully']);
        } else {
            return response()->json(['error' => 'Already Subscribed']);
        }
    }

    public function aboutUs()
    {
        $data            = getContent('about_page.content', true);
        $page_title      = $data->data_values->page_title??'';


        return view($this->activeTemplate.'page', compact('page_title', 'data'));
    }

    public function faqs()
    {
        $data            = getContent('faq_page.content', true);
        $page_title      = $data->data_values->page_title??'';
        return view($this->activeTemplate.'page', compact('page_title', 'data'));
    }

    public function addToCompare(Request $request)
    {
        $id         = $request->product_id;
        $product    = Product::where('id', $id)->with('categories')->first();

        $compare            = session()->get('compare');
        if($compare){
            $reset_compare      = reset($compare);
            $prev_product   = Product::where('id', $reset_compare['id'])->with('categories')->first();

            $not_same       = empty(array_intersect($product->categories->pluck('id')->toArray(), $prev_product->categories->pluck('id')->toArray()));

            if($not_same){
                return response()->json(['error' => 'A diffrent type of product have already added to your comparison list. Please add similar type product to compare or clear your comparison list']);
            }
            if(count($compare) > 2){
                return response()->json(['error' => 'You can\'t add more than 3 product in comparison list']);
            }

        }

        if(!$compare) {

            $compare = [
                $id => [
                    "id" => $product->id
                ]
            ];
            session()->put('compare', $compare);
            return response()->json(['success' => 'Agregado a la lista de comparación']);
        }

        // if compare list is not empty then check if this product exist
        if(isset($compare[$id])) {
            return response()->json(['error' => 'Ya en la lista de comparación']);
        }
        $compare[$id] = [
            "id" => $product->id
        ];

        session()->put('compare', $compare);
        return response()->json(['success' => 'Agregado a la lista de comparación']);
    }

    public function compare()
    {
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $data       = session()->get('compare');

        $products   = [];

        if($data){
            foreach($data as $key=>$val){
                array_push($products, $key);
            }
        }

        $compare_data   = Product::with('categories', 'offer', 'offer.activeOffer', 'reviews')
                            ->whereHas('categories')
                            ->whereHas('brand')
                            ->whereIn('id',$products)->get();

        $compare_items = $compare_data->take(4);

        $page_title = 'Product Comparison';
        $empty_message = 'Comparison list is empty';
        return view($this->activeTemplate . 'compare', compact('page_title', 'compare_items', 'empty_message'));
    }

    public function getCompare()
    {
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $data       = session()->get('compare');

        if(!$data){
            return response(['total'=> 0]);
        }

        $products   = [];
        foreach($data as $key=>$val){
            array_push($products, $key);
        }

        $compare_data   = Product::with('categories', 'offer', 'offer.activeOffer', 'reviews')
                            ->whereHas('categories')
                            ->whereHas('brand')
                            ->whereIn('id',$products)->get();
        return response(['total'=> count($compare_data)]);
    }

    public function removeFromcompare($id)
    {
        $compare = session()->get('compare');

        if(isset($compare[$id])) {
            unset($compare[$id]);
            session()->put('compare', $compare);
            $notify[] = ['success', 'Deleted from compare list'];
            return response()->json(['message' => 'Removed']);
        }

        return response()->json(['error' => 'Algo salió mal']);
    }

    public function loadMore(Request $request)
    {
        $reviews = ProductReview::where('product_id', $request->pid)->latest()->paginate(5);
        return view($this->activeTemplate . 'partials.product_review', compact('reviews'));
    }

    public function getStockByVariant(Request $request)
    {
        $pid    = $request->product_id;
        $attr   = json_decode($request->attr_id);
        sort($attr);
        $attr = json_encode($attr);

        $stock  = ProductStock::where('product_id', $pid)->where('attributes', $attr)->first();

        return response()->json(['sku'=> $stock->sku??'Not Available', 'quantity' => $stock->quantity??0]);
    }

    public function getImageByVariant(Request $request)
    {
        $variant = AssignProductAttribute::whereId($request->id)->with('productImages')->firstOrFail();
        $images         = $variant->productImages;

        if($images->count() > 0){
            return view($this->activeTemplate . 'partials.variant_images', compact('images'));
        }else{
            return response()->json(['error'=>true]);
        }
    }

    public function page(Frontend $id)
    {
        $data           = $id;
        $page_title     = $id->data_values->page_title??'';
        return view($this->activeTemplate.'page', compact('page_title', 'data'));
    }

    public function printInvoice(Order $order)
    {
        $page_title = 'Print Invoice';

        return view('invoice.print', compact('page_title', 'order'));
    }

}
