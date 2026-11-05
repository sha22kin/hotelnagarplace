<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\General;
use App\Models\Media;
use App\Models\Post;
use App\Models\PostAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Loads the Hotel Nagar Palace design content (from the "desing" folder) into
 * the admin-managed tables: site settings, pages, header menu, home slider and
 * gallery. Everything stays editable from the admin panel afterwards.
 *
 *   php artisan db:seed --class=HotelThemeSeeder --force
 *
 * Safe to run more than once (pages are matched by slug, menu/slider/gallery
 * are rebuilt).
 */
class HotelThemeSeeder extends Seeder
{
    private const IMAGES = [
        'norsinde-hotel-bangladesh2.png' => 'norsinde hotel bangladesh2',
        'hotel-nagar-palace.png' => 'hotel nagar palace',
        'norsindi-holel.png' => 'norsindi holel',
        'hotel2.jpg' => 'hotel2',
    ];

    public function run(): void
    {
        DB::transaction(function () {
            $adminId = DB::table('users')->where('admin', 1)->orderBy('id')->value('id');

            $this->settings();
            $pages = $this->pages($adminId);
            $this->menu($pages, $adminId);
            $this->slider($adminId);
            $this->gallery($pages['gallery'], $adminId);
            $this->rooms($adminId);
            $this->servicesAndPackages($adminId);
        });

        General::flushSettings();
    }

    private function settings(): void
    {
        $g = General::query()->first();
        $g->forceFill([
            'title' => 'Hotel Nagar Palace',
            'subtitle' => 'Residential',
            'website' => 'hotelnagarpalace.com',
            'mobile' => '01747641419',
            'email' => 'nagarvelabd@gmail.com',
            'address_one' => '144/6 Shobmeher Tower(2nd Floor)',
            'address_two' => 'Velanagar,Dhaka Bus Stand, Narsingdi',
            'postal_address' => 'Narsingdi, Dhaka, Bangladesh',
            'meta_title' => 'Hotel Nagar Palace in Narsingdi | Residential | Safe | AC/Non AC Room',
            'meta_description' => 'A warm welcome awaits you here at the Hotel Nagar Palace, one of the most convenient and affordable hotels in Narsingdi.',
            'meta_author' => 'Hotel Nagar Palace',
            'facebook_link' => 'https://www.facebook.com/Hotel-Nagar-Palace-Residetial-1997770417180304/',
            'twitter_link' => null,
            'youtube_link' => null,
            'linkedin_link' => null,
            'facebook_page_url' => 'https://www.facebook.com/nagarpalacehotel',
            'youtube_video_url' => 'https://youtu.be/JnCUihgf7WY',
            'google_map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3646.634924113078!2d90.70810821498492!3d23.937978384497246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375431ce77407a8b%3A0xff8f376b15e91403!2sHotel%20Nagar%20Palace!5e0!3m2!1sen!2sbd!4v1584537933749!5m2!1sen!2sbd',
            'copyright_text' => '&copy; 2020 Hotel Nagar Palace. All Rights Reserved. Shared By <a href="https://www.natoreit.com">Natore IT</a>',
            // The design has no logo/favicon image files; it shows the site name instead.
            'logo' => null,
            'footer_logo' => null,
            'favicon' => null,
        ])->save();
    }

    /** @return array<string, Post> */
    private function pages($adminId): array
    {
        $defs = [
            'home' => ['Home', 'Front Page', 'Hotel Nagar Palace in Narsingdi | Residential | Safe | AC/Non AC Room',
                'Hotel Nagar Palace (Residential) in Narsingdi. Call (01747641419) Here AC and non AC rooms are available at reasonable price. the best hotel in Narsingdi city of Bangladesh. Cheap hotel in Narsingdi bd. Narsingdi Hotel. One of the top 10 hotels in Narsingdi . best available hotels near Narsingdi Bangladesh.s Hotel Nagar Palace residential.'],
            'about-us' => ['About Us', 'About Us', null, null],
            'rooms' => ['Rooms', 'Rooms', null, null],
            'services' => ['Services', 'Services', null, null],
            'gallery' => ['Gallery', 'gallery', null, null],
            'book-now' => ['Book Now', 'Book Now', null, null],
        ];

        $pages = [];
        foreach ($defs as $slug => [$name, $template, $seoTitle, $seoDescription]) {
            $page = $template === 'Front Page'
                ? Post::where('type', 0)->where('template', 'Front Page')->first()
                : Post::where('type', 0)->where('slug', $slug)->first();
            $page = $page ?: new Post();

            $page->forceFill([
                'type' => 0,
                'name' => $name,
                'slug' => $slug,
                'template' => $template,
                'description' => File::get(database_path("seeders/hotel/$slug.html")),
                'short_description' => $slug === 'book-now' ? "AC Room\nNon AC Room\nNon AC Single Room" : null,
                'seo_title' => $seoTitle,
                'seo_keyword' => null,
                'seo_description' => $seoDescription ?: 'A warm welcome awaits you here at the Hotel Nagar Palace, one of the most convenient and affordable hotels in Narsingdi.',
                'status' => 'active',
                'addedby_id' => $page->addedby_id ?: $adminId,
            ])->save();

            $pages[$slug] = $page;
        }

        return $pages;
    }

