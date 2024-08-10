<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tickets = [];
        $products = [];
        
        $unique_tickets = $this->tickets->unique(function ($item) {
            return $item['type_id'].$item['event_id'];
        })->all();
        
        if ($this->tickets->count() > 0) {
            foreach ($unique_tickets as $ticket) {
                $tickets[] = [
                    'type_id' => $ticket['type_id'],
                    'type' => [ 'name' => $ticket['type']['name'] ],
                    'event_id' => $ticket['event_id'],
                    'quantity' => $this->tickets->where('type_id', $ticket['type_id'])->where('event_id', $ticket['event_id'])->count(),
                ];
            }
        };
        
        if ($this->products->count() > 0) {
            foreach ($this->products->unique('id') as $product) {
                $products[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'type' => [ 'name' => $product['type']['name'] ],
                    'quantity' => $this->products->where('id', $product['id'])->count()
                ];
            }
        }
        
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total' => $this->total,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
            'customer' => [
                'id' => $this->customer_id,
                'name' => "{$this->customer->firstname} {$this->customer->lastname}"
            ],
            'creator' => [
                'id' => $this->creator_id,
                'name' => "{$this->creator->firstname}"
            ],
            'events' => $this->events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'type_id' => $event->type_id,
                    'type' => [ 'name' => $event->type->name ],
                    'show' => [
                        'id' => $event->show_id,
                        'name' => $event->show->name,
                        'type_id' => $event->show->type_id,
                        'cover' => $event->show->cover,
                        'type' => ['name' => $event->show->type_id == 1 ? 'Laser Light' : 'Planetarium']
                    ]
                ];
            }),
            'tickets' => $tickets,
            'products' => $products,
            'memos' => $this->memos->count(),
            'payments' => $this->payments->count(),
            'paid'
        ];
    }
}
