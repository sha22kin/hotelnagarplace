<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Hotel rooms shown on the "Rooms" page (page template "Rooms").
 *
 * Stored in `attributes` with type = 20:
 *   name              room title (e.g. "AC ROOM")
 *   short_description intro text under the image
 *   description       features, one per line (shown as a numbered list)
 *   seo_title         button text   (e.g. "Book Now")
 *   seo_description   button link   (e.g. "/book-now")
 *   fetured           crop the image to a square
 *   view              display order
 *   image             media src_type 3 / use_Of_file 1
 *
 * Uses the "pages" role permissions, like the Rooms page itself.
 */
class RoomsController extends Controller
{
    public const TYPE = 20;

    private function can(string $key): bool
    {
        return ! empty(json_decode(Auth::user()->permission->permission ?? '[]', true)['pages'][$key]);
    }

    public function rooms(Request $r)
    {
        if (! $this->can('list')) {
            abort(401);
        }

        // Bulk actions
        if ($r->action) {
            if ($r->checkid) {
                $rooms = Attribute::where('type', self::TYPE)->whereIn('id', $r->checkid)->get();
                foreach ($rooms as $room) {
                    if ($r->action == 1) {
                        $room->status = 'active';
                        $room->save();
                    } elseif ($r->action == 2) {
                        $room->status = 'inactive';
                        $room->save();
                    } elseif ($r->action == 5 && $this->can('delete')) {
                        $this->deleteRoom($room);
                    }
                }
                Session()->flash('success', 'Action Successfully Completed!');
            } else {
                Session()->flash('info', 'Please Need To Select Minimum One Room');
            }

            return redirect()->back();
        }

        $rooms = Attribute::where('type', self::TYPE)->where('status', '<>', 'temp')
            ->where(function ($q) use ($r) {
                if ($r->search) {
                    $q->where('name', 'LIKE', '%'.$r->search.'%');
                }
                if ($r->status) {
                    $q->where('status', $r->status);
                }
            })
            ->orderBy('view')->orderBy('id')
            ->paginate(25)->appends(['search' => $r->search, 'status' => $r->status]);

        $totals = DB::table('attributes')->where('type', self::TYPE)->where('status', '<>', 'temp')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'active' then 1 end) as active")
            ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
            ->first();

        return view(adminTheme().'rooms.roomsAll', compact('rooms', 'totals'));
    }

    public function roomsAction(Request $r, $action, $id = null)
    {
        if ($action == 'create') {
            if (! $this->can('add')) {
                abort(401);
            }
            $room = Attribute::where('type', self::TYPE)->where('status', 'temp')->where('addedby_id', Auth::id())->first()
                ?: new Attribute();
            $room->type = self::TYPE;
            $room->status = 'temp';
            $room->seo_title = $room->seo_title ?: 'Book Now';
            $room->seo_description = $room->seo_description ?: '/book-now';
            $room->view = $room->view ?: ((int) Attribute::where('type', self::TYPE)->where('status', '<>', 'temp')->max('view') + 1);
            $room->addedby_id = Auth::id();
            $room->save();

            return redirect()->route('admin.roomsAction', ['edit', $room->id]);
        }

        $room = Attribute::where('type', self::TYPE)->find($id);
        if (! $room) {
            Session()->flash('error', 'This Room Are Not Found');
            return redirect()->route('admin.rooms');
        }

        if ($action == 'update' && $r->isMethod('post')) {
            if (! $this->can('add')) {
                abort(401);
            }

            $r->validate([
                'name' => 'required|max:191',
                'short_description' => 'nullable|max:2000',
                'description' => 'nullable|max:5000',
                'button_text' => 'nullable|max:100',
                'button_link' => ['nullable', 'max:300', 'regex:#^(/|https?://|tel:|mailto:|\#)#i'],
                'image_alt' => 'nullable|max:200',
                'view' => 'nullable|integer|min:0|max:9999',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            ], [
                'button_link.regex' => 'Button link must start with "/", "https://", "tel:" or "mailto:".',
            ]);

            $room->name = $r->name;
            $room->slug = Str::slug($r->name) ?: (string) $room->id;
            $room->short_description = $r->short_description;
            $room->description = $r->description;
            $room->seo_title = $r->button_text;
            $room->seo_description = $r->button_link;
            $room->view = (int) $r->view;
            $room->fetured = $r->fetured ? 1 : 0;
            $room->status = $r->status ? 'active' : 'inactive';
            $room->editedby_id = Auth::id();
            $room->save();

            if ($r->hasFile('image')) {
                uploadFile($r->image, $room->id, 3, 1, Auth::id());
                $room->unsetRelation('imageFile');
            }
            if ($r->filled('image_alt') && ($media = $room->imageFile()->first())) {
                $media->alt_text = $r->image_alt;
                $media->save();
            }

            Session()->flash('success', 'Your Are Successfully Done');
            return redirect()->back();
        }

        if ($action == 'delete') {
            if (! $this->can('delete')) {
                abort(401);
            }
            $this->deleteRoom($room);

            Session()->flash('success', 'Your Are Successfully Done');
            return redirect()->route('admin.rooms');
        }

        return view(adminTheme().'rooms.roomsEdit', compact('room'));
    }

    private function deleteRoom(Attribute $room): void
    {
        foreach (Media::where('src_type', 3)->where('src_id', $room->id)->get() as $media) {
            // Seeded design images are shared with the gallery; keep the files.
            if (! str_starts_with((string) $media->file_url, 'public/medies/hotel/') && File::exists($media->file_url)) {
                File::delete($media->file_url);
            }
            $media->delete();
        }
        $room->delete();
    }
}
