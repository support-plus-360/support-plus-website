<?php

namespace Webkul\Cms\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'type'      => $this->type,
            'order'     => $this->order,
            'is_active' => $this->is_active,
            'settings'  => $this->settings,
            'main_image_url' => $this->getFirstMediaUrl('main_media') ?: null,
            'translations' => $this->whenLoaded('translations', fn () =>
                $this->translations->keyBy('locale')->map(fn ($t) => [
                    'title'     => $t->title,
                    'sub_title' => $t->sub_title,
                    'content'   => $t->content,
                    'icon'      => $t->icon,
                ])
            ),
            'links' => LinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
