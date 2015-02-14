<?php

namespace WebApp\Resource;

use WebApp\AbstractResource;
use WebApp\Entity\User;

/**
 * Class Resource
 * @package App
 */
class UserResource extends AbstractResource
{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id)
    {
        if ($id === null) {
            $users = $this->getEntityManager()->getRepository('App\Entity\User')->findAll();
            $users = array_map(function ($user) {
                    return $this->convertToArray($user);
                },
                $users);
            $data = json_encode($users);
        } else {
            $data = $this->convertToArray($this->getEntityManager()->find('App\Entity\User', $id));
        }

        // @TODO handle correct status when no data is found...

        return json_encode($data);
    }

    // POST, PUT, DELETE methods...

    private function convertToArray(User $user)
    {
        return array(
            'id' => $user->getId(),
            'name' => $user->getName()
        );
    }
}