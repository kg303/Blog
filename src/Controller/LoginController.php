<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Model\DataObject\User;
use Pimcore\DataObject\Consent\Service;
use Pimcore\Translation\Translator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Pimcore\Controller\FrontendController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends BaseController
{

    /**
     * @Route("/login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @param UserInterface|null $user
     *
     * @return Response|RedirectResponse
     */
    public function loginAction(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        UserInterface $user = null,
        SessionInterface $session
    ): Response

    {

        //redirect user to index page if logged in
        if ($user && $this->isGranted('ROLE_USER')) {
            $session->getFlashBag()->add('success', 'You have successfully logged in.');
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $formData = [
            '_username' => $lastUsername
        ];

        $form = $this->createForm(LoginFormType::class, $formData, [
            'action' => $this->generateUrl('login'),
        ]);

        //store referer in session to get redirected after login
        if (!$request->get('no-referer-redirect')) {
            $request->getSession()->set('_security.demo_frontend.target_path', $request->headers->get('referer'));
        }

        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error ? 'Credentials are not valid.' : '',
        ]);
    }

    // Your logoutAction remains the same
    public function logoutAction(SessionInterface $session)
    {
        $session->invalidate();

        return new RedirectResponse('login');
    }
}






