<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackHandler extends Component
{
    public function mount()
    {
        try {
            $serverKey = config('midtrans.server_key');

            if (empty($serverKey)) {
                throw new \Exception('Midtrans server key is not configured. Please check your .env file');
            }

            Config::$serverKey = $serverKey;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.sanitize');
            Config::$is3ds = config('midtrans.enable_3ds');

            Log::info('Midtrans Configuration Loaded in Livewire Component', [
                'isProduction' => Config::$isProduction,
                'isSanitized' => Config::$isSanitized,
                'is3ds' => Config::$is3ds
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans configuration error in Livewire Component: ' . $e->getMessage());
            // Handle error appropriately, maybe emit an event or set a property
        }
    }

    public function handleMidtransCallback()
    {
        $notif = new Notification();

        DB::beginTransaction();
        try {
            $transaction = $notif->transaction_status;
            $fraud = $notif->fraud_status;
            $orderId = $notif->order_id;
            $paymentType = $notif->payment_type;

            Log::info('Midtrans Callback Received in Livewire Component:', [
                'order_id' => $orderId,
                'transaction_status' => $transaction,
                'fraud_status' => $fraud,
                'payment_type' => $paymentType,
                'raw_callback' => request()->all(), // Access request data using request() helper
            ]);

            $order = Order::where('invoice', $orderId)->first();

            if ($order) {
                if ($transaction == 'settlement') {
                    if ($fraud == 'accept') {
                        $order->update(['status' => 'paid', 'payment_type' => $paymentType]);
                        Log::info("Order {$orderId} set to PAID with payment type: {$paymentType}");
                    } else if ($fraud == 'challenge') {
                        $order->update(['status' => 'pending', 'payment_type' => $paymentType]);
                        Log::warning("Order {$orderId} marked as CHALLENGE with payment type: {$paymentType}");
                    } else if ($fraud == 'deny') {
                        $order->update(['status' => 'failed', 'payment_type' => $paymentType]);
                        Log::error("Order {$orderId} DENIED due to fraud with payment type: {$paymentType}");
                    }
                } else if ($transaction == 'pending') {
                    $order->update(['status' => 'pending', 'payment_type' => $paymentType]);
                    Log::info("Order {$orderId} set to PENDING with payment type: {$paymentType}");
                } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                    $order->update(['status' => 'cancelled', 'payment_type' => $paymentType]);
                    Log::warning("Order {$orderId} set to {$transaction} with payment type: {$paymentType}");
                }

                DB::commit();
                return response('OK', 200);
            } else {
                Log::error("Order with invoice {$orderId} not found in callback (Livewire)");
                DB::rollBack();
                return response('Order Not Found', 404);
            }
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans callback in Livewire: ' . $e->getMessage());
            DB::rollBack();
            return response('Callback Error', 500);
        }
    }

    public function render()
    {
        return view('livewire.midtrans-callback-handler'); // You might not need a view for this
    }
}