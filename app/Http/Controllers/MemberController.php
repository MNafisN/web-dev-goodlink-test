<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Exceptions\ArrayException;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Register a new member
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $member = $this->memberService->store($data);
            $result = [
                'status' => 201,
                'message' => 'member registered successfully',
                'registered_member' => $member->only(['name', 'email'])
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Log in and get a JWT token via given credentials
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        $credentials = $request->all();

        try {
            $token = $this->memberService->login($credentials);
            if (!$token) { return response()->json(['status' => 401, 'error' => 'Wrong email or password, please try again'], 401); }

            $result = [
                'status' => 200,
                'logged_in_member' => [
                    'name' => auth()->user()['name'],
                    'email' => auth()->user()['email']
                ],
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ];
        } catch (ArrayException $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessagesArray()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 422,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Get current logged in member's data, for edit profile form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data() : JsonResponse
    {
        $result = [
            'status' => 200,
            'member_data' => $this->memberService->data()
        ];

        return response()->json($result, $result['status']);
    }

        /**
     * Get a new JWT token for the logged in member
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function refresh() : JsonResponse
     {
         $result = [
             'status' => 200,
             'access_token' => auth()->refresh(),
             'token_type' => 'bearer',
             'expires_in' => auth()->factory()->getTTL() * 60
         ];

         return response()->json($result, $result['status']);
     }

     /**
      * Log the member out (Invalidate the token)
      *
      * @return \Illuminate\Http\JsonResponse
      */
     public function logout() : JsonResponse
     {
         $message = $this->memberService->logout().' Successfully logged out';

         $result = [
             'status' => 200,
             'message' => $message
         ];

         return response()->json($result, $result['status']);
     }
}
