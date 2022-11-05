<?php
namespace App\Controller\Bitcms;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * is Authorized
     * @param $user
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        $this->Auth->allow(['login', 'logout', 'forgotPassword']);

        return parent::isAuthorized($user);
    }


    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if( $this->Auth->user('role') == 'user'){
            return $this->redirect('/');
        }

        $this->paginate = [
            'contain' => []
        ];
        $users = $this->Users->find();
        if( $this->request->getQuery('keyword') ){

            // make sure we search on EVERY column of the table
            $columns = ['username', 'customernumber', 'firstname', 'lastname', 'email', 'company', 'address', 'postcode', 'city', 'country', 'telephone', 'website', 'market', 'kvk', 'btw', 'specials', 'remarks', 'conditions', 'fax', 'telephone_2', 'telephone_3', 'gender'];
            foreach($columns as $col){
                $where[$col . ' LIKE '] = '%' . $this->request->getQuery('keyword') . '%';
            }
            $users->where(['OR' => $where]);
        }

        if( $this->request->getQuery('role') ){
            $users->where(['role' => $this->request->getQuery('role') ]);
        }

        $this->set('users', $this->paginate($users));
        $this->set('_serialize', ['users']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if( $this->request->getData('new_password') ){
                if( $this->request->getData('new_password') != $this->request->getData('repeat_new_password') ){
                    $this->Flash->error(__('The new password does not match'));
                    $errors = true;
                } else {
                    $user->password = $this->request->getData('new_password');
                }
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('De gebruiker is toegevoegd.'));
                return $this->redirect(['action' => 'index']);
            } else {
                debug($user->getErrors());exit;
                $this->Flash->error(__('De gebruiker kan niet opgeslagen worden. Controleer de gegevens en probeer het nogmaals.'));
            }
        }
        $user->role = 'user';
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->Users->patchEntity($user, $this->request->getData());

            if( $this->request->getData('new_password') ){
                if( $this->request->getData('new_password') != $this->request->getData('repeat_new_password') ){
                    $this->Flash->error(__('The new password does not match'));
                    $errors = true;
                } else {
                  $user->password = $this->request->getData('new_password');
                }
            }

            if( empty($errors) ){
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your profile is saved.'));
                    return $this->redirect(['action' => 'edit', $id]);
                } else {
                    $this->Flash->error(__('Your profile cannot be changed at the moment.'));
                }
            }
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            if( !$this->request->is('ajax') ){
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                echo 'deleted';
            }
        } else {
            if( !$this->request->is('ajax') ) {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            } else {
                echo 'error';
            }
        }
        if( !$this->request->is('ajax') ) {
            return $this->redirect(['action' => 'index']);
        } else {
            $this->autoRender = false;
        }
    }


    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     */
    public function login()
    {
        $this->viewBuilder()->setLayout('bitcms_empty');

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['prefix' => 'bitcms', 'controller' => 'Dashboard', 'action' => 'index']);
            } else {
                $this->Flash->error(
                    __('Gebruikersnaam en/of wachtwoord is incorrect'),
                    'default',
                    [],
                    'auth'
                );
            }
        }
    }

    /**
     * Forgot password? OMG send the password again
     */
    public function forgotPassword()
    {
        $this->viewBuilder()->setLayout('bitcms_empty');

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->findByEmail($this->request->getData('email'))->where(['role' => 'admin']);
            if ($user->isEmpty()) {
                $this->Flash->error( __('We can\'t find a user with the e-mail: {0}', [$this->request->getData('email')]));
            } else {

                // make random new password
                $password = $this->generatePassword(5);
                $user = $user->first();
                $user->password = $password;

                if ($this->Users->save($user)) {
                    $email = new Email('default');
                    $email->setFrom(['info@dotbits.nl' => 'DotBits'])
                        ->setReplyTo(['info@dotbits.nl'])
                        ->setEmailFormat('html')
                        ->setTo([$user->email])
                        ->setSubject(__('Reset your DotBits password'))
                        ->setViewVars(['user' => $user, 'password' => $password])
                        ->setTemplate('forgot_password')
                        ->send();
                }

                $this->Flash->success(__('We\'ve send you an e-mail to {0}', [$user->email]));
                $this->redirect(['action' => 'login']);
            }
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Network\Response|null
     */
    public function logout()
    {
        $this->Cookie->delete('never_ending_story');
        $this->Auth->logout();

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Generate password string
     *
     * @param $length
     * @return string
     */
    protected function generatePassword($length)
    {
        $letters = array_merge( range('a','z'), range('A', 'Z'), range(0,9) );
        shuffle($letters);
        return substr( implode('', $letters), 0, $length );
    }

}
