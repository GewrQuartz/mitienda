<?php

use App\GeneralSetting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function systemDetails()
{
    $system['name'] = 'ViserMart';
    $system['version'] = '1.1';
    return $system;
}

function getLatestVersion()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.viserlab.com/updates/version/' . systemDetails()['name'];
    $result = curlPostContent($url, $param);
    if ($result) {
        return $result;
    } else {
        return null;
    }
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}

function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function uploadFile($file, $location, $size = null, $old = null){
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');
    if (!empty($old)) {
        removeFile($location . '/' . $old);
    }
    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $file->move($location,$filename);
    return $filename;
}

function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();

    $image = Image::make($file);

    if (!empty($size)) {
        $size   = explode('x', strtolower($size));
        $width  = $size[0];
        $height = $size[1];

        $canvas = Image::canvas($width, $height);

        $image = $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });

        $canvas->insert($image, 'center');
        $canvas->save($location . '/' . $filename);
    }else{
        $image->save($location . '/' . $filename);
    }

    if (!empty($thumb)) {
        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }

    return $filename;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function activeTemplate($asset = false)
{
    $gs = GeneralSetting::first(['active_template']);
    $template = $gs->active_template;
    $sess = session()->get('template');
    if (trim($sess) != null) {
        $template = $sess;
    }
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $gs = GeneralSetting::first(['active_template']);
    $template = $gs->active_template;
    $sess = session()->get('template');
    if (trim($sess) != null) {
        $template = $sess;
    }
    return $template;
}

function getCustomCaptcha($className)
{
    $textcolor  = '#'.App\GeneralSetting::first()->base_color;
    $captcha    = \App\Plugin::where('act', 'custom-captcha')->where('status', 1)->first();

    if(!$captcha){
        return null;
    }

    $code   = rand(100000, 999999);
    $char   = str_split($code);
    $ret    = '<link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">';
    $ret    .= "<div class='$className'>";
    foreach ($char as $value) {
        $ret .= '<span style="    float:left;     -webkit-transform: rotate(' . rand(-60, 60) . 'deg);">' . $value . '</span>';
    }
    $ret    .= '</div>';
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);

    $ret    .= '<input type="hidden" name="captcha_secret" value="' . $captchaSecret . '">';
    return $ret;
}


function captchaVerify($code, $secret)
{
    $captcha = \App\Plugin::where('act', 'custom-captcha')->where('status', 1)->first();
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    if ($captchaSecret == $secret) {
        return true;
    }
    return false;
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function currency(){
    $data['crypto'] = 8;
    $data['fiat'] = 2;
    return $data;
}


function getAmount($amount, $length = 0)
{
    if(0 < $length){
        return number_format( $amount + 0, $length);
    }
    return $amount + 0;
}

function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet, $amount, $crypto = null)
{

    $varb = $wallet . "?amount=" . $amount;
    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
}

function curlContent($url)
{
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $result;
}


function curlPostContent($url, $arr = null)
{
    if ($arr) {
        $params = http_build_query($arr);
    } else {
        $params = '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function str_slug($title = null)
{
    return \Illuminate\Support\Str::slug($title);
}

function str_limit($title = null, $length = 10)
{
    return \Illuminate\Support\Str::limit($title, $length);
}

//moveable
function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');


    return $data;
}

//moveable
function osBrowser(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;

    return $data;
}

function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.viserlab.com/updates/templates/' . systemDetails()['name'];
    $result = curlPostContent($url, $param);
    if ($result) {
        return $result;
    } else {
        return null;
    }
}

function getPageSections($arr = false)
{

    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}


function getImage($image,$size = null)
{
    $clean = '';
    $size = $size ? $size : 'undefined';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }else{
        return route('placeholder.image',$size);
    }
}

function getAvatar($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(imagePath()['avatar']['image']);
}


function notify($user, $type, $shortCodes = null)
{
    send_email($user, $type, $shortCodes);
    send_sms($user, $type, $shortCodes);
}

