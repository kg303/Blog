<?php

namespace App\Controller;

use Pimcore\Bundle\AdminBundle\Controller\Admin\LoginController;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Products;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\ProductCategory;
use Pimcore\Bundle\EcommerceFrameworkBundle\Factory;
use Pimcore\Bundle\EcommerceFrameworkBundle\Model\CheckoutableInterface;

class DefaultController extends FrontendController
{

    /**
     * @Route("/testing-url", name="testing_url")
     */
    public function test()
    {
        $test = BlogPost::getById(3);

        dd($test);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('layouts/layout.html.twig');
    }

    /**
     * Forwards the request to admin login
     */
    public function loginAction(): Response
    {
        return $this->forward(LoginController::class.'::loginCheckAction');
    }

    #[Template('includes/footer.html.twig')]
    public function footerAction(Request $request)
    {
        return [];
    }

    #[Template('default/my-gallery.html.twig')]
    public function myGalleryAction(Request $request): array
    {
        if ('asset' === $request->get('type')) {
            $asset = Asset::getById((int) $request->get('id'));
            if ('folder' === $asset->getType()) {
                return [
                    'assets' => $asset->getChildren()
                ];
            }
        }

        return [];
    }

    public function productAction(Request $request): Response
    {
        if($request->get('type') == 'object') {
            if($products = Products::getById($request->get('id'))) {
                return $this->render('default/product-renderlet.html.twig', ['products' => $products]);
            }
        }
        return new Response();

    }

    public function aboutAction(Request $request)
    {
        return $this->renderTemplate('about/index.html.twig', []);
    }

    /**
     * @Route("/academy")
     * @return JsonResponse
     */
    public function academyAction() {

        $products = [];

        $productList = Factory::getInstance()->getIndexService()->getProductListForTenant('Academy');
        $productList->setCategory(ProductCategory::getById( 69));

        foreach($productList as $product) {
            $products[] = [
                'id' => $product->getId(),
                'name' => $product->getName()
            ];
        }

        return $this->json($products);

    }

    /**
     * @Route("/academy/cartadd/{id}", name="cartadd")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function addToCartAction(Request $request, int $id) {

        $product = Product::getById($id);

        $cartManager = Factory::getInstance()->getCartManager();
        $cart = $cartManager->getOrCreateCartByName('cart');

        $cart->addItem($product, 2);
//       dump($cart->getItems());

        $cart->save();

        return $this->redirectToRoute("cartlist");


    }


    /**
     * @Route("/academy/cartlist", name="cartlist")
     * @return JsonResponse
     */
    public function cartListAction() {
        $cartItems = [];

        $cartManager = Factory::getInstance()->getCartManager();
        $cart = $cartManager->getOrCreateCartByName('cart');

        foreach ($cart->getItems() as $item) {
            $cartItems[] = [
                'id' => $item->getItemKey(),
                'name' => $item->getProduct()->getClassName(), // Corrected method name
                'count' => $item->getCount()
            ];
        }

        return $this->json($cartItems);
    }


}
