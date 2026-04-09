<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, "Unauthorized access. Only admins can view this page.");
        }

        $stats = [
            "users" => User::count(),
            "vendors" => Vendor::count(),
            "items" => Item::count(),
        ];

        $bannersStr = Storage::disk("public")->get("banners.json");
        $banners = json_decode($bannersStr ?? '', true);
        if (!is_array($banners)) {
            $banners = [
                ["title" => "Mega Sale Live!", "subtitle" => "Up to 50% Off on Services", "bg" => "bg-1", "color" => "text-blue-600", "btn_text" => "Book Now", "link" => "/explore", "image" => ""],
                ["title" => "Rent Or Buy", "subtitle" => "Top properties near you", "bg" => "bg-2", "color" => "text-orange-600", "btn_text" => "Explore", "link" => "/one-x-one", "image" => ""],
                ["title" => "100% Verified", "subtitle" => "Trusted professionals on door", "bg" => "bg-3", "color" => "text-emerald-600", "btn_text" => "Hire Now", "link" => "/explore", "image" => ""],
            ];
        }

        $categoriesStr = Storage::disk("public")->get("categories.json");
        $categories = json_decode($categoriesStr ?? '', true);
        if (!is_array($categories)) {
            $categories = [
                ["title" => "Plumber", "link" => "Plumber", "image" => "image/plumber.png"],
                ["title" => "Electrician", "link" => "Electrician", "image" => "image/electrician.png"],
                ["title" => "Cleaner", "link" => "Cleaner", "image" => "image/Cleaner.png"],
                ["title" => "Painter", "link" => "Painter", "image" => "image/Painter.png"],
            ];
        }
        $servicesStr = Storage::disk("public")->get("services.json");
        $services = json_decode($servicesStr ?? '', true);
        if (!is_array($services)) {
            $services = [
                [
                    "title" => "Electrician", "subtitle" => "Khanna, Ludhiana", "price" => "?500",
                    "badge" => "FLAT 20% OFF", "rating" => "5.0", "reviews" => "120 Reviews", "footer" => "GT Road Khanna, Kulesra, Ludhiana - 141401",
                    "link" => "/explore?service=Electrician", "image" => "image/car.jpg"
                ],
                [
                    "title" => "Deep Cleaning", "subtitle" => "Andheri, Mumbai", "price" => "?1200",
                    "badge" => "FLAT 15% OFF", "rating" => "4.8", "reviews" => "85 Reviews", "footer" => "Lokhandwala Complex, Andheri East - 400053",
                    "link" => "/explore?service=Cleaner", "image" => "image/drivers.jpg"
                ]
            ];
        }

        $testimonialsStr = Storage::disk("public")->get("testimonials.json");
        $testimonials = json_decode($testimonialsStr ?? '', true);
        if (!is_array($testimonials)) {
            $testimonials = [
                [
                    "name" => "John Doe", "rating" => "5", "description" => "Excellent service, highly recommended!", "image" => "image/user1.jpg"
                ],
                [
                    "name" => "Jane Smith", "rating" => "4", "description" => "Very good experience, will book again.", "image" => "image/user2.jpg"
                ]
            ];
        }
        return view("admin.dashboard", compact("stats", "banners", "categories", "services", "testimonials"));
    }

    public function updateBanners(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) abort(403);
        $oldBanners = json_decode(Storage::disk("public")->get("banners.json"), true) ?? [];
        $banners = [];
        if ($request->has("banners")) {
            foreach ($request->banners as $index => $data) {
                $imgPath = $oldBanners[$index]["image"] ?? "";
                if ($request->hasFile("banners.$index.image_file")) {
                    $val = $request->file("banners.$index.image_file")->store("banners", "public");
                    if ($val) $imgPath = $val;
                }
                if (!empty($data["title"]) || !empty($imgPath)) {
                    $banners[] = [
                        "title" => $data["title"] ?? "", "subtitle" => $data["subtitle"] ?? "",
                        "bg" => $data["bg"] ?? "bg-1", "color" => $data["color"] ?? "text-blue-600",
                        "btn_text" => $data["btn_text"] ?? "Click Here", "link" => $data["link"] ?? "#",
                        "image" => $imgPath,
                    ];
                }
            }
        }
        Storage::disk("public")->put("banners.json", json_encode($banners, JSON_PRETTY_PRINT));
        return back()->with("success", "Banners updated successfully!");
    }

    public function updateCategories(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) abort(403);
        $oldCategories = json_decode(Storage::disk("public")->get("categories.json"), true) ?? [];
        $categories = [];
        if ($request->has("categories")) {
            foreach ($request->categories as $index => $data) {
                $imgPath = $oldCategories[$index]["image"] ?? "";
                if ($request->hasFile("categories.$index.image_file")) {
                    $val = $request->file("categories.$index.image_file")->store("categories", "public");
                    if ($val) $imgPath = $val;
                }
                if (!empty($data["title"]) || !empty($imgPath)) {
                    $categories[] = [
                        "title" => $data["title"] ?? "",
                        "link" => $data["link"] ?? "",
                        "image" => $imgPath,
                    ];
                }
            }
        }
        Storage::disk("public")->put("categories.json", json_encode($categories, JSON_PRETTY_PRINT));
        return back()->with("success", "Categories updated successfully!");
    }

    public function updateServices(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) abort(403);
        $oldServices = json_decode(Storage::disk("public")->get("services.json"), true) ?? [];
        $services = [];
        if ($request->has("services")) {
            foreach ($request->services as $index => $data) {
                $imgPath = $oldServices[$index]["image"] ?? "";
                if ($request->hasFile("services.$index.image_file")) {
                    $val = $request->file("services.$index.image_file")->store("services", "public");
                    if ($val) $imgPath = $val;
                }
                if (!empty($data["title"]) || !empty($imgPath)) {
                    $services[] = [
                        "title" => $data["title"] ?? "", "subtitle" => $data["subtitle"] ?? "",
                        "price" => $data["price"] ?? "", "badge" => $data["badge"] ?? "",
                        "rating" => $data["rating"] ?? "", "reviews" => $data["reviews"] ?? "",
                        "footer" => $data["footer"] ?? "", "link" => $data["link"] ?? "#",
                        "image" => $imgPath,
                    ];
                }
            }
        }
        Storage::disk("public")->put("services.json", json_encode($services, JSON_PRETTY_PRINT));
        return back()->with("success", "Services updated successfully!");
    }

    public function updateTestimonials(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) abort(403);
        $oldTestimonials = json_decode(Storage::disk("public")->get("testimonials.json"), true) ?? [];
        $testimonials = [];
        if ($request->has("testimonials")) {
            foreach ($request->testimonials as $index => $data) {
                $imgPath = $oldTestimonials[$index]["image"] ?? "";
                if ($request->hasFile("testimonials.$index.image_file")) {
                    $val = $request->file("testimonials.$index.image_file")->store("testimonials", "public");
                    if ($val) $imgPath = $val;
                }
                if (!empty($data["name"]) || !empty($imgPath)) {
                    $testimonials[] = [
                        "name" => $data["name"] ?? "",
                        "rating" => $data["rating"] ?? "",
                        "description" => $data["description"] ?? "",
                        "image" => $imgPath,
                    ];
                }
            }
        }
        Storage::disk("public")->put("testimonials.json", json_encode($testimonials, JSON_PRETTY_PRINT));
        return back()->with("success", "Testimonials updated successfully!");
    }
}
