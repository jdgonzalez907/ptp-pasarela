<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Checkout;
use App\Helpers\PlaceToPayHelper;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkouts = Checkout::orderBy('id', 'DESC')->take(5)->get();
        
        return view('checkout.index', compact('checkouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('checkout.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'document' => 'required',
            'documentType' => 'required|max:2',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|max:50',
            'address' => 'required|max:50',
            'city' => 'required|max:50',
            'description' => 'required|max:150',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
            'accepted' => 'accepted'
        ]);
        $currentDate = date('Y-m-d H:i:s');
        $expiration = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime($currentDate)));
        
        $validatedData['reference'] = Str::uuid();
        $validatedData['expiration'] = $expiration;        
        
        $checkout = Checkout::create($validatedData);
        $validatedData['id'] = $checkout->id;
        $validatedData['ipAddress'] = $request->ip();
        $validatedData['userAgent'] = $request->server('HTTP_USER_AGENT');
        
        $ptp = new PlaceToPayHelper();
        $jsonResponse = $ptp->sendPayment($validatedData);

        // echo "<pre>";print_r($jsonResponse);exit;
        
        if ($jsonResponse) {
            $checkout->requestId = $jsonResponse->requestId;
            $checkout->save();
            return redirect($jsonResponse->processUrl);
        }
    }

    public function callback($id)
    {
        $checkout = Checkout::find($id);
        $checkoutInfo = [
            "requestId" => $checkout->requestId
        ];

        $ptp = new PlaceToPayHelper();

        $jsonResponse = $ptp->obtainPayment($checkoutInfo);

        $checkout->status = $jsonResponse->status->status;
        $checkout->authorization = $jsonResponse->payment[count($jsonResponse->payment) - 1]->authorization;
        $checkout->franchise = $jsonResponse->payment[count($jsonResponse->payment) - 1]->paymentMethod;
        $checkout->bank = $jsonResponse->payment[count($jsonResponse->payment) - 1]->paymentMethodName;
        $checkout->reason = $jsonResponse->payment[count($jsonResponse->payment) - 1]->status->message;
        $checkout->updated_at = strtotime($jsonResponse->status->date);
        $checkout->save();
        
        // echo "<pre>";print_r($jsonResponse);exit;

        return view('checkout.callback', compact('checkout'));
    }

    public function notification($id, Request $request)
    {
        $checkout = Checkout::find($id);
        $ptp = new PlaceToPayHelper();
        $data = json_decode($request->getContent(), true);
        $codeVerification = sha1($checkout->requestId.$data['status']['status'].$data['status']['date'].$ptp->secretKey);
        if ($codeVerification == $data['signature']) {
            Log::debug($id . ' ' . 'entro '.$codeVerification. ' - '.$data['signature']);
            echo "Hola";
        } else {
            Log::debug($id . ' ' . 'mmm:C '.$codeVerification. ' - '.$data['signature']);
            echo "no hol";
        }
        // echo "<pre>";print_r(dd($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
