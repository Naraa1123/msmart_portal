<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'ASC')->get();

        $classes = SchoolClass::get()
            ->sort(function ($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.payment.index', compact('payments', 'classes'));
    }

    public function outstanding()
    {
        $payments = Payment::with(['fees'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                $totalPaid = $payment->fees->sum('paid_amount');
                $payment->outstanding = $payment->due_amount - $totalPaid;
                return $payment;
            })->filter(function ($payment) {
                return $payment->outstanding > 0;
            });

        $classes = SchoolClass::get()
            ->sort(function ($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.payment.outstanding_payment', compact('payments', 'classes'));
    }


    public function mpay(Request $request, $id)
    {
        $authUser = Auth::user();

        if ($authUser->role_as == 1) {

            $validatedData = $request->validate([
                'paid_amount' => 'required|numeric|min:100',
                'payment_method' => 'required',
                'description' => 'required|string',
                'paid_date' => 'required',
                'payment_image' => 'nullable|image'
            ]);

            $decryptId = decrypt($id);

            $user_payment = Payment::find($decryptId);

            $mpaidAmount = $validatedData['paid_amount'];

            $totalPaid = $user_payment->fees->sum('paid_amount');
            $remainingAmount = $user_payment->due_amount - $totalPaid;
            $paid_date = $validatedData['paid_date'] ?? now();

            if ($mpaidAmount <= $remainingAmount) {
                if ($request->hasFile('payment_image')) {
                    $file = $request->file('payment_image');
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $ext;
                    $file->move('uploads/payment/transaction/', $filename);
                    $validatedData['payment_image'] = 'uploads/payment/transaction/' . $filename;
                } else {
                    $validatedData['payment_image'] = null;
                }

                Fee::create([
                    'payment_id' => $user_payment->id,
                    'paid_amount' => $validatedData['paid_amount'],
                    'description' => $validatedData['description'],
                    'payment_method' => $validatedData['payment_method'],
                    'payment_image' => $validatedData['payment_image'],
                    'paid_date' => $paid_date
                ]);
            } else {
                return redirect()->back()->with('error', 'Төлсөн утга үлдэгдэл төлбөрөөс их байж болохгүй');
            }


        } else {
            return redirect()->back()->with('message', 'Таньд хэрэглэгч нэмэх эрх байхгүй байна');
        }


        return redirect()->back()->with('message', 'Payment successfully');
    }

}
