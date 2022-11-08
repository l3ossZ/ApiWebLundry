<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
      * @OA\Schema()
      */

class AuthRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Name of key for storring",
     *     example="random",
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="email",
     *     description="email of key for storring",
     *     example="email@example.com",
     * )
     *
     * @var string
     */

    public $email;
    /**
     * @OA\Property(
     *     title="phone",
     *     description="Name of key for storring",
     *     example="random",
     * )
     *
     * @var string
     */

    public $phone;
    /**
     * @OA\Property(
     *     title="password",
     *     description="Password of key for storring",
     *     example="password",
     * )
     *
     * @var string
     */

    public $password;
    /**
     * @OA\Property(
     *     title="role",
     *     description="role of key for storring",
     *     example="CUSTOMER",
     * )
     *
     * @var string
     */

    public $role;
    /**
     * @OA\Property(
     *     title="realrole",
     *     description="realrole of key for storring",
     *     example="CUSTOMER",
     * )
     *
     * @var string
     */

    public $realrole;

}
