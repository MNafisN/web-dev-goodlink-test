<?php

namespace App\Http\Repositories;

use App\Models\Member;

class MemberRepository
{
    protected $members;

    public function __construct(Member $member)
    {
        $this->members = $member;
    }

    /**
     * Untuk mengambil semua list member
     */
    public function getAll() : Object
    {
        $members = $this->members->get();
        return $members;
    }

    /**
     * Untuk mengambil data member berdasarkan email
     */
    public function getByEmail(string $email) : ?Object
    {
        $member = $this->members->where('email', $email)->first();
        return $member;
    }

    /**
     * Untuk menyimpan data member baru
     */
    public function store(array $data) : Object
    {
        $memberBaru = new $this->members;

        $memberBaru->name = $data['name'];
        $memberBaru->bio = $data['bio'];
        $memberBaru->email = $data['email'];
        $memberBaru->email_verified_at = $data['verified_time'];
        $memberBaru->password = bcrypt($data['password']);

        $memberBaru->save();
        return $memberBaru->fresh();
    }

    /**
     * Untuk menghapus data member berdasarkan email
     */
    public function delete(string $email) : void
    {
        $this->members->where('email', $email)->delete();
    }
}