    private function menu(array $pages, $adminId): void
    {
        $menu = Attribute::where('type', 8)->whereNull('parent_id')->where('location', 'Header Menus')->first()
            ?: new Attribute();
        $menu->forceFill(['type' => 8, 'name' => 'Main Menu', 'location' => 'Header Menus', 'status' => 'active', 'addedby_id' => $menu->addedby_id ?: $adminId])->save();

        // Rebuild the items (children and grandchildren).
        $childIds = Attribute::where('type', 8)->where(fn ($q) => $q->where('parent_id', $menu->id)->orWhere('category_id', $menu->id))->pluck('id');
        Attribute::whereIn('parent_id', $childIds)->delete();
        Attribute::whereIn('id', $childIds)->delete();

        // [name, menu_type, page|link]  menu_type: 0 = custom link, 1 = page
        $items = [
            ['Hotel nagar palace', 0, '/'],
            ['About Us', 1, $pages['about-us']],
            ['Rooms', 1, $pages['rooms']],
            ['Services', 1, $pages['services']],
            ['Gallery', 1, $pages['gallery']],
            ['Book Now', 1, $pages['book-now']],
            ['CALL: 01747641419', 0, 'tel:+8801747641419'],
        ];

        foreach ($items as $i => [$name, $type, $target]) {
            $item = new Attribute();
            $item->forceFill([
                'type' => 8,
                'parent_id' => $menu->id,
                'category_id' => $menu->id,
                'name' => $name,
                'menu_type' => $type,
                'slug' => $type === 0 ? $target : null,
                'src_id' => $type === 1 ? $target->id : null,
                'view' => $i,
                'status' => 'active',
                'addedby_id' => $adminId,
            ])->save();
        }
    }

    private function slider($adminId): void
    {
        $slider = Attribute::where('type', 1)->whereNull('parent_id')->where('location', 'Front Page Slider')->first()
            ?: new Attribute();
        $slider->forceFill(['type' => 1, 'name' => 'Home Slider', 'location' => 'Front Page Slider', 'status' => 'active', 'addedby_id' => $slider->addedby_id ?: $adminId])->save();

        // Slides created by an earlier run of this seeder are replaced.
        $seededSlideIds = Media::where('src_type', 3)->where('use_Of_file', 1)->where('file_path', 'like', 'medies/hotel%')
            ->whereIn('src_id', Attribute::where('parent_id', $slider->id)->pluck('id'))->pluck('src_id');
        Media::where('src_type', 3)->where('use_Of_file', 1)->whereIn('src_id', $seededSlideIds)->delete();
        Attribute::whereIn('id', $seededSlideIds)->delete();

        // Other (older) slides are kept but hidden, so nothing is lost.
        Attribute::where('parent_id', $slider->id)->where('type', 1)->update(['status' => 'inactive']);

        $slide = new Attribute();
        $slide->forceFill(['type' => 1, 'parent_id' => $slider->id, 'name' => 'norsinde hotel bangladesh', 'view' => 0, 'status' => 'active', 'addedby_id' => $adminId])->save();

        $this->media('slider', 'norsinde-hotel-bangladesh2.png', $slide->id, 1, $adminId);
    }

    private function gallery(Post $page, $adminId): void
    {
        $gallery = Attribute::where('type', 4)->whereNull('parent_id')->where('location', 'Gallery Page')->first()
            ?: new Attribute();
        $gallery->forceFill(['type' => 4, 'name' => 'Hotel Gallery', 'slug' => 'hotel-gallery', 'location' => 'Gallery Page', 'status' => 'active', 'addedby_id' => $gallery->addedby_id ?: $adminId])->save();

        Media::where('src_id', $gallery->id)->where('src_type', 3)->where('use_Of_file', 3)->delete();
        $i = 0;
        foreach (self::IMAGES as $file => $alt) {
            $this->media('gallery', $file, $gallery->id, 3, $adminId, $alt, $i++);
        }

        // Show exactly this gallery on the Gallery page.
        PostAttribute::where('src_id', $page->id)->where('type', 2)->delete();
        $link = new PostAttribute();
        $link->forceFill(['type' => 2, 'src_id' => $page->id, 'reff_id' => $gallery->id, 'drag' => 0])->save();
    }

