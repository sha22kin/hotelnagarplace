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
 * Admin lists for the hotel "Services" page:
 *
 *   services  (attributes.type = 21)  name, image, fetured = square crop, view = order
 *   packages  (attributes.type = 22)  name (room), short_description = box heading ("PACKAGE"),
 *                                     seo_title = price text, description = features (one per line)
 *
 * Shown on the page with template "Services" where its content has [services] / [packages].
 * Uses the "pages" role permissions (same as Rooms).
 */
class HotelItemsController extends Controller
{
    public const KINDS = [
        'services' => ['type' => 21, 'single' => 'Service', 'plural' => 'Services', 'route' => 'hotelServices', 'image' => true],
        'packages' => ['type' => 22, 'single' => 'Package', 'plural' => 'Packages', 'route' => 'packages', 'image' => false],
    ];

    private function can(string $key): bool
    {
        return ! empty(json_decode(Auth::user()->permission->permission ?? '[]', true)['pages'][$key]);
    }

    private function kind(string $kind): array
    {
        abort_unless(isset(self::KINDS[$kind]), 404);
        return self::KINDS[$kind] + ['key' => $kind];
    }

    public function services(Request $r) { return $this->index($r, 'services'); }
    public function servicesAction(Request $r, $action, $id = null) { return $this->action($r, 'services', $action, $id); }
    public function packages(Request $r) { return $this->index($r, 'packages'); }
    public function packagesAction(Request $r, $action, $id = null) { return $this->action($r, 'packages', $action, $id); }

    private function index(Request $r, string $key)
    {
        $kind = $this->kind($key);
        abort_unless($this->can('list'), 401);

        if ($r->action) {
            if ($r->checkid) {
                foreach (Attribute::where('type', $kind['type'])->whereIn('id', $r->checkid)->get() as $item) {
                    if ($r->action == 1) {
                        $item->status = 'active';
                        $item->save();
                    } elseif ($r->action == 2) {
                        $item->status = 'inactive';
                        $item->save();
                    } elseif ($r->action == 5 && $this->can('delete')) {
                        $this->deleteItem($item);
                    }
                }
                Session()->flash('success', 'Action Successfully Completed!');
            } else {
                Session()->flash('info', 'Please Need To Select Minimum One '.$kind['single']);
            }

            return redirect()->back();
        }

        $items = Attribute::where('type', $kind['type'])->where('status', '<>', 'temp')
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

        $totals = DB::table('attributes')->where('type', $kind['type'])->where('status', '<>', 'temp')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'active' then 1 end) as active")
            ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
            ->first();

        return view(adminTheme().'hotel-items.itemsAll', compact('items', 'totals', 'kind'));
    }

    private function action(Request $r, string $key, $action, $id)
    {
        $kind = $this->kind($key);
        $editRoute = 'admin.'.$kind['route'].'Action';

        if ($action == 'create') {
            abort_unless($this->can('add'), 401);
            $item = Attribute::where('type', $kind['type'])->where('status', 'temp')->where('addedby_id', Auth::id())->first()
                ?: new Attribute();
            $item->type = $kind['type'];
            $item->status = 'temp';
            if ($key === 'packages' && ! $item->short_description) {
                $item->short_description = 'PACKAGE';
            }
            $item->view = $item->view ?: ((int) Attribute::where('type', $kind['type'])->where('status', '<>', 'temp')->max('view') + 1);
            $item->addedby_id = Auth::id();
            $item->save();

            return redirect()->route($editRoute, ['edit', $item->id]);
        }

        $item = Attribute::where('type', $kind['type'])->find($id);
        if (! $item) {
            Session()->flash('error', 'This '.$kind['single'].' Are Not Found');
            return redirect()->route('admin.'.$kind['route']);
        }

        if ($action == 'update' && $r->isMethod('post')) {
            abort_unless($this->can('add'), 401);

            $rules = [
                'name' => 'required|max:191',
                'view' => 'nullable|integer|min:0|max:9999',
            ];
            if ($kind['image']) {
                $rules += [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                    'image_alt' => 'nullable|max:200',
                ];
            } else {
                $rules += [
                    'heading' => 'nullable|max:100',
                    'price' => 'nullable|max:100',
                    'description' => 'nullable|max:5000',
                ];
            }
            $r->validate($rules);

            $item->name = $r->name;
            $item->slug = Str::slug($r->name) ?: (string) $item->id;
            $item->view = (int) $r->view;
            $item->status = $r->status ? 'active' : 'inactive';
            $item->editedby_id = Auth::id();
            if ($kind['image']) {
                $item->fetured = $r->fetured ? 1 : 0;
            } else {
                $item->short_description = $r->heading;
                $item->seo_title = $r->price;
                $item->description = $r->description;
            }
            $item->save();

            if ($kind['image'] && $r->hasFile('image')) {
                uploadFile($r->image, $item->id, 3, 1, Auth::id());
            }
            if ($kind['image'] && $r->filled('image_alt') && ($media = $item->imageFile()->first())) {
                $media->alt_text = $r->image_alt;
                $media->save();
            }

            Session()->flash('success', 'Your Are Successfully Done');
            return redirect()->back();
        }

        if ($action == 'delete') {
            abort_unless($this->can('delete'), 401);
            $this->deleteItem($item);

            Session()->flash('success', 'Your Are Successfully Done');
            return redirect()->route('admin.'.$kind['route']);
        }

        return view(adminTheme().'hotel-items.itemsEdit', compact('item', 'kind'));
    }

    private function deleteItem(Attribute $item): void
    {
        foreach (Media::where('src_type', 3)->where('src_id', $item->id)->get() as $media) {
            if (File::exists($media->file_url)) {
                File::delete($media->file_url);
            }
            $media->delete();
        }
        $item->delete();
    }
}
