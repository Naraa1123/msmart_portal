<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\User;
use App\Services\BylPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(BylPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createInvoice(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:100',
            'user_id' => 'required|exists:users,id'
        ]);

        $mpaidAmount = $validatedData['amount'];
        $user = User::findOrFail($validatedData['user_id']);
        $user_payment = $user->payment;
        $totalPaid = $user_payment->fees->sum('paid_amount');
        $remainingAmount = $user_payment->due_amount - $totalPaid;

        $description = $user->school_id;

        if ($mpaidAmount <= $remainingAmount) {
            $invoice = $this->paymentService->createInvoice($mpaidAmount, $description, true);

            if ($invoice['data']['status'] === 'open') {
                Invoice::create([
                    'user_id' => $validatedData['user_id'],
                    'invoice_id' => $invoice['data']['id'],
                    'url' => $invoice['data']['url'],
                    'status' => $invoice['data']['status'],
                    'amount' => $invoice['data']['amount'],
                    'customer_id' => $invoice['data']['customer_id'],
                    'description' => $invoice['data']['description'],
                    'number' => $invoice['data']['number'],
                    'project_id' => $invoice['data']['project_id'],
                    'due_date' => $invoice['data']['due_date']
                ]);

//                return response()->json($invoice);
                return redirect($invoice['data']['url']);

            } else if ($invoice['data']['status'] === 'closed') {
                redirect()->back()->with('error', 'Нэхэмжлэл хаагдсан байна');
            } else {
                redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            return redirect()->back()->with('error', 'Төлж байгаа дүн үлдэгдэл төлбөрөөс их байж болохгүй');
        }
    }


    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $data = json_decode($payload, true);
        $signatureReceived = $request->header('Byl-Signature');

        if ($signatureReceived && $this->isSignatureValid($payload, $signatureReceived)) {
            if (isset($data['type']) && $data['type'] === 'invoice.paid') {
                $invoiceNumber = $data['data']['object']['number'];
                $invoice = Invoice::where('number', $invoiceNumber)->first();
                if ($invoice){
                    if ($invoice->status === 'open') {
                        Fee::create([
                            'payment_id' => $invoice->user->payment->id,
                            'paid_amount' => $data['data']['object']['amount'],
                            'description' => $data['data']['object']['description'],
                            'payment_method' => 'BANK_APP',
                            'paid_date' => now(),
                        ]);
                        $invoice->update([
                            'status' => 'paid'
                        ]);
                        return response()->json(['status' => 'success']);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Invoice not found']);
                }
            }
            else{
                return response()->json(['status' => 'error', 'message' => 'Unsupported event type']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid or missing signature'], 403);
        }
    }

    protected function isSignatureValid($payload, $signatureReceived)
    {
        $secret = env('BYL_HASH_KEY');
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signatureReceived);
    }

}
