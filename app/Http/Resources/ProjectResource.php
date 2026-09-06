<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'signing_location' => $this->signing_location,

            'start_date' => $this->start_date?->format('Y-m-d'),

            'end_date' => $this->end_date?->format('Y-m-d'),

            'incoming_entity' => $this->whenLoaded(
                'incomingEntity',
                function () {
                    return [
                        'id' => $this->incomingEntity->id,
                        'name' => $this->incomingEntity->name,
                        'notes' => $this->incomingEntity->notes,
                    ];
                }
            ),

            'contractor' => $this->whenLoaded(
                'contractor',
                function () {
                    return [
                        'id' => $this->contractor->id,
                        'name' => $this->contractor->name,
                        'phone' => $this->contractor->phone,
                        'national_number' =>
                            $this->contractor->national_number,
                        'birth_date' =>
                            $this->contractor->birth_date?->format('Y-m-d'),
                    ];
                }
            ),

            'pricing_items' => $this->whenLoaded(
                'pricingItems',
                function () {
                    return $this->pricingItems->map(
                        function ($pricingItem) {
                            return [
                                'id' => $pricingItem->id,
                                'name' => $pricingItem->name,
                                'type' => $pricingItem->type,
                                'default_unit' =>
                                    $pricingItem->default_unit,

                                'quantity' =>
                                    $pricingItem->pivot->quantity,

                                'unit_price_syp' =>
                                    $pricingItem->pivot->unit_price_syp,

                                'unit_price_usd' =>
                                    $pricingItem->pivot->unit_price_usd,

                                'specifications' =>
                                    $pricingItem->pivot->specifications,
                            ];
                        }
                    );
                }
            ),

            'created_at' =>
                $this->created_at?->toISOString(),

            'updated_at' =>
                $this->updated_at?->toISOString(),
        ];
    }
}