<?php

// src/YourBundle/Controller/RegisterController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\User;

class RegisterController extends AbstractController
{




    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            // Validate and persist user

            $user = new User();
            $user->setKey(\Pimcore\Model\Element\Service::getValidKey($username, 'object'));
            $user->setParentId(61);
            $user->setUsername($username);
            $user->setPassword($password);
            $user->save();



            // Redirect to a success page or handle it accordingly
            return $this->render('home/index.html.twig');
        }

        return $this->render('login/register.html.twig');
    }
}

