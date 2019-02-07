<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;

/**
 * @OA\Put(
 *     path="/v1/me",
 *     operationId="me.updateMe",
 *     tags={"Me"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Peter Chan",
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     example="me@example.com",
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     example="password",
 *                 ),
 *                 @OA\Property(
 *                     property="password_confirmation",
 *                     type="string",
 *                     example="password",
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 * )
 */
class UpdateMe extends Controller
{
    protected $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    protected function shouldUpdatePassword(User $user, & $data)
    {
        if (! empty($data['password']) && ! empty($user->email)) {
            return true;
        }

        unset($data['password']);
        return false;
    }

    public function __invoke(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users',
            'password' => 'sometimes|required|string|min:6|confirmed',
        ]);

        /** @var User $user */
        $user = $request->user();

        if ($this->shouldUpdatePassword($user, $data)) {
            $data['password'] = $this->hasher->make($data['password']);
        }

        if (! empty($data['email'])) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->update($data);

        return new UserResource($user);
    }
}
