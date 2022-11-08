<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
    * @OA\Schema()
      */

class EmployeeRequest extends FormRequest
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
     *     title="phone",
     *     description="Phone of key for storring",
     *     example="0981273812",
     * )
     *
     * @var string
     */

    public $phone;

    /**
     * @OA\Property(
     *     title="email",
     *     description="email of key for storring",
     *     example="me@example.com",
     * )
     *
     * @var string
     */

    public $email;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Name of key for storring",
     *     example="password",
     * )
     *
     * @var string
     */

    public $password;

    /**
     * @OA\Property(
     *     title="salary",
     *     description="salary of key for storring",
     *     example="10000",
     * )
     *
     * @var double
     */
    public $salary;

    /**
     * @OA\Property(
     *     title="role",
     *     description="role of key for storring",
     *     example="random",
     * )
     *
     * @var string
     */

    public $role;

    /**
     * @OA\Property(
     *     title="address",
     *     description="address of key for storring",
     *     example="115/112 ถ....",
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *     title="ID_Card",
     *     description="ID_Card of key for storring",
     *     example="111111111111111",
     * )
     *
     * @var string
     */

    public $ID_Card;
    /**
     * @OA\Property(
     *     title="bank_account",
     *     description="bank_account of key for storring",
     *     example="1112231231231",
     * )
     *
     * @var string
     */
    public $bank_account;

    /**
     * @OA\Property(
     *     title="bank_name",
     *     description="bank_name of key for storring",
     *     example="SCB",
     * )
     *
     * @var string
     */

    public $bank_name;
}
