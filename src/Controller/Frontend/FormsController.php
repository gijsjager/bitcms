<?php

namespace Bitcms\Controller\Frontend;


use Cake\Error\FatalErrorException;
use Bitcms\Controller\FrontendController;
use Cake\Mailer\Mailer;
use Cake\View\View;


class FormsController extends FrontendController
{
    public function submit()
    {
        if ($this->request->getData('_hmnzr') !== $this->getHumanizerCode()) {
            $response = [
                'send' => 'OK',
                'humanizer' => 'failed'
            ];
        } else if (filter_var($this->request->getData('email'), FILTER_VALIDATE_EMAIL)) {

            // generate view
            $template = $this->getTemplate();

            // back up first
            $this->store($template);

            // send email
            $mailer = new Mailer();
            $send = $mailer->setFrom($this->getMailFrom())
                ->setTo($this->getReceiver())
                ->setSubject($this->getSubject())
                ->setReplyTo($this->request->getData('email'))
                ->setViewVars(['data' => $this->request->getData()])
                ->setEmailFormat('html')
                ->deliver($template);

            // if there is template for a default response, send that to the user as well
            $template = $this->getTemplate();
            $replyTpl = 'email/html/reply/' . $this->getTemplateName();
            if (file_exists(ROOT . DS . 'templates' . DS . $replyTpl . '.php')) {
                $mailer = new Mailer();
                $send = $mailer->setFrom($this->getMailFrom())
                    ->setTo($this->request->getData('email'))
                    ->setSubject($this->getSubject())
                    ->setReplyTo($this->getReceiver())
                    ->setViewVars(['data' => $this->request->getData()])
                    ->setEmailFormat('html')
                    ->deliver($template);
            }

            $response = [
                'send' => 'OK',
                'humanizer' => 'validated',
                'log' => (bool)$send
            ];
        } else {
            throw new FatalErrorException(__('Could not send email'));
        }

        if($this->getRequest()->is('ajax')){
            return $this->getResponse()->withStringBody(json_encode($response));
        }

        $this->getRequest()->getSession()->write('form_submitted', true);

        $url = $this->referer();
        $url = explode('?', $url);
        $url = $url[0] . '?submitted=1';

        return  $this->redirect($url);

    }

    protected function getTemplate(): string
    {
        // get correct template
        $view = new View($this->getRequest());
        $view->setLayout('email/html/default');
        return $view->render('email/html/' . $this->getTemplateName());
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
     * @return string
     */
    protected function getSubject(): string
    {
        $config = $this->getConfig();
        if(!empty($config['mails'][$this->request->getData('_name')])){
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

    protected function getReceiver(): string
    {
        $settings = $this->getSettings();
        return !empty($settings['mail_to']) ? $settings['mail_to'] : 'gijsjager@gmail.com';
    }
}
