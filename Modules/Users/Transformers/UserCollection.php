<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Activities\Transformers\ActivityTransformer;
use Modules\Roles\Entities\Role;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'full_name'   => $this->full_name,
            'avatar'      => $this->getAvatar(),
            'email'       => $this->email,
            'role'        => $this->mapRole(),
            'roles'       => $this->mapRoles(),
            'all_roles'   => $this->mapAllRoles(),
            'permissions' => $this->mapPermissions(),
            'status'      => $this->getStatus(),
            'activities'  => ActivityTransformer::collection($this->activities),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }

    private function mapAllRoles()
    {
        return Role::all()->map(static function ($item) {
            return [
                'id'   => $item->id,
                'name' => $item->name,
            ];
        });
    }

    private function mapRole()
    {
        $role = $this->roles()->first();

        if (null === $role) {
            return 'user';
        }

        return mb_strtolower($role->name);
    }

    private function mapRoles()
    {
        $role = $this->roles()->first();

        if (null === $role) {
            return [];
        }

        return [$role->id];
    }

    private function mapPermissions()
    {
        $permissions = [
            'users' => [
                'read'         => $this->hasPermissionTo('READ_USERS'),
                'write'        => $this->hasPermissionTo('EDIT_USERS'),
                'update'       => $this->hasPermissionTo('UPDATE_USERS'),
                'delete'       => $this->hasPermissionTo('DELETE_USERS'),
                'restore'      => $this->hasPermissionTo('RESTORE_USERS'),
                'force_delete' => $this->hasPermissionTo('FORCE_DELETE_USERS'),
            ],
            'roles' => [
                'read'         => $this->hasPermissionTo('READ_ROLES'),
                'write'        => $this->hasPermissionTo('EDIT_ROLES'),
                'update'       => $this->hasPermissionTo('UPDATE_ROLES'),
                'delete'       => $this->hasPermissionTo('DELETE_ROLES'),
                'restore'      => $this->hasPermissionTo('RESTORE_ROLES'),
                'force_delete' => $this->hasPermissionTo('FORCE_DELETE_ROLES'),
            ]
        ];

        return $permissions;
    }

    private function getStatus()
    {
        if (null === $this->deleted_at) {
            return 'active';
        }

        return 'blocked';
    }

    private function getAvatar()
    {
        if ($avatar = $this->attachments()->latest()->first()) {
            return $avatar->url;
        }

        return '';
    }
}