function send_sms($user, $type, $shortCodes = [])
{
    $general = GeneralSetting::first(['sn', 'sms_api']);
    $sms_template = \App\SmsTemplate::where('act', $type)->where('sms_status', 1)->first();
    if ($general->sn == 1 && $sms_template) {

        $template = $sms_template->sms_body;

        foreach ($shortCodes as $code => $value) {
            $template = shortCodeReplacer('{{' . $code . '}}', $value, $template);
        }
        $template = urlencode($template);

        $message = shortCodeReplacer("{{number}}", $user->mobile, $general->sms_api);
        $message = shortCodeReplacer("{{message}}", $template, $message);
        $result = @file_get_contents($message);
    }
}

function send_email($user, $type = null, $shortCodes = [])
{
    $general = GeneralSetting::first();

    $email_template = \App\EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    if ($general->en != 1 || !$email_template) {
        return;
    }

    $message = shortCodeReplacer("{{name}}", $user->username, $general->email_template);
    $message = shortCodeReplacer("{{message}}", $email_template->email_body, $message);

    if (empty($message)) {
        $message = $email_template->email_body;
    }

    foreach ($shortCodes as $code => $value) {
        $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    }
    $config = $general->mail_config;

    if ($config->name == 'php') {
        send_php_mail($user->email, $user->username, $general->email_from, $email_template->subj, $message);
    } else if ($config->name == 'smtp') {
        send_smtp_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    } else if ($config->name == 'sendgrid') {
        send_sendGrid_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    } else if ($config->name == 'mailjet') {
        send_mailjet_mail($config, $user->email, $user->username, $general->email_from, $general->sitetitle, $email_template->subj, $message);
    }
}

function send_php_mail($receiver_email, $receiver_name, $sender_email, $subject, $message)
{
    $gnl = GeneralSetting::first();
    $headers = "From: $gnl->sitename <$sender_email> \r\n";
    $headers .= "Reply-To: $gnl->sitename <$sender_email> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail($receiver_email, $subject, $message, $headers);
}


function send_smtp_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->enc == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($sender_email, $sender_name);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($sender_email, $receiver_name);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
       throw new Exception($e);
    }
}


function send_sendGrid_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $sendgridMail = new \SendGrid\Mail\Mail();
    $sendgridMail->setFrom($sender_email, $sender_name);
    $sendgridMail->setSubject($subject);
    $sendgridMail->addTo($receiver_email, $receiver_name);
    $sendgridMail->addContent("text/html", $message);
    $sendgrid = new \SendGrid($config->appkey);
    try {
        $response = $sendgrid->send($sendgridMail);
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}


function send_mailjet_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $mj = new \Mailjet\Client($config->public_key, $config->secret_key, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $sender_email,
                    'Name' => $sender_name,
                ],
                'To' => [
                    [
                        'Email' => $receiver_email,
                        'Name' => $receiver_name,
                    ]
                ],
                'Subject' => $subject,
                'TextPart' => "",
                'HTMLPart' => $message,
            ]
        ]
    ];
    $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
}


function getPaginate($paginate = 15)
{
    return $paginate;
}


function menuActive($routeName, $type = null)
{
    if ($type == 3) {
        $class = 'side-menu--open';
    } elseif ($type == 2) {
        $class = 'sidebar-submenu__open';
    } else {
        $class = 'active';
    }

    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function imagePath()
{
    $data['user_profile'] = [
        'path' => 'assets/images/user/profile',
        'size' => '500x500',
    ];

    $data['gateway'] = [
        'path' => 'assets/images/gateway',
        'size' => '800x800',
    ];

    $data['verify'] = [
        'deposit'=>[
            'path'=>'assets/images/verify/deposit'
        ]
    ];
    $data['image'] = [
        'default' => 'assets/images/default.png',
    ];

    $data['avatar'] = [
        'image' => 'assets/images/avatar.png',
    ];

    $data['ticket'] = [
        'path' => 'assets/images/support',
    ];
    $data['language'] = [
        'path' => 'assets/images/lang',
        'size' => '64x64'
    ];
    $data['logoIcon'] = [
        'path' => 'assets/images/logoIcon',
    ];
    $data['favicon'] = [
        'size' => '128x128',
    ];
    $data['plugin'] = [
        'path' => 'assets/images/plugin',
    ];
    $data['seo'] = [
        'path' => 'assets/images/seo',
        'size' => '600x315'
    ];

    $data['product'] = [
        'path' => 'assets/images/product',
        'size' => '520x600',
        'thumb' => '266x290',
    ];

    $data['attribute'] = [
        'path' => 'assets/images/product/attribute',
        'size' => '64x64',
    ];

    $data['category'] = [
        'path' => 'assets/images/category',
        'size' => '200x150',
    ];

    $data['brand'] = [
        'path' => 'assets/images/brand',
        'size' => '200x150',
    ];

    return $data;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'd M, Y h:i A')
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->translatedFormat($format);
}


