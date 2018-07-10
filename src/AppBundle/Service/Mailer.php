<?php
/**
 * Created by PhpStorm.
 * User: wilder8
 * Date: 10/07/18
 * Time: 18:44
 */

namespace AppBundle\Service;


class Mailer
{
    private $mailer;

    private $templating;


    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param $reservation
     */
    public function sendEMail($setTo, $setFrom, $setBody)
    {
        // Pilot mail
        $message = (new \Swift_Message('Réservation Flyaround'))

            ->setFrom($setFrom)
            ->setTo($setTo);
            if ($setBody === 'notification') {
                $message->setBody($this->templating->render('mail/notification.html.twig'), 'text/html');
            } else {
                $message->setBody($this->templating->render('mail/confirmation.html.twig'), 'text/html');
            }
        $this->mailer->send($message);
    }
}