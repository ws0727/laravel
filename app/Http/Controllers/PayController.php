<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
      public function __construct()
    {
        
       $this->middleware('auth:api', ['except' => ['notify','return']]);
        //构造函数，过滤login
    }

    protected $config = [
        'alipay' => [
            'app_id' => '2016101000655071',
            'notify_url' => 'http://localhost/laravel/laravel/public/api/pay/notify',
            'return_url' => 'http://localhost/laravel/laravel/public/api/pay/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmER6HkA52W1wxLnsV91MUBAhfqO9h79DP9o1tnqQAfOxfOayQOfEBphf3Bt2LxD/6ssHO+U7cgi4xAO6CQANJWQGUozoB/6CKeebTXFyCh6DB1+u+Ao8cPkTXN34IcCyELD1hgK8mSI+jUAE/hqRHxWvwS6tGyD3OAweUyfFyC40C3GipXFLBlCrgyIMnOY8EwPzKH7WFKQVahQak1ulmxNUTWgyb605EoeSbzMn+mXNlMr7DD4gTVmXqIQ2bRFBmEsTwwh+ZpoYPcUcsm7LWf1yT6ZRg9o/+p1MH9en0lTffw+H9L/Y4XYErNv1kdI8a/qiCYkrPcKL9vk00EDZkQIDAQAB',
            'private_key' => 'MIIEpAIBAAKCAQEAwAd51WfAMqo+Wa4M/eMGrGceBprVN9T6XZ/mLfdfs+NEsskA2nrqFJxNjoZIlL3luLLeObaFm0JxLolWjQURmMSh1KykXUowF4jfw4xWTntFrcrAMWvrh+djn3kk1gDxoxbsCPElFm4gEB5131KltxsdW4JYU4Vj687cDSME/jFrGeOt0X8ElvFk5w0ruUGszgZ+jxRC5kG11XRNR871Bke/xW1eQR4VlXUUqPx8gOfsv/c5mFODp+9yV6vANoFqQpDnn4iTCrUucferVc/7Zkhb92cFR79dunD7rCmSU0J79sJhFbVz/25kyyE4f/vzmZNjBwu2ok3WbIuFPwT4HQIDAQABAoIBAQCY6NsRHe6j6YCAtOHPgWoc+nekVsKWFNfQmbUWwTbJ7Z0UqI4va1TeWKBBb5h4KMa2Tmg6mKbHPR8XKXFsFa8vcNRUn6y6RIsLEojsE+Hd2LdhbmOgdwk0TQK9SCAW8OV5MpV9gVhBBiwt6bN+wzcGGWdFKQPgbgVlDnGXXF1rctcBjWaq4Y7YNtzgdaPw/HQNY2nIbJDHyZ6oLVz+vaRyEqWA/RBBeBTNDLPutU85Dn3z9f5nL3f32hkUq8qSYTfdFaiKhxV9PKswN8WprcfK8Bbd05JpS+25Wb6ao/wDS8b7IW70hZu30ZF94YRK+mgodlJm7GCFVMpVVdtL0KgZAoGBAPlor4mtdBlEgD14GOiOJaeOdHoQzWWnj4LTo/Xcnk+/rgV5dhxgJc/t659doyRAr9V7fcZTdrH/qYbOKPf/afK2Megrss2rorCGSD7G1ikTKZB8Cisw6fIU64aGRFRAQcd/SJumTKmdd5ZaJ1YYnYV94CD6dTUQxx7EfHH0B6NfAoGBAMUamhY6MeZg3Z6pJpxbkHkCgktjh7ggwDKMBass23NKMh///vt7WF6+3r2sZNf4LYn+7I/IscWubKFDfq9N2DQ+MuspjCsXQ6mu9bsPOpE+kRM2AZQVQJ72QlciVMf96PX4f7dgTCum/4qozlAHt6f4NhWRzHW6WnshpXxSarIDAoGBAOED0LM++Wq+gZBzpM1TSaeU/4MNW7Il7XUT6m4r/+xlO+SWg7fwCs1Akv7x5PkVH05UntHqhUDsLw9/Ojkch4LBW99iZWvnON1YGSACFj9ymWJQdoAnHjoZI7D3u/fjDTWmoWREMhApEDZm2ex0QtGoEijOriYVIACjNr88chOzAoGAFjm/sk3xnobBtshgIDV6/wo3YwTgIvUedxSu9vRh8oglStJ1ECqCdnyTZVPxMyE7EVp7lmMNGLtoaG7R9DaU8J8q4rWWpq1C5flioCtBcWtatI3cc7RJyyL9rBGk+cA56rKQxD7JmAqGuj36ta+JGBm3D4uXQJc46LWMkY5Blb0CgYBMw6Wrl5ccR68pLqbhemMuUOO7UGsJCo5WQvDWyjAQ8JnX/xrhbd3YXnr4iEktYiH/tMpgLE/r8kM2T7Cb4w46euFVLnxJFb/ouaQhGnBfM+mOrdHvlI3ypNf2iaXDstZl9xVVWFtpuunvvORBv2KWHzpW/A+XydSwKGPBCeUUkw==',
        ],
    ];

    public function index(Request $request)
    {
        $order_id=$request->input('id');
        $arr=DB::select("select price from order_x where order_id='$order_id'");
        $price=0;
          foreach ($arr as $key => $value) {
                $price+=$value->price;
          }
        $config_biz = [
            'out_trade_no' =>$order_id,
            'total_amount' =>$price,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        $arr=$pay->driver('alipay')->gateway()->verify($request->all());
         
         $aa=$arr['out_trade_no'];
         $bb=$arr['total_amount'];
         $cc=$arr['timestamp'];
         header("location:http://localhost:8080/#/Buytree?order_id=$aa&price=$bb&time=$cc");

        
        return $pay->driver('alipay')->gateway()->verify($request->all());
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}



  