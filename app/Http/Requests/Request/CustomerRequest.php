<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

     /**
      * @OA\Schema()
      */
class CustomerRequest extends FormRequest
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
     *     description="Value for storring",
     *     example="example@example.com",
     * )
     *
     * @var string
     */



    public $email;

    /**
     * @OA\Property(
     *     title="pwd",
     *     description="Value for storring",
     *     example="password",
     * )
     *
     * @var string
     */
    public $pwd;

    /**
     * @OA\Property(
     *     title="phone",
     *     description="Value for storring",
     *     example="0xxxxxxxxx",
     * )
     *
     * @var string
     */
    public $phone;


}
