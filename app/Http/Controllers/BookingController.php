<?php

namespace App\Http\Controllers;

use App\Http\Resources\Booking as ResourcesBooking;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();

        $arr = [
            'status' => true,
            'message' => 'Bookings lists',
            'data' => ResourcesBooking::collection($bookings),
        ];
        return response()->json($arr,200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validatedData = Validator::make($input, [
            'fullname'=> 'required',
            'phone_number'=> 'required',
            'email'=> 'required',
            'quantity'=> 'required',
            'time'=> 'required',
            'date' => 'required',
        ]);

        if($validatedData->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Error while check data',
                'data' => $validatedData->errors(),
            ];
            return response()->json($arr,200);
        }

        $booking = Booking::create($input);
        $arr = [
            'success' => true,
            'message' => 'Booking date have been saved !',
            'data' => new ResourcesBooking($booking),
        ];
        return response()->json($arr,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Use the scopeDeleted scope
        $bookings = DB::table('bookings as bk')
            ->join('users as u', 'bk.user_id', '=', 'u.id')
            ->select('bk.*')
            ->where('u.id', $id)
            ->where(function($query) {
                $query->where('bk.deleted', '!=', 0)
                    ->orWhereNull('bk.deleted');
            }) // Apply the condition for 'deleted' being NULL or not equal to 0
            ->get();


        // Prepare the response data
        $response = [
            'status' => true,
            'message' => 'Success',
            'data' => $bookings,
        ];

        // Return the JSON response
        return response()->json($response, 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->deleted = 0;
        $booking->save();
        $arr = [
            'status' => true,
            'message' => 'Destroy data success',
            'data' => $booking,
        ];

        return response()->json($arr,200);
    }
}
