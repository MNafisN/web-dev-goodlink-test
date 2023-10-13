<?php

namespace App\Http\Services;

use App\Http\Repositories\MemberRepository;
use Carbon\Carbon;
use InvalidArgumentException;
use App\Exceptions\ArrayException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Untuk mengambil semua list member
     */
    public function getAll() : ?Object
    {
        $members = $this->memberRepository->getAll();
        $member = $members->isEmpty() ? null : $members;
        return $member;
    }

    /**
     * Untuk menambahkan member
     */
    public function store(array $data) : Object
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'min:4', 'max:32'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Min. character length for name is 4',
            'name.max' => 'Max. character length for name is 32',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.max' => 'Max. character length for email is 255',
            'email.unique' => 'Email already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Min. character length for password is 6',
        ]);

        if ($validator->fails()) { 
            throw new ArrayException($validator->errors()->toArray()); }

        if ((filter_var($data['email'], FILTER_VALIDATE_EMAIL)) !== false) {
            $data['verified_time'] = (string)Carbon::now();
            $data['bio'] = "Bio " . $data['name'];
        } else { throw new InvalidArgumentException('invalid email'); }

        $result = $this->memberRepository->store($data);
        return $result;
    }

    /**
     * Untuk melakukan login member dengan data yang diperlukan
     */
    public function login(array $credentials) : string|bool
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) { throw new ArrayException($validator->errors()->toArray()); }

        $token = auth()->attempt($credentials, true);

        return $token;
    }

    /**
     * Untuk melihat detail member yang telah dalam keadaan logged in
     */
    public function data() : array
    {
        $member = auth()->user();
        return $member->only(['name', 'bio', 'email']);
    }

    /**
     * Untuk melakukan logout pada member
     */
    public function logout() : string
    {
        $name = auth()->user()['name'];
        auth()->logout();
        return $name;
    }
}