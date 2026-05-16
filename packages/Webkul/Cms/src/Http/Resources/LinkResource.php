<?php

namespace Webkul\Cms\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'link'      => $this->link,
            'icon'      => $this->icon,
            'target'    => $this->target,
            'type'      => $this->type,
            'order'     => $this->order,
            'is_active' => $this->is_active,
            'translations' => $this->whenLoaded('translations', fn () =>
                $this->translations->keyBy('locale')->map(fn ($t) => [
                    'name' => $t->name,
                ])
            ),
        ];
    }
}
