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
            'date'  => 'required|date|after_or_equal:today',
            'shift' => 'required|in:day,night',
        ]);

        $available = Booking::isDateAvailable($request->date, $request->shift);
        $bookedCount = Booking::where('event_date', $request->date)
            ->where('booking_shift', $request->shift)
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
            'booker_name'           => 'required|string|max:200',
            'booker_phone'          => 'required|string|max:20',
            'booker_email'          => 'nullable|email|max:100',
            'booker_address'        => 'nullable|string|max:500',
            'booker_nid'            => 'nullable|string|max:30',
            'verification_document' => 'required|file|mimes:jpeg,png,pdf,jpg|max:5120',
            'package_id'            => 'nullable|exists:packages,id',
            'booking_shift'         => 'required|in:day,night',
            'rental_type'           => 'required|in:hall,hall_field',
            'booker_type'           => 'required|in:general,staff,member',
            'event_type'            => 'required|string',
            'event_type_other'      => 'nullable|string|max:100',
            'event_date'            => 'required|date|after_or_equal:today',
            'start_time'            => 'nullable|date_format:H:i',
            'end_time'              => 'nullable|date_format:H:i',
            'guests_count'          => 'nullable|integer|min:1|max:5000',
            'special_requests'      => 'nullable|string|max:1000',
        ]);

        if (!Booking::isDateAvailable($validated['event_date'], $validated['booking_shift'])) {
            return back()->withInput()->withErrors([
                'event_date' => __('site.date_unavailable'),
            ]);
        }

        // Store verification file
        $documentPath = null;
        if ($request->hasFile('verification_document')) {
            $documentPath = $request->file('verification_document')->store('bookings/documents', 'public');
        }

        // Calculate dynamic total price
        $totalAmount = Booking::calculatePrice(
            $validated['booker_type'],
            $validated['booking_shift'],
            $validated['rental_type']
        );

        $booking = Booking::create(array_merge($validated, [
            'reference_number'      => Booking::generateReference(),
            'verification_document' => $documentPath,
            'total_amount'          => $totalAmount,
            'advance_paid'          => 0,
            'status'                => 'pending',
        ]));

        return redirect()->route('booking.confirm', $booking->reference_number);
    }

    public function confirm(string $ref)
    {
        $booking = Booking::where('reference_number', $ref)->firstOrFail();

        return view('booking.confirm', compact('booking'));
    }
}
