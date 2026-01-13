<?php

namespace Bitcms\Controller\Frontend;


use Bitcms\Controller\FrontendController;
use Bitcms\Utilities\Recaptcha;
use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Mailer\Mailer;
use Cake\View\View;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

/**
 * Forms Controller
 * If you want to use mailtrap:
 * Configure::write('Mailtrap.token', 'your-mailtrap-token');
 *
 * @package Bitcms\Controller\Frontend
 *
 */
class FormsController extends FrontendController
{
    public function submit(): ?\Cake\Http\Response
    {
        // validate recaptcha
        $config = $this->getConfig();

        if (!empty($config['mails']['recaptha']) ) {
            $recaptcha = new Recaptcha();
            if (!$recaptcha->validate($this->getRequest())) {
                return $this->redirect($this->referer() . '?recaptcha_failed=1');
            }
        }

        // honeypot check
        if (
            !empty($config['mails']['honeypot']) &&
            $this->request->getData('honey') !== '') {
            return $this->redirect($this->referer() . '?honeypot_failed=1');
        }

        if ($this->request->getData('_hmnzr') !== $this->getHumanizerCode()) {
            $response = [
                'send' => 'OK',
                'humanizer' => 'failed'
            ];
        } elseif (filter_var($this->request->getData('email'), FILTER_VALIDATE_EMAIL)) {

            // generate view
            $template = $this->getTemplate();

            // back up first
            $this->store($template);

            // send email
            $send = $this->sendMail(
                receiver: $this->getReceiver(),
                subject: $this->getSubject(),
                template: $template,
                replyTo: $this->request->getData('email'),
            );

            // if there is template for a default response, send that to the user as well
            $replyTpl = 'email/html/reply/' . $this->getTemplateName();
            if (file_exists(ROOT . DS . 'templates' . DS . $replyTpl . '.php')) {
                $this->sendMail(
                    receiver: $this->request->getData('email'),
                    subject: $this->getSubject(true),
                    template: $this->getTemplate(reply: true),
                );
            }

            $response = [
                'send' => 'OK',
                'humanizer' => 'validated',
                'log' => $send
            ];
        } else {
            throw new FatalErrorException(__('Could not send email'));
        }

        if ($this->getRequest()->is('ajax')) {
            return $this->getResponse()->withStringBody(json_encode($response));
        }

        $this->getRequest()->getSession()->write('form_submitted', true);

        $url = $this->referer();
        $url = explode('?', $url);
        $url = $url[0] . '?submitted=1';

        return $this->redirect($url);

    }

    protected function getTemplate(bool $reply = false): string
    {
        // get correct template
        $view = new View($this->getRequest());
        $view->setLayout('email/html/default');

        $templatePath = 'email/html/';
        if ($reply) {
            $templatePath .= 'reply/';
        }
        $templatePath .= $this->getTemplateName();
        return $view->render($templatePath);
    }

    protected function getTemplateName(): string
    {
        return ($this->request->getData('_template') ? $this->request->getData('_template') : 'default');
    }

    protected function store(string $template = '')
    {

        $table = $this->fetchTable('Bitcms.Mails');
        $entity = $table->newEntity([
            'date_created' => new \DateTime(),
            'receiver' => $this->getReceiver(),
            'sender' => $this->request->getData('email'),
            'subject' => $this->getSubject(),
            'content' => $template
        ]);
        $table->save($entity);
    }

    /**
     * Get mail subject
     * @param bool $isReply
     * @return string
     */
    protected function getSubject(bool $isReply = false): string
    {
        $config = $this->getConfig();

        if ($isReply && !empty($config['mails'][$this->request->getData('_name')]['reply']['subject'])) {
            return $config['mails'][$this->request->getData('_name')]['reply']['subject'];
        }

        if (!empty($config['mails'][$this->request->getData('_name')])) {
            return $config['mails'][$this->request->getData('_name')]['subject'];
        } else {
            return __('New mail received from website');
        }
    }

    /**
     * Get mail from setting
     * @return string
     */
    protected function getMailFrom(): string
    {
        $settings = $this->getSettings();
        return !empty($settings['mail_from']) ? $settings['mail_from'] : 'gijsjager@gmail.com';
    }

    protected function getMailFromName(): string
    {
        $config = $this->getConfig();

        if (!empty($config['mails'][$this->request->getData('_name')]['fromName'])) {
            return $config['mails'][$this->request->getData('_name')]['fromName'];
        } else {
            $settings = $this->getSettings();
            return !empty($settings['site_name']) ? $settings['site_name'] : 'Website';
        }
    }

    protected function getReceiver(): string
    {
        $settings = $this->getSettings();
        return !empty($settings['mail_to']) ? $settings['mail_to'] : 'gijsjager@gmail.com';
    }

    /**
     * Send mail using Mailtrap or default mailer
     * @param string $receiver
     * @param string $subject
     * @param string $template
     * @param string|null $replyTo
     * @return bool
     */
    protected function sendMail(
        string $receiver,
        string $subject,
        string $template,
        string $replyTo = null
    ): bool
    {
        // Send with Mailtrap
        $config = $this->getConfig();

        if (!empty($config['mails']['mailtrap'])) {

            $mailtrap = MailtrapClient::initSendingEmails(
                apiKey: Configure::read('Mailtrap.token'),
                isSandbox: Configure::read('Mailtrap.sandbox', false),
                inboxId: Configure::read('Mailtrap.inbox_id', null),
            );

            $email = (new MailtrapEmail())
                ->from(new Address($this->getMailFrom(), $this->getMailFromName()))
                ->to(new Address($receiver))
                ->subject($subject)
                ->html($template)
                ->category('Website email');

            if ($replyTo) {
                $email->replyTo(new Address($replyTo));
            }

            $response = $mailtrap->send($email);
            return $response->getStatusCode() === 200;
        }

        // fallback on normal mailer
        $mailer = new Mailer('default');
        $mailer->setTo($this->getReceiver())
            ->setFrom($this->getMailFrom(), $this->getMailFromName())
            ->setSubject($subject)
            ->setEmailFormat('html');

        try {
            $mailer->deliver($template);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
