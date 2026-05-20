<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\DataGrids\ContactMessageDataGrid;
use Webkul\Cms\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ContactMessageDataGrid::class)->process();
        }

        return view('cms::contact-messages.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $contactMessage = ContactMessage::query()->findOrFail($id);

        Event::dispatch('cms.contact-messages.delete.before', $id);

        $contactMessage->delete();

        Event::dispatch('cms.contact-messages.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.contact-messages.messages.delete-success'),
        ]);
    }
}
