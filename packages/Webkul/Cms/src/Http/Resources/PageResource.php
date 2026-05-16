<?php

namespace Webkul\Cms\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'slug'         => $this->slug,
            'name'         => $this->name,
            'type'         => $this->type,
          //   'status'       => $this->status,
            'order'        => $this->order,
          //   'is_active'    => $this->is_active,
          //   'published_at' => $this->published_at?->toIso8601String(),
          //   'author_id'    => $this->author_id,
          //   'company_id'   => $this->company_id,
            'translations' => $this->whenLoaded('translations', fn () =>
                $this->translations->keyBy('locale')->map(fn ($t) => [
                    'title'            => $t->title,
                    'meta_description' => $t->meta_description,
                    'meta_keywords'    => $t->meta_keywords,
                ])
            ),
            'sections' => SectionResource::collection($this->whenLoaded('sections')),
            'links'    => LinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
