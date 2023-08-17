<?php

namespace App\Constants;

class RoleConstant
{
    const ID_OF_MEMBER = 1;
    const NAME_OF_MEMBER_ROLE = 'member';
    const ID_OF_ADMIN = 2;
    const NAME_OF_ADMIN_ROLE = 'admin';
    const ROLES = [
      self::ID_OF_MEMBER => self::NAME_OF_MEMBER_ROLE,
      self::ID_OF_ADMIN => self::NAME_OF_ADMIN_ROLE
    ];
}
