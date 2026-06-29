<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.form');
    }

    public function checkAvailability(Request $request)
    {
        $date  = $request->query('date');
        $shift = $request->query('shift', 'day');

        if (!$date) {
            return response()->json(['available' => false, 'message' => 'Date is required.']);
        }

        $available = Booking::isDateAvailable($date, $shift);

        return response()->json([
            'available' => $available,
            'message'   => $available
                ? 'This date and shift is available.'
                : 'This date and shift is already booked. Please choose another.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booker_name'           => 'required|string|max:100',
            'booker_phone'          => 'required|string|max:20',
            'booker_email'          => 'nullable|email|max:100',
            'booker_nid'            => 'nullable|string|max:30',
            'verification_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'booker_address'        => 'nullable|string|max:500',
            'booker_type'           => 'required|in:general,staff,member',
            'booking_shift'         => 'required|in:day,night',
            'rental_type'           => 'required|in:hall,hall_field',
            'event_type'            => 'required|string',
            'event_name'            => 'nullable|string|max:200',
            'event_date'            => 'required|date|after:today',
            'guests_count'          => 'nullable|integer|min:1|max:2000',
            'special_requests'      => 'nullable|string|max:1000',
        ]);

        if (!Booking::isDateAvailable($validated['event_date'], $validated['booking_shift'])) {
            return back()->withErrors([
                'event_date' => 'Sorry, this date and shift is already booked. Please choose another date or shift.',
            ])->withInput();
        }

        $docPath = null;
        if ($request->hasFile('verification_document')) {
            $docPath = $request->file('verification_document')
                ->store('bookings/documents', 'public');
        }

        $totalAmount = Booking::calculatePrice(
            $validated['booker_type'],
            $validated['booking_shift'],
            $validated['rental_type']
        );

        $booking = Booking::create([
            'reference_number'      => Booking::generateReference(),
            'booker_name'           => $validated['booker_name'],
            'booker_phone'          => $validated['booker_phone'],
            'booker_email'          => $validated['booker_email'] ?? null,
            'booker_nid'            => $validated['booker_nid'] ?? null,
            'verification_document' => $docPath,
            'booker_address'        => $validated['booker_address'] ?? null,
            'booker_type'           => $validated['booker_type'],
            'booking_shift'         => $validated['booking_shift'],
            'rental_type'           => $validated['rental_type'],
            'event_type'            => $validated['event_type'],
            'event_date'            => $validated['event_date'],
            'guests_count'          => $validated['guests_count'] ?? 0,
            'special_requests'      => $validated['special_requests'] ?? null,
            'total_amount'          => $totalAmount,
            'status'                => 'pending',
        ]);

        return redirect()->route('booking.confirm', $booking->reference_number);
    }

    public function confirm(string $ref)
    {
        $booking = Booking::where('reference_number', $ref)->firstOrFail();
        return view('booking.confirm', compact('booking'));
    }
}