<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BookingResources Controller
 *
 * @property \App\Model\Table\BookingResourcesTable $BookingResources
 */
class BookingResourcesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BookingResources->find()
            ->contain(['Bookings']);
        $bookingResources = $this->paginate($query);

        $this->set(compact('bookingResources'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingResource = $this->BookingResources->get($id, contain: ['Bookings']);
        $this->set(compact('bookingResource'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookingResource = $this->BookingResources->newEmptyEntity();
        if ($this->request->is('post')) {
            $bookingResource = $this->BookingResources->patchEntity($bookingResource, $this->request->getData());
            if ($this->BookingResources->save($bookingResource)) {
                $this->Flash->success(__('The booking resource has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking resource could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingResources->Bookings->find('list', limit: 200)->all();
        $this->set(compact('bookingResource', 'bookings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingResource = $this->BookingResources->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingResource = $this->BookingResources->patchEntity($bookingResource, $this->request->getData());
            if ($this->BookingResources->save($bookingResource)) {
                $this->Flash->success(__('The booking resource has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking resource could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingResources->Bookings->find('list', limit: 200)->all();
        $this->set(compact('bookingResource', 'bookings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingResource = $this->BookingResources->get($id);
        if ($this->BookingResources->delete($bookingResource)) {
            $this->Flash->success(__('The booking resource has been deleted.'));
        } else {
            $this->Flash->error(__('The booking resource could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
