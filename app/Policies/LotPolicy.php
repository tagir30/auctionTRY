<?php

namespace App\Policies;

use App\Lot;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LotPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Lot $lot
     * @return mixed
     */
    public function view(User $user, Lot $lot)
    {
        return $user->id === $lot->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Lot $lot
     * @return mixed
     */
    public function update(User $user, Lot $lot)
    {
        return $user->id === $lot->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Lot $lot
     * @return mixed
     */
    public function delete(User $user, Lot $lot)
    {
        return $user->id === $lot->user_id;
    }

//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param User $user
//     * @param Lot $lot
//     * @return mixed
//     */
//    public function restore(User $user, Lot $lot)
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param User $user
//     * @param Lot $lot
//     * @return mixed
//     */
//    public function forceDelete(User $user, Lot $lot)
//    {
//        //
//    }
}