    private function servicesAndPackages($adminId): void
    {
        // services.html: "OUR SERVICES" (Admin > Services) and "OUR PACKAGE" (Admin > Packages).
        $services = [
            ['AC Room', 'norsinde-hotel-bangladesh2.png', 'narsingdi hotel', true],
            ['Non-AC Room', 'norsindi-holel.png', 'norsindi holel', false],
            ['Non-Ac Double Room', 'hotel-nagar-palace.png', 'hotel nagar palace', false],
        ];
        $packages = [
            ['AC Room', 'Tk. 1200tk/Day', "Newspaper\nWi-Fi\nVIP Bed, Bathroom\nFood Facility\nAC Room"],
            ['Non AC Room', 'Tk. 700/Day', "Newspaper\nWi-Fi\nVIP Bed, Bathroom\nFood Facility\nNon AC Room"],
            ['AC Double Room', 'Tk. 1600tk/Day', "Newspaper\nWi-Fi\nVIP Bed, Bathroom\nFood Facility\nNon AC  Single Room"],
        ];

        // Replace items created by an earlier run (services: seeded image; packages: all
        // with the seeded names), leave anything added in the admin.
        $seeded = Media::where('src_type', 3)->where('use_Of_file', 1)->where('file_path', 'medies/hotel/services')
            ->whereIn('src_id', Attribute::where('type', 21)->pluck('id'))->pluck('src_id');
        Media::where('src_type', 3)->whereIn('src_id', $seeded)->delete();
        Attribute::whereIn('id', $seeded)->delete();
        Attribute::where('type', 22)->whereIn('name', array_column($packages, 0))->where('addedby_id', $adminId)->delete();

        foreach ($services as $i => [$name, $file, $alt, $square]) {
            $item = new Attribute();
            $item->forceFill([
                'type' => 21, 'name' => $name, 'slug' => \Illuminate\Support\Str::slug($name),
                'fetured' => $square ? 1 : 0, 'view' => $i, 'status' => 'active', 'addedby_id' => $adminId,
            ])->save();
            $this->media('services', $file, $item->id, 1, $adminId, $alt);
        }

        foreach ($packages as $i => [$name, $price, $features]) {
            $item = new Attribute();
            $item->forceFill([
                'type' => 22, 'name' => $name, 'slug' => \Illuminate\Support\Str::slug($name),
                'short_description' => 'PACKAGE', 'seo_title' => $price, 'description' => $features,
                'view' => $i, 'status' => 'active', 'addedby_id' => $adminId,
            ])->save();
        }
    }

    private function rooms($adminId): void
    {
        // The three rooms of the design (rooms.html), editable in Admin > Rooms.
        $rooms = [
            ['AC ROOM', 'norsinde-hotel-bangladesh2.png', 'narsingdi hotel', true,
                'A VIP AC bedroom is good in size. It is usually only large enough to contain a double  bed and a minimal amount of furniture.',
                "Newspaper,Wi-Fi\nVIP Bed, Bathroom,\nFood Facility\nAC Room"],
            ['NON AC ROOM', 'norsindi-holel.png', 'norsindi holel', false,
                'A Non AC bedroom is better in size. It is usually only large enough to contain a double  bed and a minimal amount of furniture.',
                "Newspaper,Wi-Fi\nVIP Bed, Bathroom,\nFood Facility\nNon AC Room"],
            ['NON AC SINGLE ROOM', 'hotel-nagar-palace.png', 'hotel nagar palace', false,
                'A Non AC single bedroom is normally small in size. It is usually only large enough to contain a double  bed and a minimal amount of furniture.',
                "Newspaper,Wi-Fi\nVIP Bed, Bathroom,\nFood Facility\nSingla Non AC Room"],
        ];

        // Replace rooms created by an earlier run of this seeder (identified by
        // their seeded image); rooms added in the admin are left alone.
        $seeded = Media::where('src_type', 3)->where('use_Of_file', 1)->where('file_path', 'medies/hotel/rooms')
            ->whereIn('src_id', Attribute::where('type', 20)->pluck('id'))->pluck('src_id');
        Media::where('src_type', 3)->whereIn('src_id', $seeded)->delete();
        Attribute::whereIn('id', $seeded)->delete();

        foreach ($rooms as $i => [$name, $file, $alt, $square, $intro, $features]) {
            $room = new Attribute();
            $room->forceFill([
                'type' => 20,
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'short_description' => $intro,
                'description' => $features,
                'seo_title' => 'Book Now',
                'seo_description' => '/book-now',
                'fetured' => $square ? 1 : 0,
                'view' => $i,
                'status' => 'active',
                'addedby_id' => $adminId,
            ])->save();

            $this->media('rooms', $file, $room->id, 1, $adminId, $alt);
        }
    }

    private function media(string $folder, string $file, int $srcId, int $use, $adminId, ?string $alt = null, int $drag = 0): Media
    {
        // Each section gets its own copy: replacing an image in the admin deletes the old file.
        $dir = public_path('medies/hotel/'.$folder);
        File::ensureDirectoryExists($dir);
        $dest = $dir.'/'.$file;
        if (! File::exists($dest)) {
            File::copy(public_path('hotel/images/'.$file), $dest);
        }

        $media = new Media();
        $media->forceFill([
            'src_type' => 3,
            'use_Of_file' => $use,
            'src_id' => $srcId,
            'file_name' => $file,
            'alt_text' => $alt ?: pathinfo($file, PATHINFO_FILENAME),
            'file_rename' => $file,
            'file_size' => File::size($dest),
            'mine_type' => File::mimeType($dest),
            'file_type' => 1,
            'file_url' => 'public/medies/hotel/'.$folder.'/'.$file,
            'file_path' => 'medies/hotel/'.$folder,
            'drag' => $drag,
            'addedby_id' => $adminId,
        ])->save();

        return $media;
    }
}
