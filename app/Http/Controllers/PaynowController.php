<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Paynow\Payments\Paynow;

class PaynowController extends Controller
{
    public function checkout($pollUrl = "")
    {
        try {
            $paynow = new Paynow(env('PAYNOW_INTEGRATION_ID'), env('PAYNOW_INTEGRATION_KEY'), 'http://127.0.0.1:8000/$pollUrl', 'http://127.0.0.1:8000/user/getcart/$pollUrl');

            $payment =  $paynow->createPayment('Invoice 31', 'chemhuru.panashe@gmail.com');
            $cartlist = Cart::where('uuid', Auth::user()->uuid)->get();
            // Add cart items to payment
            foreach ($cartlist as $cartitem) {
                $onsale = Sale::where('game_id', $cartitem['productId'])->first();
                $price = !empty($onsale)
                    ? $onsale->new_price * $cartitem['productQuantity']
                    : Product::where('id', $cartitem['productId'])->value('price') * $cartitem['productQuantity'];

                $payment->add($cartitem->productName, $price);
            }

            $response = $paynow->send($payment);
            if ($response->success()) {
                // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
                $link = $response->redirectUrl();
                // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
                $pollUrl = $response->pollUrl();
                $this->generateInvoice($cartlist);
                return redirect()->to($link)->with('pollUrl', $pollUrl);
            }
            return redirect()->route('welcome')->with('message', 'Payment initialization failed.');
        } catch (Exception $error) {
            return redirect()->to('welcome')->with('message', $error->getMessage());
        }
    }

    private function generateInvoice($cartlist)
    {
        $invoicedetails = [];
        $sum = 0;

        foreach ($cartlist as $cartitem) {
            $onsale = Sale::where('game_id', $cartitem['productId'])->first();
            $price = !empty($onsale)
                ? $onsale->new_price * $cartitem['productQuantity']
                : Product::where('id', $cartitem['productId'])->value('price') * $cartitem['productQuantity'];

            $sum += $price;

            $invoicedetails[] = [
                'productName' => $cartitem->productName,
                'productQuantity' => $cartitem->productQuantity,
                'price' => $price,
            ];
        }

        Invoice::create([
            'uuid' => Auth::user()->uuid,
            'invoice_total' => $sum,
            'item_details' => json_encode($invoicedetails),
        ]);

        // Clear the cart
        Cart::where('uuid', Auth::user()->uuid)->delete();
    }
}
