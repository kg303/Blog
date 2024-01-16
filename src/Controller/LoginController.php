<?php

namespace App\Controller;

use Pimcore\Model\DataObject\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request): Response
    {
        $errormessage = null;
        $successMessage = null;

        if ($request->isMethod('POST')) {
            try {
                $username = $request->request->get('username');
                $password = $request->request->get('password');

                // Load user data from Pimcore based on the provided username
                $userDataObject = User::getByPath("/Users/{$username}");
//                dump($password);
//                dd($userDataObject->getPassword());
                if (!$userDataObject || $userDataObject->getPassword() !== $password) {
                    // Invalid username or password
                    throw new BadCredentialsException('Invalid username or password');
                }

                // Set success message for successful login
                $successMessage = 'Successfully logged in!';

                // If authentication is successful, redirect to the login page with success message
                return $this->redirectToRoute('login', ['successMessage' => $successMessage]);
            } catch (BadCredentialsException $exception) {
                // Catch the exception and set the error message for the template
                $errormessage = 'Invalid username or password';
            }
        }

        // Get the success message from the query parameters
        $successMessage = $request->query->get('successMessage');

        return $this->render('login/login.html.twig', [
            'errormessage' => $errormessage,
            'successMessage' => $successMessage,
        ]);
    }
}





