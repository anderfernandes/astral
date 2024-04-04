<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $validator = Validator::make($this->input(), $this->rules());

        if ($validator->fails()) {
            return false;
        }

        if ($this->has('products')) {
            for ($i = 0; $i < count($this->input('products')); $i++) {
                $id = $this->input('products')[$i]['id'];
                $product = (new \App\Models\Product())->find($id);

                if ($product === null || $product->price === null) {
                    return false;
                }

                $this->merge(['products.'.$i.'price' => $product->price]);
            }
        }

        if ($this->has('tickets')) {
            for ($i = 0; $i < count($this->input('tickets')); $i++) {
                $type_id = $this->input('tickets')[$i]['type_id'];
                $ticket_type = (new \App\Models\TicketType())->find($type_id);

                if ($ticket_type === null || $ticket_type->price === null) {
                    return false;
                }

                $this->merge(['tickets'.$i.'price' => $ticket_type->price]);
            }
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "tickets.*.type_id" => ["integer"],
            "tickets.*.event_id" => ["integer"],
            "tickets.*.quantity" => ["integer"],
            "products.*.id" => ["integer"],
            "products.*.quantity" => ["integer"],
            "organization_id" => ["integer", "nullable"],
            "customer_id" => ["required", "integer"],
            "tendered" => ["numeric", "nullable"],
            "method_id" => ["integer"],
            "reference" => ["min:2", "max:8", "nullable"],
            "taxable" => ["boolean", "nullable"]
        ];
    }
}
