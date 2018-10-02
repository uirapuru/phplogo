<?php

namespace App\Controller;

use Logo\Game;
use Parser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function index()
    {
        return $this->render("index.html.twig");
    }

    public function addCommand(Request $request, Session $session)
    {
//        $commands = $session->get("commands", []);
        $commands[] = $request->get("command", "");
        $session->set("commands", $commands);
        $session->save();

        return $this->redirectToRoute("index");
    }

    public function reset(Session $session)
    {
        $session->set("commands", []);
        $session->save();

        return $this->redirectToRoute("index");
    }

    public function getLogo(Session $session)
    {
        $commands = $session->get("commands", []);

        $game = new Game(800, 600);

        if(count($commands) > 0) {
            $game->addCommands(
                Parser::fromString(implode(" ", $commands))
            );
        }

        $game->run();

        $image = $game->image();

        return new Response($image->get("png"), 200, [
            "Content-Type" => "image/png",
        ]);
    }
}