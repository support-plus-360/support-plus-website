<?php

namespace Webkul\Cms\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Cms\Services\NavMenuTreeBuilder;

class NavMenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = $this->whenLoaded('items');

        $tree = [];

        if ($items) {
            $tree = app(NavMenuTreeBuilder::class)->build($items);
        }

        return [
            'id'         => $this->id,
            'key'        => $this->key,
            'name'       => $this->name,
            'company_id' => $this->company_id,
            'items'      => $tree,
        ];
    }
}
