<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResourcse;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    public function index() {
        $packages = Package::all();
        $features = Feature::where('active', true)->get();

        return inertia('Credit/Index', [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResourcse::collection($features),
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function buyCredits(Package $package) {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $check_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency'=> 'usd',
                        'product_data'=> [
                            'name' => $package->name . ' - ' . $package->credits . ' credits',
                        ],
                        'unit_amount' => $package->price * 100,
                    ],
                    'quantity'=> 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('credit.success', [], true),
            'cancel_url' => route('credit.success', [], true),
        ]);

        Transaction::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $check_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package->id,

        ]);

        return redirect($check_session->url);
    }

    public function success()
    {
        return to_route('credit.index')->with('success', 'You have successfully purchase new credit');
    }

    public function cancel()
    {
        return to_route('credit.index')->with('error', 'Error processing your payment, Please try again later.');
    }

    public function webhook()
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try{
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret,
            );
        } catch(\UnexpectedValueException $e) {
           return response('', 400);
        
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('', 400);
        }

        switch($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $transaction = Transaction::where('session_id', $session->id)->first();

                if($transaction && $transaction->status === 'pending') {
                    $transaction->status = 'paid';
                    $transaction->save();

                    $transaction->user->available_credits += $transaction->credits;
                    $transaction->user->save();
                }


            default:
                echo 'Receive Unknown even type ' . $event->type;
        }
        return response('');
    }
}