function send_general_email($email, $subject, $message, $receiver_name = '')
{
    $general = GeneralSetting::first();
    if ($general->en != 1 || !$general->email_from) {
        return;
    }
    $message = shortCodeReplacer("{{message}}", $message, $general->email_template);
    $message = shortCodeReplacer("{{name}}", $receiver_name, $message);

    $config = $general->mail_config;
    if ($config->name == 'php') {
        send_php_mail($email, $receiver_name, $general->email_from, $subject, $message);
    } else if ($config->name == 'smtp') {
        send_smtp_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    } else if ($config->name == 'sendgrid') {
        send_sendgrid_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    } else if ($config->name == 'mailjet') {
        send_mailjet_mail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
    }
}
if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('=' . env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function getContent($data_keys, $singleQuery = false, $limit = null)
{
    if ($singleQuery) {
        $content = \App\Frontend::where('data_keys', $data_keys)->latest()->first();
    } else {
        $article = \App\Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        $content = $article->where('data_keys', $data_keys)->latest()->get();
    }
    return $content;
}


function gatewayRedirectUrl(){
    return 'user.deposit';
}

function combinations($arrays, $i = 0) {
    if(sizeof($arrays) == 1){
       foreach($arrays[0] as $arr){
           $temp_array[]    = $arr;
           $final_array[]   =  $temp_array;
           unset($temp_array);
        }
       return  $final_array;
    }
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }
    // get combinations from subsequent arrays
    $tmp = combinations($arrays, $i + 1);
    $result = array();
    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ?
                array_merge(array($v), $t) :
                array($v, $t);
        }
    }
    return $result;
}

function getStockData($pid, $attr)
{
    $a = App\ProductStock::where('product_id', $pid)->where('attributes', $attr)->first();
    if ($a) {
        return $a;
    }

    return false;
}

function calculateDiscount($amount, $type, $base_price){
    if ($type == 1) {
        $discount = $amount;
    } else {
        $discount = ($amount * $base_price) / 100;
    }
    return $discount;
}

function display_avg_rating($rvw)
{
    $total_rvw      =  $rvw->count();
    $total_rvw = ($total_rvw == 0) ? 1 : $total_rvw;
    $total_rating   =  $rvw->sum('rating');
    $rvw_avg        =  $total_rating / $total_rvw;

    $prec = round($rvw_avg, 2) - intval($rvw_avg);
    $result = '';
    if ($prec > 0.25) {
        $rvw_avg = intval($rvw_avg) + 0.5;
    }

    if ($prec > 0.75) {
        $rvw_avg = intval($rvw_avg) + 1;
    }

    for ($i = 0; $i < intval($rvw_avg); $i++) {
        $result .= '<i class="la la-star"></i>';
    }

    if ($rvw_avg - intval($rvw_avg) == 0.5) {
        $i++;
        $result .= '<i class="las la-star-half-alt"></i>';
    }

    for ($k = 0; $k < 5 - $i; $k++) {
        $result .= '<i class="lar la-star"></i>';
    }
    return $result;
}


function checkWishList($product_id){
    $user_id    = auth()->user()->id??null;
    $wishlist   = session()->get('wishlist')??[];

    $wishlist   = array_keys($wishlist);

    if(in_array($product_id, $wishlist)){
        return true;
    }else{
        return false;
    }
}

