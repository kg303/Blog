<?php
// src/Model/DataOb

namespace App\Model\DataObject;

use Pimcore\Model\DataObject\User as BaseUser;

class User extends BaseUser
{
    // ... other properties and methods ...

    public function isValidCredentials($providedPassword): bool
    {
        // Implement your logic to validate whether the provided password matches
        // the stored password for the user.

        // For example, assuming you store hashed passwords:
        $storedPasswordHash = $this->getPassword(); // replace with the actual method to get the stored password hash

        // Use a secure password hashing function (e.g., password_hash) for comparison
        return password_verify($providedPassword, $storedPasswordHash);
    }
}

