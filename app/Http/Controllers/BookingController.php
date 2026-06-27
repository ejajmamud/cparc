<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $packages    = Package::where('is_active', true)->orderBy('sort_order')->get();
        $selectedPkg = $request->query('package');

        return view('booking.form', compact('packages', 'selectedPkg'));
    }

    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'date'       => 'required|date|after_or_equal:today',
            'package_id' => 'required|exists:packages,id',
        ]);

        $available = Booking::isDateAvailable($request->date, $request->package_id);
        $bookedCount = Booking::where('event_date', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return response()->json([
            'available'   => $available,
            'booked_slots'=> $bookedCount,
            'message'     => $available
                ? __('site.date_available')
                : __('site.date_unavailable'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booker_name'     => 'required|string|max:200',
            'booker_phone'    => 'required|string|max:20',
            'booker_email'    => 'nullable|email|max:100',
            'booker_address'  => 'nullable|string|max:500',
            'booker_nid'      => 'nullable|string|max:30',
            'package_id'      => 'required|exists:packages,id',
            'event_type'      => 'required|string',
            'event_type_other'=> 'nullable|string|max:100',
            'event_date'      => 'required|date|after_or_equal:today',
            'start_time'      => 'nullable|date_format:H:i',
            'end_time'        => 'nullable|date_format:H:i',
            'guests_count'    => 'nullable|integer|min:1|max:5000',
            'special_requests'=> 'nullable|string|max:1000',
        ]);

        if (!Booking::isDateAvailable($validated['event_date'], $validated['package_id'])) {
            return back()->withInput()->withErrors([
                'event_date' => __('site.date_unavailable'),
            ]);
        }

        $package = Package::findOrFail($validated['package_id']);

        $booking = Booking::create(array_merge($validated, [
            'reference_number' => Booking::generateReference(),
            'total_amount'     => $package->price,
            'status'           => 'pending',
        ]));

        return redirect()->route('booking.confirm', $booking->reference_number);
    }

    public function confirm(string $ref)
    {
        $booking = Booking::with('package')
            ->where('reference_number', $ref)
            ->firstOrFail();

        return view('booking.confirm', compact('booking'));
    }
}
