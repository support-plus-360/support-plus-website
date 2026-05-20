<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Requests\StoreContactMessageRequest;
use Webkul\Cms\Models\ContactMessage;

class ContactMessageApiController extends Controller
{
    use InteractsWithCompanyDomain;

    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $companyId = (int) $request->validated('company_id');

        // if ($this->isCompanyMismatch($resolvedCompanyId, $companyId)) {
        //     return $this->companyMismatchResponse();
        // }

        $validated = $request->validated();
        $validated['company_id'] = $resolvedCompanyId;

        Event::dispatch('cms.contact-messages.create.before');

        $message = ContactMessage::query()->create( $validated);

        Event::dispatch('cms.contact-messages.create.after', $message);

        return response()->json([
            'message' => trans('cms::app.contact-messages.api.created'),
            'data'    => [
                'id'         => $message->id,
                'company_id' => $message->company_id,
                'created_at' => $message->created_at?->toIso8601String(),
            ],
        ], 201);
    }
}
