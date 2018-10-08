<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\ListingType;
use Logo\Game;
use Parser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function index(Session $session, Request $request)
    {
        $data = new Listing($session->get("listing", ""));

        $form = $this->createForm(ListingType::class, $data, [
            "action" => $this->generateUrl("index"),
            "method" => Request::METHOD_POST
        ]);

        if($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if($form->isValid()) {
                $listing = $form["listing"]->getData();

                $session->set("listing", $listing);
                $session->set("commands", Parser::fromString($listing));
                $session->save();

                return $this->redirectToRoute("index");
            }
        }

        return $this->render("index.html.twig", [
            "form" => $form->createView()
        ]);
    }

    public function reset(Session $session)
    {
        $session->set("listing", "");
        $session->save();

        return $this->redirectToRoute("index");
    }

    public function getLogo(Session $session)
    {
        $listing = $session->get("listing", "");

        $game = new Game(800, 600);

        if(strlen($listing) > 0) {
            if(!$session->has("commands")) {
                $session->set("commands", Parser::fromString($listing));
                $session->save();
            }

            $game->addCommands($session->get("commands"));
        }

        $game->run();

        $image = $game->image();

        return new Response($image->get("png"), 200, [
            "Content-Type" => "image/png",
        ]);
    }
}