function checkCompareList($product_id){
    $compare   = session()->get('compare')??[];

    $compare   = array_keys($compare);

    if(in_array($product_id, $compare)){
        return true;
    }else{
        return false;
    }
}


function showAvailableStock($pid, $attr)
{
    $a = App\ProductStock::where('product_id', $pid)->where('attributes', $attr)->first();
    if ($a) {
        return $a->quantity;
    }
    return 0;
}

function getProuductAttributes($pid, $aid)
{
    $data = App\AssignProductAttribute::where('status', 1)->where('product_id', $pid)->where('product_attribute_id', $aid)->with(['product', 'productAttribute'])->get();

    return $data;
}


function cartAttributesShow($attributes)
{
    $varients = '';
    $attr_data  =  App\AssignProductAttribute::with('productAttribute')->get();

    foreach ($attributes as $aid) {
        $varients .=  $attr_data->where('id', $aid)->first()->productAttribute->name_for_user . ' : ';
        $varients .= $attr_data->where('id', $aid)->first()->name . '<br>';
    }
    return $varients;
}

function priceAfterAttribute($product, $attributes){

    $base_price = $product->base_price;
    if($product->offer && $product->offer->activeOffer){
        $discount   = calculateDiscount($product->offer->activeOffer->amount, $product->offer->activeOffer->discount_type, $product->base_price);
    }else{
        $discount = 0;
    }

    $attr_data  =  App\AssignProductAttribute::with('productAttribute')->get();
    $varient_Price = 0;
    foreach($attributes as $aid){
        $varient_Price = $varient_Price +  $attr_data->where('id', $aid)->first()->extra_price;
    }
    $final_price = $base_price - $discount + $varient_Price;

    return $final_price;
}


function insertUserToCart($user_id, $session_id)
{
    $cart = App\Cart::where('session_id',$session_id)->get();
    if($cart){
        foreach($cart as $crt){
            $crt->user_id = $user_id;
            $crt->save();
        }
    }
}


function number_format_short( $n) {
    $n_format = 0;
    $suffix = '';
	if ($n > 0 && $n < 1000) {
		// 1 - 999
		$n_format = floor($n);
	} else if ($n >= 1000 && $n < 1000000) {
		// 1k-999k
		$n_format = floor($n / 1000);
		$suffix = 'K+';
	} else if ($n >= 1000000 && $n < 1000000000) {
		// 1m-999m
		$n_format = floor($n / 1000000);
		$suffix = 'M+';
	} else if ($n >= 1000000000 && $n < 1000000000000) {
		// 1b-999b
		$n_format = floor($n / 1000000000);
		$suffix = 'B+';
	} else if ($n >= 1000000000000) {
		// 1t+
		$n_format = floor($n / 1000000000000);
		$suffix = 'T+';
	}


	return [$n_format, $suffix];
}


function paginate($items, $perPage = 5, $page = null,  $options = [])
{
    $page = $page ?: (Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

    $items = $items instanceof Illuminate\Database\Eloquent\Collection ? $items : Illuminate\Database\Eloquent\CollectionCollection::make($items);
    return new Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [

    'path' => Illuminate\Pagination\Paginator::resolveCurrentPath(),
    'pageName' => 'page',

    ]);
}


function productAttributesDetails($attributes)
{
    $variants   = '';
    $attr_data  =  App\AssignProductAttribute::with('productAttribute')->get();
    $variants   = [];
    $extra_price = 0;
    foreach ($attributes as $key=>$aid) {
        $price = $attr_data->where('id', $aid)->first()->extra_price;
        $variants[$key]['name']   =  $attr_data->where('id', $aid)->first()->productAttribute->name_for_user;
        $variants[$key]['value']  = $attr_data->where('id', $aid)->first()->name;
        $variants[$key]['price']  = $price;

        $extra_price += $price;
    }
    $details['variants'] = $variants;
    $details['extra_price'] = $extra_price;

    return $details;
}


function array_flatten($array) {
    if (!is_array($array)) {
      return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $result = array_merge($result, array_flatten($value));
      }
      else {
        $result[$key] = $value;
      }
    }
    return $result;
  }
