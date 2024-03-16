<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    private $rules = [
        'cashier' => ['required', 'integer'],
        'start' => ['required', 'integer'],
        'end' => ['required', 'integer'],
    ];

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $report): Response
    {
        $validator = Validator::make($request->query(), $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ]);
        }

        $cashier = $request->query('cashier');
        $start = Carbon::createFromTimestamp($request->query('start'));
        $end = Carbon::createFromTimestamp($request->query('end'));

        $data = match ($report) {
            'closeout' => $this->generateCloseoutReport($cashier, $start, $end),
            'payment' => $this->generatePaymentReport($cashier, $start, $end)
        };

        return response(['data' => $data], 200);
    }

    /**
     * @param  int  $cashier
     * @param  Carbon  $start
     * @param  Carbon  $end
     * @return array
     */
    function generateCloseoutReport(int $cashier, Carbon $start, Carbon $end): array
    {
        $filters = [
            ["created_at", ">=", $start],
            ["created_at", "<=", $end],
        ];

        if ($cashier != "0") {
            $filters[] = ["cashier_id", $cashier];
        }

        $payments = DB::table("payments")->select('id', 'cashier_id', 'method_id', 'total', 'refunded')
            ->where($filters)
            ->orderBy("id")
            ->get();

        $cashiers = DB::table("users")
            ->select('id', 'firstname', 'lastname')
            ->whereIn("id", array_unique($payments->pluck("cashier_id")->all()))
            ->get();

        $payment_methods = DB::table("payment_methods")
            ->select('id', 'name', 'type')
            ->whereIn("id", array_unique($payments->pluck("method_id")->all()))
            ->get();

        $data = [];

        foreach ($cashiers as $cashier) {
            $items = [];
            $transactions = $payments->where('cashier_id', $cashier->id);

            foreach ($payment_methods->pluck("type")->unique() as $type) {
                $filtered_payments = $transactions->whereIn('method_id',
                    $payment_methods->where('type', $type)->pluck('id')->all());

                if ($filtered_payments->where('refunded', false)->count() > 0) {
                    $items[] = [
                        "method" => $type,
                        "transactions" => $filtered_payments->where('refunded', false)->count(),
                        "amount" => number_format($filtered_payments->where("refunded", false)->sum("total"), 2),
                    ];
                }

                if ($filtered_payments->where('refunded', true)->count() > 0) {
                    $items[] = [
                        "method" => "$type (refund)",
                        "transactions" => $filtered_payments->where('refunded', true)->count(),
                        "amount" => number_format($filtered_payments->where("refunded", true)->sum("total"), 2),
                    ];
                }
            }

            $data[] = [
                "cashier" => "$cashier->firstname $cashier->lastname",
                "items" => $items,
                "transactions" => $transactions->count(),
                "total" => number_format($transactions->where('refunded', false)->sum("total"), 2),
            ];
        }

        return [
            "start" => $start,
            "end" => $end,
            "report" => $data,
            "transactions" => $payments->count(),
            "total" => number_format($payments->where("refunded", false)->sum("total"), 2),
        ];
    }

    /**
     * @param  int  $cashier
     * @param  Carbon  $start
     * @param  Carbon  $end
     * @return array
     */
    function generatePaymentReport(int $cashier, Carbon $start, Carbon $end): array
    {
        $filters = [
            ['created_at', '>=', $start],
            ['created_at', '<=', $end],
        ];

        if ($cashier != 0) {
            $filters[] = ['cashier_id', $cashier];
        }

        $payments = DB::table('payments')->where($filters)->orderBy('id')->get();

        $methods = DB::table('payment_methods')->orderBy('id')->get();

        $sales = DB::table('sales')->select('id', 'customer_id')->get();

        $users = DB::table("users")
            ->select('id', 'firstname', 'lastname')
            ->whereIn("id", array_merge(array_unique($payments->pluck("cashier_id")->all()),
                array_unique($sales->pluck("customer_id")->all())))
            ->get();

        $report = [];

        foreach ($users->whereIn("id", array_unique($payments->pluck("cashier_id")->all())) as $cashier) {
            $data = [
                "cashier" => "$cashier->firstname $cashier->lastname",
                "totals" => number_format($payments->where("cashier_id", $cashier->id)->where("refunded",
                    false)->sum("total"), 2)
            ];

            foreach ($payments->where("cashier_id", $cashier->id) as $payment) {
                $customer_id = $sales->where("id", $payment->sale_id)->first()->customer_id;
                $customer = $users->where("id", $customer_id)->first();
                $method = $methods->where('id', $payment->method_id)->first();
                $data["transactions"][] = [
                    "created_at" => $payment->created_at,
                    "sale_id" => $payment->sale_id,
                    "reference" => $payment->reference,
                    "tendered" => $payment->tendered,
                    "change" => $payment->change_due,
                    "amount" => $payment->total,
                    "customer" => "$customer->firstname $customer->lastname",
                    "refunded" => $payment->refunded,
                    "cashier" => "$cashier->firstname $cashier->lastname",
                    "method" => "$method->name"
                ];
            }

            $report[] = $data;
        }

        return [
            "start" => $start,
            "end" => $end,
            "report" => $report,
            "totals" => number_format($payments->where("refunded", false)->sum("total"), 2)
        ];
    }

}
