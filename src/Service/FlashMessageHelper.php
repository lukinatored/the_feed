<?php
namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use symfony\HttpFoundation\Session\FlashBagAwareSessionInterface;

class FlashMessageHelper implements FlashMessageHelperInterface
{

    public function __construct(
        private RequestStack $requestStack
    ){}

    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        foreach ($form->getErrors(true) as $error) {
            $this->requestStack->getSession()->getFlashBag()->add("error", $error->getMessage());
        }
    }
}