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
            $email = $request->request->get('email'); // Add this line to get the email
            $password = $request->request->get('password');

            try {
                // Validate input
                if (empty($username) || empty($email) || empty($password)) {
                    throw new \Exception('Username, email, and password are required!');
                }

                // Validate and persist user
                $user = new User();
                $user->setKey(\Pimcore\Model\Element\Service::getValidKey($username, 'object'));
                $user->setParentId(61);
                $user->setUsername($username);
                $user->setEmail($email); // Set the email value
                $user->setPassword($password);

                // Check if the fields are empty
                if (empty($user->getUsername()) || empty($user->getEmail()) || empty($user->getPassword())) {
                    throw new \Exception('Username, email, and password cannot be empty');
                }

                // Save the user
                $user->save();

                // Redirect to a success page or handle it accordingly
                return $this->render('home/index.html.twig');
            } catch (\Exception $e) {
                // Redirect back to registration form with an error message
                return $this->render('login/register.html.twig', ['error' => $e->getMessage()]);
            }
        }

        return $this->render('login/register.html.twig');
    }




}

