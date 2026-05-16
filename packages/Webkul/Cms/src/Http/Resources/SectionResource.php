<?php

namespace Webkul\Cms\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'section_layout' => $this->section_layout,
            'order'          => $this->order,
            'is_active'      => $this->is_active,
            'settings'       => $this->settings,
            'main_image_url' => $this->getFirstMediaUrl('main_media') ?: null,
            'translations' => $this->whenLoaded('translations', fn () =>
                $this->translations->keyBy('locale')->map(fn ($t) => [
                    'title'       => $t->title,
                    'subtitle'    => $t->subtitle,
                    'description' => $t->description,
                ])
            ),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'links' => LinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
